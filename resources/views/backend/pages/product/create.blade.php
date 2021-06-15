@extends('backend.layouts.master')

@section('fav_title', 'Add Product')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-archive"></i> {{ __('backend/product.product_management') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg fa-fw"></i><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">{{ __('backend/product.product') }}</a></li>
            <li class="breadcrumb-item active">{{ __('backend/default.add_new') }}</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6"><h2><i class="fa fa-plus-square"></i> {{ __('backend/product.product') }}</h2></div>
                        <div class="col-md-6"><a href="{{ route('admin.product.index') }}" class="float-right btn btn-primary"><i class="fa fa-arrow-left"></i> {{ __('backend/default.list') }}</a></div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="card-body">
                    @include('backend.partials.error_message')
                    <form id="productForm" action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{--<input type="hidden" name="url" value="{{ url('/') }}">--}}
                        <div class="form-row">
                            <div class="col-md-4 form-group">
                                <label for="title">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" id="title" required placeholder="">
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="category_id">Category </label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option selected disabled>Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title_en }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="sub_category_id">Subcategory </label>
                                <select name="sub_category_id" id="sub_category_id" class="form-control">
                                    <option selected disabled>Select Sub Category</option>
                                    {{-- @foreach($subcategories as $sub_category) --}}
                                        {{-- <option value="{{ $sub_category->id }}">{{ $sub_category->title_en }}</option> --}}
                                    {{-- @endforeach --}}
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-3 form-group">
                                <label for="brand_id">Brand </label>
                                <select name="brand_id" id="brand_id" class="form-control">
                                    <option selected disabled>Select Brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->title_en }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="delivery">Delivery </label>
                                <input name="delivery" id="delivery" class="form-control">
                            </div>

                            <div class="col-md-2 form-group">
                                <label for="product_return">Return </label>
                                <input name="product_return" id="product_return" class="form-control">
                            </div>
                        
                            <div class="col-md-2 form-group">
                                <label for="warranty">Warranty </label>
                                <input name="warranty" id="warranty" class="form-control">
                            </div>
                        
                            <div class="col-md-2 form-group">
                                <label for="warranty">Min Sales Quantity <span class="text-danger">*</span></label></label>
                                <input type="number" name="min_sale_quantity" value="1" id="min_sale_quantity" class="form-control" required="true">
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="col-md-2 form-group">
                                <label for="purchase_price">Purchase Price <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="purchase_price" id="purchase_price" required placeholder="">
                            </div>

                            <div class="col-md-2 form-group">
                                <label for="regular_price">Regular Price <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="regular_price" id="regular_price" required placeholder="">
                            </div>

                            <div class="col-md-2 form-group">
                                <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="quantity" id="quantity" required placeholder="">
                            </div>

                            <div class="col-md-2 form-group">
                                <label for="is_offer">Offer <span class="text-danger">*</span></label>
                                <select name="is_offer" id="is_offer" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <div class="col-md-2 form-group">
                                <label for="warranty">D Commission </label>
                                <select class="form-control" name="d_commission">
                                    <option value="0" selected="true">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <div class="col-md-2 form-group d-none">
                                <label for="discount">Discount <small>(in %)</small></label>
                                <input type="number" min="0" max="100" value="0" class="form-control" name="discount" id="discount" placeholder="">
                            </div>

                            <div class="col-md-2 form-group">
                                <label for="discount">Discount <small>(in Flat)</small></label>
                                <input type="number" min="0" value="0" class="form-control" name="discount_flat" id="discount_flat" placeholder="">
                            </div>
                        </div>

                        <div class="form-row">

                            <div class="col-md-2 form-group">
                                <label for="discount_time">End Date </label>
                                <div class="input-group date" data-provide="datepicker" id="discount_time">
                                    <input type="text" name="discount_time" class="form-control">
                                    <div class="input-group-addon">
                                        <span><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 form-group">
                                <label for="unit_id">Unit </label>
                                <select name="unit_id" id="unit_id" class="form-control">
                                    <option disabled>Select Unit</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            @if(\Auth::user()->is_merchant == 0)
                            <div class="col-md-2 form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>
                            @endif
                            {{-- 
                            <div class="col-md-2 form-group">
                                <label for="status">Bagerhat Bazar</label>
                                <select name="product_area" id="product_area" class="form-control">
                                    <option value="others">No</option>
                                    <option value="bagerhat">Yes</option>
                                </select>
                            </div>

                            <div class="col-md-2 form-group">
                                <label for="status">Feature Product</label>
                                <select name="is_feature_product" id="is_feature_product" class="form-control">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            --}}
                            <div class="col-md-3 form-group">
                                <label for="brand_id">Size </label>
                                <select name="size_id[]" id="size_id" class="form-control" multiple>
                                    <option disabled>Select Size</option>
                                    @foreach($sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3 form-group">
                                <label for="brand_id">Color </label>
                                <select name="color_id[]" id="color_id" class="form-control" multiple>
                                    <option disabled>Select Color</option>
                                    @foreach($colors as $color)
                                        <option value="{{ $color->id }}">{{ $color->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3 form-group">
                                <label for="brand_id">Supplier </label>
                                <select name="supplier_id" id="supplier_id" class="form-control">
                                    <option selected disabled>Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span></label>
                             <textarea name="description" id="" class="form-control" cols="30" rows="4" required></textarea>
                        </div>

                        <div class="form-row" id="img">
                            <div class="col-md-6 form-group">
                                <label for="image">Feature Image <small>(1:1)</small> <span class="text-danger">*</span> </label>
                                <input type="file" class="form-control" name="feature_photo" id="image" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="image">Photo <small>(1:1)</small> <span class="text-danger">*</span> <button type="button" id="addImage" class="btn btn-success"><i class="fa fa-plus"></i></button></label>
                                <input type="file" class="form-control" name="image[]">
                            </div>
                            <div></div>
                        </div>

                        <div class="col-md-6 p-0 form-group">
                            <label for="short_video">Short Video Code</label>
                            <input type="text" class="form-control" name="short_video" id="short_video" placeholder="">
                        </div>

                        <button type="submit" name="save_menu" class="btn btn-success float-right">{{ __('backend/default.submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (()=>{
            var discount = document.querySelector('#discount');
            var discount_flat = document.querySelector('#discount_flat');
            var regular_price = document.querySelector('#regular_price');
            
            discount_flat.addEventListener('input', ()=>{
                let sale_price    = document.querySelector('#regular_price').value;
                let flat_discount = document.querySelector('#discount_flat').value;
                discount.value = (flat_discount / sale_price) * 100;
            });
            regular_price.addEventListener('input', ()=>{
                let sale_price    = document.querySelector('#regular_price').value;
                let flat_discount = document.querySelector('#discount_flat').value;
                discount.value = (flat_discount / sale_price) * 100;
            });
            
        })()
    </script>
    
    <script>
        let category = document.querySelector("#category_id");
        let sub_category = document.querySelector("#sub_category_id");
        let url = '{{ route("admin.getSubCategory").'/' }}'
        
        
        category.onchange = function(){
            fetch(url+this.value)
            .then((response)=>response.json())
            .then((myJson)=>{
                SubCatDiv(myJson);
            });
            function SubCatDiv(myjson){
                let optionField = `<option selected disabled>Select Sub Category</option>`;
                if(myjson.length > 0){
                    myjson.forEach((value)=>{
                        optionField += `<option value="${ value.id }"> ${ value.title_en } </option>`;
                    });
                    sub_category.focus();
                }else{
                    optionField = `<option selected disabled>Select another Category</option>`;
                }
                sub_category.innerHTML = optionField;
            }
        }
    </script>

    <script>
        $(document).ready(function(){

            $('#category_id').select2();
            $('#sub_category_id').select2();
            $('#brand_id').select2();
            $('#supplier_id').select2();
            $('#size_id').select2();
            $('#color_id').select2();

            $('#discount_time').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                startDate: '-0d'
            });

            $('#productForm').validate({ // initialize the plugin
                 rules: {
                     title: {
                         required: true,
                     },
                 },
                messages: {
                    title: "{{ __('backend/default.required_validation') }}",
                    description: "{{ __('backend/default.required_validation') }}",
                    purchase_price: "{{ __('backend/default.required_validation') }}",
                    regular_price: "{{ __('backend/default.required_validation') }}",
                    quantity: "{{ __('backend/default.required_validation') }}",
                    "image[]": "{{ __('backend/default.required_validation') }}",
                    status: "{{ __('backend/default.required_validation') }}",
                }
            });

            $("#addImage").click(function(){
                var newImage = "<div class=\"col-md-6 form-group\">\n" +
                    "                                <label for=\"image\" class=\"mt-3\">Photo <small>(1:1)</small> </label>\n" +
                    "                                <input type=\"file\" class=\"form-control\" name=\"image[]\" >\n" +
                    "                            </div>";

                $("#img").append(newImage);
            });
        });
    </script>

@endsection
