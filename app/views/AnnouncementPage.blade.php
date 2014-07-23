<html>
	<head>
		<style>
			h1{
			color:red;
			text-Align:center;
			}
		</style>	
	</head>
	<body>
		<h1>Announcement</h1>
		{{ Form::open(array('url' => 'announcement/create')) }}
			{{Form::textarea('content')}}
			{{Form::submit('Submit')}}
		{{ Form::close()}}

		<table border="1">
			<tr>
				<td>Time</td>
				<td>Content</td>
			</tr>
		@foreach ($announcements as $announcement) 
			<tr>
				<td>{{$announcement->created_at}}</td>	
				<td>{{$announcement->content}}</td>
			</tr>
		@endforeach	
		</table>
	</body>	
</html>
