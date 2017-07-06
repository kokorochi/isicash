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

    @include('layouts.topup-confirmation-modal')

    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h1>Topup List</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb">
                        <li><a href="{{url('/')}}">Home</a>
                        </li>
                        <li>Topup List</li>
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
                        @if(!$order_to_confirms->isEmpty())
                        <div class="table-responsive">
                            <table class="table table-stripped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Tanggal</th>
                                    <th>Username</th>
                                    <th>Jumlah</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order_to_confirms as $order_to_confirm)
                                    <tr>
                                        <td>{{$order_to_confirm->id}}</td>
                                        <td>{{$order_to_confirm->date}}</td>
                                        <td>{{$order_to_confirm->username}}</td>
                                        <td>Rp.{{number_format($order_to_confirm->total_amount, 0, ',', '.')}}</td>
                                        <td class="text-center">
                                            <a href='#' class='btn btn-xs btn-warning confirm_topup'
                                               data-toggle="modal"
                                               data-id="{{$order_to_confirm->id}}"
                                               data-total_amount="Rp.{{number_format($order_to_confirm->total_amount, 0, ',', '.')}}"
                                               data-target="#topup-confirmation-modal"><i class='fa fa-check'></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Tanggal</th>
                                    <th>Username</th>
                                    <th>Jumlah</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        @else
                            Tidak ada data
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /#content -->
@endsection