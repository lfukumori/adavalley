{{ csrf_field() }}

<div class="field">
    <label class="label">Number:</label>
    <div class="control">
        <input class="input" type="text" name="number" value="{{ $equipment->number or old('number') }}">
    </div>
</div>

<div class="field">
    <label class="label">Brand:</label>
    <div class="control">
        <input class="input" type="text" name="brand" value="{{ $equipment->brand or old('brand') }}">
    </div>
</div>

<div class="field">
    <label class="label">Model:</label>
    <div class="control">
        <input class="input" type="text" name="model" value="{{ $equipment->model or old('model') }}">
    </div>
</div>

<div class="field">
    <label class="label">Serial Number:</label>
    <div class="control">
        <input class="input" type="text" name="serial_number" value="{{ $equipment->serial_number or old('serial_number') }}">
    </div>
</div>

<div class="field">
    <label class="label">Weight:</label>
    <div class="control">
        <input class="input" type="text" name="weight" value="{{ $equipment->weight or old('weight') }}">
    </div>
</div>

<div class="field">
    <label class="label">Department:</label>
    <div class="control">
        <input class="input" type="text" name="department" value="{{ $equipment->department or old('department') }}">
    </div>
</div>

<div class="field">
    <label class="label">Category:</label>
    <div class="control">
        <input class="input" type="text" name="category" value="{{ $equipment->category or old('category') }}">
    </div>
</div>

<div class="field">
    <label class="label">Purchase Date:</label>
    <div class="control">
        <input class="input" type="date" name="purchase_date" value="{{ $equipment->purchase_date or old('purchase_date') }}">
    </div>
</div>

<div class="field">
    <label class="label">Purchase Value:</label>
    <div class="control">
        <input class="input" type="text" name="purchase_value" value="{{ $equipment->purchase_value or old('purchase_value') }}">
    </div>
</div>

<div class="field">
    <label class="label">Depreciated Value:</label>
    <div class="control">
        <input class="input" type="text" name="depreciated_value" value="{{ $equipment->depreciated_value or old('depreciated_value') }}">
    </div>
</div>

<div class="field">
    <label class="label">Real Value:</label>
    <div class="control">
        <input class="input" type="text" name="real_value" value="{{ $equipment->real_value or old('real_value') }}">
    </div>
</div>

<div class="field">
    <label class="label">Current Value:</label>
    <div class="control">
        <input class="input" type="text" name="current_value" value="{{ $equipment->current_value or old('current_value') }}">
    </div>
</div>

<div class="field">
    <label class="label">Use of Equipment:</label>
    <div class="control">
        <input class="input" type="text" name="use_of_equipment" value="{{ $equipment->use_of_equipment or old('use_of_equipment') }}">
    </div>
</div>

<div class="field">
    <label class="label">Active:</label>
    <div class="control">
        <div class="select">
            <select>
                <option>{{ $equipment->active or old('active') }}</option>
                <option value="1">True</option>
                <option value="0">False</option>
            </select>
        </div>
    </div>
</div>

<div class="field">
    <label class="label">Location:</label>
    <div class="control">
        <input class="input" type="text" name="location" value="{{ $equipment->location or old('location') }}">
    </div>
</div>

<div class="field">
    <label class="label">Manual Url:</label>
    <div class="control">
        <input class="input" type="text" name="manual_url" value="{{ $equipment->manual_url or old('manual_url') }}">
    </div>
</div>

<div class="field">
    <label class="label">Procedures Location:</label>
    <div class="control">
        <input class="input" type="text" name="procedures_location" value="{{ $equipment->procedures_location or old('procedures_location') }}">
    </div>
</div>

<div class="field">
    <label class="label">Description:</label>
    <div class="control">
        <input class="input" type="text" name="description" value="{{ $equipment->description or old('description') }}">
    </div>
</div>

<div class="field">
    <label class="label">Depreciation Value:</label>
    <div class="control">
        <input class="input" type="text" name="depreciation_value" value="{{ $equipment->depreciation_value or old('depreciation_value') }}">
    </div>
</div>

<div class="field">
    <label class="label">Depreciation Note:</label>
    <div class="control">
        <input class="input" type="text" name="depreciation_note" value="{{ $equipment->depreciation_note or old('depreciation_note') }}">
    </div>
</div>

<div class="field">
    <label class="label">Account Asset Number:</label>
    <div class="control">
        <input class="input" type="text" name="account_asset_number" value="{{ $equipment->account_asset_number or old('account_asset_number') }}">
    </div>
</div>

<div class="field">
    <label class="label">Date Removed:</label>
    <div class="control">
        <input class="input" type="date" name="date_removed" value="{{ $equipment->date_removed or old('date_removed') }}">
    </div>
</div>

<div class="field">
    <label class="label">Service by Days:</label>
    <div class="control">
        <input class="input" type="text" name="service_by_days" value="{{ $equipment->service_by_days or old('service_by_days') }}">
    </div>
</div>

<div class="field">
    <label class="label">Manual File Location:</label>
    <div class="control">
        <input class="input" type="text" name="manual_file_location" value="{{ $equipment->manual_file_location or old('manual_file_location') }}">
    </div>
</div>

<div class="field">
    <label class="label">Schematics Location:</label>
    <div class="control">
        <input class="input" type="text" name="schematics_location" value="{{ $equipment->schematics_location or old('schematics_location') }}">
    </div>
</div>

<div class="field">
    <label class="label">SizeX:</label>
    <div class="control">
        <input class="input" type="text" name="sizeX" value="{{ $equipment->sizeX or old('sizeX') }}">
    </div>
</div>

<div class="field">
    <label class="label">SizeY:</label>
    <div class="control">
        <input class="input" type="text" name="sizeY" value="{{ $equipment->sizeY or old('sizeY') }}">
    </div>
</div>

<div class="field">
    <label class="label">SizeZ:</label>
    <div class="control">
        <input class="input" type="text" name="sizeZ" value="{{ $equipment->sizeZ or old('sizeZ') }}">
    </div>
</div>

<div class="field is-grouped">
    <p class="control">
        <button type="submit" class="button is-primary">
            {{ $submitButtonText }}
        </button>
    </p>
    <p class="control">
        <a href="{{ route('equipment.index') }}" class="button is-light">
            Cancel
        </a>
    </p>
</div>