@extends('layouts.main_layout')

@php
    $input = request()->input();
    if(!isset($input['category_code']))
        $input['category_code'] = '';
    if(!isset($input['sub_category_code']))
        $input['sub_category_code'] = '';
@endphp

@section('content')
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

                <!-- *** LEFT COLUMN *** -->
            @include('layouts.left-column')
            <!-- *** LEFT COLUMN END *** -->

                <!-- *** PRODUCT LIST COLUMN *** -->
                <div class="col-sm-9">

                    <p class="text-muted lead">Voucher game termurah hanya ada di sini. Aman, cepat, dan terjangkau.
                        Silahkan pilih voucher game yang anda inginkan.</p>

                    <div class="row products">
                        {{csrf_field()}}
                        @foreach($products as $product)
                            @php($product_price = $product->productPrice()->orderBy('id', 'desc')->first())
                            <div class="col-md-4 col-sm-6">
                                <div class="product">
                                    <div class="image">
                                        <a href="{{url('products/detail?product_id=' . $product->id)}}">
                                            <img src="{{url('img/products/' . $product->image_file)}}" alt=""
                                                 class="img-responsive image1">
                                        </a>
                                    </div>
                                    <!-- /.image -->
                                    <div class="text">
                                        <h3>
                                            <a href="{{url('products/detail?product_id=' . $product->id)}}">{{$product->name}}</a>
                                        </h3>
                                        <p class="price">
                                            {{--<del>$280</del>--}}
                                            Rp.{{number_format($product_price->final_price, 0, ',', '.')}}
                                        </p>
                                        <p class="">
                                            <a href="#" data-product-id="{{$product->id}}"
                                               class="btn btn-template-main add-to-cart">
                                                <i class="fa fa-shopping-cart"></i>Tambah Ke Keranjang
                                            </a>
                                        </p>
                                    </div>
                                    <!-- /.text -->

                                {{--<div class="ribbon sale">--}}
                                {{--<div class="theribbon">SALE</div>--}}
                                {{--<div class="ribbon-background"></div>--}}
                                {{--</div>--}}
                                <!-- /.ribbon -->

                                {{--<div class="ribbon new">--}}
                                {{--<div class="theribbon">NEW</div>--}}
                                {{--<div class="ribbon-background"></div>--}}
                                {{--</div>--}}
                                <!-- /.ribbon -->
                                </div>
                                <!-- /.product -->
                            </div>
                        @endforeach
                    </div> <!-- /.products -->
                </div> <!-- /.col-md-9 -->
                <!-- *** PRODUCT LIST COLUMN END *** -->

            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /#content -->
@endsection