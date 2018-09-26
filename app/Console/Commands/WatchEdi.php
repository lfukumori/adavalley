<?php

namespace App\Console\Commands;

use EDI\X12\Parser;
use EDI\X12\EDIHandler;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class WatchEdi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'edi:watch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Watches edi partner directories for new incoming message files.';

    protected $files;
    protected $documents;
    private $parser;
    private $handler;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(EDIHandler $handler, Parser $parser)
    {
        parent::__construct();

        $this->files = collect(Storage::disk('edi')->files('spartannash/incoming'));
        $this->parser = $parser;
        $this->handler = $handler;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! $this->files->count() > 0) return true;

        $this->files->each(function ($file) {
            $documents = collect($this->parser::parseFile($file));

            // translate each document to erp order and insert into erp database
            $documents->each(function ($document) {
                // handler->load will set erp order and fa997
                $this->handler->load($document);

                
                dd($this->handler->getDocument());
                //$fa997 = $salesOrder->();
                dd('test');
                // $document->processed = $order->saveToERP();

                $this->send997($document);
            });                      
        }); 

        return true;
    }

    private function send997($document) 
    {
        try {
            $translator = $this->getTranslator($document);
        
            // send 997 (put 997 file into outgoing directory)
            if (!$translator->send()) {
                throw new \Exception('Failed to send 997 (copy to outgoing directory)');
            }

            // move original message to processed folder so it wont be processed again
            if (!Storage::disk('edi')->move(
                "{$document->getAs2Id()}/incoming/{$document->fileName}",
                "{$document->getAs2Id()}/incoming/processed/{$document->fileName}"
            )) {
                throw new \Exception('Failed to move 997 to processed directory.');
            }

            // save 997 document into database
            $inserted = DB::table('edi_outgoing')->insert([
                'id'                => $document->getNewIsaControlNumber(),
                'filepath'          => "{$document->as2Id}/incoming/processed/{$document->fileName}",
                'processed'         => $document->processed,
                'type'              => "997",
                'created_at'        => $document->dateTime,
                'updated_at'        => $document->dateTime,
                'po_number'         => $document->poNumber(),
            ]);

            if (! $inserted) {
                throw new \Exception("Failed to record document into database, with new control number of {$document->getNewIsaControlNumber()}");
            }

            Mail::send('emails.alert-brian', ['error' => "997 sent successfully<br>Control# {$document->getNewIsaControlNumber()}<br>Filepath: {$document->filePath}<br>Server: 192.168.1.12"], function ($message) {
                $message->subject('997 Sent Successfully');
                $message->from('brian@adavalley.com', 'EDI Monitor');
                $message->to('bdbriandupont@gmail.com');
            });

            return true;
        } catch (\Exception $e) {
            Mail::send('emails.alert-brian', ['error' => "Error: {$e->getMessage()}<br>Filepath: {$document->filePath}<br>Server: 192.168.1.12"], function ($message) {
                $message->subject('997 Send Error');
                $message->from('brian@adavalley.com', 'EDI Monitor');
                $message->to('bdbriandupont@gmail.com');
            });
            
            return false;
        }
    }
}
