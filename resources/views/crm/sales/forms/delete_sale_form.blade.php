<form action="{{ route('sales.delete', $sale) }}" method="POST" class="pull-right">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-small btn-danger">Delete this sale</button>
</form>
