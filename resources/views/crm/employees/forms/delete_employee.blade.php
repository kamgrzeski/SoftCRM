<form action="{{ route('employees.delete', $employee) }}" method="POST" class="pull-right">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-small btn-danger">Delete this employee</button>
</form>
