@extends('backend.layouts.master')
@section('fav_title', 'Max Amount User')
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
        <h1><i class="fa fa-user"></i> {{ __('backend/user.max_amount') }}</h1>
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
                    <div class="col-md-6"><h2><i class="fa fa-table"></i> {{ __('backend/user.max_amount') }}</h2></div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="card-body">
                
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-hover display">
                        <thead>
                            <th>{{ __('backend/default.sl') }}</th>
                            <th>{{ __('backend/default.name') }}</th>
                            <th>{{ __('backend/default.photo') }}</th>
                            <th>{{ __('backend/default.username') }}</th>
                            <th class="action">{{ __('backend/default.mobile') }}</th>
                            <th>{{ __('backend/default.amount') }}</th>
                        </thead>

                        <tbody>
                            @foreach($maxusers as $key=>$user)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$user->name}}</td>
                                <td><img src="{{asset($user->image)}}" height="25"></td>
                                <td>{{$user->mobile}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->total_amount_tk}}</td>
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