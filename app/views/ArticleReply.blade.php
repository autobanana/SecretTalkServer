<html>
	<head>
		<style>
			h1{
			color:red;
			text-align:center
			}
		</style>
	</head>
	<body>
		<h1>Article Reply</h1>
		<table border="1">
			<tr>
				<td>id</td>
				<td>author_id</td>
				<td>content</td>
				<td>created_at</td>
			<tr>
			@foreach ($replys as $reply)
			<tr>
				<td>{{$reply->id}}</td>
				<td>{{$reply->author_id}}</td>
				<td>{{$reply->content}}</td>
				<td>{{$reply->created_at}}</td>
			</tr>
			@endforeach
		</table>
	</body>
</html>
