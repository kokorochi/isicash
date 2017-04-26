@extends('layouts.main_layout')

@section('content')
    <div id="content">
        <div class="container">
            <div class="col-sm-6 col-sm-offset-3" id="error-page">
                <div class="box">
                    <p class="text-center">
                        <a href="index.html">
                            <img src="{{url('img/logo.png')}}" alt="ISICASH">
                        </a>
                    </p>

                    <h3>Halaman yang anda tuju terbatas</h3>
                    <h4 class="text-muted">Error 403 - Anda tidak punya hak akses ke halaman ini</h4>

                    <p class="buttons"><a href="{{url('/')}}" class="btn btn-template-main"><i class="fa fa-home"></i> Kembali ke beranda</a>
                    </p>
                </div>
            </div> <!-- /.col-sm-6 -->
        </div> <!-- /.container -->
    </div> <!-- /#content -->
@endsection