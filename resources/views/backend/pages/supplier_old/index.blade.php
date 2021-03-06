@extends('backend.layouts.master')

@section('fav_title', 'brand List')

@section('styles')
<style>
.action{
  min-width: 70px;
}
  .table th, .table td{
    vertical-align: middle;
  }
</style>
@endsection

@section('content')
<div class="app-title">
  <div>
    <h1><i class="fa fa-briefcase"></i> {{ __('backend/brand.brand_management') }}</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg fa-fw"></i><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('backend/brand.brand') }}</li>
  </ul>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h2><i class="fa fa-table"></i> {{ __('backend/default.supplier') }}</h2></div>
          <div class="col-md-6"><a href="{{ route('admin.supplier') }}" class="float-right btn btn-primary"><i class="fa fa-plus"></i> {{ __('backend/default.add_new') }}</a></div>
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="card-body">
          @php
              $permissions = \App\Models\Menu::orderBy('id', 'desc')->where('url', substr(url()->current(), 1+strlen(url('/'))))
              ->orWhere('url', substr(url()->current(), strlen(url('/'))))->first();
              $bodyMenu = \App\Models\Role::where('role', Auth::guard('admin')->user()->admin_role)->first();
          @endphp
        
        <div class="table-responsive">
          <table id="datatable" class="table table-bordered table-hover display">
            <thead>
              <th width="10">SL</th>
              <th>Name</th>
              <th>Image</th>
              <th class="action" width="15">Action</th>
            </thead>

            <tbody>
            @foreach($suppliers as $key => $row)
              <tr class="{{ $row->status == 0 ? 'deactive_':'' }}">
                <td>{{ ($key+1) }}  </td>
                <td>{{ $row->name }}</td>
                <td>
                    <img style="width: 80px; height: 80px " src="{{asset($row->image)}}" alt="">
                </td>
                <td class="action">
                    <div class="btn-group">
                        @foreach($permissions->submenus as $key => $permission)
                            @if(\App\Models\Menu::checkBodyMenu($permission->id, $bodyMenu->in_body))
                                @if($key == 0)
                                    <a href="{{route($permission->route, $row->id)}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                @else
                                    <button class="btn btn-danger" onClick="deleteMethod({{ json_encode($row->id) }})" role="button"><i class="fa fa-trash"></i></button>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection
