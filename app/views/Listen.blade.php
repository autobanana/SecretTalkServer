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
		<h1>Listen</h1>
		<table border="1">
			<tr>
				<td>id</td>
				<td>article_id</td>
				<td>author_id</td>
				<td>content</td>
				<td>status</td>
				<td>See Reply</td>
			</tr>
			@foreach ($matchArticles as $matchArticle)
			<tr>
				<td>{{$matchArticle->id}}</td>
				<td>{{$matchArticle->article_id}}</td>
				<td>{{$matchArticle->article_author_id}}</td>
				<td>{{$matchArticle->content}}</td>
				<td>{{$matchArticle->status}}</td>
				<td><a href="{{action('ManageController@getArticleReply',$matchArticle->article_id)}}">See Reply</a></td>
			</tr>
			@endforeach
		</table>
	</body>
</html>
