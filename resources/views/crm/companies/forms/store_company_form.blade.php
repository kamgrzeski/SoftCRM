<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('companies.store') }}" method="POST">
            @csrf

            <div class="form-group input-row">
                <label for="name">Name</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Write something...">
                </div>
            </div>

            <div class="form-group input-row">
                <label for="tax_number">Tax number</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-slack"></i></span>
                    <input type="text" name="tax_number" id="tax_number" class="form-control" placeholder="Write something...">
                </div>
            </div>

            <div class="form-group input-row">
                <label for="phone">Phone</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-phone-square"></i></span>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Write something...">
                </div>
            </div>

            <div class="form-group input-row">
                <label for="city">City</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                    <input type="text" name="city" id="city" class="form-control" placeholder="Write something...">
                </div>
            </div>

            <div class="form-group input-row">
                <label for="billing_address">Billing address</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                    <input type="text" name="billing_address" id="billing_address" class="form-control" placeholder="Write something...">
                </div>
            </div>

            <div class="form-group input-row">
                <label for="country">Country</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                    <input type="text" name="country" id="country" class="form-control" placeholder="Write something...">
                </div>
            </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="postal_code">Postal code</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Write something...">
            </div>
        </div>

        <div class="form-group input-row">
            <label for="employees_size">Employee size</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-crop"></i></span>
                <input type="text" name="employees_size" id="employees_size" class="form-control" placeholder="Write something...">
            </div>
        </div>

        <div class="form-group input-row">
            <label for="fax">Fax number</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                <input type="text" name="fax" id="fax" class="form-control" placeholder="Write something...">
            </div>
        </div>

        <div class="form-group input-row">
            <label for="client_id">Assign client</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                <select name="client_id" id="client_id" class="form-control">
                    <option value="" disabled selected>{{ App\Traits\Language::getMessage('messages.input_text') }}</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->full_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group input-row">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" placeholder="Write something..."></textarea>
        </div>
    </div>

    <div class="col-lg-12 validate_form">
        <button type="submit" class="btn btn-primary">Add company</button>
    </div>
    </form>
</div>
