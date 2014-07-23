<html>
	<head>
		<style>
			h1{
				color:red;
				font-size:50px;
				text-align:center;
			}
		</style>
	</head>
	<body>
		<h1><strong>Control Panel</strong></h1>
		<hr>
		<div>
			<p><a href="{{action('AnnouncementController@getManagement')}}">公告管理</a></p>	
			<p><a href="{{action('ManageController@anyUsermanagement')}}">使用者管理</a><p>
		</div>
	</body>
</html>
