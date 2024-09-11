<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('finances.update', $finance->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group input-row">
                <label for="name">Name</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                    <input type="text" name="name" value="{{ $finance->name }}" class="form-control" placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
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
                        <option value="{{ $id }}" {{ $finance->companies_id == $id ? 'selected' : '' }}>{{ $name }}</option>
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
                <input type="text" name="description" value="{{ $finance->description }}" class="form-control" placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
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
                    <option value="Invoice" {{ $finance->type == 'Invoice' ? 'selected' : '' }}>Invoice</option>
                    <option value="proforma invoice" {{ $finance->type == 'proforma invoice' ? 'selected' : '' }}>Proforma invoice</option>
                    <option value="advance" {{ $finance->type == 'advance' ? 'selected' : '' }}>Advance</option>
                    <option value="simple transfer" {{ $finance->type == 'simple transfer' ? 'selected' : '' }}>Simple transfer</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="gross">Gross</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                <input type="text" name="gross" value="{{ $finance->gross }}" class="form-control" placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
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
                    <option value="steady income" {{ $finance->category == 'steady income' ? 'selected' : '' }}>Steady income</option>
                    <option value="large order" {{ $finance->category == 'large order' ? 'selected' : '' }}>Large order</option>
                    <option value="small order" {{ $finance->category == 'small order' ? 'selected' : '' }}>Small order</option>
                    <option value="one-off order" {{ $finance->category == 'one-off order' ? 'selected' : '' }}>One-off order</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group">
            <label for="date">Date</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="date" name="date" class="form-control" required placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}" value="{{ $finance->date->format('Y-m-d') }}">
            </div>
        </div>
    </div>

    <div class="col-lg-12 validate_form">
        <button type="submit" class="btn btn-primary">Edit finance</button>
    </div>
    </form>
</div>
