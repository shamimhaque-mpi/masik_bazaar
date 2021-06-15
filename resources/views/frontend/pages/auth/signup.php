    <!--credential include css-->
    <link rel="stylesheet" href="<?php echo base_url('public/css/credential.css');?>">
    
    <!-- credential section start -->
    <section class="credential_section" ng-controller="SubscriberSignupCtrl" ng-cloak>
        <div class="section_cover">
            <!-- signup area start -->
            <div class="credential_area">
                <div class="credential_header">
                    <a href="<?php echo base_url('login');?>">Sign In</a>
                    <a href="" class="active">Sign Up</a>
                </div>
                <div class="credential_body">
                    <form ng-submit="signupFn();">
                        <div class="form-group">
                            <p class="signup_error">{{ signup_warning }}</p>
		                    <p class="signup_success">{{ signup_success }}</p>
                        </div>
                        <div class="form-group">
                            <p class="signup_error">{{ name_field }}</p>
                            <input type="text" name="first_name" ng-model="name"  placeholder="Full Name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <p class="signup_error">{{ mobile_field }}</p>
                            <input type="text" name="phon_number" ng-model="mobile" placeholder="Phon Number" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <p class="signup_error">{{ password_field }}</p>
                            <input type="password" name="password" ng-model="password" placeholder="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="confirm_password" ng-model="confirm_password" placeholder="Confirm password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <p class="signup_error">{{ address_field }}</p>
                            <textarea name="address" ng-model="address" placeholder="Enter Your Address" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mb-2">Submit</button>
                        </div>
                    </form>

                    <div class="credential_footer">
                        <p>Already have an account?  <a href="<?php echo base_url('login');?>">Login</a></p>
                    </div>
                </div>
            </div>
            <!-- signup area end -->
        </div>
    </section>
    <!-- credential section end -->