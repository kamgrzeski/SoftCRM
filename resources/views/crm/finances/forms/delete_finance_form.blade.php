<form action="{{ route('finances.delete', $finance) }}" method="POST" class="pull-right">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-small btn-danger">Delete this finance</button>
</form>
