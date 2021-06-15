{{-- =====Wishlist Modal Start===== --}}
<div class="modal fade" id="wishlistModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('frontend/default.wishlist') }}{{-- Wishlist --}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="cursor: pointer;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="cart-box">
                    <wish-list 
                        url="{{ url('/') }}"
                        nothing_to_show="{{ __('frontend/default.nothing_to_show') }}"
                    > 
                    </wish-list>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- =====Wishlist Modal End==== --}}



<nav class="navbar_nav">
    <div class="container">
        <a href="{{ route('index') }}" class="brand_logo" title="HOME">
            <img class="man_lazy" src="{{ asset('public/lazy_load.png') }}" data-src="{{ asset('public/images/settings/'.$site_setting->logo) }}">
        </a>
        <div class="nav_content">
            <div class="top_nav">
                <h4>Call Us : 01914883116</h4>
                <div class="coupons_marquee">
                    @php
                        $coupons = \App\Models\Coupon::where('status','1')->get();
                    @endphp
                    @if(count($coupons) > 0)
                        <div class="position-relative p-1">
                            <!--<div class="position-absolute h-100"-->
                            <!--    style="left: 0; top: 0; background-color: #FF9805; color: #fff; z-index: 1; text-transform: uppercase; padding: 3px 12px;}">-->
                            <!--    <strong>আমাদের কথা</strong>-->
                            <!--</div>-->
                            <!--<p class="marquee_ marquee marquee_style">-->
                            <!--    <b>-->
                            <!--    @foreach($coupons as $coupon)-->
                            <!--        <span class="mx-2 px-1 {{ $coupon->category == 0 ? 'span-a':'span-b' }}"><span style="font-weight: normal;"><i class="fas fa-ticket-alt"></i> {{ $coupon->category == 0 ? 'New User Coupon: ' : 'Pro User Coupon: ' }}</span> <span class="copy_btn" data-clipboard-text="{{ $coupon->code }}" data-toggle="tooltip" data-placement="bottom" title="Click to copy tag">{{ $coupon->code }}</span></span>-->
                            <!--    @endforeach-->
                            <!--    </b>-->
                            <!--</p>-->
                            <p class="marquee_style" style="font-size: 15px; text-align: center;">
                                <b>পন্য বুঝে নিয়ে মূল্য পরিশোধ ★ সেরা পণ্য ★ সঠিক ওজন ★ ন্যায্য মূল্য</b>
                            </p>
                        </div>
                    @endif
                </div>
                <div class="athontication_access">
                    <!-- Signin & Signup -->
                    @if(Auth::check())
                        <div class="profile_hover cursor-pointer">
                            <div class="user_icon">
                                @if(is_null(Auth::user()->image))
                                    <img src="{{ asset('public/images/user.jpg') }}" alt="">
                                @else
                                    <img src="{{ asset(Auth::user()->image) }}" alt="">
                                @endif
                            </div>
                            <ul class="profile-dropdown">
                                <li class="profile-dropdown-content cursor-pointer profile_name">
                                    <a href="javascript:void(0)">
                                        <span style="text-transform: capitalize;">{{ Auth::user()->name }}</span></li>
                                    </a>
                                <li class="profile-dropdown-content cursor-pointer">
                                    <a href="{{ route('user.index',Auth::user()->username) }}">{{ __('frontend/default.my_account') }}</a>
                                </li>
                                <li class="profile-dropdown-content cursor-pointer">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">{{ __('frontend/default.logout') }}</a>
                                </li>
                            </ul>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    @else
                        {{-- <div class="user_icon"><img src="{{ asset('public/front/images/user.svg') }}" alt=""></div> --}}
                        <div class="sign_in">
                            <a href="{{ route('login') }}">
                                <span>LOGIN</span>
                            </a>
                        </div>
                    @endif
                    
                    <!--search click button-->
                    <button id="searchClick_button">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </button>
                    
                    <!--language-->
                    <div class="language_div">
                        @if(Config::get('app.locale') == 'bn')
                        <a href="{{ route('language', 'en') }}">
                            <img src="{{ asset('public/images/flag/en.png') }}" width="24" height="24">
                        </a>
                        @else
                        <a href="{{ route('language', 'bn') }}">
                            <img src="{{ asset('public/images/flag/bn.png') }}" width="24" height="24">
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="main_navbar">
                <h4 class="slogun">বাজার করুন ঘরে বসে</h4>
                
                <div class="navbar_search_form">
                    <search url="{{ url('/') }}" search_place="Search Your Favourite Product..." ></search>
                </div>
                
                <div class="coupons_marquee">
                    @php
                        $coupons = \App\Models\Coupon::where('status','1')->get();
                    @endphp
                    @if(count($coupons) > 0)
                        <div class="position-relative p-1">
                            <div class="position-absolute h-100"
                                style="font-family: 'Pacifico', cursive; left: 0; top: 0; background-color: #FF9805; color: #fff; z-index: 1; text-transform: uppercase;font-size: 12px; padding: 6px 12px;}">
                                Coupon
                            </div>
                            <p class="marquee_ marquee marquee_style">
                                <b>
                                @foreach($coupons as $coupon)
                                    <span class="mx-2 px-1 {{ $coupon->category == 0 ? 'span-a':'span-b' }}"><span style="font-weight: normal;"><i class="fas fa-ticket-alt"></i> {{ $coupon->category == 0 ? 'New User Coupon: ' : 'Pro User Coupon: ' }}</span> <span class="copy_btn" data-clipboard-text="{{ $coupon->code }}" data-toggle="tooltip" data-placement="bottom" title="Click to copy tag">{{ $coupon->code }}</span></span>
                                @endforeach
                                </b>
                            </p>
                        </div>
                    @endif
                </div>
                
                <div class="wishlist_cart">
                    <!-- Signin & Signup -->
                    <div class="athontication_access">
                        @if(Auth::check())
                            <div class="profile_hover cursor-pointer">
                                <div class="user_icon">
                                    @if(is_null(Auth::user()->image))
                                        <img src="{{ asset('public/images/user.jpg') }}" alt="">
                                    @else
                                        <img src="{{ asset(Auth::user()->image) }}" alt="">
                                    @endif
                                </div>

                                <div>
                                    <ul class="profile-dropdown">
                                        <li class="profile-dropdown-content cursor-pointer profile_name">
                                            <a href="javascript:void(0)">
                                                <span style="text-transform: capitalize;">{{ Auth::user()->name }}</span></li>
                                            </a>
                                        <li class="profile-dropdown-content cursor-pointer">
                                            <a href="{{ route('user.index',Auth::user()->username) }}">{{ __('frontend/default.my_account') }}</a>
                                        </li>
                                        <li class="profile-dropdown-content cursor-pointer">
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">{{ __('frontend/default.logout') }}</a>
                                        </li>
                                    </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @else
                            {{-- <div class="user_icon"><img src="{{ asset('public/front/images/user.svg') }}" alt=""></div> --}}
                            <div class="sign_in">
                                <a href="{{ route('login') }}" style="color: #333;font-weight: normal;">
                                    <i class="fas fa-sign-in-alt"></i>
                                </a>

                            </div>
                        @endif
                    </div>
                    
                    <!-- App -->
                    <a href="{{asset('public/front/app/Masik_Bazar_Khulna.apk')}}" class="app_download_icons" download="Masik Bazar Khulna">
                        <i class="fab fa-android tool_tip"></i>
                    </a>

                    <!--wishlist-->
                    <div class="wishlist_icon cursor-pointer" style="margin-bottom: -2px;" data-toggle="modal" data-target="#wishlistModalCenter">
                        <i class="far fa-heart" style="font-size: 25px;"></i>
                        <div class="cart_count">
                            <span title="WishList">
                                <total-wish></total-wish>
                            </span>
                        </div>
                    </div>
                    
                    <!--shopping card-->
                    <div id="cartAnimationEnd" class="cart_icon cursor-pointer" @click="cart">
                        <i class="fas fa-shopping-cart"></i>
                        <div class="cart_count">
                            <span title="Cart" >
                                <cart-count url="{{ url('/') }}"></cart-count>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>



