{{ csrf_field() }}

<div class="field">
    <label class="label">Name:</label>
    <div class="control">
        <input class="input" type="text" name="name" value="{{ $vendor->name or old('name') }}">
    </div>
</div>

<div class="field">
    <label class="label">Email:</label>
    <div class="control">
        <input class="input" type="email" name="email" value="{{ $vendor->email or old('email') }}">
    </div>
</div>

<div class="field">
    <label class="label">Phone:</label>
    <div class="control">
        <input class="input" type="tel" name="phone_number" value="{{ $vendor->phone_number or old('phone_number') }}">
    </div>
</div>

<div class="field is-grouped">
    <p class="control">
        <button type="submit" class="button is-primary">
            {{ $submitButtonText }}
        </button>
    </p>
    <p class="control">
        <a href="{{ route('vendor.index') }}" class="button is-light">
            Cancel
        </a>
    </p>
</div>