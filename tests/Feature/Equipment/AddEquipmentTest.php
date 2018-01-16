<?php

namespace Tests\Feature\Equipment;

use Carbon\Carbon;
use App\Equipment;
use App\User;
use Tests\TestCase;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddEquipmentTest extends TestCase
{
    use RefreshDatabase;

    private $equipment;

    public function setUp()
    {
        parent::setUp();
        $this->equipment = create(Equipment::class);

        $this->signIn();
    }
    
    /** @test */
    public function only_signed_in_users_can_add_equipment()
    {
        \Auth::logout();\Auth::logout();

        $this->post('/equipment', $this->equipment->toArray())
            ->assertRedirect('/login');
    }

    /** @test */
    public function equipment_number_is_required()
    {
        $equipment = make(Equipment::class, ['number' => null]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('number');
    }

    /** @test */
    public function equipment_number_cannot_be_more_than_10_characters()
    {
        $elevenDigits = 12345678901;
        $equipment = make(Equipment::class, ['number' => $elevenDigits]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('number');
    }

    /** @test */
    public function equipment_number_must_be_unique()
    {
        $duplicateNumber = $this->equipment->number;
        $equipment = make(Equipment::class, ['number' => $duplicateNumber]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('number');
    }

    /** @test */
    public function equipment_number_must_be_alpha_dash()
    {
        $invalidNumber = "34s-3b";
        $equipment = make(Equipment::class, ['number' => $invalidNumber]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('number');
    }

    /** @test */
    public function equipment_brand_cannot_be_more_than_50_characters()
    {
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';
        $equipment = make(Equipment::class, ['brand' => $fiftyOneCharacters]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('brand');
    }

    /** @test */
    public function equipment_brand_must_be_alpha_dash()
    {
        $invalidBrand = '<script>test</script>';
        $equipment = make(Equipment::class, ['brand' => $invalidBrand]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('brand');
    }

    /** @test */
    public function equipment_model_cannot_be_more_than_50_characters()
    {
        $this->withExceptionHandling();
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';
        $equipment = make(Equipment::class, ['model' => $fiftyOneCharacters]);
        
        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('model');
    }

    /** @test */
    public function equipment_serial_number_cannot_be_more_than_50_characters()
    {
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';
        $equipment = make(Equipment::class, ['serial_number' => $fiftyOneCharacters]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('serial_number');
    }

    /** @test */
    public function equipment_serial_number_must_be_alpha_dash()
    {
        $invalidSerialNumber = 'test<script>';
        $equipment = make(Equipment::class, ['serial_number' => $invalidSerialNumber]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('serial_number');
    }

    /** @test */
    public function equipment_weight_must_be_a_integer()
    {
        $nonInteger = '1234lb';
        $equipment = make(Equipment::class, ['weight' => $nonInteger]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('weight');
    }

    /** @test */
    public function equipment_weight_cannot_be_more_than_4_digits()
    {
        $sevenDigitWeight = '12345';
        $equipment = make(Equipment::class, ['weight' => $sevenDigitWeight]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('weight');
    }

    /** @test */
    public function equipment_weight_cannot_be_negative()
    {
        $negativeWeight = '-100';
        $equipment = make(Equipment::class, ['weight' => $negativeWeight]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('weight');
    }

    /** @test */
    public function equipment_purchase_date_cannot_be_in_the_future()
    {
        $invalidPurchaseDate = new \DateTime('January 01, 3099');
        
        $equipment = make(Equipment::class, ['purchase_date' => $invalidPurchaseDate->format('Ymd')]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('purchase_date');
    }

    /** @test */
    public function equipment_purchase_value_must_be_numeric()
    {
        $nonNumericValue = '$100';
        $equipment = make(Equipment::class, ['purchase_value' => $nonNumericValue]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('purchase_value');
    }

    /** @test */
    public function equipment_purchase_value_must_be_a_positive_value()
    {
        $negativeNumericValue = '-100';
        $equipment = make(Equipment::class, ['purchase_value' => $negativeNumericValue]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('purchase_value');
    }

    /** @test */
    public function equipment_depreciation_amount_must_be_numeric()
    {
        $nonNumericValue = '$100';
        $equipment = make(Equipment::class, ['depreciation_amount' => $nonNumericValue]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('depreciation_amount');
    }

    /** @test */
    public function equipment_depreciation_amount_must_be_a_positive_value()
    {
        $negativeNumericValue = '-100';
        $equipment = make(Equipment::class, ['depreciation_amount' => $negativeNumericValue]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('depreciation_amount');
    }

    /** @test */
    public function equipment_depreciation_amount_must_be_less_than_the_purchase_value()
    {
        $purchaseValue = 1;
        $tooHighDepreciationAmount = 2;

        $equipment = make(Equipment::class, [
            'purchase_value' => $purchaseValue,
            'depreciation_amount' => $tooHighDepreciationAmount
        ]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('depreciation_amount');
    }

    /** @test */
    public function equipment_use_must_be_alpha_dash()
    {
        $invalidUseOfEquipment = '<script>test</script>';
        $equipment = make(Equipment::class, ['use_of_equipment' => $invalidUseOfEquipment]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('use_of_equipment');
    }

    /** @test */
    public function equipment_use_cannot_be_more_than_100_characters()
    {
        $oneHundredAndOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghgasdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';
        $equipment = make(Equipment::class, ['use_of_equipment' => $oneHundredAndOneCharacters]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('use_of_equipment');
    }

    /** @test */
    public function equipment_manual_url_must_be_a_valid_url()
    {
        $invalidUrl = "invalidUrl";
        $equipment = make(Equipment::class, ['manual_url' => $invalidUrl]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('manual_url');
    }

    /** @test */
    public function equipment_service_by_days_must_be_numeric_value()
    {
        $invalidNumericalValue = 'e100';
        $equipment = make(Equipment::class, ['service_by_days' => $invalidNumericalValue]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('service_by_days');
    }

    /** @test */
    public function equipment_service_by_days_must_be_a_positive_value()
    {
        $negativeNumericValue = -30;
        $equipment = make(Equipment::class, ['service_by_days' => $negativeNumericValue]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('service_by_days');
    }

    /** @test */
    public function equipment_account_asset_number_must_be_alpha_dash_only()
    {
        $invalidAccountAssetNumber = "<script>test</script>";
        $equipment = make(Equipment::class, ['account_asset_number' => $invalidAccountAssetNumber]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('account_asset_number');
    }

    /** @test */
    public function equipment_account_asset_number_cannot_be_more_than_50_characters()
    {
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';
        $equipment = make(Equipment::class, ['account_asset_number' => $fiftyOneCharacters]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('account_asset_number');
    }

    /** @test */
    public function equipment_size_x_must_be_numeric_value()
    {
        $invalidNumericValue = 'e100';
        $equipment = make(Equipment::class, ['size_x' => $invalidNumericValue]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('size_x');
    }

    /** @test */
    public function equipment_size_x_must_be_a_positive_value()
    {
        $invalidNumericValue = '-100';
        $equipment = make(Equipment::class, ['size_x' => $invalidNumericValue]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('size_x');
    }

    /** @test */
    public function equipment_size_y_must_be_numeric_value()
    {
        $invalidNumericValue = 'e100';
        $equipment = make(Equipment::class, ['size_y' => $invalidNumericValue]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('size_y');
    }

    /** @test */
    public function equipment_size_y_must_be_a_positive_value()
    {
        $invalidNumericValue = '-100';
        $equipment = make(Equipment::class, ['size_y' => $invalidNumericValue]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('size_y');
    }

    /** @test */
    public function equipment_size_z_must_be_numeric_value()
    {
        $invalidNumericValue = '$100';
        $equipment = make(Equipment::class, ['size_z' => $invalidNumericValue]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('size_z');
    }

    /** @test */
    public function equipment_size_z_must_be_a_positive_value()
    {
        $invalidNumericValue = '-100';
        $equipment = make(Equipment::class, ['size_z' => $invalidNumericValue]);

        $this->post('/equipment', $equipment->toArray())
            ->assertSessionHasErrors('size_z');
    }
}
