<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('sales.store') }}" method="POST">
            @csrf
            <div class="form-group input-row">
                <label for="name">Name</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
                </div>
            </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="product_id">Assign product</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                <select name="product_id" id="product_id" class="form-control" placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="quantity">Quantity</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                <input type="text" name="quantity" id="quantity" class="form-control" placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group">
            <label for="date_of_payment">Date of payment</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="date" name="date_of_payment" id="date_of_payment" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control" required placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="price">Price</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                <input type="text" name="price" id="price" class="form-control" placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
            </div>
        </div>
    </div>

    <div class="col-lg-12 validate_form">
        <button type="submit" class="btn btn-primary">Add sales</button>
    </div>

    </form>
</div>
