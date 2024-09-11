<div class="modal fade" id="deleteClientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="myModalLabel">You want delete this client?</h4>
            </div>
            <div class="modal-body">
                Action will delete permanently this client.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right: 15px;">
                    Close
                </button>
                @include('crm.clients.forms.delete_client_form')
            </div>
        </div>
    </div>
</div>
