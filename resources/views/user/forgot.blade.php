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
                <div class="col-md-6">
                    <div class="box">
                        <h2 class="text-uppercase">New account</h2>

                        <p class="lead">Not our registered customer yet?</p>
                        <p>With registration with us new world of fashion, fantastic discounts and much more opens to
                            you! The whole process will not take you more than a minute!</p>
                        <p class="text-muted">If you have any questions, please feel free to <a href="contact.html">contact
                                us</a>, our customer service center is working for you 24/7.</p>

                        <hr>

                        <form action="{{url('/user/register')}}" method="post">
                            <div class="form-group {{$errors->has('username') ? 'has-error' : ''}}">
                                <label for="username">Username *</label>
                                <input name="username" type="text" class="form-control" value="{{$data['username']}}">
                                @if($errors->has('username'))
                                    <span class="help-block">{{$errors->first('username')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
                                <label for="password">Password *</label>
                                <input name="password" type="password" class="form-control">
                                @if($errors->has('password'))
                                    <span class="help-block">{{$errors->first('password')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('password_retype') ? 'has-error' : ''}}">
                                <label for="password_retype">Ulangi Password *</label>
                                <input name="password_retype" type="password" class="form-control">
                                @if($errors->has('password_retype'))
                                    <span class="help-block">{{$errors->first('password_retype')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('pin') ? 'has-error' : ''}}">
                                <label for="pin">PIN *</label>
                                <input name="pin" type="password" class="form-control">
                                @if($errors->has('pin'))
                                    <span class="help-block">{{$errors->first('pin')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('pin_retype') ? 'has-error' : ''}}">
                                <label for="pin_retype">Ulangi PIN *</label>
                                <input name="pin_retype" type="password" class="form-control">
                                @if($errors->has('pin_retype'))
                                    <span class="help-block">{{$errors->first('pin_retype')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
                                <label for="email">Email *</label>
                                <input name="email" type="text" class="form-control" value="{{$data['email']}}">
                                @if($errors->has('email'))
                                    <span class="help-block">{{$errors->first('email')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('full_name') ? 'has-error' : ''}}">
                                <label for="full_name">Nama Lengkap *</label>
                                <input name="full_name" type="text" class="form-control" value="{{$data['full_name']}}">
                                @if($errors->has('full_name'))
                                    <span class="help-block">{{$errors->first('full_name')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('phone') ? 'has-error' : ''}}">
                                <label for="phone">Nomor Handphone *</label>
                                <input name="phone" type="text" class="form-control" value="{{$data['phone']}}">
                                @if($errors->has('phone'))
                                    <span class="help-block">{{$errors->first('phone')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('dob') ? 'has-error' : ''}}">
                                <label for="dob">Tanggal Lahir *</label>
                                <input name="dob" type="date" class="form-control" value="{{$data['dob']}}">
                                @if($errors->has('dob'))
                                    <span class="help-block">{{$errors->first('dob')}}</span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('sex') ? 'has-error' : ''}}">
                                <label for="sex">Jenis Kelamin *</label>
                                <select name="sex" class="form-control">
                                    @foreach(['L' => 'Laki-laki', 'P' => 'Perempuan'] as $key => $item)
                                        <option value="{{$key}}" {{$data['sex'] == $key ? 'selected' : ''}}>{{$item}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('sex'))
                                    <span class="help-block">{{$errors->first('sex')}}</span>
                                @endif
                            </div>
                            {{csrf_field()}}
                            <div class="text-center">
                                <button type="submit" class="btn btn-template-main"><i class="fa fa-user-md"></i>
                                    Register
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box">
                        <h2 class="text-uppercase">Login</h2>

                        <p class="lead">Already our customer?</p>
                        <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames
                            ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet,
                            ante. Donec eu libero sit amet quam egestas semper. Aenean
                            ultricies mi vitae est. Mauris placerat eleifend leo.</p>

                        <hr>

                        <form action="{{url('user/login')}}" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input name="username" type="text" class="form-control" id="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input name="password" type="password" class="form-control" id="password">
                            </div>
                            {{csrf_field()}}
                            <a href="{{url('user/forgot')}}">Lupa password?</a>
                            <div class="text-center">
                                <button type="submit" class="btn btn-template-main"><i class="fa fa-sign-in"></i> Log in
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