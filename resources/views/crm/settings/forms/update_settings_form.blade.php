<form action="{{ route('settings.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="pagination_size">Pagination size</label>
            <input type="text" name="pagination_size" id="pagination_size" value="{{ $settings->where('key', 'pagination_size')->first()->value }}" class="form-control">
        </div>
        <div class="form-group input-row">
            <label for="priority_size">Priority size</label>
            <input type="text" name="priority_size" id="priority_size" value="{{ $settings->where('key', 'priority_size')->first()->value }}" class="form-control">
        </div>
        <div class="form-group input-row">
            <label for="loading_circle">Loading circle</label>
            <select name="loading_circle" id="loading_circle" class="form-control">
                <option value="1" {{ $settings->where('key', 'loading_circle')->first()->value == 1 ? 'selected' : '' }}>Show</option>
                <option value="0" {{ $settings->where('key', 'loading_circle')->first()->value == 0 ? 'selected' : '' }}>Don't show</option>
            </select>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="currency">Currency type</label>
            <select name="currency" id="currency" class="form-control">
                <option value="PLN" {{ $settings->where('key', 'currency')->first()->value == 'PLN' ? 'selected' : '' }}>PLN</option>
                <option value="EUR" {{ $settings->where('key', 'currency')->first()->value == 'EUR' ? 'selected' : '' }}>EUR</option>
                <option value="USD" {{ $settings->where('key', 'currency')->first()->value == 'USD' ? 'selected' : '' }}>USD</option>
            </select>
        </div>
        <div class="form-group input-row">
            <label for="invoice_tax">Tax</label>
            <input type="text" name="invoice_tax" id="invoice_tax" value="{{ $settings->where('key', 'invoice_tax')->first()->value }}" class="form-control">
        </div>
    </div>

    <div class="col-lg-12 validate_form">
        <button type="submit" class="btn btn-primary">Save settings</button>
    </div>
</form>
