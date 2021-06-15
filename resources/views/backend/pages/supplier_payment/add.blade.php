@extends('backend.layouts.master')

@section('fav_title', 'Add Supplier')

@section('content')

<div class="row">
	<div class="col-md-12">
	    <div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h2><i class="fa fa-plus-square"></i> {{ __('backend/default.add_payment') }}</h2></div>
					<div class="col-md-6"><a href="{{ route('admin.supplier.payment') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
					<div class="clearfix"></div>
				</div>
			</div>

		    <div class="card-body">
		        @include('backend.partials.error_message')
		        <form class="form-horizontal" id="myform" action="{{ route('admin.supplier.payment.add') }}" method="post" enctype="multipart/form-data">
		          @csrf
					<div class="form-group row">
						<label class="control-label col-md-3 text-right">
							<strong>{{ __('backend/default.date') }}</strong> 
							<span class="text-danger">*</span>
						</label>
						<div class="col-md-5">
							<div class="input-group date" data-provide="datepicker">
								<input type="text" class="form-control to_date" name="date" value="{{ date('Y-m-d') }}" autocomplete="off">
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
							<select name="supplier_id" id="supplier_id" class="form-control select2">
								<option value=""> -- Select A Supplier -- </option>
								@foreach($suppliers as $value)
								<option value="{{$value->id}}">{{$value->name}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3 text-right">
							<strong>Balance (TK)</strong> 
							<span class="text-danger">*</span>
						</label>
						<div class="col-md-5">
							<div class="row">
								<div class="col-7 pr-0">
									<input class="form-control" type="text" id="previous_blnc" required readonly="">
								</div>
								<div class="col-5">
									<input class="form-control" type="text" id="previous_blnc_type" required readonly>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3 text-right">
							<strong>Transaction Type</strong> 
							<span class="text-danger">*</span>
						</label>
						<div class="col-md-5">
							<select name="trx_type" id="trx_type" class="form-control select2">
								<option value="payment">Paid To Supplier</option>
                            	<option value="receive">Receive From Supplier</option>
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
	                            <option value="cash">Cash</option>
	                            <option value="cheque">Cheque</option>
	                            <option value="bkash">bKash</option>
	                            <option value="bank">Bank</option>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3 text-right">
							<strong>Payment (TK) </strong>
							<span class="text-danger">*</span>
						</label>
						<div class="col-md-5">
							<input  class="form-control" type="number" name="paid" value="0" id="paid" required>
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3 text-right">
							<strong>Commission (TK)</strong>
						</label>
						<div class="col-md-5">
							<input class="form-control" type="number" value="0" name="remission" id="remission">
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3 text-right">
							<strong>Paid By</strong>
						</label>
						<div class="col-md-5">
							<input  class="form-control" type="text" name="paid_by">
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3 text-right">
							<strong>Balance (TK)</strong> 
							<span class="text-danger">*</span>
						</label>
						<div class="col-md-5">
							<div class="row">
								<div class="col-7 pr-0">
									<input class="form-control" type="text" name="balance" id="blnc" readonly>
								</div>
								<div class="col-5">
									<input class="form-control" type="text" name="type" id="blnc_type" readonly>
								</div>
							</div>
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
<script>
	$('.select2').select2();
	$('.date').datepicker({
		format: 'yyyy-mm-dd',
		todayHighlight:'TRUE',
		autoclose: true,
	});
	// Execute below code when dom is ready
	window.addEventListener('load', ()=>{
		_x('#supplier_id').onchange = ()=>{

			var previous_blnc_type  = _x('#previous_blnc_type');
			var previous_blnc 		= _x('#previous_blnc');
			var blnc_type 			= _x('#blnc_type');
			var blnc 				= _x('#blnc');

			if(_x('#supplier_id').value){
				axios.post(window.location.origin+'/api/getSupllier/'+_x('#supplier_id').value)
				.then(response=>{
					var data = response.data;
					// Calculate Balance Type
					var new_type = (data.initial_balance > 0 ? 'Receivable' : 'Payable')
					// Asign Value
					previous_blnc_type.value  = new_type;
					previous_blnc.value = Math.abs(data.initial_balance);
					blnc.value 			= Math.abs(data.initial_balance);
					blnc_type.value		= new_type;
					paymentChange();
				})
				.catch(err=>console.log(err));
			}
			else{
				previous_blnc_type.value  = '';
				previous_blnc.value = '';
				blnc.value 			= '';
				blnc_type.value		= '';
				paymentChange();
			}
		}


		_x('#trx_type').onchange=()=>{
			paymentChange();
		}
		_x('#remission').oninput=()=>{
			paymentChange();
		}
		_x('#paid').oninput=()=>{
			paymentChange();
		}

		// Change and customize payment collection
		function paymentChange(){
			var previous_blnc_type  = _x('#previous_blnc_type');
			var previous_blnc 		= _x('#previous_blnc');
			var blnc_type 			= _x('#blnc_type');
			var blnc 				= _x('#blnc');
			var paid 				= _x('#paid');
			var remission 			= _x('#remission');
			var trx_type 			= _x('#trx_type');

			previous_blnc = (previous_blnc_type.value == 'Payable' ? previous_blnc.value : (0 - previous_blnc.value));

			var current_balcne  = +previous_blnc - +remission.value;

			if(trx_type.value == 'payment'){
				current_balcne = +current_balcne - +paid.value;
			}
			else{
				current_balcne = +current_balcne + +paid.value;
			}
			blnc.value = Math.abs(current_balcne);
			// Set new Type
			if(+current_balcne >= 0){
				blnc_type.value = "Payable";
			}
			else{
				blnc_type.value = "Receivable";
			}
		}

	});

	// Dom Rendaring
	function _x(x){
		return document.querySelector(x);
	}


</script>
@endsection
