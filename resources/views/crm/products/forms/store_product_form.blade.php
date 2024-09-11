<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="form-group input-row">
                <label for="name">Name</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Write something...">
                </div>
            </div>

            <div class="form-group input-row">
                <label for="category">Category</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-podcast"></i></span>
                    <input type="text" name="category" id="category" class="form-control" placeholder="Write something...">
                </div>
            </div>

        <div class="form-group input-row">
            <label for="count">Count</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-cog"></i></span>
                <input type="text" name="count" id="count" class="form-control" placeholder="Write something...">
            </div>
        </div>
        <div class="form-group input-row">
            <label for="price">Price</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-cog"></i></span>
                <input type="text" name="price" id="price" class="form-control" placeholder="Write something...">
            </div>
        </div>
            <button type="submit" class="btn btn-primary">Add product</button>
    </form>
</div>
</div>
