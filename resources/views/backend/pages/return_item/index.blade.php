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
    <h1><i class="fa fa-pie-chart"></i> {{ "All Request" }}</h1>
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
          <div class="col-md-6"><h2><i class="fa fa-table"></i> {{ __('backend/default.all_request_item') }}</h2> </div>
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

        @php
        $permissions = \App\Models\Menu::orderBy('id', 'desc')->where('url', substr(url()->current(), 1+strlen(url('/'))))
        ->orWhere('url', substr(url()->current(), strlen(url('/'))))->first();
        $bodyMenu = \App\Models\Role::where('role', Auth::guard('admin')->user()->admin_role)->first();
        @endphp
        
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
              <th>Action</th>
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
                <td>{{ $item->regular_price }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ ($item->quantity * $item->regular_price) }}</td>
                <td class="action">
                  <div class="btn-group">
                    @foreach($permissions->submenus as $key => $permission)
                      @if(\App\Models\Menu::checkBodyMenu($permission->id, $bodyMenu->in_body))
                        @if($key == 0)
                        <a href="{{ route('admin.return.items.view', $item->order_id) }}" class="btn btn-info" title="view order"><i class="fa fa-eye"></i></a>
                      @else
                        <a href="{{ route('admin.return.items.received', $item->id) }}" class="btn btn-warning " title="Product Received"><i class="fa fa-history"></i></a>
                      @endif
                      @endif
                    @endforeach
                </td>
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