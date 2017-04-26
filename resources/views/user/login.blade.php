@extends('layouts.main_layout')

@php
    $get_olds = session()->getOldInput();
    if(count($get_olds))
    {
        $data = [];
        foreach ($get_olds as $key => $get_old)
        {
            if($key !== '_token')
            {
                $data[$key] = old($key);
            }
        }
    }
@endphp

@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h1>New account / Sign in</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb">
                        <li><a href="index.html">Home</a>
                        </li>
                        <li>New account / Sign in</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <div id="content">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <h2 class="text-uppercase">Login</h2>

                        <p class="lead">Already our customer?</p>
                        <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames
                            ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet,
                            ante. Donec eu libero sit amet quam egestas semper. Aenean
                            ultricies mi vitae est. Mauris placerat eleifend leo.</p>

                        <hr>

                        <form action="{{url('user/login')}}" method="post">
                            <div class="form-group {{$errors->has('username') ? 'has-error' : ''}}">
                                <label for="username">Username</label>
                                <input name="username" type="text" class="form-control">
                                @if($errors->has('username'))
                                    <span class="help-block">{{$errors->first('username')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
                                <label for="password">Password</label>
                                <input name="password" type="password" class="form-control">
                                @if($errors->has('password'))
                                    <span class="help-block">{{$errors->first('password')}}</span>
                                @endif
                            </div>
                            {{csrf_field()}}
                            <div class="text-center">
                                <button type="submit" class="btn btn-template-main"><i class="fa fa-sign-in"></i> Log in
                                </button>
                            </div>
                        </form>

                        <hr>

                        <p class="lead">Lupa Password?</p>
                        <p class="text-muted">Silahkan masukkan username atau email untuk melakukan reset password.
                            Link reset password akan dikirimkan ke email anda. Harap periksa junk/spam jika email
                            tidak ditemukan di inbox.</p>

                        <form action="{{url('user/forgot')}}" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input name="username" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input name="email" type="text" class="form-control">
                            </div>

                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="PUT">

                            <div class="text-center">
                                <button type="submit" class="btn btn-template-main">
                                    <i class="fa fa-share-square"></i> Kirim Email
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /#content -->
@endsection