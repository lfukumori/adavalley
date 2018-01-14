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

    protected $equipment;

    public function setUp()
    {
        parent::setUp();
        $this->equipment = create(Equipment::class);

        $this->signIn();
        $this->withoutExceptionHandling();
    }
    
    /** @test */
    public function only_signed_in_users_can_add_equipment()
    {
        \Auth::logout();
        $this->withExceptionHandling();

        $response = $this->post('/equipment', $this->equipment->toArray());
        $response->assertRedirect('/login');
    }

    /** @test */
    public function equipment_number_is_required()
    {
        $equipment = make(Equipment::class, ['number' => null]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_number_cannot_be_more_than_10_characters()
    {
        $elevenDigits = 12345678901;
        $equipment = make(Equipment::class, ['number' => $elevenDigits]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_number_must_be_unique()
    {
        $duplicateNumber = $this->equipment->number;
        $equipment = make(Equipment::class, ['number' => $duplicateNumber]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_number_must_be_alpha_dash()
    {
        $invalidNumber = "34s-3b";
        $equipment = make(Equipment::class, ['number' => $invalidNumber]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_brand_cannot_be_more_than_50_characters()
    {
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';
        $equipment = make(Equipment::class, ['brand' => $fiftyOneCharacters]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_brand_must_be_alpha_dash()
    {
        $invalidBrand = '<script>test</script>';
        $equipment = make(Equipment::class, ['brand' => $invalidBrand]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_model_cannot_be_more_than_50_characters()
    {
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';
        $equipment = make(Equipment::class, ['model' => $fiftyOneCharacters]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_serial_number_cannot_be_more_than_50_characters()
    {
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';
        $equipment = make(Equipment::class, ['serial_number' => $fiftyOneCharacters]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_serial_number_must_be_alpha_dash()
    {
        $invalidSerialNumber = '<script>test</script>';
        $equipment = make(Equipment::class, ['serial_number' => $invalidSerialNumber]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_weight_must_be_a_numeric()
    {
        $invalidWeight = '$1234';
        $equipment = make(Equipment::class, ['weight' => $invalidWeight]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_weight_must_be_a_positive_value()
    {
        $invalidWeight = '-100';
        $equipment = make(Equipment::class, ['weight' => $invalidWeight]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_purchase_date_cannot_be_in_the_future()
    {
        $invalidPurchaseDate = new \DateTime('January 01, 2399');
        $equipment = make(Equipment::class, ['purchase_date' => $invalidPurchaseDate]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_purchase_value_must_be_numeric()
    {
        $nonNumericValue = '$100';
        $equipment = make(Equipment::class, ['purchase_value' => $nonNumericValue]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_purchase_value_must_be_a_positive_value()
    {
        $negativeNumericValue = '-100';
        $equipment = make(Equipment::class, ['purchase_value' => $negativeNumericValue]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_depreciation_value_must_be_numeric()
    {
        $nonNumericValue = '$100';
        $equipment = make(Equipment::class, ['depreciation_value' => $nonNumericValue]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_depreciation_value_must_be_a_positive_value()
    {
        $negativeNumericValue = '-100';
        $equipment = make(Equipment::class, ['depreciation_value' => $negativeNumericValue]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_use_must_be_alpha_dash()
    {
        $invalidUseOfEquipment = '<script>test</script>';
        $equipment = make(Equipment::class, ['use_of_equipment' => $invalidUseOfEquipment]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_use_cannot_be_more_than_100_characters()
    {
        $oneHundredAndOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghgasdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';
        $equipment = make(Equipment::class, ['use_of_equipment' => $oneHundredAndOneCharacters]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_manual_url_must_be_a_valid_url()
    {
        $invalidUrl = "www.test";
        $equipment = make(Equipment::class, ['manual_url' => $invalidUrl]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_service_by_days_must_be_a_numeric_value()
    {
        $invalidNumericalValue = 'e100';
        $equipment = make(Equipment::class, ['service_by_days' => $invalidNumericalValue]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_service_by_days_must_be_a_positive_value()
    {
        $negativeNumericValue = -30;
        $equipment = make(Equipment::class, ['service_by_days' => $negativeNumericValue]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_account_asset_number_must_be_alpha_dash_only()
    {
        $invalidAccountAssetNumber = "<script>test</script>";
        $equipment = make(Equipment::class, ['account_asset_number' => $invalidAccountAssetNumber]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_account_asset_number_cannot_be_more_than_50_characters()
    {
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';
        $equipment = make(Equipment::class, ['account_asset_number' => $fiftyOneCharacters]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_size_x_must_be_a_numeric_value()
    {
        $invalidNumericValue = 'e100';
        $equipment = make(Equipment::class, ['size_x' => $invalidNumericValue]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_size_x_must_be_a_positive_value()
    {
        $invalidNumericValue = '-100';
        $equipment = make(Equipment::class, ['size_x' => $invalidNumericValue]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_size_y_must_be_a_numeric_value()
    {
        $invalidNumericValue = 'e100';
        $equipment = make(Equipment::class, ['size_y' => $invalidNumericValue]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_size_y_must_be_a_positive_value()
    {
        $invalidNumericValue = '-100';
        $equipment = make(Equipment::class, ['size_y' => $invalidNumericValue]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_size_z_must_be_a_numeric_value()
    {
        $invalidNumericValue = 'e100';
        $equipment = make(Equipment::class, ['size_z' => $invalidNumericValue]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }

    /** @test */
    public function equipment_size_z_must_be_a_positive_value()
    {
        $invalidNumericValue = '-100';
        $equipment = make(Equipment::class, ['size_z' => $invalidNumericValue]);

        $this->expectException(ValidationException::class);
        $this->post('/equipment', $equipment->toArray());
    }
}
