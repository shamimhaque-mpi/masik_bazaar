@extends('frontend.layouts.master')

@section('title', 'Home')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('public/front/styles/main_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/front/styles/responsive.css') }}">
<style>
    .myShadow {
        background: #fff;
        padding-bottom: 15px;
        box-shadow: 0px 0px 7px #aaa;
    }
    .mymg {
        margin-top: -55px;
        margin-bottom: 30px;
    }
    .my-row {
        margin-right: 0 !important;
        margin-left: 0 !important;
    }
    .btn_close {
        position: absolute;
        top: -15px;
        right: -15px;
        width: 25px;
        border-radius: 50%;
        background: #fff;
        text-align: center;
        line-height: 25px;
        font-size: 15px;
    }

    .btn_close a#close {display: block;cursor: pointer;color: #f33;}
    a#close:hover, a#close:visited, a#close:focus, a#close:active {outline: 0;}
    .modal-content img{vertical-align: top;}
    .modal-lg {max-width: 600px !important;width: 100%;}
    .modal-dialog {margin: 100px auto !important;}
    .____middle_cart___ {
        display: flex;
        width: 100%;
        background: rgba(0,0,0,0.5);
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1;
        color: #fff !important;
        line-height: 32px;
        font-size: 30px;
        /* padding: 115px 30px; */
        transition: all 400ms linear 0s;
        opacity: 0;
        pointer-events: none;
        cursor: pointer;
        justify-content: center;
        align-items: center;
    }
    .viewed_item:hover .____middle_cart___ {
        opacity: 1;
        pointer-events: auto;
    }
    .viewed_item .wishlist-btn, .cart-button {
        z-index: 3;
    }
    .viewed_item .wishlist-btn i {
        color: #11da3c; 
    }

