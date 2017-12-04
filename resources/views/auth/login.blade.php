<!DOCTYPE html>
<html>
<head>
    <title>SoftCRM - login panel</title>
    <link href="css/style.css" rel='stylesheet' type='text/css'/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords"
          content="Simple Login Form,Login Forms,Sign up Forms,Registration Forms,News latter Forms,Elements" ./>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700'
          rel='stylesheet' type='text/css'>
</head>
<body>

<h1>SoftCRM</h1>
<h4 class="small-text">Customer relationship management system</h4>
<div class="login">
    <div class="ribbon-wrapper h2 ribbon-red">
        <div class="ribbon-front">
            <h2>Login Panel</h2>
        </div>
        <div class="ribbon-edge-topleft2"></div>
        <div class="ribbon-edge-bottomleft"></div>
    </div>
    <form method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            @if ($errors->has('email'))
                <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
            @if ($errors->has('password'))
                <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>
        <ul>
            <li class="input-row">
                <input type="text" class="text" id="email" type="email" name="email" autocomplete="off" placeholder="Write your email here ...">
                <a href="#" class=" icon user"></a>
            </li>
            <li>
                <input id="password" type="password" name="password" placeholder="Write your password here ...">
                <a href="#" class=" icon lock"></a>
            </li>
            {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
            <a class="btn btn-link" href="#">
                Forgot Your Password?
            </a>
            <li>

                <div class="submit">
                    <button type="submit">Log in</button>
                </div>
            </li>
        </ul>
    </form>
</div>
<div class="copy-right">
    <p>Copyright &copy; <?php echo date('Y'); ?> All rights Reserved | Template by &nbsp;<a href="http://w3layouts.com">W3layouts</a>
    </p>
</div>
</body>
</html>