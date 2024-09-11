<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('companies.update', $company->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $company->name }}" placeholder="Write something...">
            </div>

            <div class="form-group">
                <label for="tax_number">Tax number</label>
                <input type="text" name="tax_number" id="tax_number" class="form-control" value="{{ $company->tax_number }}" placeholder="Write something...">
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ $company->phone }}" placeholder="Write something...">
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input type="text" name="city" id="city" class="form-control" value="{{ $company->city }}" placeholder="Write something...">
            </div>

            <div class="form-group">
                <label for="billing_address">Billing address</label>
                <input type="text" name="billing_address" id="billing_address" class="form-control" value="{{ $company->billing_address }}" placeholder="Write something...">
            </div>

            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" name="country" id="country" class="form-control" value="{{ $company->country }}" placeholder="Write something...">
            </div>

            <div class="form-group">
                <label for="client_id">Assigned Client</label>
                <select name="client_id" id="client_id" class="form-control">
                    <option value="" disabled selected>{{ App\Traits\Language::getMessage('messages.input_text') }}</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ $client->id == $company->client_id ? 'selected' : '' }}>
                            {{ $client->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="postal_code">Postal code</label>
                <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ $company->postal_code }}" placeholder="Write something...">
            </div>

            <div class="form-group">
                <label for="employees_size">Employees size</label>
                <input type="text" name="employees_size" id="employees_size" class="form-control" value="{{ $company->employees_size }}" placeholder="Write something...">
            </div>

            <div class="form-group">
                <label for="fax">Fax</label>
                <input type="text" name="fax" id="fax" class="form-control" value="{{ $company->fax }}" placeholder="Write something...">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" placeholder="Write something...">{{ $company->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Edit company</button>
        </form>
    </div>
</div>
