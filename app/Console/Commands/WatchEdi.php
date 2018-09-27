<?php

namespace App\Console\Commands;

use EDI\X12\Parser;
use EDI\X12\IncomingHandler;
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

    private $parser;
    private $handler;
    protected $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(IncomingHandler $handler, Parser $parser)
    {
        parent::__construct();

        $this->parser   = $parser;
        $this->handler  = $handler;
        $this->files    = collect(Storage::disk('edi')->files('spartannash/incoming'));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            if (!$this->files->count() > 0) return true;

            $this->files->each(function ($file) {
                $PO850s = collect($this->parser::parseFile($file));

            // translate each document to erp order and insert into erp database
                $PO850s->each(function ($PO850) {
                // handler->load will set erp order and fa997
                    $this->handler->setPO850($PO850);

                // TODO below
                // $this->handler->handle();


                    dd($this->handler->getPO850());
                //$fa997 = $salesOrder->();
   
                // $PO850->processed = $order->saveToERP();

                    $this->send997($PO850);
                });
            });

            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    private function send997($PO850) 
    {
        try {
            $translator = $this->getTranslator($PO850);
        
            // send 997 (put 997 file into outgoing directory)
            if (!$translator->send()) {
                throw new \Exception('Failed to send 997 (copy to outgoing directory)');
            }

            // move original message to processed folder so it wont be processed again
            if (!Storage::disk('edi')->move(
                "{$PO850->getAs2Id()}/incoming/{$PO850->fileName}",
                "{$PO850->getAs2Id()}/incoming/processed/{$PO850->fileName}"
            )) {
                throw new \Exception('Failed to move 997 to processed directory.');
            }

            // save 997 document into database
            $inserted = DB::table('edi_outgoing')->insert([
                'id'                => $PO850->getNewIsaControlNumber(),
                'filepath'          => "{$PO850->as2Id}/incoming/processed/{$PO850->fileName}",
                'processed'         => $PO850->processed,
                'type'              => "997",
                'created_at'        => $PO850->dateTime,
                'updated_at'        => $PO850->dateTime,
                'po_number'         => $PO850->poNumber(),
            ]);

            if (! $inserted) {
                throw new \Exception("Failed to record document into database, with new control number of {$PO850->getNewIsaControlNumber()}");
            }

            Mail::send('emails.alert-brian', ['error' => "997 sent successfully<br>Control# {$PO850->getNewIsaControlNumber()}<br>Filepath: {$PO850->filePath}<br>Server: 192.168.1.12"], function ($message) {
                $message->subject('997 Sent Successfully');
                $message->from('brian@adavalley.com', 'EDI Monitor');
                $message->to('bdbriandupont@gmail.com');
            });

            return true;
        } catch (\Exception $e) {
            Mail::send('emails.alert-brian', ['error' => "Error: {$e->getMessage()}<br>Filepath: {$PO850->filePath}<br>Server: 192.168.1.12"], function ($message) {
                $message->subject('997 Send Error');
                $message->from('brian@adavalley.com', 'EDI Monitor');
                $message->to('bdbriandupont@gmail.com');
            });
            
            return false;
        }
    }
}
