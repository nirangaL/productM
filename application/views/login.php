
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ProductM - Login</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>/assets/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>/assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>/assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>/assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>/assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="<?php echo base_url()?>assets/global_assets/js/main/jquery.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="<?php echo base_url()?>/assets/js/app.js"></script>
    <!-- /theme JS files -->
    <style>
        body {
            position: relative;
            height: 100%;
            margin: 0;
        }

        .bg-image {
            position: absolute;
            /* The image used */
            background-image: url("<?php echo base_url('assets/images/login_back.png')?>");
            opacity: 0.2;
            /* Full height */
            height: 100%; 
            width: 100%; 
            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            z-index:0;
            bottom: 20px;
            right: 20px;
        }

        .login-form{
            opacity: 1 !important;
            /* z-index:11; */
        }

    </style>


</head>

<body>

<!-- Main navbar -->
<!-- <div class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-brand">
        <a href="index.html" class="d-inline-block">
            <img src="<?php echo base_url()?>assets/global_assets/images/logo_light.png" alt="">
        </a>
    </div>

</div> -->
<!-- /main navbar -->
<!-- Page content -->
<div class="page-content">
<div class="bg-image"></div>

    <!-- Main content -->
    <div class="content-wrapper ">
   
        <!-- Content area -->
        <div class="content d-flex justify-content-center align-items-center">
        <!-- <div class=""></div> -->
            <!-- Login form -->
            <div class="login-form">
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
                            <h5 class="mb-0">Login to your account</h5>
                            <span class="d-block text-muted">Enter your credentials below</span>
                        </div>

                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input type="text" id="username" name="username" class="form-control" placeholder="Username">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary btn-block" onclick="checkUser()">Sign in <i class="icon-circle-right2 ml-2"></i></button>
                        </div>
                        <div class="bg-danger-300 text-center">
                           <span id="errorLogin"></span>
                        </div>

<!--                        <div class="text-center">-->
<!--                            <a href="login_password_recover.html">Forgot password?</a>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
            <!-- /login form -->

        </div>
        <!-- /content area -->


        <!-- Footer -->
        <!-- <div class="navbar navbar-expand-lg navbar-light">
            <div class="text-center d-lg-none w-100">
                <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
                    <i class="icon-unfold mr-2"></i>
                    Footer
                </button>
            </div>

            <div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; 2019. <a href="#">ProductM Web App Kit</a> by <a href="#" target="_blank">OAIT</a>
					</span>

                <ul class="navbar-nav ml-lg-auto">
                    <li class="nav-item"><a href="https://kopyov.ticksy.com/" class="navbar-nav-link" target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
                </ul>
            </div>
        </div> -->
        <!-- /footer -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

</body>
</html>


<script>


        $('input').keypress(function () {
            $(this).css('border','') ;
            $('#errorLogin').text('');
        });

    function checkUser() {
        var userName = $('#username').val();
        var password = $('#password').val();

        if(checkLoginForm()){
            $.ajax({
                url: '<?php echo base_url("index.php/welcome/checkUser")?>', //This is the current doc
                type: "POST",
                data: ({
                    userName:userName,
                    password:password
                }),
                success: function (data) {
                    if (data == "ok") {
                        window.location.replace("<?php echo base_url('Comdashboard')?>");
                    } else if(data == "notOk") {
                        $('#errorLogin').text('Entered credentials are incorrect! ');
                    } else if(data == "block"){
                        $('#errorLogin').text('Account is Disabled!');
                    }else{
                        window.location.replace(data);
                    }
                }
            });
        }

    }

     function  checkLoginForm() {
         var userName = $('#username').val();
         var password = $('#password').val();

         if(userName == ''){
             $('#username').css('border','1px red solid');
             if(password == '') {
                 $('#password').css('border', '1px red solid');
                 $('#errorLogin').text('Please enter userName And Password');
                 return false;
             }
             $('#errorLogin').text('Please enter userName ');
             return false;
         }else if(password == '') {
             $('#password').css('border', '1px red solid');
             $('#errorLogin').text('please enter Password');
         }else{
           return true;
         }

    }

</script>