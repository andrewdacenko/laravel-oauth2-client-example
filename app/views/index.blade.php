<!DOCTYPE html>
<html ng-app="register">
<head>
	<title>Simple app</title>
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
	<script src="{{ asset('bower_components/angular/angular.js') }}"></script>
	<script src="{{ asset('bower_components/angular-ui-router/release/angular-ui-router.js') }}"></script>
	<script>
		var register = angular.module('register', ['ui.router'])
			.constant('ACCESS_TOKEN', "{{ Session::get('access_token') }}")
			.constant('HOST', 'http://localhost:8000/api/');
	</script>
	<script src="{{ asset('app/js/register.js') }}"></script>
	<script src="{{ asset('app/js/controllers.js') }}"></script>
</head>
<body>
	<div ng-include="'/app/templates/partials/header.html'"></div>

	<div class="container">
		<div ui-view></div>
	</div> 

	<script src="//code.jquery.com/jquery-latest.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>