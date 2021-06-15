@extends('frontend.layouts.master')

@section('title', 'Home')

@section('styles')
    <!--credential include css-->
    <link rel="stylesheet" href="{{asset('public/css/credential.css')}}">
@endsection

@section('content')
    <!-- credential section start -->
    <section class="credential_section">
        
        <div class="section_cover">
            <!-- signup area start -->
            <div class="credential_area">
                <div class="credential_header">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{Route::is('login') ? 'active' : ''}}" data-toggle="tab" href="#singin">Sign In</a> 
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{Route::is('user.registration') ? 'active' : ''}}" data-toggle="tab" href="#signup">Sign Up</a>
                        </li>
                    </ul>
                </div>
                <div class="credential_body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if ( Session::has('login_error') )
                    <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {!! Session::get('login_error') !!}
                    </div>
                    @endif
                    @if ( Session::get('success_message') )
                    <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {!! Session::get('success_message') !!}
                    </div>
                    @endif
                    
                    <div class="tab-content">
                        <div class="tab-pane fade {{Route::is('login') ? 'show active' : ''}}" id="singin">
                            <form action="{{route('login')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="username" placeholder="Mobile Number" value="{{old('username')}}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                                </div>
                                <div class="form-check d-flex">
                                    <div>
                                        <input id="remember" type="checkbox" class="form-check-input">
                                        <label class="form-check-label" for="remember">Remember</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary mb-2">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade {{Route::is('user.registration') ? 'show active' : ''}}" id="signup">
                            <form action="{{route('user.registration')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Full Name" value="{{old('name')}}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="mobile" placeholder="Phon Number" value="{{old('mobile')}}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm_password" placeholder="Confirm password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <textarea name="address" placeholder="Enter Your Address" class="form-control" required> {{old('address')}} </textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary mb-2">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="credential_footer">
                        <p>Welcome to Masik Bazar Khulna</p>
                    </div>
                </div>
            </div>
            <!-- signup area end -->
        </div>
    </section>
    <!-- credential section end -->
@endsection