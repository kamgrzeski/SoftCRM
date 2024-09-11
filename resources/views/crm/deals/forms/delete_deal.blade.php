<form action="{{ route('deals.terms.delete', ['dealTerm' => $terms->id]) }}" method="POST" class="pull-right">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-small btn-danger btn-padding">Delete</button>
</form>
