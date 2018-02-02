<?php

namespace Tests\Feature\Equipment;

use App\Status;
use App\Equipment;
use App\Department;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateEquipmentTest extends TestCase
{
    use RefreshDatabase;

    protected $equipment;

    public function setUp()
    {
        parent::setUp();

        $this->equipment = create(Equipment::class);

        $this->signIn();
    }

    /** @test */
    public function only_authorized_users_can_update_equipment_details()
    {
        \Auth::logout();

        $response = $this->patch($this->equipment->path(), ['brand' => 'some brand']);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function equipment_number_is_required()
    {
        $number = 'number';

        $this->updateEquipment([$number => null])
            ->assertSessionHasErrors($number);
    }

    /** @test */
    public function equipment_number_cannot_be_more_than_10_characters()
    {
        $number = 'number';
        $elevenCharacterString = '12345678901';

        $this->updateEquipment([$number => $elevenCharacterString])
            ->assertSessionHasErrors($number);
    }

    /** @test */
    public function equipment_number_must_be_unique()
    {
        $number = 'number';
        $equipment = create(Equipment::class);
        $duplicateNumber = $equipment->number;

        $this->updateEquipment([$number => $duplicateNumber])
            ->assertSessionHasErrors($number);
    }

    /** @test */
    public function equipment_number_must_be_alpha_dash()
    {
        $number = 'number';
        $nonAlphaDashString = 'test<script>';

        $this->updateEquipment([$number => $nonAlphaDashString])
            ->assertSessionHasErrors($number);
    }

    /** @test */
    public function equipment_brand_cannot_be_more_than_50_characters()
    {
        $brand = 'brand';
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';

        $this->updateEquipment([$brand => $fiftyOneCharacters])
            ->assertSessionHasErrors($brand);
    }

    /** @test */
    public function equipment_brand_must_be_alpha_dash()
    {
        $brand = 'brand';
        $nonAlphaDashString = 'test<script>';

        $this->updateEquipment([$brand => $nonAlphaDashString])
            ->assertSessionHasErrors($brand);
    }

    /** @test */
    public function equipment_model_cannot_be_more_than_50_characters()
    {
        $nodel = 'model';
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';

        $this->updateEquipment([$nodel => $fiftyOneCharacters])
            ->assertSessionHasErrors($nodel);
    }

    /** @test */
    public function equipment_model_must_be_alpha_dash()
    {
        $model = 'model';
        $nonAlphaDashString = 'test<script>';

        $this->updateEquipment([$model => $nonAlphaDashString])
            ->assertSessionHasErrors($model);
    }

    /** @test */
    public function equipment_serial_number_cannot_be_more_than_50_characters()
    {
        $serialNumber = 'serial_number';
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';

        $this->updateEquipment([$serialNumber => $fiftyOneCharacters])
            ->assertSessionHasErrors($serialNumber);
    }

    /** @test */
    public function equipment_serial_number_must_be_alpha_dash()
    {
        $serialNumber = 'serial_number';
        $nonAlphaDashString = 'test<script>';

        $this->updateEquipment([$serialNumber => $nonAlphaDashString])
            ->assertSessionHasErrors($serialNumber);
    }

    /** @test */
    public function equipment_weight_cannot_be_more_than_4_digits()
    {
        $weight = 'weight';
        $fiveDigitInteger = 12345;

        $this->updateEquipment([$weight => $fiveDigitInteger])
            ->assertSessionHasErrors($weight);
    }

    /** @test */
    public function equipment_weight_must_be_a_positive_integer()
    {
        $weight = 'weight';
        $negativeInteger = -100;

        $this->updateEquipment([$weight => $negativeInteger])
            ->assertSessionHasErrors($weight);
    }

    /** @test */
    public function equipment_purchase_date_cannot_be_in_the_future()
    {
        $purchaseDate = 'purchase_date';
        $futureDate = new \DateTime('January 01, 3099');

        $this->updateEquipment([$purchaseDate => $futureDate->format('Ymd')])
            ->assertSessionHasErrors($purchaseDate);
    }

    /** @test */
    public function equipment_purchase_value_must_be_a_positive_numeric_value()
    {
        $purchaseValue = 'purchase_value';
        $negativeNumericValue = -100;
        $nonNumericValue = '$100';

        $this->updateEquipment([$purchaseValue => $negativeNumericValue])
            ->assertSessionHasErrors($purchaseValue);

        $this->updateEquipment([$purchaseValue => $nonNumericValue])
            ->assertSessionHasErrors($purchaseValue);
    }

    /** @test */
    public function equipment_depreciation_amount_must_be_a_positive_numeric_value()
    {
        $depreciationAmount = 'depreciation_amount';
        $negativeNumericValue = -100;
        $nonNumericValue = '$100';

        $this->updateEquipment([$depreciationAmount => $negativeNumericValue])
            ->assertSessionHasErrors($depreciationAmount);

        $this->updateEquipment([$depreciationAmount => $nonNumericValue])
            ->assertSessionHasErrors($depreciationAmount);
    }

    /** @test */
    public function equipment_depreciation_amount_must_be_less_than_the_purchase_value()
    {
        $purchaseValue = 100;
        $tooHighDepreciationAmount = 199;

        $this->updateEquipment(['depreciation_amount' => $tooHighDepreciationAmount, 'purchase_value' => $purchaseValue])
            ->assertSessionHasErrors('depreciation_amount');
    }

    /** @test */
    public function equipment_use_cannot_be_more_than_100_characters()
    {
        $useOfEquipment = 'use_of_equipment';
        $oneHundredAndOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghgasdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';

        $this->updateEquipment([$useOfEquipment => $oneHundredAndOneCharacters])
            ->assertSessionHasErrors($useOfEquipment);
    }

    /** @test */
    public function equipment_manual_url_must_be_a_valid_url()
    {
        $manualUrl = 'manual_url';
        $invalidManualUrl = "test.com";

        $this->updateEquipment([$manualUrl => $invalidManualUrl])
            ->assertSessionHasErrors($manualUrl);
    }

    /** @test */
    public function equipment_service_by_days_must_be_a_positive_integer_less_than_366()
    {
        $serviceByDays = 'service_by_days';
        $nonInteger = '$100';
        $negativeInteger = -100;
        $integerGreaterThan365 = 366;

        $this->updateEquipment([$serviceByDays => $nonInteger])
            ->assertSessionHasErrors($serviceByDays);

        $this->updateEquipment([$serviceByDays => $negativeInteger])
            ->assertSessionHasErrors($serviceByDays);

        $this->updateEquipment([$serviceByDays => $integerGreaterThan365])
            ->assertSessionHasErrors($serviceByDays);
    }

    /** @test */
    public function equipment_account_asset_number_must_be_alpha_dash_only()
    {
        $accountAssetNumber = 'account_asset_number';
        $nonAlphaDashString = "<script>test</script>";

        $this->updateEquipment([$accountAssetNumber => $nonAlphaDashString])
            ->assertSessionHasErrors($accountAssetNumber);
    }

    /** @test */
    public function equipment_account_asset_number_cannot_be_more_than_50_characters()
    {
        $accountAssetNumber = 'account_asset_number';
        $fiftyOneCharacters = 'asdfgjklaskdkfjdkslslslslslslslslslslsldkdkdkdkghg3';

        $this->updateEquipment([$accountAssetNumber => $fiftyOneCharacters])
            ->assertSessionHasErrors($accountAssetNumber);
    }

    /** @test */
    public function equipment_size_x_must_be_a_positive_numeric_value()
    {
        $sizeX = 'size_x';
        $negativeValue = -100;
        $nonNumericValue = '$100';

        $this->updateEquipment([$sizeX => $nonNumericValue])
            ->assertSessionHasErrors($sizeX);

        $this->updateEquipment([$sizeX => $negativeValue])
            ->assertSessionHasErrors($sizeX);
    }

    /** @test */
    public function equipment_size_y_must_be_a_positive_numeric_value()
    {
        $sizeY = 'size_y';
        $negativeValue = -100;
        $nonNumericValue = '$100';

        $this->updateEquipment([$sizeY => $nonNumericValue])
            ->assertSessionHasErrors($sizeY);

        $this->updateEquipment([$sizeY => $negativeValue])
            ->assertSessionHasErrors($sizeY);
    }

    /** @test */
    public function equipment_size_z_must_be_a_positive_numeric_value()
    {
        $sizeZ = 'size_z';
        $negativeValue = -100;
        $nonNumericValue = '$100';

        $this->updateEquipment([$sizeZ => $nonNumericValue])
            ->assertSessionHasErrors($sizeZ);

        $this->updateEquipment([$sizeZ => $negativeValue])
            ->assertSessionHasErrors($sizeZ);
    }

    /** @test */
    public function equipment_department_must_exist_in_database()
    {
        $departmentId = 'department_id';
        $validDepartmentId = (create(Department::class))->id;
        $inValidDepartmentId = 100;

        $this->updateEquipment([$departmentId => $inValidDepartmentId])
            ->assertSessionHasErrors($departmentId);

        $this->updateEquipment([$departmentId => $validDepartmentId])
            ->assertSessionMissing($departmentId);
    }

    /** @test */
    public function equipment_status_must_exist_in_database()
    {
        $statusId = 'status_id';
        $validStatusId = (create(Status::class))->id;
        $inValidStatusId = 100;

        $this->updateEquipment([$statusId => $inValidStatusId])
            ->assertSessionHasErrors($statusId);

        $this->updateEquipment([$statusId => $validStatusId])
            ->assertSessionMissing($statusId);
    }

    private function updateEquipment($overrides = [])
    {
        return $this->patch($this->equipment->path(), $overrides);
    }
}
