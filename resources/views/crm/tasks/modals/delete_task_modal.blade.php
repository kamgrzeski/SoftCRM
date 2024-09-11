<div class="modal fade" id="deleteTaskModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="myModalLabel">You want delete this task?</h4>
            </div>
            <div class="modal-body">
                Action will delete permanently this task.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right: 15px;">Close</button>
                @include('crm.tasks.forms.delete_task_form')
            </div>
        </div>
    </div>
</div>
