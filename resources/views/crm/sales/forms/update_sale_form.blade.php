<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('sales.update', $sale->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group input-row">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ $sale->name }}" class="form-control">
            </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="product_id">Assign product</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                <select name="product_id" id="product_id" class="form-control">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ $sale->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
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
                <input type="text" name="quantity" id="quantity" value="{{ $sale->quantity }}" class="form-control" placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group">
            <label for="date_of_payment">Date of payment</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="date" name="date_of_payment" id="date_of_payment" value="{{ $sale->date_of_payment->format('Y-m-d') }}" class="form-control" required placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group">
            <label for="price">Price</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" name="price" id="price" value="{{ $sale->price }}" class="form-control" placeholder="{{ App\Traits\Language::getMessage('messages.input_text') }}">
            </div>
        </div>
    </div>

    <div class="col-lg-12 validate_form">
        <button type="submit" class="btn btn-primary">Edit sales</button>
    </div>

    </form>
</div>
