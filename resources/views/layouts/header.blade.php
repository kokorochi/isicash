<header>
    <!-- *** TOP ***
_________________________________________________________ -->
    <div id="top">
        <div class="container">
            <div class="row">
                <div class="col-xs-5 contact">
                </div>
                <div class="col-xs-7">
                    <div class="login">
                        @if(Auth::user())
                            <span class="hidden-xs text-uppercase">
                                Selamat datang, {{Auth::user()->userAccount()->first()->full_name}}
                            </span>
                            |
                            <a href="{{url('user/logout')}}"><i class="fa fa-sign-out"></i> <span
                                        class="hidden-xs text-uppercase">Logout</span></a>
                        @else
                            <a href="#" data-toggle="modal" data-target="#login-modal"><i class="fa fa-sign-in"></i> <span
                                        class="hidden-xs text-uppercase">Sign in</span></a>
                            <a href="{{url('user/register')}}"><i class="fa fa-user"></i> <span
                                        class="hidden-xs text-uppercase">Register</span></a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- *** TOP END *** -->

    <!-- *** NAVBAR ***
_________________________________________________________ -->

    <div class="navbar-affixed-top" data-spy="affix" data-offset-top="200">

        <div class="navbar navbar-default yamm" role="navigation" id="navbar">

            <div class="container">
                <div class="navbar-header">

                    <a class="navbar-brand home" href="{{url('/')}}">
                        <img src="{{url('img/logo.png')}}" alt="Universal logo" class="hidden-xs hidden-sm">
                        <img src="{{url('img/logo-small.png')}}" alt="Universal logo" class="visible-xs visible-sm"><span
                                class="sr-only">Isicash - kembali ke beranda</span>
                    </a>
                    <div class="navbar-buttons">
                        <button type="button" class="navbar-toggle btn-template-main" data-toggle="collapse"
                                data-target="#navigation">
                            <span class="sr-only">Toggle navigation</span>
                            <i class="fa fa-align-justify"></i>
                        </button>
                    </div>
                </div>
                <!--/.navbar-header -->

                <div class="navbar-collapse collapse" id="navigation">

                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown {{Request::is('/', '/') ? 'active' : null }}">
                            <a href="{{url('/')}}" class="dropdown-toggle">Home</a>
                        </li>
                        <li class="dropdown {{Request::is('products', 'products/*') ? 'active' : null }}">
                            <!-- <li class="dropdown use-yamm yamm-fw"> -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Produk<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{url('products?category_code=VG')}}">Voucher Game</a>
                                </li>
                                <li>
                                    <a href="{{url('products')}}">Semua Produk</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown {{Request::is('manuals', 'manuals/*') ? 'active' : null }}">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Panduan Pengguna <b
                                        class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="">Panduan Registrasi</a>
                                </li>
                                <li>
                                    <a href="">Panduan Topup</a>
                                </li>
                                <li>
                                    <a href="">Panduan Belanja</a>
                                </li>
                            </ul>
                        </li>
                        <!-- ========== USER MENU ================== -->
                        @can('isUser')
                            <li class="dropdown {{Request::is('user', 'user/*') ? 'active' : null }}">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                                   data-delay="200">User <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="">Profile</a>
                                    </li>
                                    <li>
                                        <a href="{{url('user/vouchers')}}">Voucher</a>
                                    </li>
                                    <li>
                                        <a href="{{url('user/carts')}}">Keranjang Belanja</a>
                                    </li>
                                    <li>
                                        <a href="">Topup</a>
                                    </li>
                                    <li>
                                        <a href="{{url('user/orders')}}">Histori Pembelian</a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        <!-- ========== USER MENU END ================== -->

                        <!-- ========== ADMIN MENU ================== -->
                        @can('isAdmin')
                            <li class="dropdown">
                                <a href="javascript: void(0)" class="dropdown-toggle" data-toggle="dropdown">Admin <b
                                            class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="contact.html">Banner</a>
                                    </li>
                                    <li><a href="contact2.html">Berita</a>
                                    </li>
                                    <li><a href="{{url('admin/products')}}">Produk</a>
                                    </li>
                                    <li><a href="{{url('admin/vouchers')}}">Voucher</a>
                                    </li>
                                    <li><a href="{{url('admin/users')}}">User</a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        <!-- ========== ADMIN MENU END ================== -->

                    </ul>

                </div>
                <!--/.nav-collapse -->


                <div class="collapse clearfix" id="search">

                    <form class="navbar-form" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                                    <span class="input-group-btn">

                    <button type="submit" class="btn btn-template-main"><i class="fa fa-search"></i></button>

                </span>
                        </div>
                    </form>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
        <!-- /#navbar -->
    </div>
    <!-- *** NAVBAR END *** -->
</header>