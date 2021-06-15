@extends('backend.layouts.master')

@section('fav_title', 'Edit Supplier')

@section('content')

<div class="row">
	<div class="col-md-12">
	    <div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h2><i class="fa fa-plus-square"></i> {{ __('backend/default.edit_payment') }}</h2></div>
					<div class="col-md-6"><a href="{{ route('admin.supplier.payment') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
					<div class="clearfix"></div>
				</div>
			</div>

		    <div class="card-body">
		        @include('backend.partials.error_message')
		        <form class="form-horizontal" id="myform" action="{{ route('admin.supplier.payment.edit', $transaction->id) }}" method="post" enctype="multipart/form-data">
		          @csrf
					<div class="form-group row">
						<label class="control-label col-md-3 text-right">
							<strong>{{ __('backend/default.date') }}</strong> 
							<span class="text-danger">*</span>
						</label>
						<div class="col-md-5">
							<div class="input-group date" data-provide="datepicker">
								<input type="text" class="form-control to_date" name="date" value="{{ $transaction->date }}" autocomplete="off">
								<div class="input-group-addon to_icon">
									<span><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3 text-right">
							<strong>{{ __('backend/form_field.name') }}</strong> 
							<span class="text-danger">*</span>
						</label>
						<div class="col-md-5">
							<select name="supplier_id" id="supplier_id" class="form-control select2" disabled>
								<option value=""> -- Select A Supplier -- </option>
								@foreach($suppliers as $value)
								<option value="{{$value->id}}" {{$transaction->supplier_id==$value->id?'selected':''}}>{{$value->name}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3 text-right">
							<strong>Transaction Type</strong> 
							<span class="text-danger">*</span>
						</label>
						<div class="col-md-5">
							<select name="trx_type" id="trx_type" class="form-control select2">
								<option value="payment" {{$transaction->trx_type=='payment'?'selected':''}}>Paid To Supplier</option>
                            	<option value="receive" {{$transaction->trx_type=='receive'?'selected':''}}>Receive From Supplier</option>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3 text-right">
							<strong>Transaction Method</strong> 
							<span class="text-danger">*</span>
						</label>
						<div class="col-md-5">
							<select name="trx_method" id="trx_method" class="form-control select2">
	                            <option value="cash" {{$transaction->trx_method=="cash"?"selected":""}}>Cash</option>
	                            <option value="cheque" {{$transaction->trx_method=="cheque"?"selected":""}}>Cheque</option>
	                            <option value="bkash" {{$transaction->trx_method=="bkash"?"selected":""}}>bKash</option>
	                            <option value="bank" {{$transaction->trx_method=="bank"?"selected":""}}>Bank</option>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3 text-right">
							<strong>Payment (TK) </strong>
							<span class="text-danger">*</span>
						</label>
						<div class="col-md-5">
							<input  class="form-control" type="number" name="paid"  value="{{$transaction->paid}}" id="paid" required>
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3 text-right">
							<strong>Commission (TK)</strong>
						</label>
						<div class="col-md-5">
							<input class="form-control" type="number" value="{{$transaction->remission}}" name="remission" id="remission">
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3 text-right">
							<strong>Paid By</strong>
						</label>
						<div class="col-md-5">
							<input  class="form-control" type="text" name="paid_by" value="{{$transaction->paid_by}}">
						</div>
					</div>
		          
					<div class="form-row">
						<div class="col-md-8 mt-3">
							<button type="submit" class="btn btn-primary float-right">{{ __('backend/default.submit') }}</button>
						</div>
					</div>
		        </form>
		    </div>
		    <div class="card-footer">&nbsp;</div>
	    </div>
	</div>
</div>
@endsection

@section('scripts')
<script >
	$('.date').datepicker({
		format: 'yyyy-mm-dd',
		todayHighlight:'TRUE',
		autoclose: true,
	});
</script>
@endsection
