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
<div class="login-page">
    <div style="text-align: center;color:white">
        <h1>SoftCRM</h1>
        <h4 class="small-text">Customer relationship management system</h4></div>
    <div class="form">
        <form method="POST" action="{{ route('login') }}" class="login-form">
            {{ csrf_field() }}
            <input id="email" type="email" name="email" placeholder="Write your email here ..." value="admin@admin.com"/>
            <input id="password" type="password" name="password" placeholder="Write your password here ..." value="admin"/>
            <button>login</button>
            <p class="message">Not registered? <a href="#">Create an account</a></p>
        </form>
    </div>
</div>
</body>
</html>