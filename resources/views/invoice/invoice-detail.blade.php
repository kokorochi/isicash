@extends('layouts.main_layout')

@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h1>Invoice Pembelian</h1>
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
                        <p class="lead">Nomor Order: {{$order->id}}, pada tanggal {{$order->date}}</p>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th colspan="2">Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga / Unit</th>
                                    <th>Diskon</th>
                                    <th colspan="1">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($sum_price = 0)
                                @foreach($order_items as $order_item)
                                    @php($product = $order_item->product()->first())
                                    @php($product_price = $order_item->productPrice()->first())
                                    <tr>
                                        <td>
                                            <a href="{{url('products/detail?product_id=' . $product->id) . '#product-detail'}}">
                                                <img src="{{url('img/products/' . $product->image_file)}}"
                                                     class="wdt-50"
                                                     alt="{{$product->name}}">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{url('products/detail?product_id=' . $product->id . '#product-detail')}}">{{$product->name}}</a>
                                        </td>
                                        <td>{{$order_item->quantity}}</td>
                                        <td>Rp.{{number_format($product_price->sales_price, 0, ',', '.')}}</td>
                                        <td>{{$product_price->discount}}</td>
                                        <td>Rp.{{number_format($order_item->total_amount, 0, ',', '.')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="5">Total</th>
                                    <th colspan="1">Rp.{{number_format($order->total_amount, 0, ',', '.')}}</th>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                        <!-- /.table-responsive -->

                        <p class="lead">List Voucher:</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Voucher</th>
                                    <th>Jenis Produk</th>
                                    <th>Nama Produk</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($vouchers as $voucher)
                                    @php($product = $voucher->product()->first())
                                    @php($sub_category = \App\SubCategory::where('category_code', $product->category_code)->where('sub_category_code', $product->sub_category_code)->first())
                                    <tr>
                                        <td>{{$voucher->no}}</td>
                                        <td class="cn-font">{!! decrypt($voucher->code) !!}</td>
                                        <td>{{$sub_category->name}}</td>
                                        <td>{{$product->name}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Voucher</th>
                                    <th>Jenis Produk</th>
                                    <th>Nama Produk</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /#content -->
@endsection