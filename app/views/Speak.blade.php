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
		<h1>Speak</h1>
		<table border="1">
			<tr>
				<td>id</td>
				<td>content</td>
				<td>created_at</td>
				<td></td>
			</tr>
			@foreach ($articles as $article)
			<tr>
				<td>{{$article->id}}</td>
				<td>{{$article->content}}</td>
				<td>{{$article->created_at}}</td>
				<td><a href="{{action('ManageController@getArticleReply',$article->id)}}">ReplyList</a></td>
			</tr>
			@endforeach
		</table>
	</body>
</html>
