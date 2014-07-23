<html>
	<body>
		{{ Form::open(array('url' => 'manage/login')) }}
		<div>
			Username : {{Form::text('username')}}
		</div>
		<div>
			Password : {{Form::password('password')}}
		</div>
		<div>
			{{Form::submit('Login')}}
		</div>
		{{ Form::close() }}
	</body>
</html>
