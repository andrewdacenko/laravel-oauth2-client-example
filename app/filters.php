<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

// App::missing(function($exception)
// {
//     return View::make('index');
// });

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/
Route::filter('access_token', function(){

	if (Session::has('expires')) {
		if (Session::get('expires') < time()) {
			if (Session::has('refresh_token')) {
				$client = new GuzzleHttp\Client();

				$res = $client->post(Config::get('oauth.host').'oauth/access_token'.'?grant_type=refresh_token&'.
						'client_id='.Config::get('oauth.client_id').'&'.
						'client_secret='.Config::get('oauth.client_secret').'&'.
						'refresh_token='.Session::get('refresh_token'));

				try {
					$json = $res->json();
					
					Session::put('access_token', $json['access_token']);
					Session::put('token_type', $json['token_type']);
					Session::put('expires', $json['expires']);
					Session::put('expires_in', $json['expires_in']);
					Session::put('refresh_token', $json['refresh_token']);
				} catch (Exception $e) {
					return Redirect::to('/login');
				}
			} else {
				return Redirect::to('/login');
			}
		}
	}

	if (!Session::has('access_token')) {
		return Redirect::to('/login');
	}
});


Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