/*All style by Abdullah Al Ahsan*/
.footer_social ul li a {color: #fff;}
.footer_social ul li a:hover {color: #FF9805;}
</style>
@endsection

@section('content')

<div class="row">
    <div class="col-12 layout_2" id="isLoading">
        <div class="container mt-3">
            <div class="header_slider">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($sliders as $key => $slider)
                        <div class="carousel-item {{ $key==0 ? 'active':'' }}">
                            <a href="{{$slider->url}}">
                                <img class="d-block w-100" src="{{ $slider->image }}" alt="{{ $slider->title }}">
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        @if(!empty($adv))
            <div class="deals_featured">
                <div class="container">
                    <div class="form-row mt-3">
                        @foreach ($adv as $element)
                            <div class="col-md-4" title="{{ $element->title }}">
                                <div class="add-top-right">
                                    <a href="{{$element->link}}">
                                        <img class="man_lazy" src="{{ asset('public/gb.png') }}" data-src="{{ isset($element->image) ? asset($element->image) : '' }}" alt="">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        
        
        <!--market list start-->
        <section class="market_list_section mt-4 my_personal">
            <div class="container">
                <div class="col-lg-12 myShadow">
                    <div class="viewed_title_container">
                        <h3 class="viewed_title">আপনার বাজারের তালিকা</h3>
                    </div>
                
                    <div class="content_area">
                        <div class="row">
                            <div class="col-lg-4">
                                <img src="{{ asset('public/00.jpg') }}">
                            </div>
                            <div class="col-lg-8">
                                <form action="" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="market_list">নিন্মের বক্সে আপনার বাজারের তালিকাটি দিন *</label>
                                        <textarea class="form-control" name="items" id="market_list" rows="4" placeholder="Such as 10 kn rice, 1 kg potato, 2 kg onion etc."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">মোবাইল নম্বর *</label>
                                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Give your mobile number">
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn submit">Send</button> 
                                        <button type="reset" class="btn reset">Reset</button> 
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--market list end-->

        <!-- Deals of the week -->
        @if(count($offer_products)>0)
        <div class="deals_featured mt-4 my_personal">
            <div class="container">
                <div class="row my-row">
                    <div class="col myShadow">
                        <!-- Category Wise -->
                        <div class="featured mymg">
                            <div class="tabbed_container">
                                
                                <div class="viewed_title_container">
                                    <h3 class="viewed_title">
                                         {{ __('frontend/default.offer') }}
                                    </h3>
                                    <div class="viewed_nav_container">
                                        <a class="btn view_btn" href="{{ asset('shop?is_offer='.urlencode($offer_products[0]->is_offer)) }}">{{ __('frontend/default.view_all') }}</a>
                                    </div>
                                </div>
                                    <!-- Product Panel -->
                                <div class="viewed feature">
                                    <div class="padding_">
                                        <!-- Recently Viewed Slider -->
                                        <div class="row">
                                            <!-- Recently Viewed Item -->
                                            @foreach($offer_products as $offer_product)
                                                @php
                                                    $images = json_decode($offer_product->image);
                                                @endphp
                                                <div class="col-xl-2 col-lg-2 col-md-4 col-6 p-0 mb-2">
                                                    <div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                                        @if(Auth::check()) 
                                                            @php
                                                                if(\App\Models\WishList::where('product_id', $offer_product->id)->where('user_mac', Auth::guard('web')->user()->id)->first()){
                                                                    $find = 'find';
                                                                }
                                                                else{
                                                                    $find = 'not';
                                                                }
                                                            @endphp
                                                            <add-to-wish-list :style_wish="0" :product="{{ json_encode($offer_product) }}" url="{{ url('/') }}" find="{{ $find }}"></add-to-wish-list>
                                                        @endif
                                                        
                                                        <div class="viewed_image cursor-pointer" onclick="location.href='{{ route('product.view', $offer_product->slug) }}'">
                                                        <img class="man_lazy" src="{{ asset('public/gb.png') }}" data-src="{{ $offer_product->feature_photo!='' ? asset($offer_product->feature_photo) : asset($images[0]) }}" alt="">
                                                        </div>
                                                        <div class="viewed_content text-center">
                                                            <div class="viewed_name text-truncate"><a href="{{ route('product.view', $offer_product->slug) }}" title="{{ $offer_product->title }}">{{ $offer_product->title }}</a></div>
                                                            <div class="viewed_price">{{ $offer_product->discount_flat ? $offer_product->regular_price - ($offer_product->discount_flat).' TK' : '' }}<span>({{ $offer_product->regular_price}})</span></div>
                                                        </div>

                                                        @if($offer_product->discount_flat > 0)
                                                            <ul class="item_marks">
                                                                <li class="item_mark item_discount" style="display: none;">{{ $offer_product->discount_flat.' TK' }}</li>
                                                            </ul>
                                                        @endif

                                                        <add-to-cart
                                                            :hover_product="2"
                                                            :product="{{ json_encode($offer_product) }}">
                                                        </add-to-cart>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        


        <!-- Popular Categories -->
        @if(!$categories->isEmpty())
        <div class="popular_categories mt-4 my_personal">
            <div class="container">
                <div class="row my-row">
                    <div class="col-lg-12 myShadow">
                        <div class="viewed_title_container">
                            <h3 class="viewed_title">{{ __('frontend/default.popular_categories') }}</h3>
                        </div>
                        <br>
                            <div class="popular_categories_slider_container">
                                <div class="popular_categories_slider col-12">
                                    <div class="row">
                                        <!-- Popular Categories Item -->
                                        @foreach($categories as $category)
                                            <div class="col-xl-2 col-lg-2 col-md-4 col-6 p-0">
                                                <a href="{{ url('/') }}/shop?category={{ $category->slug }}">
                                                    <div class="popular_category p-2 d-flex flex-column align-items-center justify-content-center">
                                                        <div class="viewed_image">
                                                            <img class="man_lazy" src="{{ asset('public/gb.png') }}" data-src="{{ asset($category->image) }}" alt="">
                                                        </div>
                                                        <div class="popular_category_text text-truncate">{{ $category->title_en  }}</div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Hot New Arrivals -->
        @if(count($new_arrivals) > 0)
            <div class="viewed mt-4 my_personal">
                <div class="container">
                    <div class="row my-row">
                        <div class="col myShadow">
                            <div class="viewed_title_container">
                                <h3 class="viewed_title">{{ __('frontend/default.new_arrivals') }}</h3>
                            </div>

                            <div class="viewed_slider_container col-12">

                                <!-- Recently Viewed Slider -->
                                <div class="row">
                                    <!-- Recently Viewed Item -->
                                    @foreach($new_arrivals as $new_arrival)
                                        @php
                                            $images = json_decode($new_arrival->image);
                                        @endphp
                                        <div class="col-xl-2 col-lg-2 col-md-4 col-6 p-0 mb-2">
                                            <div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                                @if(Auth::check())
                                                @php
                                                if(\App\Models\WishList::where('product_id', $new_arrival->id)->where('user_mac', Auth::guard('web')->user()->id)->first()){
                                                    $find = 'find';
                                                }
                                                else{
                                                    $find = 'not';
                                                }
                                                @endphp
                                                <add-to-wish-list :style_wish="0" :product="{{ json_encode($new_arrival) }}" url="{{ url('/') }}" find="{{ $find }}"></add-to-wish-list>
                                                @endif
                                                <div class="viewed_image cursor-pointer" onclick="location.href='{{ route('product.view', $new_arrival->slug) }}'">
                                                    <img class="man_lazy" src="{{ asset('public/gb.png') }}" data-src="{{ $new_arrival->feature_photo!='' ? asset($new_arrival->feature_photo) : asset($images[0]) }}" alt="">
                                                </div>
                                                <div class="viewed_content text-center">
                                                    <div class="viewed_name text-truncate"><a href="{{ route('product.view', $new_arrival->slug) }}" title="{{ $new_arrival->title }}">{{ $new_arrival->title }}</a></div>
                                                    <div class="viewed_price">{{ $new_arrival->discount ? ($new_arrival->regular_price - $new_arrival->discount_flat).' TK' : '' }}<span>({{ $new_arrival->regular_price }})</span></div>
                                                </div>

                                                @if($new_arrival->discount_flat > 0)
                                                <ul class="item_marks">
                                                    <li class="item_mark item_discount" style="display: none;">{{ $new_arrival->discount_flat.'TK' }}</li>
                                                </ul>
                                                @endif
                                                <add-to-cart :hover_product="2" :product="{{ json_encode($new_arrival) }}"></add-to-cart>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
            <!-- Best Sellers -->
        @if(count($best_sellers) > 0)
            <div class="viewed2 mt-4 my_personal">
                <div class="container">
                    <div class="row my-row">
                        <div class="col myShadow">
                            <div class="viewed_title_container">
                                <h3 class="viewed_title">{{ __('frontend/default.best_sellers') }}</h3>
                            </div>

                            <div class="viewed_slider_container col-12">
                                <!-- Recently Viewed Slider -->
                                <div class="viewed_1_slider row">
                                    <!-- Recently Viewed Item -->
                                    @foreach($best_sellers as $best_seller)
                                        @php
                                        $images = json_decode($best_seller->image);
                                        @endphp
                                        <div class="col-xl-2 col-lg-2 col-md-4 col-6 p-0 mb-2">
                                            <div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                                @if(Auth::check())
                                                @php
                                                if(\App\Models\WishList::where('product_id', $best_seller->id)->where('user_mac', Auth::guard('web')->user()->id)->first()){
                                                    $find = 'find';
                                                }
                                                else{
                                                    $find = 'not';
                                                }
                                                @endphp
                                                <add-to-wish-list :style_wish="0" :product="{{ json_encode($best_seller) }}" url="{{ url('/') }}" find="{{ $find }}"></add-to-wish-list>
                                                @endif
                                                <div class="viewed_image cursor-pointer" onclick="location.href='{{ route('product.view', $best_seller->slug) }}'">
                                                    <img class="man_lazy" src="{{ asset('public/gb.png') }}" data-src="{{ $best_seller->feature_photo!='' ? asset($best_seller->feature_photo) : asset($images[0]) }}" alt="">
                                                </div>
                                                <div class="viewed_content text-center">
                                                    <div class="viewed_name text-truncate"><a href="{{ route('product.view', $best_seller->slug) }}" title="{{ $best_seller->title }}">{{ $best_seller->title }}</a></div>
                                                    <div class="viewed_price">{{ $best_seller->discount ? $best_seller->regular_price - ($best_seller->discount_flat).' TK' : '' }}<span>
                                                        {{ $best_seller->regular_price.' TK' }}</span>
                                                    </div>
                                                </div>
                                                @if($best_seller->discount_flat > 0)
                                                <ul class="item_marks">
                                                    <li class="item_mark item_discount" style="display: none;">{{ $best_seller->discount_flat.' TK' }}</li>
                                                </ul>
                                                @endif
                                                <add-to-cart :hover_product="2" :product="{{ json_encode($best_seller) }}"></add-to-cart>
                                            </div>
                                        </div>
                                    @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @foreach($category_products as $category_id => $category_product)
            <div class="deals_featured mt-4 my_personal">
                <div class="container">
                    <div class="row my-row">
                        <div class="col myShadow">
                            <!-- Category Wise -->
                            <div class="featured mymg" @if(!$offers) style="width: 100%;" @endif>
                                <div class="tabbed_container">
                                    <div class="viewed_title_container">
                                        <h3 class="viewed_title">
                                            {{ array_key_exists($category_id, $categories->groupBy('id')->toArray()) ? (Config::get('app.locale')=='en' ? $categories->groupBy('id')->toArray()[$category_id][0]->title_en : $categories->groupBy('id')->toArray()[$category_id][0]->title_bn) : '' }}  
                                        </h3>
                                        <div class="viewed_nav_container">
                                            <a class="btn view_btn" href="{{ asset('shop?category='.urlencode($category_product[0]->category_slug)) }}">{{ __('frontend/default.view_all') }}</a>
                                        </div>
                                    </div>
                                    <!-- Product Panel -->
                                    <div class="viewed feature">
                                        <div class="padding_">
                                            <!-- Recently Viewed Slider -->
                                            <div class="row">
                                                <!-- Recently Viewed Item -->
                                                @foreach($category_product as $product__)
                                                    @php
                                                        $images = json_decode($product__->image);
                                                    @endphp
                                                    <div class="col-xl-2 col-lg-2 col-md-4 col-6 p-0 mb-2">

                                                        <div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                                            @if(Auth::check()) 
                                                                @php
                                                                    if(\App\Models\WishList::where('product_id', $product__->id)->where('user_mac', Auth::guard('web')->user()->id)->first()){
                                                                        $find = 'find';
                                                                    }
                                                                    else{
                                                                        $find = 'not';
                                                                    }
                                                                @endphp
                                                                <add-to-wish-list :style_wish="0" :product="{{ json_encode($product__) }}" url="{{ url('/') }}" find="{{ $find }}"></add-to-wish-list>
                                                            @endif
                                                            <div class="viewed_image cursor-pointer" onclick="location.href='{{ route('product.view', $product__->slug) }}'">
                                                                <img class="man_lazy" src="{{ asset('public/gb.png') }}" data-src="{{ $product__->feature_photo!='' ? asset($product__->feature_photo) : asset($images[0]) }}" alt="">
                                                            </div>
                                                            <div class="viewed_content text-center">
                                                                <div class="viewed_name text-truncate"><a href="{{ route('product.view', $product__->slug) }}" title="{{ $product__->title }}">{{ $product__->title }}</a></div>
                                                                <div class="viewed_price">{{ $product__->discount_flat ? ($product__->regular_price - $product__->discount_flat).' TK' : '' }}<span>({{ $product__->regular_price }})</span></div>
                                                            </div>

                                                            @if($product__->discount_flat > 0)
                                                                <ul class="item_marks">
                                                                    <li class="item_mark item_discount" style="display: none;">{{ $product__->discount_flat.' TK' }}</li>
                                                                </ul>
                                                            @endif
                                                            <add-to-cart :hover_product="2" :product="{{ json_encode($product__) }}"></add-to-cart>                                                        
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if(count($feature_products)>0)
        <div class="deals_featured mt-4 my_personal">
            <div class="container">
                <div class="row my-row">
                    <div class="col myShadow">
                        <!-- is_feature_product -->
                        <div class="featured mymg" @if(count($feature_products)>0) style="width: 100%;" @endif>
                            <div class="tabbed_container">
                                <div class="viewed_title_container">
                                    <h3 class="viewed_title">Feature Product</h3>
                                </div>
                                <!-- Product Panel -->
                                <div class="viewed feature">
                                    <div class="padding_">
                                        <!-- Recently Viewed Slider -->
                                        <div class="row">
                                            <!-- Recently Viewed Item -->
                                            @foreach($feature_products as $feature_product)
                                                @php
                                                $images = json_decode($feature_product->image);
                                                @endphp
                                                <div class="col-xl-2 col-lg-2 col-md-4 col-6 p-0 mb-2">

                                                    <div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                                        @if(Auth::check())
                                                        {{-- <div class="wishlist-btn"><i title="Add to wishlist." class="fas fa-heart"></i></div> --}}
                                                        @php
                                                        if(\App\Models\WishList::where('product_id', $feature_product->id)->where('user_mac', Auth::guard('web')->user()->id)->first()){
                                                            $find = 'find';
                                                        }
                                                        else{
                                                            $find = 'not';
                                                        }
                                                        @endphp
                                                        @endif
                                                        <div class="viewed_image cursor-pointer" > <!-- onclick="location.href='{{ route('product.view', $feature_product->slug) }}'"-->
                                                            <img class="man_lazy" src="{{ asset('public/gb.png') }}" data-src="{{ $feature_product->feature_photo!='' ? asset($feature_product->feature_photo) : asset($images[0]) }}" alt="">
                                                        </div>
                                                        <div class="viewed_content text-center">
                                                            <div class="viewed_name text-truncate"><a href="{{ route('product.view', $feature_product->slug) }}" title="{{ $feature_product->title }}">{{ $feature_product->title }}</a></div>
                                                            <div class="viewed_price">{{ $feature_product->discount ? $feature_product->regular_price - (($feature_product->regular_price * $feature_product->discount) / 100).' TK' : '' }}<span>({{ $feature_product->regular_price }})</span></div>
                                                        </div>

                                                        @if($feature_product->discount > 0)
                                                        <ul class="item_marks">
                                                            <li class="item_mark item_discount" style="display: none;">{{ $feature_product->discount.' %' }}</li>
                                                        </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif


        @if($recently_viewed)
        <div class="viewed mt-4 my_personal">
            <div class="container">
                <div class="row my-row">
                    <div class="col myShadow">
                        <div class="viewed_title_container">
                            <h3 class="viewed_title">{{ __('frontend/default.recently_viewed')}}</h3>
                        </div>

                        <div class="viewed_slider_container col-12">

                            <!-- Recently Viewed Slider -->
                            <div class="row">

                                <!-- Recently Viewed Item -->
                                @foreach($recently_viewed as $recent_view)
                                @php
                                $images = json_decode($recent_view->image);
                                @endphp
                                <div class="col-xl-2 col-lg-2 col-md-4 col-6 p-0 mb-2">
                                    <div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                        @if(Auth::check())
                                        @php
                                        if(\App\Models\WishList::where('product_id', $recent_view->id)->where('user_mac', Auth::guard('web')->user()->id)->first()){
                                            $find = 'find';
                                        }
                                        else{
                                            $find = 'not';
                                        }
                                        @endphp
                                        <add-to-wish-list :style_wish="0" :product="{{ json_encode($recent_view) }}" url="{{ url('/') }}" find="{{ $find }}"></add-to-wish-list>
                                        @endif
                                        <div class="viewed_image cursor-pointer" onclick="location.href='{{ route('product.view', $recent_view->slug) }}'">
                                            <img class="man_lazy" src="{{ asset('public/gb.png') }}" data-src="{{ $recent_view->feature_photo!='' ? asset($recent_view->feature_photo) : asset($images[0]) }}" alt="">
                                        </div>
                                        <div class="viewed_content text-center">
                                            <div class="viewed_name text-truncate"><a href="{{ route('product.view', $recent_view->slug) }}" title="{{ $recent_view->title }}">{{ $recent_view->title }}</a></div>
                                            <div class="viewed_price">{{ $recent_view->discount ? $recent_view->regular_price - (($recent_view->regular_price * $recent_view->discount) / 100).' TK' : '' }}<span>({{ $recent_view->regular_price }})</span></div>
                                        </div>
                                        @if($recent_view->discount > 0)
                                        <ul class="item_marks">
                                            <li class="item_mark item_discount" style="display: none;">{{ $recent_view->discount.' %' }}</li>
                                        </ul>
                                        @endif
                                        <add-to-cart :hover_product="2" :product="{{ json_encode($recent_view) }}"></add-to-cart> 
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function(){
      $(".owl-carousel").owlCarousel();
  });
</script>
<script src="{{ asset('public/front/js/custom.js') }}" type="b85f535929402f07d7a62e20-text/javascript"></script>
<script src="{{ asset('public/front/js/push_message.js') }}"></script>

<script>
    $(document).ready(function() {
        $("#close").click(function(event) {
            $('#myModal').modal('hide');
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var yetVisited = localStorage['visited'];
        if (!yetVisited) {
            localStorage['visited'] = "yes";
            $('#myModal').modal('toggle');
        } else {
          $('#myModal').modal('hide');
        }
    });
</script>
@endsection
