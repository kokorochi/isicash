@extends('layouts.main_layout')

@php
    $input['product_id'] = request()->input('product_id');
    $input['category_code'] = $product->category_code;
    $input['sub_category_code'] = $product->sub_category_code;
    $product_price = $product->productPrice()->orderBy('id', 'desc')->first()
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
{{--            @include('layouts.left-column')--}}
            <!-- *** LEFT COLUMN END *** -->

                <!-- *** PRODUCT DETAIL COLUMN *** -->

                <div class="col-md-12">

                    <p class="lead" id="product-detail">Voucher game termurah hanya ada di sini. Aman, cepat, dan terjangkau.
                        Silahkan pilih voucher game yang anda inginkan.
                    </p>
                    <p class="goToDescription"><a href="#details" class="scroll-to text-uppercase">Scroll ke detail
                            voucher</a>
                    </p>

                    <div class="row" id="productMain">
                        <div class="col-sm-6">
                            <div id="mainImage">
                                <img src="{{url('img/products/' . $product->image_file)}}" alt=""
                                     class="img-responsive">
                            </div>

                            {{--<div class="ribbon sale">--}}
                            {{--<div class="theribbon">SALE</div>--}}
                            {{--<div class="ribbon-background"></div>--}}
                            {{--</div>--}}
                            {{--<!-- /.ribbon -->--}}

                            {{--<div class="ribbon new">--}}
                            {{--<div class="theribbon">NEW</div>--}}
                            {{--<div class="ribbon-background"></div>--}}
                            {{--</div>--}}
                            {{--<!-- /.ribbon -->--}}

                        </div>
                        <div class="col-sm-6">
                            <div class="box">

                                <form action="{{url('user/carts/add')}}" method="post">
                                    <div class="sizes">

                                        <h3>{{$product->name}}</h3>

                                    </div>

                                    <p class="price">Rp.{{number_format($product_price->final_price, 0, ',', '.')}}</p>

                                    <div class="form-group">
                                        <label for="quantity" class="control-label">Jumlah</label>
                                        <input name="quantity" class="form-control inputmask" type="text"
                                               data-inputmask="'alias': 'decimal', 'rightAlign': false"
                                               value="1">
                                    </div>

                                    {{csrf_field()}}
                                    <input name="product_id" type="hidden" value="{{$input['product_id']}}">

                                    <p class="text-center">
                                        <button type="submit" class="btn btn-template-main">
                                            <i class="fa fa-shopping-cart"></i> Add to cart
                                        </button>
                                    </p>

                                </form>
                            </div>
                        </div>

                    </div>


                    <div class="box" id="details">
                        <p>
                        <h4>Product details</h4>
                        <p>{{$product->description}}</p>
                    </div>

                </div>
                <!-- *** PRODUCT DETAIL COLUMN END *** -->
                <!-- /.col-md-9 -->
                <!-- /.row -->
            </div>
            <
            <!-- /.container -->
        </div>
        <!-- /#content -->
@endsection