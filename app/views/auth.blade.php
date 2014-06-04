<!DOCTYPE html>
<html>
<head>
	<title>Reg client</title>
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
</head>
<body>
	<div class="container">
		<div class="col-md-6 col-md-offset-3">
			<h1 class="page-header text-center">You need to authorize first</h1>
			<a class="btn btn-block btn-primary" href="{{ route('oauth.redirect') }}">Sign In via Registry</a>
			<!-- <a href="{{ Config::get('oauth.host').Config::get('oauth.url').'?client_id='.Config::get('oauth.client_id').'&redirect_uri='.Config::get('oauth.redirect_uri').'&response_type=code' }}">Log via Registry</a> -->
			<hr>
			<p class="text-center">Or</p>
			<h3 class="text-center page-header">Sing In using username</h3>
			{{ Form::open(['class' => 'text-center']) }}
			@include('misc.messages')
			@include('misc.errors')
			<div class="form-group">
				{{ Form::label('username', 'Username', []) }}
				{{ Form::text('username', Input::old('username'), ['class' => 'form-control'])}}
			</div>
			<div class="form-group">
				{{ Form::label('password', 'Password', []) }}
				{{ Form::password('password', ['class' => 'form-control'])}}
			</div>
			<div class="form-group">
				{{ Form::submit('Sign In', ['class' => 'btn btn-success btn-block']) }}
			</div>
			{{ Form::close() }}
		</div>
	</div>

	<script src="//code.jquery.com/jquery-latest.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>