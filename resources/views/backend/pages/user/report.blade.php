@extends('backend.layouts.master')
@section('fav_title', 'Max Order User')
@section('styles')
<style>
    .action{
        min-width: 70px;
    }
</style>
@endsection

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-user"></i> {{ __('backend/user.max_order') }}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg fa-fw"></i><a href="{{ route('admin.home') }}">{{ __('backend/default.dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('backend/user.user') }}</li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><h2><i class="fa fa-table"></i> {{ __('backend/default.orders') }}</h2></div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.user.report') }}" method="post" class="none">
                    @csrf
                    <div class="form-row mb-3">
                        <div class="col-md-2">
                            <div class="input-group date" id="fromDate" data-provide="datepicker">
                                <input type="text" class="form-control" name="from" value="{{$_POST ? $_POST['from'] : date('Y-m-d')}}" autocomplete="off">
                                <div class="input-group-addon">
                                    <span><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="input-group date" id="toDate" data-provide="datepicker">
                                <input type="text" class="form-control" name="to" value="{{$_POST ? $_POST['to'] : date('Y-m-d')}}" autocomplete="off">
                                <div class="input-group-addon">
                                    <span><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <select class="form-control" name="user_id">
                                <option disabled="" selected="">--Select A User--</option>
                                @if(!empty($users))
                                @foreach($users as $row)
                                <option value="{{$row->id}}">{{$row->name}}-{{$row->mobile}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary" type="submit">{{ __('backend/default.search') }}</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover display">
                        <thead>
                            <th>{{ __('backend/default.sl') }}</th>
                            <th>{{ __('backend/default.date') }}</th>
                            <th>{{ __('backend/default.name') }}</th>
                            <th>{{ __('backend/default.photo') }}</th>
                            <th>{{ __('backend/default.username') }}</th>
                            <th class="action">{{ __('backend/default.mobile') }}</th>
                            <th>{{ __('backend/default.order') }}</th>
                            <th>{{ __('backend/default.item') }}</th>
                            <th>{{ __('backend/default.quantity') }}</th>
                            <th>{{ __('backend/default.total') }}</th>
                        </thead>

                        <tbody>
                            @php
                                $total_order = $total_item = $total_qty = $total_amount = 0;
                            @endphp
                            @foreach($result as $key=>$user)
                            @php
                                $total_order  += 1;
                                $total_item   += $user->total_items;
                                $total_qty    += $user->total_qty;
                                $total_amount += $user->grand_total;
                            @endphp
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{date("y-m-d", strtotime($user->date))}}</td>
                                <td>{{$user->name}}</td>
                                <td><img src="{{asset($user->image)}}" height="25"></td>
                                <td>{{$user->mobile}}</td>
                                <td>{{$user->username}}</td>
                                <td>1</td>
                                <td>{{$user->total_items}}</td>
                                <td>{{$user->total_qty}}</td>
                                <td>{{$user->grand_total}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <th class="text-right" colspan="6">Total</th>
                                <th>{{$total_order}}</th>
                                <th>{{$total_item}}</th>
                                <th>{{$total_qty}}</th>
                                <th>{{$total_amount}} ৳</th>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
 $(document).ready(function(){
    $('#fromDate').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight:'TRUE',
        autoclose: true,
    });

    $('#toDate').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight:'TRUE',
        autoclose: true,
    });
});
</script>
@endsection