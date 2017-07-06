<!-- *** DELETE CONFIRMATION MODAL *** -->
<div class="modal fade" id="topup-confirmation-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog modal-sm">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="Login">Konfirmasi Topup</h4>
            </div>
            <div class="modal-body">
                <form action="{{url('admin/users/topup?id=order_id')}}" method="post">
                    <p class="text-center text-muted question">
                        Anda yakin melakukan konfirmasi topup atas order ini? <strong id="delete-question"></strong>
                    </p>

                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="put">

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