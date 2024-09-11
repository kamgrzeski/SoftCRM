<form action="{{ route('clients.delete', ['client' => $clientDetails]) }}" method="POST" class="pull-right">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Delete this client</button>
</form>
