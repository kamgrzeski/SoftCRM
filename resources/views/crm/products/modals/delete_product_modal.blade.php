<div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="myModalLabel">You want delete this product?</h4>
            </div>
            <div class="modal-body">
                Action will delete permanently this product.
            </div>
            <div class="modal-footer">
                @include('crm.products.forms.delete_product_form')
            </div>
        </div>
    </div>
</div>
