
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Reset password</title>
	<style>
		.content{
			margin: 0px auto;
			width:60%;
			padding: 20px;
		}
		.btn .btn-error{
			margin: 0px auto;
		}
	</style>
</head>
<body>
	<div class="content">
		<h3>Hello!</h3>
		<p>You are receiving this email because we received a password reset request for your account.</p>
		<a href="{{url('http://thanh-laravel.local:8000/user/recover-password/'.$data['email'].'/'.$data['token'])}}" class="btn btn-error">Reset password</a>
		<p>This password reset link will expire in 3 hours.</p>
		<p>if you did not request a passqord reset , no furthor action is required </p>
		<p>Le Thanh</p>
		<p>Laravel</p>
	</div>

</body>
</html>