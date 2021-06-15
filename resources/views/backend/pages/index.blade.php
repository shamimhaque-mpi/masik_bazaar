@extends('backend.layouts.master')

@section('fav_title', 'Dashboard')

@section('styles')
<style>
  .widget-small .info h4 {
    text-transform: initial;
    margin: 0;
    margin-bottom: 5px;
    font-weight: 800;
    font-size: 0.9rem;
  }
</style>
@endsection

@section('content')

<div class="app-title">
  <div>
    <h1><i class="fa fa-dashboard"></i> {{ __('backend/default.dashboard') }}</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i> {{ __('backend/default.dashboard') }}</li>
  </ul>
</div>


@if(Auth::guard('admin')->user()->admin_role == 1)
  <div class="row">
    <div class="col-md-6 col-lg-3">
      <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/user.user') }}</h4>
          <p><b>{{ $user }}</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon"><i class="icon fa fa-hand-rock-o fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/order.pending_order') }}</h4>
          <p><b>{{ $pending_order }}</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><i class="icon fa fa-thumbs-o-up fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/order.completed_order') }}</h4>
          <p><b>{{ $completed_order }}</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon"><i class="icon fa fa-archive fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/product.product') }}</h4>
          <p><b>{{ $product }}</b></p>
        </div>
      </div>
    </div>
{{-- 
    <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon"><i class="icon fa fa-pie-chart fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/category.category') }}</h4>
          <p><b>{{ $category }}</b></p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><i class="icon fa fa-yelp fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/subcategory.subcategory') }}</h4>
          <p><b>{{ $sub_category }}</b></p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon"><i class="icon fa fa-briefcase fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/brand.brand') }}</h4>
          <p><b>{{ $brand }}</b></p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="widget-small primary coloured-icon"><i class="icon fa fa-cloud fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/advertisement.advertisement') }}</h4>
          <p><b>{{ $advertisement }}</b></p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="widget-small primary coloured-icon"><i class="icon fa fa-money fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/payment.payment_method') }}</h4>
          <p><b>{{ $payment_method }}</b></p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon"><i class="icon fa fa-ticket fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/coupon.coupon') }}</h4>
          <p><b>{{ $coupon }}</b></p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><i class="icon fa fa-paint-brush fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/color.color') }}</h4>
          <p><b>{{ $color }}</b></p>
        </div>
      </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon"><i class="icon fa fa-arrows fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/size.size') }}</h4>
          <p><b>{{ $size }}</b></p>
        </div>
      </div>
    </div> 
    --}}

    <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-bag fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/default.today_sale') }}</h4>
          <p><b>{{ $today_sale }}</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><i class="icon fa fa-shopping-bag fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/default.this_week_sale') }}</h4>
          <p><b>{{ $this_week_sale }}</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon"><i class="icon fa fa-shopping-bag fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/default.this_month_sale') }}</h4>
          <p><b>{{ $this_month_sale }}</b></p>
        </div>
      </div>
    </div>
  </div>
@else
  @php
      $product = DB::table('products')->where('admin_id', Auth::guard('admin')->user()->id)->where('status', 1)->count();
  @endphp
  <div class="row">
    {{-- <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon"><i class="icon fa fa-hand-rock-o fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/order.pending_order') }}</h4>
          <p><b>{{ $pending_order }}</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><i class="icon fa fa-thumbs-o-up fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/order.completed_order') }}</h4>
          <p><b>{{ $completed_order }}</b></p>
        </div>
      </div>
    </div> --}}
    
    <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon"><i class="icon fa fa-archive fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/product.product') }}</h4>
          <p><b>{{ $product }}</b></p>
        </div>
      </div>
    </div>

    {{-- <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-bag fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/default.today_sale') }}</h4>
          <p><b>{{ $today_sale }}</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><i class="icon fa fa-shopping-bag fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/default.this_week_sale') }}</h4>
          <p><b>{{ $this_week_sale }}</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon"><i class="icon fa fa-shopping-bag fa-3x"></i>
        <div class="info">
          <h4>{{ __('backend/default.this_month_sale') }}</h4>
          <p><b>{{ $this_month_sale }}</b></p>
        </div>
      </div>
    </div> --}}
  </div>
@endif

<br>

<!--<div class="row d-flex justify-content-center">-->
<!--    <div class="col-md-6">-->
<!--        <div class="table-responsive">-->
<!--            <table class="table table-bordered">-->
<!--                <tr>-->
<!--                    <th>SL</th>-->
<!--                    <th>Date</th>-->
<!--                    <th>Voucher</th>-->
<!--                    <th>Product</th>-->
<!--                    <th>Total Amount</th>-->
<!--                    <th>Profit</th>-->
<!--                </tr>-->
                
<!--            </table>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->




@endsection
@section('scripts')
  <script type="text/javascript"></script>
@endsection