<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
            body { background-image: url(<?php echo \App\CompanyIdentity::systemSettings('login_background_image_url'); ?>); background-repeat: no-repeat; background-position: center; background-size: cover; height: 100%;}
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ \App\CompanyIdentity::systemSettings('company_name') . 'online system'  }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <img src="{{ \App\CompanyIdentity::systemSettings('company_logo_url') }}" width="100%" class="img-responsive" alt="Company Logo">
        <!-- <a href="/"><b>OSIZWENI</b>EDC</a> -->
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Complete the form to register</p>

        @if (count($errors) > 0)
            <div id="invalid-input" class="alert alert-danger alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Invalid Input!</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form role="form" action="{{ url('/contacts/register') }}" method="POST">
            {{ csrf_field() }}

            <div class="form-group has-feedback{{ $errors->has('first_name') ? ' has-error' : '' }}">
                <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name') }}">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback{{ $errors->has('surname') ? ' has-error' : '' }}">
                <input type="text" name="surname" class="form-control" placeholder="Surname" value="{{ old('surname') }}">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                {!! app('captcha')->display() !!}
            </div>
            <!--
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password"required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password_confirm" class="form-control" placeholder="Retype password" required>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            -->
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="terms" checked> I agree to the <a href="#">terms</a>
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <a href="/login" class="text-center">I already have an account</a>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 2.2.3 -->
<script src="/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
<!-- InputMask -->
<script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js"></script>
<script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script>
    $(function () {
        //iCheck
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        //Phone mask
        $("[data-mask]").inputmask();

        //autoclose alert after 7 seconds
        $("#invalid-input").alert();
        window.setTimeout(function() { $("#invalid-input").fadeOut('slow'); }, 7000);
    });
</script>
</body>
</html>
