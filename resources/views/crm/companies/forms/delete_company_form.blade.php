<form action="{{ route('companies.delete', ['company' => $company]) }}" method="POST" class="pull-right">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-small btn-danger">Delete this company</button>
</form>
