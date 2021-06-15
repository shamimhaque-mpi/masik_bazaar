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
        <form class="form-horizontal" id="myform" action="{{ route('admin.supplier.add') }}" method="post" enctype="multipart/form-data">
          @csrf

          <div class="form-group row">
            <label class="control-label col-md-3 text-right">
              <strong>{{ __('backend/form_field.name') }}</strong> 
              <span class="text-danger">*</span>
            </label>
            <div class="col-md-5">
              <input id="name" class="form-control" value="{{old('name')}}" type="text" name="name"  required>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3 text-right">
              <strong>{{ __('backend/form_field.mobile') }}</strong> 
              <span class="text-danger">*</span>
            </label>
            <div class="col-md-5">
              <input id="mobile" class="form-control" value="{{old('mobile')}}" type="text" name="mobile"  required>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3 text-right">
              <strong>{{ __('backend/form_field.email') }}</strong>  &nbsp;
            </label>
            <div class="col-md-5">
              <input id="email" class="form-control" value="{{old('email')}}" type="text" name="email" >
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3 text-right">
              <strong>{{ __('backend/form_field.address') }}</strong> &nbsp;
            </label>
            <div class="col-md-5">
              <textarea name="address" class="form-control">{{old('address')}}</textarea>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3 text-right">
              <strong>{{ __('backend/form_field.initial_balance') }}</strong> 
              <span class="text-danger">*</span>
            </label>
            <div class="col-md-5">
              <div class="row">
                <div class="col-md-7 pr-0">
                  <input id="initial_balance" class="form-control" value="{{old('initial_balance')}}" type="text" name="initial_balance" value="0" required>
                </div>
                <div class="col-md-5">
                  <select name="type" class="form-control">
                    <option value="payable" {{old('type')=="payable"?"selected":""}}>Payable</option>
                    <option value="revceivable" {{old('type')=="revceivable"?"selected":""}}>Revceivable</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3 text-right">
              <strong>{{ __('backend/form_field.photo') }}</strong>  &nbsp;
            </label>
            <div class="col-md-5">
              <input id="photo" class="form-control" type="file" name="photo">
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

@endsection
