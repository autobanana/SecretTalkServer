<html>
	<head>
		<style>
			h1{
			color:red;
			text-align:center;
			}
		</style>
	</head>
	<body>
		<h1>User Management</h1>
		<table border="1">
			<tr>
				<td><b>Username</b></td>
				<td><b>Listen</b></td>
				<td><b>Speak</b></td>
			</tr>
			@foreach ($users as $user)
			<tr>
				<td>
					{{$user->Username}}
				</td>
				<td>
					<a href="{{action('ManageController@getListen',$user->Username)}}">Listen</a>
				</td>
				<td>
					<a href="{{action('ManageController@getSpeak',$user->Username)}}">Speak</a>
				</td>
			</tr>
			@endforeach
		</table>
	</body>
</html>
