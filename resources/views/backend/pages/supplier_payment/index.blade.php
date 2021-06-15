@extends('backend.layouts.master')

@section('fav_title', 'Add Supplier')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h2><i class="fa fa-plus-square"></i> {{ __('backend/default.transaction_history') }}</h2></div>
          <div class="col-md-6"><a href="{{ route('admin.supplier') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="card-body">
      	<form action="{{ url('admin/payment') }}" method="post" class="none">
			@csrf
			<div class="row mb-3">
				<div class="col-md-3">
					<div class="input-group date" id="fromDate" data-provide="datepicker">
						<input type="text" class="form-control from_date" name="from_date" value="{{ $_POST ? $app->request->input('from_date') : date('Y-m-d') }}" autocomplete="off">
						<div class="input-group-addon from_icon">
							<span><i class="fa fa-calendar"></i></span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="input-group date" id="toDate" data-provide="datepicker">
						<input type="text" class="form-control to_date" name="to_date" value="{{ $_POST ? $app->request->input('to_date') : date('Y-m-d') }}" autocomplete="off">
						<div class="input-group-addon to_icon">
							<span><i class="fa fa-calendar"></i></span>
						</div>
					</div>
				</div>
				<div class="col-md-1">
					<button class="btn btn-primary searchByDate" type="submit">{{ __('backend/default.search') }}</button>
				</div>
			</div>
		</form>

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
              <th>Date</th>
              <th>Name</th>
              <th>Photo</th>
              <th>Trx Method</th>
              <th>Receive</th>
              <th>Payment</th>
              <th>Remission</th>
              <th>Paid By</th>
              <th>Type</th>
              <th class="action">Action</th>
            </thead>

            <tbody>
            	@php
            		$total_payment = $total_receive = $total_remission = 0;
            	@endphp
              @foreach($transactions as $key => $row)
              	@php
                $total_remission += $row->remission;
            		if($row->trx_type=="receive")
            		$total_receive += $row->paid;
            		else
            		$total_payment += $row->paid;
            	@endphp
              <tr>
                <td>{{ 1+$key }}</td>
                <td>{{ $row->date }}</td>
                <td>{{ $row->supplier->name ?? 'N/A' }}</td>
                <td><img src="{{asset($row->supplier->img)}}" height="25"></td>
                <td>{{ ucfirst($row->trx_method) }}</td>
                <td>{{ $row->trx_type=="receive"?$row->paid:0 }}</td>
                <td>{{ $row->trx_type=="payment"?$row->paid:0 }}</td>
                <td>{{ $row->remission }}</td>
                <td>{{ $row->paid_by }}</td>
                <td>{{ ucfirst($row->trx_type) }}</td>
                <td class="action">
                  <div class="btn-group">
                    @foreach($permissions->submenus as $key => $permission)
                      @if(\App\Models\Menu::checkBodyMenu($permission->id, $bodyMenu->in_body))
                        @if($key == 0)
                          <a href="{{route($permission->route, $row->id)}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                        @else
                          <button class="btn btn-danger text-white" onClick="deleteMethod({{ json_encode($row->id) }})"><i class="fa fa-trash"></i></button>
                        @endif
                      @endif
                    @endforeach
                  </div>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <hr>
          <pre>
          	<table>
          		<tr>
          			<th>Total Payment</th>
          			<th>: {{$total_payment}}TK</th>
          		</tr>
          		<tr>
          			<th>Total Receive</th>
          			<th>: {{$total_receive}}TK</th>
          		</tr>
              <tr>
                <th>Total Remission</th>
                <th>: {{$total_remission}}TK</th>
              </tr>
          	</table>
          </pre>

        </div>
      </div>
      <div class="card-footer">&nbsp;</div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
	$('.date').datepicker({
		format: 'yyyy-mm-dd',
		todayHighlight:'TRUE',
		autoclose: true,
	});
</script>
@endsection
