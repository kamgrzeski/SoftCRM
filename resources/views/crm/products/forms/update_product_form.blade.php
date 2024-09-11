<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group input-row">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" placeholder="Write something...">
            </div>
            <div class="form-group input-row">
                <label for="category">Category</label>
                <input type="text" name="category" id="category" class="form-control" value="{{ $product->category }}" placeholder="Write something...">
            </div>

            <div class="form-group input-row">
                <label for="count">Count</label>
                <input type="text" name="count" id="count" class="form-control" value="{{ $product->count }}" placeholder="Write something...">
            </div>
            <div class="form-group input-row">
                <label for="price">Price</label>
                <input type="text" name="price" id="price" class="form-control" value="{{ $product->price }}" placeholder="Write something...">
            </div>

            <button type="submit" class="btn btn-primary">Edit product</button>
        </form>
    </div>
</div>
