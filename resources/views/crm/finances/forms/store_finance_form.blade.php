<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('finances.store') }}" method="POST">
            @csrf
            <div class="form-group input-row">
                <label for="name">Name</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                    <input type="text" name="name" class="form-control" placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
                </div>
            </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="companies_id">Assign companies</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                <select name="companies_id" class="form-control" placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
                    @foreach ($companies as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="description">Description</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                <input type="text" name="description" class="form-control" placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="type">Type</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                <select name="type" class="form-control" placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
                    <option value="">Please select type</option>
                    <option value="Invoice">Invoice</option>
                    <option value="proforma invoice">Proforma invoice</option>
                    <option value="advance">Advance</option>
                    <option value="simple transfer">Simple transfer</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="gross">Gross</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                <input type="text" name="gross" class="form-control" placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="category">Category</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                <select name="category" class="form-control" placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
                    <option value="">Please select category</option>
                    <option value="steady income">Steady income</option>
                    <option value="large order">Large order</option>
                    <option value="small order">Small order</option>
                    <option value="one-off order">One-off order</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group">
            <label for="date">Date</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="date" name="date" class="form-control" required placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
            </div>
        </div>
    </div>

    <div class="col-lg-12 validate_form">
        <button type="submit" class="btn btn-primary">Add finances</button>
    </div>
    </form>
</div>
