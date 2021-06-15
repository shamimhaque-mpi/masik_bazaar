@extends('frontend.layouts.master')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('public/front/styles/main_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/front/styles/responsive.css') }}">
<style>
/*All style by Abdullah Al Ahsan*/
.footer_social ul li a {color: #fff;}
.footer_social ul li a:hover {color: #FF9805;}
</style>
@endsection


@section('content')
<div class="container mt-5 mb-5">
  <div class="card">
    @if(!empty($sitemapeInfo))

      <div class="card-header">
          <h3 class="mb-0">{{ $sitemapeInfo->title }}</h2>
      </div>

      <div class="card-body">
        {!! $sitemapeInfo->content !!}
      </div>
    @else
      <div class="card-body">
          <p>Data Not Found....!</p>
      </div>
    @endif
  </div>
</div>
@endsection

