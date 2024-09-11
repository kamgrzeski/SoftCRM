<div class="modal fade" id="deleteEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="myModalLabel">You want delete this employee?</h4>
            </div>
            <div class="modal-body">
                Action will delete permanently this employees.
            </div>
            <div class="modal-footer">
                @include('crm.employees.forms.delete_employee')
            </div>
        </div>
    </div>
</div>
