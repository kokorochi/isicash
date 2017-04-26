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
                        <h2 class="text-uppercase">Reset Password</h2>

                        <p class="lead">Silahkan reset password anda</p>

                        <form action="{{url('user/reset')}}" method="post">
                            <input name="username" type="hidden" value="{{$username}}">
                            <div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
                                <label for="password">Password</label>
                                <input name="password" type="password" class="form-control">
                                @if($errors->has('password'))
                                    <span class="help-block">{{$errors->first('password')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('password_retype') ? 'has-error' : ''}}">
                                <label for="password_retype">Ulangi Password</label>
                                <input name="password_retype" type="password" class="form-control">
                                @if($errors->has('password_retype'))
                                    <span class="help-block">{{$errors->first('password_retype')}}</span>
                                @endif
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="PUT">
                            <div class="text-center">
                                <button type="submit" class="btn btn-template-main"><i class="fa fa-retweet"></i> Reset
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