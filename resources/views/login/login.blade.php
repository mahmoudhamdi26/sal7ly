<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Webarch - Responsive Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN PLUGIN CSS -->
    <link href="{{ asset('assets') }}/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{ asset('assets') }}/plugins/bootstrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/plugins/bootstrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('assets') }}/plugins/animate.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" />
    <!-- END PLUGIN CSS -->
    <!-- BEGIN CORE CSS FRAMEWORK -->
    <link href="{{ asset('webarch') }}/css/webarch.css" rel="stylesheet" type="text/css" />
    <!-- END CORE CSS FRAMEWORK -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="error-body no-top">
<div class="container">
    <div class="row login-container column-seperation">
        <div class="col-md-5 col-md-offset-1">
            <h2>
                Sign in to webarch
            </h2>
            <p>
                Use Facebook, Twitter or your email to sign in.
                <br>
                <a href="#">Sign up Now!</a> for a webarch account,It's free and always will be..
            </p>
            <br>
            <button class="btn btn-block btn-info col-md-8" type="button"><span class="pull-left icon-facebook" style="font-style: italic"></span> <span class="bold">Login with Facebook</span></button>
            <button class="btn btn-block btn-success col-md-8" type="button"><span class="pull-left icon-twitter" style="font-style: italic"></span>
                <span class="bold">Login with Twitter</span></button>
        </div>
        <div class="col-md-5">
            <br>
            <form method="POST" action="{{ url('/auth/login') }}"
                  class="login-form validate" id="login-form" name="login-form">
                {!! csrf_field() !!}

                <div class="row">
                    <div class="form-group col-md-10">
                        <label class="form-label">Username</label>
                        <input id="txtusername"  type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-10">
                        <label class="form-label">Password</label> <span class="help"></span>
                        <input id="txtpassword" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="control-group col-md-10">
                        <div class="checkbox checkbox check-success">
                            <a href="javascript: restorePass();">Trouble login in?</a>&nbsp;&nbsp;
                            {{--<input id="checkbox1" type="checkbox" value="1">--}}
                            <input id="checkbox1" type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}>
                            <label for="checkbox1">Keep me reminded</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <button class="btn btn-primary btn-cons pull-right" type="submit">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalRestorePass" class="modal" data-backdrop="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ action('LoginController@postResetPassword') }}" method="post">
                {!! csrf_field() !!}
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('labels.restore_pass') }}</h5>
                </div>
                <div class="modal-body text-center p-lg">
                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ trans('labels.msg_restore_password') }}</label>
                        <input type="email" class="form-control" name="email"
                               value="{{ old('email') }}"
                               id="exampleInputEmail1" placeholder="{{ trans('labels.email') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn success p-x-md">Restore</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
</div>

<script type="text/javascript">
    function restorePass() {
        $('#modalRestorePass').modal('show');
    }
</script>

<!-- END CONTAINER -->
<script src="{{ asset('assets') }}/plugins/pace/pace.min.js" type="text/javascript"></script>
<!-- BEGIN JS DEPENDECENCIES-->
<script src="{{ asset('assets') }}/plugins/jquery/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/bootstrapv3/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/jquery-block-ui/jqueryblockui.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
<!-- END CORE JS DEPENDECENCIES-->
<!-- BEGIN CORE TEMPLATE JS -->
<script src="{{ asset('webarch') }}/js/webarch.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/js/chat.js" type="text/javascript"></script>
<!-- END CORE TEMPLATE JS -->
</body>
</html>

