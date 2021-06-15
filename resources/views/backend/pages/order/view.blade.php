@extends('backend.layouts.master')

@section('fav_title', 'Invoice#000'.$order->id)

@section('styles')
<style>
    @media print{
        .none{
            display: none;
        }
        .hide{
            display: block;
        }
        .text-white{
            color: #000000 !important;
        }
    }
    .hide{
        display: none;
    }
    .invoice {
        width: 150px;
        background: #ddd;
        text-align: center;
        padding: 1rem;
    }
    .border-btom {
        padding-bottom: 8px;
        margin-bottom: 20px;
        width: 170px;
        border-bottom: 1px solid #000 !important;
    }
    .border-btom2 {
        padding-bottom: 8px;
        margin-top: 40px;
        width: 250px;
        border-bottom: 1px solid #000 !important;
    }
    .inv-head {
        font-weight: 600;
    }
    #table {
        width: 100%;
    }
    #table tr th, #table tr td {
        padding: 5px 0px;
    }
    
    .admin-action .pull-right {
        margin-bottom: 8px;
    }
    .table_responsive {
        display: block;
        width: 100%;
        overflow-x: auto
    }
    @media screen and (max-width: 576px){
       .admin-action {
           display: flex;
           flex-wrap: wrap;
           justify-content: center;
       } 
       .admin-action button {min-width: 160px;} 
    }

</style>
@endsection

@section('content')

@php 
    $order_number = App\Helpers\CalculationHelper::generateVoucher($order->id);
@endphp


