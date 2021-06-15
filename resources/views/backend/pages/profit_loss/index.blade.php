@extends('backend.layouts.master')

@section('fav_title', 'Category List')

@section('styles')
  <style>
    .action{
      min-width: 70px;
    }
    .table th, .table td{
      vertical-align: middle;
    }
    .drag-sort-enable > tr{
      cursor: move;
    }
    .table tr.drag-sort-active {
      border: 1px solid #4ca1af;
    }
    .table tr.drag-sort-active>*{
      visibility: hidden;
    }
  </style>
@endsection

@section('content')
<div class="app-title">
  <div>
    <h1><i class="fa fa-pie-chart"></i> {{ __('backend/default.profit_loss') }}</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg fa-fw"></i><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('backend/default.profit_loss') }}</li>
  </ul>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h2><i class="fa fa-table"></i> {{ __('backend/default.profit_loss') }}</h2></div>
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="card-body">
        <div id="alert"></div>
        
        <form action="" method="post" class="none">
            @csrf
            <div class="form-row mb-3">
                <div class="col-md-3">
                    <div class="input-group date" id="fromDate" data-provide="datepicker">
                        <input type="text" class="form-control" name="from_date" value="{{ $app->request->input('from_date') }}">
                        <div class="input-group-addon">
                            <span><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group date" id="toDate" data-provide="datepicker">
                        <input type="text" class="form-control" name="to_date" value="{{ $app->request->input('to_date') }}">
                        <div class="input-group-addon">
                            <span><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
        
        <div class="table-responsive">
          <table class="table table-bordered table-hover display">
            <thead>
              <th>SL</th>
              <th>Date</th>
              <th>Product name</th>
              <th>QTY</th>
              <th>Purchase Price</th>
              <th>Sale Price</th>
              <th>Profit</th>
              <th>Loss</th>
            </thead>
            {{-- @dd($orderItems->toArray()) --}}
            <tbody>
            	@php($total_purchase = $total_sale = $total = 0)
            	@foreach($products as $key=>$product)
	            	<tr>
	            		<td>{{ ++$key }}</td>
	            		<td>{{ $product->updated_at }}</td>
                  <td>{{ $product->title }}</td>
		              	<td>{{ $product->total_qty }}</td>
		              	<td>{{ $product->purchase_price }}</td>
		              	<td>{{ $product->regular_price }}</td>
		              	@php($result = ($product->regular_price - $product->purchase_price) * $product->total_qty)
		              	<td>{{ ($result > 0 ? $result : 0) }}</td>
		              	<td>{{ ($result < 0 ? $result : 0) }}</td>
		              	@php($total_purchase += $product->purchase_price)
		              	@php($total_sale += $product->regular_price)
		              	@php($total += $result)
	            	</tr>
	            @endforeach
	            <tr>
	            	<td class="text-right" colspan="4"><strong>Total:</strong></td>
	            	<td>{{ $total_purchase }}</td>
	            	<td>{{ $total_sale }}</td>
	            	<td>{{ ($total > 0 ? $total : 0) }}</td>
		            <td>{{ ($total < 0 ? $total : 0) }}</td>
	            </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('scripts')
<script>
    $('#fromDate').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight:'TRUE',
        autoclose: true,
    });

    $('#toDate').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight:'TRUE',
        autoclose: true,
    });
</script>
@endsection