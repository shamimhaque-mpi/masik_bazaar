@extends('frontend.layouts.master')

@section('title', 'Contact Us')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('public/front/plugins/jquery-ui-1.12.1.custom/jquery-ui.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/front/styles/contact_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/front/styles/custom.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/front/styles/contact_responsive.css') }}">
<style>
    .ml-25 {
        margin-left: 25px;
    }
    #isLoading input:focus, #isLoading textarea:focus {
        box-shadow: 0 0 0 0.2rem #FF9907 !important;
    }
</style>
@endsection

@section('content')
<div class="row">
    <!-- Contact Info -->
    <div class="col-12 layout_2" id="isLoading">
        <div class="contact_info">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3677.4614018020006!2d89.5479196149641!3d22.8224128850547!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39ff91d2a7f89d97%3A0xb913c723fdbe154c!2sMasik%20Bazar%20Khulna!5e0!3m2!1sen!2sbd!4v1615009072333!5m2!1sen!2sbd" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="contact_info my-3 p-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="contact_info_container d-flex flex-lg-row flex-column justify-content-between align-items-between">

                            @php
                                $site_setting = \App\Models\Setting::first();
                            @endphp
                            <!-- Contact Item -->
                            <div class="col-md-4 contact_info_item d-flex flex-row align-items-center justify-content-start">
                                <div class="contact_info_image"><img src="{{ asset('public/front/images/contact_1.png')}} " alt=""></div>
                                <div class="contact_info_content ml-3">
                                    <div class="contact_info_title">Phone</div>
                                    <div class="contact_info_text">{{ $site_setting->mobile }}</div>
                                </div>
                            </div>

                            <!-- Contact Item -->
                            <div class="col-md-4 contact_info_item d-flex flex-row align-items-center justify-content-start">
                                <div class="contact_info_image"><img src="{{ asset('public/front/images/contact_2.png') }}" alt=""></div>
                                <div class="contact_info_content ml-3">
                                    <div class="contact_info_title">Email</div>
                                    <div class="contact_info_text"><a href="https://colorlib.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="016760727572606d647241666c60686d2f626e6c">{{ $site_setting->email }}</a></div>
                                </div>
                            </div>

                            <!-- Contact Item -->
                            <div class="col-md-4 contact_info_item d-flex flex-row align-items-center justify-content-start">
                                <div class="contact_info_image"><img src="{{asset('public/front/images/contact_3.png')}}" alt=""></div>
                                <div class="contact_info_content ml-3">
                                    <div class="contact_info_title">Address</div>
                                    <div class="contact_info_text">{!! $site_setting->address !!}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Contact Form -->

        <div class="contact_form">
            <div class="container">
                <contact url="{{url('/')}}"></contact>
            </div>
            {{-- <div class="panel"></div> --}}
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('public/front/js/contact_custom.js') }}"></script>
@endsection
