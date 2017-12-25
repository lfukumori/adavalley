{{ csrf_field() }}

<div class="field">
    <label class="label">Name:</label>
    <div class="control">
        <input class="input" type="text" name="name" value="{{ $part->name or old('name') }}">
    </div>
</div>

<div class="field">
    <label class="label">Serial Number:</label>
    <div class="control">
        <input class="input" type="text" name="serial_number" value="{{ $part->serial_number or old('serial_number') }}">
    </div>
</div>

<div class="field">
    <label class="label">Purchase Value:</label>
    <div class="control">
        <input class="input" type="text" name="purchase_value" value="{{ $part->purchase_value or old('purchase_value') }}">
    </div>
</div>

<div class="field">
    <label class="label">Purchase Date:</label>
    <div class="control">
        <input class="input" type="text" name="purchase_date" value="{{ $part->purchase_date or old('purchase_date') }}">
    </div>
</div>

<div class="field">
    <label class="label">Description:</label>
    <div class="control">
        <input class="input" type="text" name="description" value="{{ $part->description or old('description') }}">
    </div>
</div>

<div class="field">
    <label class="label">Extended Description:</label>
    <div class="control">
        <input class="input" type="text" name="extended_description" value="{{ $part->extended_description or old('extended_description') }}">
    </div>
</div>

<div class="field is-grouped">
    <p class="control">
        <button type="submit" class="button is-primary">
            {{ $submitButtonText }}
        </button>
    </p>
    <p class="control">
        <a href="{{ route('part.index') }}" class="button is-light">
            Cancel
        </a>
    </p>
</div>