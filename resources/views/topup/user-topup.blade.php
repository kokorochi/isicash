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
                    <h1>Topup Saldo</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb">
                        <li><a href="index.html">Home</a>
                        </li>
                        <li>Topup Saldo</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <div id="content">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <h3>Tabs with nav pills</h3>

                    <div class="tabs mb-10">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#tab2-1" data-toggle="tab">Pilih Bank</a>
                            </li>
                            <li class=""><a href="#tab2-2" data-toggle="tab">Jumlah Topup</a>
                            </li>
                            <li class=""><a href="#tab2-3" data-toggle="tab">Checkout</a>
                            </li>
                            {{--<li><a href="#tab2-4" data-toggle="tab">Marketing</a>--}}
                            {{--</li>--}}
                        </ul>
                        <form action="{{url('user/topup')}}" method="post">
                            <div class="tab-content tab-content-inverse">
                                <div class="tab-pane active" id="tab2-1">
                                    <label class="radio-inline">
                                        <input type="radio" name="bank" value="mandiri" checked><img src="{{url('img/bankmandiri-logo.png')}}" alt="Bank Mandiri">
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="bank" value="bca"><img src="{{url('img/bca.png')}}" alt="Bank BCA">
                                    </label>
                                </div>
                                <!-- /.tab -->
                                <div class="tab-pane" id="tab2-2">
                                    <div class="form-group">
                                        <label for="balance" class="control-label">Sisa Saldo Topup</label>
                                        <input type="text" name="balance" value="{{$user_account->balance}}" disabled
                                               data-inputmask="'alias': 'decimal', 'groupSeparator': '.', 'autoGroup': true, 'rightAlign': false"
                                               class="form-control inputmask">
                                    </div>
                                    <div class="form-group">
                                        <label for="topup_balance" class="control-label">Jumlah Topup</label>
                                        <input type="text" name="topup_balance" value=""
                                               data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'rightAlign': false"
                                               class="form-control inputmask">
                                    </div>
                                </div>
                                <!-- /.tab -->
                                <div class="tab-pane" id="tab2-3">

                                </div>
                                <!-- /.tab -->
                            </div>
                        </form>
                    </div>
                    <!-- /.tabs -->
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /#content -->
@endsection