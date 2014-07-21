<!DOCTYPE html>
<html ng-app="shalery">
<head>
	<meta charset="UTF-8">
	<title>
		Shalery 株式会社
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	{{ HTML::style('asset/css/shalerywebsite.css'); }}
	{{ HTML::style('asset/css/bootstrap.css'); }}
	{{ HTML::style('asset/css/font-awesome.min.css'); }}

	{{ HTML::script('asset/js/jquery-2.1.1.min.js'); }}
	{{ HTML::script('asset/js/angular.min.js'); }}
	{{ HTML::script('asset/js/app.js'); }}

</head>
<body>
	@include('frontend.website.navbar')
	<div class="container">
		@yield('content')
	</div>
</body>
</html>