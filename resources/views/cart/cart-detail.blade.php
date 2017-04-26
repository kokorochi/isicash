@extends('layouts.main_layout')

@php
    $user_account = Auth::user()->userAccount()->first();
@endphp

@section('content')

    @include('layouts.delete-confirmation-modal')

    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h1>Product List</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb">
                        <li><a href="{{url('/')}}">Home</a>
                        </li>
                        <li>Product List</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <div id="content">
        <div class="container">

            <div class="row">

                <!-- *** SHOPPING CART COLUMN *** -->
                @if(! $shopping_carts->isEmpty())
                    <div class="col-md-12">
                        <p class="text-muted lead">Ada {{count($shopping_carts)}} item(s) di keranjang anda.</p>
                    </div>


                    <div class="col-md-9 clearfix" id="basket">

                        <div class="box">

                            <form method="post" action="{{url('user/carts/update')}}">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th colspan="2">Produk</th>
                                            <th>Jumlah</th>
                                            <th>Harga / Unit</th>
                                            <th>Diskon</th>
                                            <th colspan="2">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php($sum_price = 0)
                                        @foreach($shopping_carts as $shopping_cart)
                                            @php($product = $shopping_cart->product()->first())
                                            @php($product_price = $product->productPrice()->where('date', '<=', \Carbon\Carbon::now()->toDateString())->orderBy('date','desc')->first())
                                            @php($final_price = $product_price->final_price * $shopping_cart->quantity)
                                            @php($sum_price += $final_price)
                                            <tr>
                                                <td>
                                                    <a href="{{url('products/detail?product_id=' . $product->id) . '#product-detail'}}">
                                                        <img src="{{url('img/products/' . $product->image_file)}}"
                                                             alt="{{$product->name}}">
                                                    </a>
                                                </td>
                                                <td><a href="{{url('products/detail?product_id=' . $product->id . '#product-detail')}}">{{$product->name}}</a>
                                                </td>
                                                <td>
                                                    <input name='quantity[{{$shopping_cart->id}}]'
                                                           class="form-control input-sm inputmask"
                                                           id="cart-quantity"
                                                           data-inputmask="'alias': 'decimal', 'rightAlign': false"
                                                           value="{{$shopping_cart->quantity}}">
                                                </td>
                                                <td>Rp.{{number_format($product_price->sales_price, 0, ',', '.')}}</td>
                                                <td>{{$product_price->discount}}</td>
                                                <td>Rp.{{number_format($final_price, 0, ',', '.')}}</td>
                                                <td>
                                                    <a href="#" data-toggle="modal" class="delete-cart"
                                                       data-id="{{$shopping_cart->id}}"
                                                       data-target="#delete-confirmation-modal">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th colspan="5">Total</th>
                                            <th colspan="2">Rp.{{number_format($sum_price, 0, ',', '.')}}</th>
                                        </tr>
                                        </tfoot>
                                    </table>

                                </div>
                                <!-- /.table-responsive -->

                                <div class="form-group {{$errors->has('pin') ? 'has-error' : ''}}">
                                    <div class="col-sm-6"></div>
                                    <label for="pin" class="col-sm-6 control-label">PIN</label>
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6">
                                        <input name="pin" type="password" class="form-control input-sm">
                                    </div>
                                    @if($errors->has('pin'))
                                        <div class="col-sm-6"></div>
                                        <span class="col-sm-6 help-block">{{$errors->first('pin')}}</span>
                                    @endif
                                </div>
                                <div class="clearfix"></div>

                                <div class="box-footer">
                                    {{csrf_field()}}
                                    <input type="hidden" name="_method" value="PUT">
                                    <div class="pull-left">
                                        <a href="{{url('products')}}" class="btn btn-default"><i
                                                    class="fa fa-chevron-left"></i> Kembali Berbelanja</a>
                                    </div>
                                    <div class="pull-right">
                                        <button name="btn_update_cart" value="1" type="submit" class="btn btn-default"><i class="fa fa-refresh"></i> Update Keranjang
                                        </button>
                                        <button name="btn_checkout" value="1"  type="submit" class="btn btn-template-main">Lanjut Pembayaran <i
                                                    class="fa fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>

                            </form>

                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- *** SHOPPING CART COLUMN END *** -->

                    <!-- *** ORDER SUMMARY *** -->
                    <div class="col-md-3">
                        <div class="box" id="order-summary">
                            <div class="box-header">
                                <h3>Ringkasan Pesanan</h3>
                            </div>
                            <p class="text-muted">Berikut adalah ringkasan pesanan anda.</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>Saldo Anda</td>
                                        <th>Rp.{{number_format($user_account->balance, 0, ',', '.')}}</th>
                                    </tr>
                                    <tr>
                                        <td>Subtotal Pesanan</td>
                                        <th>Rp.{{number_format($sum_price, 0, ',', '.')}}</th>
                                    </tr>
                                    @php($balance_left = $user_account->balance - $sum_price)
                                    <tr class="total {{$balance_left >= 0 ? 'bg-success' : 'bg-danger'}}">
                                        <td>Sisa Saldo</td>
                                        <th>Rp.{{number_format($balance_left, 0, ',', '.')}}</th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-3 -->
                    <!-- *** ORDER SUMMARY END *** -->
                @else
                    <div class="col-sm-6 col-sm-offset-3" id="error-page">
                        <div class="box">
                            <p class="text-center">
                                <a href="{{url('products')}}">
                                    <img src="{{url('img/empty-cart.png')}}" alt="Keranjang Kosong">
                                </a>
                            </p>

                            <h3>Anda belum memasukkan produk apapun ke dalam keranjang</h3>
                            <h4 class="text-muted">Keranjang Kosong</h4>

                            <p class="buttons"><a href="{{url('products')}}" class="btn btn-template-main"><i class="fa fa-home"></i> Kembali Berbelanja</a>
                            </p>
                        </div>
                    </div> <!-- /.col-sm-6 -->
                @endif
            </div>
            <
            <!-- /.container -->
        </div>
        <!-- /#content -->
@endsection