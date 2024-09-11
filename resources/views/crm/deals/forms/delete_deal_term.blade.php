<form action="{{ route('deals.delete', ['deal' => $deal->id]) }}" method="POST" class="pull-right">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-small btn-danger btn-padding">Delete</button>
</form>
