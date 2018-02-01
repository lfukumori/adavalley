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
    <label class="label">Description:</label>
    <div class="control">
        <input class="input" type="text" name="description" value="{{ $equipment->description or old('description') }}">
    </div>
</div>

<div class="field">
    <label class="label">Weight:</label>
    <div class="control">
        <input class="input" type="number" name="weight" value="{{ $equipment->weight or old('weight') }}">
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
    <label class="label">Depreciation Amount:</label>
    <div class="control">
        <input class="input" type="text" name="depreciation_amount" value="{{ $equipment->depreciation_amount or old('depreciation_amount') }}">
    </div>
</div>

<div class="field">
    <label class="label">Depreciation Note:</label>
    <div class="control">
        <input class="input" type="text" name="depreciation_note" value="{{ $equipment->depreciation_note or old('depreciation_note') }}">
    </div>
</div>

<div class="field">
    <label class="label">Use of Equipment:</label>
    <div class="control">
        <input class="input" type="text" name="use_of_equipment" value="{{ $equipment->use_of_equipment or old('use_of_equipment') }}">
    </div>
</div>

<div class="field">
    <label class="label">Status:</label>
    <div class="control">
        <div class="select">
            <select name="status_id">
                @foreach($statuses as $status)

                    @if(old('status_id', $equipment->status_id) == $status->id)
                        <option value="{{ $status->id }}" selected >{{ $status->name }}</option>
                    @else
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endif
                    
                @endforeach 
            </select>
        </div>
    </div>
</div>

<div class="field">
    <label class="label">Department:</label>
    <div class="control">
        <div class="select">
            <select name="department_id">
                @foreach ($departments as $department)
                    @if (old('department_id') == $department->id)
                        <option value="{{ $department->id }}" selected>{{ $department->name }}</option>
                    @else
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="field">
    <label class="label">Manual Url:</label>
    <div class="control">
        <input class="input" type="text" name="manual_url" value="{{ $equipment->manual_url or old('manual_url') }}">
    </div>
</div>

<div class="field">
    <label class="label">Paper Manual Location:</label>
    <div class="control">
        <div class="select">
            <select name="manual_file_location">
                <option>{{ $equipment->manual_file_location or old('manual_file_location') }}</option>
                <option value="Filing Cabinet">Manual Filing Cabinet</option>
            </select>
        </div>
    </div>
</div>

<div class="field">
    <label class="label">Procedures Location:</label>
    <div class="control">
        <div class="select">
            <select name="procedures_location">
                <option>{{ $equipment->procedures_location or old('procedures_location') }}</option>
                <option value="Filing Cabinet">Procedures Filing Cabinet</option>
            </select>
        </div>
    </div>
</div>

<div class="field">
    <label class="label">Schematics Location:</label>
    <div class="control">
        <div class="select">
            <select name="schematics_location">
                <option>{{ $equipment->schematics_location or old('schematics_location') }}</option>
                <option value="Filing Cabinet">Schematics Filing Cabinet</option>
            </select>
        </div>
    </div>
</div>

<div class="field">
    <label class="label">Service by Days:</label>
    <div class="control">
        <input class="input" type="number" min="1" max="365" name="service_by_days" value="{{ $equipment->service_by_days or old('service_by_days') }}">
    </div>
</div>

<div class="field">
    <label class="label">Account Asset Number:</label>
    <div class="control">
        <input class="input" type="text" name="account_asset_number" value="{{ $equipment->account_asset_number or old('account_asset_number') }}">
    </div>
</div>

<div class="field">
    <label class="label">SizeX:</label>
    <div class="control">
        <input class="input" type="text" name="size_x" value="{{ $equipment->size_x or old('size_x') }}">
    </div>
</div>

<div class="field">
    <label class="label">SizeY:</label>
    <div class="control">
        <input class="input" type="text" name="size_y" value="{{ $equipment->size_y or old('size_y') }}">
    </div>
</div>

<div class="field">
    <label class="label">SizeZ:</label>
    <div class="control">
        <input class="input" type="text" name="size_z" value="{{ $equipment->size_z or old('size_z') }}">
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
