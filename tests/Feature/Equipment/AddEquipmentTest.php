<?php

namespace Tests\Feature\Equipment;

use App\Equipment;
use App\Department;
use Tests\TestCase;
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
        $number = 'number';

        $this->createEquipment([$number => null])
            ->assertSessionHasErrors($number);
    }

    /** @test */
    public function equipment_number_cannot_be_more_than_10_characters()
    {
        $number = 'number';
        $elevenCharacterString = '12345678901';

        $this->createEquipment([$number => $elevenCharacterString])
            ->assertSessionHasErrors($number);
    }

    /** @test */
    public function equipment_number_must_be_unique()
    {
        $number = 'number';
        $duplicateNumber = $this->equipment->number;

        $this->createEquipment([$number => $duplicateNumber])
            ->assertSessionHasErrors($number);
    }

    /** @test */
    public function equipment_number_must_be_alpha_dash()
    {
        $number = 'number';
        $nonAlphaDashString = 'test<script>';

        $this->createEquipment([$number => $nonAlphaDashString])
            ->assertSessionHasErrors($number);
    }

    /** @test */
    public function equipment_brand_cannot_be_more_than_50_characters()
    {
        $brand = 'brand';
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';

        $this->createEquipment([$brand => $fiftyOneCharacters])
            ->assertSessionHasErrors($brand);
    }

    /** @test */
    public function equipment_brand_must_be_alpha_dash()
    {
        $brand = 'brand';
        $nonAlphaDashString = 'test<script>';

        $this->createEquipment([$brand => $nonAlphaDashString])
            ->assertSessionHasErrors($brand);
    }

    /** @test */
    public function equipment_model_cannot_be_more_than_50_characters()
    {
        $nodel = 'model';
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';

        $this->createEquipment([$nodel => $fiftyOneCharacters])
            ->assertSessionHasErrors($nodel);
    }

    /** @test */
    public function equipment_model_must_be_alpha_dash()
    {
        $model = 'model';
        $nonAlphaDashString = 'test<script>';

        $this->createEquipment([$model => $nonAlphaDashString])
            ->assertSessionHasErrors($model);
    }

    /** @test */
    public function equipment_serial_number_cannot_be_more_than_50_characters()
    {
        $serialNumber = 'serial_number';
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';

        $this->createEquipment([$serialNumber => $fiftyOneCharacters])
            ->assertSessionHasErrors($serialNumber);
    }

    /** @test */
    public function equipment_serial_number_must_be_alpha_dash()
    {
        $serialNumber = 'serial_number';
        $nonAlphaDashString = 'test<script>';

        $this->createEquipment([$serialNumber => $nonAlphaDashString])
            ->assertSessionHasErrors($serialNumber);
    }

    /** @test */
    public function equipment_weight_cannot_be_more_than_4_digits()
    {
        $weight = 'weight';
        $fiveDigitInteger = 12345;

        $this->createEquipment([$weight => $fiveDigitInteger])
            ->assertSessionHasErrors($weight);
    }

    /** @test */
    public function equipment_weight_must_be_a_positive_integer()
    {
        $weight = 'weight';
        $negativeInteger = -100;

        $this->createEquipment([$weight => $negativeInteger])
            ->assertSessionHasErrors($weight);
    }

    /** @test */
    public function equipment_purchase_date_cannot_be_in_the_future()
    {
        $purchaseDate = 'purchase_date';
        $futureDate = new \DateTime('January 01, 3099');

        $this->createEquipment([$purchaseDate => $futureDate->format('Ymd')])
            ->assertSessionHasErrors($purchaseDate);
    }

    /** @test */
    public function equipment_purchase_value_must_be_a_positive_numeric_value()
    {
        $purchaseValue = 'purchase_value';
        $negativeNumericValue = -100;
        $nonNumericValue = '$100';

        $this->createEquipment([$purchaseValue => $negativeNumericValue])
            ->assertSessionHasErrors($purchaseValue);

        $this->createEquipment([$purchaseValue => $nonNumericValue])
            ->assertSessionHasErrors($purchaseValue);
    }

    /** @test */
    public function equipment_depreciation_amount_must_be_a_positive_numeric_value()
    {
        $depreciationAmount = 'depreciation_amount';
        $negativeNumericValue = -100;
        $nonNumericValue = '$100';

        $this->createEquipment([$depreciationAmount => $negativeNumericValue])
            ->assertSessionHasErrors($depreciationAmount);

        $this->createEquipment([$depreciationAmount => $nonNumericValue])
            ->assertSessionHasErrors($depreciationAmount);
    }

    /** @test */
    public function equipment_depreciation_amount_must_be_less_than_the_purchase_value()
    {
        $purchaseValue = 100;
        $tooHighDepreciationAmount = 199;

        $this->createEquipment(['depreciation_amount' => $tooHighDepreciationAmount, 'purchase_value' => $purchaseValue])
            ->assertSessionHasErrors('depreciation_amount');
    }

    /** @test */
    public function equipment_use_cannot_be_more_than_100_characters()
    {
        $useOfEquipment = 'use_of_equipment';
        $oneHundredAndOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghgasdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';
        
        $this->createEquipment([$useOfEquipment => $oneHundredAndOneCharacters])
            ->assertSessionHasErrors($useOfEquipment);
    }

    /** @test */
    public function equipment_manual_url_must_be_a_valid_url()
    {
        $manualUrl = 'manual_url';
        $invalidManualUrl = "test.com";

        $this->createEquipment([$manualUrl => $invalidManualUrl])
            ->assertSessionHasErrors($manualUrl);
    }

    /** @test */
    public function equipment_service_by_days_must_be_a_positive_integer_less_than_366()
    {
        $serviceByDays = 'service_by_days';
        $nonInteger = '$100';
        $negativeInteger = -100;
        $integerGreaterThan365 = 366;

        $this->createEquipment([$serviceByDays => $nonInteger])
            ->assertSessionHasErrors($serviceByDays);

        $this->createEquipment([$serviceByDays => $negativeInteger])
            ->assertSessionHasErrors($serviceByDays);

        $this->createEquipment([$serviceByDays => $integerGreaterThan365])
            ->assertSessionHasErrors($serviceByDays);
    }

    /** @test */
    public function equipment_account_asset_number_must_be_alpha_dash_only()
    {
        $accountAssetNumber = 'account_asset_number';
        $nonAlphaDashString = "<script>test</script>";

        $this->createEquipment([$accountAssetNumber => $nonAlphaDashString])
            ->assertSessionHasErrors($accountAssetNumber);
    }

    /** @test */
    public function equipment_account_asset_number_cannot_be_more_than_50_characters()
    {
        $accountAssetNumber = 'account_asset_number';
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';
        
        $this->createEquipment([$accountAssetNumber => $fiftyOneCharacters])
            ->assertSessionHasErrors($accountAssetNumber);
    }

    /** @test */
    public function equipment_size_x_must_be_a_positive_numeric_value()
    {
        $sizeX = 'size_x';
        $negativeValue = -100;
        $nonNumericValue = '$100';

        $this->createEquipment([$sizeX => $nonNumericValue])
            ->assertSessionHasErrors($sizeX);

        $this->createEquipment([$sizeX => $negativeValue])
            ->assertSessionHasErrors($sizeX);
    }

    /** @test */
    public function equipment_size_y_must_be_a_positive_numeric_value()
    {
        $sizeY = 'size_y';
        $negativeValue = -100;
        $nonNumericValue = '$100';

        $this->createEquipment([$sizeY => $nonNumericValue])
            ->assertSessionHasErrors($sizeY);

        $this->createEquipment([$sizeY => $negativeValue])
            ->assertSessionHasErrors($sizeY);
    }

    /** @test */
    public function equipment_size_z_must_be_a_positive_numeric_value()
    {
        $sizeZ = 'size_z';
        $negativeValue = -100;
        $nonNumericValue = '$100';

        $this->createEquipment([$sizeZ => $nonNumericValue])
            ->assertSessionHasErrors($sizeZ);

        $this->createEquipment([$sizeZ => $negativeValue])
            ->assertSessionHasErrors($sizeZ);
    }

    /** @test */
    public function equipment_department_must_exist_in_database()
    {
        $departmentId = 'department_id';
        $validDepartmentId = (create(Department::class))->id;
        $inValidDepartmentId = 100;

        $this->createEquipment([$departmentId => $inValidDepartmentId])
            ->assertSessionHasErrors($departmentId);

        $this->createEquipment([$departmentId => $validDepartmentId])
            ->assertSessionMissing($departmentId);
    }

    private function createEquipment($overrides = [])
    {
        $equipment = make(Equipment::class, $overrides);

        return $this->post('/equipment', $equipment->toArray());
    }
}
