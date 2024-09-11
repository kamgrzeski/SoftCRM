<form action="{{ route('tasks.delete', $task) }}" method="POST" class="pull-right">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-small btn-danger">Delete this task</button>
</form>