<div class="app-title">
    <div>
        <h1><i class="fa fa-shopping-basket"></i> {{ __('backend/order.order_management') }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg fa-fw"></i>
            <a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.order.pending') }}">{{ $order->order_status < 4 ? __('backend/order.pending_order') : __('backend/order.completed_order') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('backend/order.order').' #'.$order_number }}</li>
    </ul>
</div>

<div class="container mb-3">
    <div class="card">
        <div class="float-right none">
            <button class="btn btn-primary float-right" onclick="window.print()"><i class="fa fa-fw fa-print"></i>Print</button>
        </div>    
        <div class="col-md-12">
            <div class="row my-4">
                <div class="col-sm-6">
                    <h2 class="invoice">Invoice</h2>
                </div>
                <div class="col-sm-6">
                    <img class="float-right" src="{{ asset('public/images/settings/'.\App\Models\Setting::first()->logo) }}" alt="Your Logo" height="80">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="border-btom">Invoice Detail</h5>
                    <label><span class="inv-head">Order Date :&emsp;</span><span>{{ date("d-m-Y", strtotime($order->updated_at)) }}</span></label><br>
                    <label><span class="inv-head">Delivery Date :&emsp;</span><span>{{ date("d-m-Y", strtotime(date('d-m-Y'))) }}</span></label><br>
                    <label><span class="inv-head">Invoice No :&emsp;</span><span>{{ "#".$order_number }}</span></label><br>
                </div>
                <div class="col-md-4">
                    @php
                        $user = $order->user;
                        $total_price = 0;
                    @endphp
                    <h5 class="border-btom">Invoice To</h5>
                    <label class="inv-head">{{ $user->name ?? "User Deleted"}}</label><br>
                    <label>{{ $order->address ? $order->address : $user->address ?? "N/A" }}, {{ $order->upazilla_id ? $order->upazilla->name : '' }}, <br> {{ $order->district_id ? $order->district->name : '' }}<br></label><br>
                    <label><span class="inv-head">Phone :&emsp;</span><span>{{ $user->mobile ?? "N/A" }}</span></label><br>
                    <label><span class="inv-head">Email :&emsp;</span><span>{{ $user->email ?? "N/A" }}</span></label><br>
                </div>
                {{-- <div class="col-md-4">
                    <h5 class="mb-4">{{$settiong->address}}</h5>
                    <label><span class="inv-head">Mobile :&emsp;</span><span>{{$settiong->mobile}}</span></label><br>
                    <label><span class="inv-head">Email :&emsp;</span><span>{{$settiong->email}}</span></label><br>
                    <label><span class="inv-head">Website :&emsp;</span><span>{{ url('/') }}</span></label><br>
                </div> --}}
            </div>
        </div>
        

        <div class="col-md-12">
            <div class="mt-5 mb-2 table_responsive">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>{{ __('backend/default.sl') }}</th>
                        <th>{{ __('backend/product.product') }}</th>
                        <th>{{ __('backend/default.supplier') }}</th>
                        <th>{{ __('backend/default.quantity') }}</th>
                        <th>{{ __('backend/default.color') }}</th>
                        <th>{{ __('backend/default.size') }}</th>
                        <th>{{ __('backend/default.price') }}<small>(per unit)</small></th>
                        <th>{{ __('backend/default.price') }}</th>
                        <th>{{ __('backend/default.status') }}</th>
                    </tr>
                    @foreach($order->order_items as $item)

                        @php
                            if($item->order_status == 0) {
                                $status = 'Pending';
                                $color_ = 'text-secondary';
                                $icon_ = 'fa fa-hourglass-half';
                            } else if($item->order_status == 1) {
                                $status = 'Received';
                                $color_ = 'text-info';
                                $icon_ = 'fa fa-handshake-o';
                            } else if($item->order_status == 2) {
                                $status = 'Procesing';
                                $color_ = 'text-warning';
                                $icon_ = 'fa fa-spinner';
                            } else if($item->order_status == 3) {
                                $status = 'On the Way';
                                $color_ = 'text-primary';
                                $icon_ = 'fa fa-motorcycle';
                            } else if($item->order_status == 4) {
                                $status = 'Received';
                                $color_ = 'text-success';
                                $icon_ = 'fa fa-check';
                            }
                        @endphp
                        @if(Auth::guard('admin')->user()->is_merchant)
                            @if($item->admin_id == Auth::guard('admin')->user()->id)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->product->title }} {!! $item->is_return == 1 ? "<span class='badge badge-warning'>request for return</span>" : "" !!}</td>
                                    <td>{{ $item->admin->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->colorS->title ?? "N/A" }}</td>
                                    <td>{{ $item->sizeS->title ?? "N/A" }}</td>
                                    <td>{{ $item->price.' TK' }}</td>
                                    <td>{{ $item->price * $item->quantity.' TK' }}</td>
                                    <td title="{{ $status }}" class="{{ $color_ }}">
                                        <i class="{{ $icon_ }}"></i> {{ $status }}
                                    </td>
                                </tr>
                                @php
                                    $total_price += $item->price * $item->quantity;
                                @endphp
                            @endif
                        @else
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $item->product->title }} {!! $item->is_return == 1 ? "<span class='badge badge-warning'>request for return</span>" : "" !!}</td>
                                <td>{{ $item->admin->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->colorS->title ?? "N/A" }}</td>
                                <td>{{ $item->sizeS->title ?? "N/A" }}</td>
                                <td>{{ $item->price.' TK' }}</td>
                                <td>{{ $item->price * $item->quantity.' TK' }}</td>
                                <td title="{{ $status }}" class="{{ $color_ }}">
                                    <i class="{{ $icon_ }}"></i> {{ $status }}
                                </td>
                            </tr>
                            @php
                                $total_price += $item->price * $item->quantity;
                            @endphp
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-7">
                    <h5 class="border-btom2">PAYMENT METHODS</h5>
                    <label><span class="inv-head">Payment Method :&emsp;</span><span>{{ $order->payment_gateway_id ? $order->payment_gateway->title : 'Nothing selected' }}</span></label><br>
                    <label><span class="inv-head">Tx Id :&emsp;</span><span>{{ $order->txnid !='' ? $order->txnid : 'N/A' }}</span></label><br>
                    <label><span class="inv-head">Tx Amount :&emsp;</span><span>{{ $order->tx_amount !='' ? $order->tx_amount : 'N/A' }}</span></label><br>
                    <label><span class="inv-head">Order Number :&emsp;</span><span>{{ '#'.$order_number }}</span></label><br>
                </div>
                <div class="col-md-5">
                    <table id="table">
                        <tr>
                            <th class="">SubTotal: </th>
                            <td class="">{{ $total_price.' TK' }}</td>
                        </tr>
                        <tr>
                            <th class="">Shipping Cost:</th>
                            <td class="">{{ $order->shipping_cost.' TK' }}</td>
                        </tr>
                        <tr>
                            <th class="">Paid Amound:</th>
                            <td class="">{{ $order->tx_amount.' TK' }}</td>
                        </tr>
                        @if($order->coupon_discount)
                            <tr>
                                <th class="">Coupon Discount:</th>
                                <td class="">{{ $order->coupon_discount.' %' }}</td>
                            </tr>
                        @endif
                        <tr class="bg-primary">
                            <th class=" text-white">Total:</th>
                            <td class=" text-white">{{ (($order->grand_total+$order->shipping_cost) - $order->tx_amount) }} TK</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row my-5">
                <div class="col-md-3 text-center">
                    <br>
                    <br>
                    <hr class="m-0">
                    Customer Signature
                </div>
                <div class="col-md-6">
                    <h4 class="text-center">Thank You For Shopping With Us !</h4>
                </div>
                <div class="col-md-3 text-center">
                    <br>
                    <br>
                    <hr class="m-0">
                    Authority Signature
                </div>
            </div>
        </div>
        @php
            $status_code    = $order_item->order_status;
            $cond_aspending = ($status_code < 0 ? true : false);
            $order_received = ($status_code == 0 ? true : false);
            $asProcess      = ($status_code == 1 && $status_code < 2 ? true : false);
            $ontheway       = ($status_code == 2 && $status_code < 3 ? true : false);
            $ascomplete     = ($status_code == 3 && $status_code < 4 ? true : false);
        @endphp
        <div class="admin-action mb-5 mr-2 none">
            @if(Auth()->user()->id == $order->order_items[0]->admin_id || Auth()->user()->admin_role == 1)
                <div class="pull-right">
                    <form action="{{ route('admin.order.orderManager') }}" method="post">
                        @csrf
                        <input type="hidden" name="orderId" value="{{ $order->id }}">
                        <input type="hidden" name="order_stat" value="4">
                        {{-- <button class="btn btn-success ml-2 {!! $order_item->order_status == 4 ? 'Menu_Permission text-dark" style="border: 2px solid red;':'' !!}" {!! ($order_item->order_status == 3) ? '':'disabled=""' !!} type="submit" title="If order has received"><i class="fa fa-check" aria-hidden="true"></i>{{ __('backend/order.markAsComplete') }}</button> --}}
                        <button class="btn btn-success ml-2 {!! $order_item->order_status == 4 ? 'Menu_Permission text-dark" style="border: 2px solid red;':'' !!}" {!! ($ascomplete) ? '':'disabled=""' !!} type="submit" title="If order has received"><i class="fa fa-check" aria-hidden="true"></i>{{ __('backend/order.markAsComplete') }}</button>
                    </form>
                </div>

                <div class="pull-right">
                    <form action="{{ route('admin.order.orderManager') }}" method="post">
                        @csrf
                        <input type="hidden" name="orderId" value="{{ $order->id }}">
                        <input type="hidden" name="order_stat" value="3">
                        {{-- <button class="btn btn-primary ml-2 {!! $order_item->order_status == 3 ? 'Menu_Permission text-dark" style="border: 2px solid red;':'' !!}" {!! ($order_item->order_status == 2 || $order_item->order_status == 4) ? '':'disabled=""' !!}  type="submit" title="If order is ready for deliver"><i class="fa fa-motorcycle" aria-hidden="true"></i>{{ __('backend/order.onTheWay') }}</button> --}}
                        <button class="btn btn-primary ml-2 {!! $order_item->order_status == 3 ? 'Menu_Permission text-dark" style="border: 2px solid red;':'' !!}" {!! ($ontheway) ? '':'disabled=""' !!}  type="submit" title="If order is ready for deliver"><i class="fa fa-motorcycle" aria-hidden="true"></i>{{ __('backend/order.onTheWay') }}</button>
                    </form>
                </div>

                <div class="pull-right">
                    <form action="{{ route('admin.order.orderManager') }}" method="post">
                        @csrf
                        <input type="hidden" name="orderId" value="{{ $order->id }}">
                        <input type="hidden" name="order_stat" value="2">
                        <button class="btn btn-warning ml-2 {!! $order_item->order_status == 2 ? 'Menu_Permission text-dark" style="border: 2px solid red;':'' !!}" {!! ($asProcess) ? '':'disabled=""' !!} type="submit" title="If order is processing in shop"><i class="fa fa-spinner" aria-hidden="true"></i>{{ __('backend/order.markAsProcessing') }}</button>
                    </form>
                </div>

                <div class="pull-right">
                    <form action="{{ route('admin.order.orderManager') }}" method="post">
                        @csrf
                        <input type="hidden" name="orderId" value="{{ $order->id }}">
                        <input type="hidden" name="order_stat" value="1">
                        <button class="btn btn-info ml-2 {!! $order_item->order_status == 1 ? 'Menu_Permission text-dark" style="border: 2px solid red;':'' !!}" {!! ($order_received) ? '':'disabled=""' !!} type="submit" title="If order has receved by you"><i class="fa fa-handshake-o" aria-hidden="true"></i>{{ __('backend/order.markAsReceived') }}</button>
                    </form>
                </div>

                <div class="pull-right">
                    <form action="{{ route('admin.order.orderManager') }}" method="post">
                        @csrf
                        <input type="hidden" name="orderId" value="{{ $order->id }}">
                        <input type="hidden" name="order_stat" value="0">
                        {{-- <button class="btn btn-secondary ml-2 {!! $order_item->order_status == 0 ? 'Menu_Permission text-dark" style="border: 2px solid red;':'' !!}" {!! ($order_item->order_status == 0 || $order_item->order_status > 1) ? 'disabled=""':'' !!} --}}
                        <button class="btn btn-secondary ml-2 {!! $order_item->order_status == 0 ? 'Menu_Permission text-dark" style="border: 2px solid red;':'' !!}" {!! ($cond_aspending) ? '':'disabled=""' !!}
                        type="submit" title="If order is in pending"><i class="fa fa-hourglass-half" aria-hidden="true"></i>{{ __('backend/order.markAsPending') }}</button>
                    </form>
                </div>

            @endif


        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
