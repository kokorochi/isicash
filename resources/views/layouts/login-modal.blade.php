<!-- *** LOGIN MODAL *** -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog modal-sm">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="Login">Silahkan Login</h4>
            </div>
            <div class="modal-body">
                <form action="{{url('user/login')}}" method="post">
                    <div class="form-group">
                        <input name="username" type="text" class="form-control" id="email_modal" placeholder="username">
                    </div>
                    <div class="form-group">
                        <input name="password" type="password" class="form-control" id="password_modal" placeholder="password">
                    </div>

                    {{csrf_field()}}

                    <p class="text-center">
                        <button class="btn btn-template-main"><i class="fa fa-sign-in"></i> Log in</button>
                    </p>

                </form>

                <a href="{{url('user/login')}}">Lupa password?</a>
                <hr>

                <p class="text-center text-muted">Belum registrasi?</p>
                <p class="text-center text-muted"><a href="{{url('user/register')}}"><strong>Register sekarang</strong></a>! Mudah dan cepat dalam pembelian voucher!</p>

            </div>
        </div>
    </div>
</div>
<!-- *** LOGIN MODAL END *** -->