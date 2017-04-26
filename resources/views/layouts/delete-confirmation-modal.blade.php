<!-- *** DELETE CONFIRMATION MODAL *** -->
<div class="modal fade" id="delete-confirmation-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog modal-sm">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="Login">Konfirmasi Penghapusan Item</h4>
            </div>
            <div class="modal-body">
                <form action="{{url('user/carts/delete-item?id=cart_id')}}" method="post">
                    <p class="text-center text-muted">
                        Anda yakin untuk menghapus item ini? <strong id="delete-question"></strong>
                    </p>

                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="delete">

                    <p class="text-center">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fa fa-times submit"></i> Tidak
                        </button>
                        <button class="btn btn-default" name="submit">
                            <i class="fa fa-check"></i> Ya
                        </button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- *** DELETE CONFIRMATION MODAL END *** -->