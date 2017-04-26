<div class="col-sm-3">
    <!-- *** MENUS AND FILTERS *** _________________________________________________________ -->
    <div class="panel panel-default sidebar-menu">

        <div class="panel-heading">
            <h3 class="panel-title">Kategori</h3>
        </div>

        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked category-menu">
                @foreach($categories as $category)
                    <li {{$input['category_code'] == $category->category_code ? 'class=active' : ''}}>
                        <a href="{{url('products?category_code=' . $category->category_code)}}">
                            {{$category->name}} <span
                                    class="badge pull-right">{{$category['product_count']}}</span>
                        </a>
                        <ul>
                            @php($sub_categories = $category->subCategory()->get())
                            @foreach($sub_categories as $sub_category)
                                <li>
                                    <a href="{{url('products?category_code=' . $category->category_code . '&sub_category_code=' . $sub_category->sub_category_code)}}">{{$sub_category->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>

    {{--<div class="banner">--}}
    {{--<a href="shop-category.html">--}}
    {{--<img src="img/banner.jpg" alt="sales 2014" class="img-responsive">--}}
    {{--</a>--}}
    {{--</div> <!-- /.banner -->--}}
</div> <!-- /.col-md-3 -->