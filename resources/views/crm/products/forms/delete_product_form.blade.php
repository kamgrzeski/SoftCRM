<form action="{{ route('products.delete', $product) }}" method="POST" class="pull-right">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-small btn-danger">Delete this product</button>
</form>
