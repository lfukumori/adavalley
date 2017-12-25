{{ csrf_field() }}

<div class="field">
    <label for="name" class="label">Name:</label>
    <div class="control">
        <input id="name" class="input" type="text" name="name" value="{{ $workOrder->name or old('name') }}">
    </div>
</div>

<div class="field">
    <label for="recurring" class="label">Recurring:</label>
    <div class="control">
        <input id="recurring" class="input" type="checkbox" name="recurring" value="{{ $workOrder->recurring or old('recurring') }}">
    </div>
</div>

<div class="field is-grouped">
    <p class="control">
        <button type="submit" class="button is-primary">
            {{ $submitButtonText }}
        </button>
    </p>
    <p class="control">
        <a href="{{ route('work-order.index') }}" class="button is-light">
            Cancel
        </a>
    </p>
</div>