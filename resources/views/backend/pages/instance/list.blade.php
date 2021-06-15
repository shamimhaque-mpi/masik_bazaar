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
    <h1><i class="fa fa-pie-chart"></i> {{ __('backend/default.instance_order') }}</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg fa-fw"></i><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('backend/default.instance_order') }}</li>
  </ul>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h2><i class="fa fa-table"></i> {{ __('backend/default.instance_order') }}</h2></div>
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
              <th>Mobile</th>
              <th>Product List</th>
              <th class="action">Action</th>
            </thead>

            <tbody id="drag_sortable">
            @if($items) @foreach($items as $key=>$value)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$value->mobile}}</td>
                <td>{{$value->items}}</td>
                <td class="action">
                  <div class="btn-group">
                    <button class="btn btn-danger" onClick="deleteMethod({{ json_encode($value->id) }})"><i class="fa fa-trash"></i></button>
                  </div>
                </tr>
            @endforeach @endif
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