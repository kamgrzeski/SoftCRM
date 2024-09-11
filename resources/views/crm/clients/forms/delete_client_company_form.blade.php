<form action="{{ route('clients.delete.company', ['client' => $clientDetails, 'company' => $company->id]) }}" method="POST" class="pull-right">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Delete this companies</button>
</form>
