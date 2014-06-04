<!DOCTYPE html>
<html>
<head>
	<title>Simple app</title>
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
	<style>
	#header {
		padding: 20px 0 0 0;
	}
	</style>
</head>
<body>
	<div class="container">
		<div id="header">
			<ul class="nav nav-pills">
				<li><a href="{{ route('usreous.index') }}">Предприятия</a></li>
				<li><a href="{{ route('ins.index') }}">Идентификационные номера</a></li>
				<li class="pull-right"><a class="btn btn-default" href="/logout">Выйти</a></li>
			</ul>
		</div>
	</div>

	<div class="container">
		@include('misc.messages')
		@yield('main')
	</div>

	<script src="//code.jquery.com/jquery-latest.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>