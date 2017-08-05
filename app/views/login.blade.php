<!doctype html>
<html>
<head>
	<title>cepdsap - Login</title>
	<!--<meta name="csrf-token" ng-init="csrf_token = <?php echo csrf_token(); ?>">-->
	<meta name="csrf-token" content="<?php echo csrf_token(); ?>">
</head>
<body>
<!--
	{{ Form::open(array('url' => 'login'))}}	
		<h1>Login</h1>

		<p>
			{{ $errors->first('email') }}
			{{ $errors->first('password') }}
		</p>

		<p>
			{{ Form::label('email', 'Email Adress') }}
			{{ Form::text('email', Input::old('email'), array('placeholder' => 'ornek@mesela.com')) }}
		</p>

		<p>
			{{ Form::label('password', 'Password') }}
			{{ Form::password('password') }}
		</p>

		<p> {{ Form::submit('Submit!') }} </p>
	{{ Form::close() }}
-->
	<form method="POST" action="http://cepdsap.web/login" accept-charset="UTF-8">

		<h1>Login</h1>

		<p>


		</p>

		<p>
			<label for="email">Email Adress</label>
			<input placeholder="ornek@mesela.com" name="email" type="text" id="email">
		</p>

		<p>
			<label for="password">Password</label>
			<input name="password" type="password" value="" id="password">
		</p>

		<p> <input type="submit" value="Submit!"> </p>
	</form>
</body>
</html>	