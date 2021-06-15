@extends('backend.layouts.master')

@section('fav_title', 'Add brand')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-briefcase"></i> {{ __('backend/default.supplier') }}</h1>
        </div>
        
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6"><h2><i class="fa fa-plus-square"></i> {{ __('backend/default.supplier') }}</h2></div>
                        <div class="col-md-6"><a href="{{ route('admin.supplier.all') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="card-body">
                    @include('backend.partials.error_message')
                    <form class="form-horizontal" id="myform" action="{{ route('admin.supplier.edit', $supplier->id) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Name<span class="text-danger">*</span></label>
                            <div class="col-md-5">
                                <input id="name" class="form-control" type="text" name="name" value="{{ $supplier->name }}"  required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Photo</label>
                            <div class="col-md-5">
                                <input id="iamge" class="form-control" type="file" name="image">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-8 mt-3">
                                <button type="submit" class="btn btn-primary float-right">{{ __('backend/default.submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
  <script type="text/javascript" charset="utf-8">
    $(function(){
      $('input[name=title_bn]').avro();
    });
  </script>
  <script type="text/javascript" charset="utf-8">
    $(function(){
      $('input[name=title_bn]').avro({'bangla':true});
    });
  </script>
@endsection