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
    .drag-sort-enable>tr{
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
    <h1><i class="fa fa-pie-chart"></i> {{ "All Return Items" }}</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg fa-fw"></i><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
  </ul>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h2><i class="fa fa-table"></i> {{ __('backend/default.all_returned_item') }}</h2> </div>
          <div class="col-md-6">
            @if($total > 0)
            <div class="btn-group float-right">
              <span><strong>Total:</strong> {{$total}} TK</span>
            </div> 
            @endif
          </div>
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="card-body">
        <div id="alert"></div>
        
        <div class="table-responsive">
          <table id="datatable" class="table table-bordered table-hover display">
            <thead>
              <th>SL</th>
              <th>Order id</th>
              <th>Username</th>
              <th>Mobile</th>
              <th>Title</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Amount</th>
            </thead>
            @php($order_number = new App\Helpers\CalculationHelper())
            <tbody id="drag_sortable">
            @if(!$items->isEmpty())
              @foreach($items as $key=>$item)
              <tr>
                <td>{{ $key+1 }}</td>
                <td>#{{ $order_number::generateVoucher($item->order_id)  }}</td>
                <td>{{ $item->username  }}</td>
                <td>{{ $item->mobile }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ ($item->quantity * $item->price) }}</td>
              </tr>
              @endforeach
            @endif
            </tbody>

            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection


@section('scripts')

@endsection