<header class="header">
    <!-- start -->
    @php
        $nav_site = $categories         = \App\Models\Category::where('status',1)->orderBy('position', 'ASC')->get();
        $categories_count               = $categories->count();
        $categories                     = $categories->take(9);
    @endphp
    <div style="height: 56px;">
        <div class="container-fluid" id="nav_wrapper">
            <div class="row">
                <div class="container">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="cotegories_wraper">
                            <!--<a class="man_categories_toggle" href="{{ asset('/shop') }}">-->
                            <a class="man_categories_toggle" id="category_toggle_menu" href="javascript:void(0)" style="text-transform: uppercase;">
                                <i class="fa fa-bars"></i><span>{{-- __('frontend/default.categories') --}}</span>
                            </a>
                            <ul class="man_categories">
                                @foreach($categories as $category)
                                <li>
                                    @php
                                        $subcategories = $category->subcategories;
                                    @endphp
                                    @if(count($subcategories) > 0 )
                                        <a href="javascript:void(0)">
                                            {{ ucfirst(Session::get('locale') == 'bn' ? ($category->title_bn == '' ? $category->title_en : $category->title_bn) : $category->title_en)}}
                                            <i class="fa fa-angle-right" aria-hidden="true"></i>

                                            <!-------------------------------------------------- -->
                                            <div class="man_sub_dropdown">
                                            @foreach($subcategories as $subcategory)
                                                @php
                                                    $brands = $subcategory->brands;
                                                @endphp
                                                @if(count($brands) > 0)
                                                    <div class="sub_sub_dropdown_wrapper">
                                                        <a href="javascript:void(0)">
                                                          {{ $subcategory->title_en }}
                                                          <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                         
                                                        </a>
                                                        <!-- ----------------------------------------- -->
                                                        <div class="man_sub_sub_dropdown">
                                                            @foreach($brands as $brand)
                                                                <a href="{{ asset('shop?category='.$category->slug.'&sub_category='.$subcategory->slug.'&brand='.$brand->slug) }}" style="min-width: 200px;">
                                                                  {{ $brand->title_en }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                        <!-- ----------------------------------------- -->
                                                    </div>
                                                @else
                                                    <a href="{{ asset('shop?category='.$category->slug.'&sub_category='.$subcategory->slug) }}">
                                                      {{ $subcategory->title_en }} 
                                                    </a>
                                                @endif

                                            @endforeach
                                            </div>
                                         <!-------------------------------------------------- -->
                                        </a>
                                    @else
                                        <a href="{{ asset('shop?category='.$category->slug) }}">
                                            {{ ucfirst(Session::get('locale') == 'bn' ? ($category->title_bn == '' ? $category->title_en : $category->title_bn) : $category->title_en)}}
                                        </a>
                                    @endif
                                </li>
                                @endforeach

                                @if($categories_count > 9)
                                <li><a class="see_more" href="{{ asset('shop#categories') }}" style="color:var(--secondary_color)">See More...</a></li>
                                @endif

                                <li><a class="see_more" href="{{ asset('shop') }}" style="color:var(--secondary_color)">All Category...</a></li>
                                
                            </ul>
                        </div>
                        
                        <div class="header_search">
                            <div class="header_search_content">
                                <div class="header_search_form_container">
                                    <search url="{{ url('/') }}" search_place="Search Your Favourite Product..." ></search>
                                </div>
                            </div>
                        </div>
                        
                        <button class="navbar-toggler" id="navbarToggler" type="button" style="padding: 10px 10px; font-size: 16px;">
                            <!--<span class="navbar-toggler-icon"></span>-->
                            <i class="fa fa-list-alt" aria-hidden="true" style="color: #FF9805;"></i>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto" style="text-transform: uppercase;">     
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('index') ? 'active':'' }}" href="{{ route('index') }}">{{ __("frontend/default.home") }} <span class="sr-only">(current)</span></a>
                                </li>
                                @php($categories = $nav_site->take(3))
                                @foreach($categories as $category)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ asset('/shop') }}?category={{ $category->slug }}">{{ ucfirst(Session::get('locale') == 'bn' ? ($category->title_bn == '' ? $category->title_en : $category->title_bn) : $category->title_en)}}</a>
                                </li>
                                @endforeach
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('contact') ? 'active':'' }}" href="{{ route('contact') }}">{{ __("frontend/default.contact") }}</a>
                                </li>
                            </ul>
                        </div>
                        
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end -->
    
    <!-- Menu -->
    <div class="page_menu mt-0">
        <div class="container copy_me_menu">
            <div class="row">
                <div class="col">
                    <div class="page_menu_content">
                        <div class="page_menu_search">
                            <form action="#">
                                <input type="search" required="required" class="page_menu_search_input"
                                placeholder="{{ __('frontend/default.search_product') }}">
                            </form>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
