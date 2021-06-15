@extends('backend.layouts.master')

@section('fav_title', 'Add Supplier')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h2><i class="fa fa-plus-square"></i> {{ __('backend/default.add_supplier') }}</h2></div>
          <div class="col-md-6"><a href="{{ route('admin.supplier') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="card-body">
        @include('backend.partials.error_message')
        @php
          $permissions = \App\Models\Menu::orderBy('id', 'desc')->where('url', substr(url()->current(), 1+strlen(url('/'))))
          ->orWhere('url', substr(url()->current(), strlen(url('/'))))->first();
          $bodyMenu = \App\Models\Role::where('role', Auth::guard('admin')->user()->admin_role)->first();
        @endphp
        <div class="table-responsive">
          <table id="datatable" class="table table-bordered table-hover display">
            <thead>
              <th>SL</th>
              <th>Name</th>
              <th>Photo</th>
              <th>Mobile</th>
              <th>E-mail</th>
              <th>Address</th>
              <th>Balance</th>
              <th>Type</th>
              <th class="action">Action</th>
            </thead>

            <tbody>
              @foreach($suppliers as $key => $row)
              <tr>
                <td>{{ 1+$key }}</td>
                <td>{{ $row->name }}</td>
                <td><img src="{{asset($row->img)}}" height="25"></td>
                <td>{{ $row->mobile }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->address }}</td>
                <td>{{ $row->initial_balance }}</td>
                <td>{{ ucfirst($row->type) }}</td>
                <td class="action">
                  <div class="btn-group">
                    @foreach($permissions->submenus as $key => $permission)
                      @if(\App\Models\Menu::checkBodyMenu($permission->id, $bodyMenu->in_body))
                        @if($key == 0)
                          <a href="{{route($permission->route, $row->id)}}" class="btn btn-info"><i class="fa fa-history"></i></a>
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
      <div class="card-footer">&nbsp;</div>
    </div>
  </div>
</div>
@endsection

@section('scripts')

@endsection
