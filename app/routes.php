<?php

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientErrorResponseException;
use GuzzleHttp\Exception\AdapterException;
use GuzzleHttp\Exception\ParseException;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/authenticated', function(){
	$code = Input::get('code');

	try {
		$client = new GuzzleHttp\Client();

		$res = $client->post(Config::get('oauth.host').'oauth/access_token'.'?grant_type=authorization_code&'.
				'client_id='.Config::get('oauth.client_id').'&'.
				'client_secret='.Config::get('oauth.client_secret').'&'.
				'redirect_uri='.Config::get('oauth.redirect_uri').'&'.
				'code='.$code);

		$json = $res->json();

		Session::put('access_token', $json['access_token']);
		Session::put('token_type', $json['token_type']);
		Session::put('expires', $json['expires']);
		Session::put('expires_in', $json['expires_in']);
		Session::put('refresh_token', $json['refresh_token']);

		return Redirect::to('/usreous');
	} catch (Exception $e){
		Session::flush();
		return Redirect::to('/login')->with('danger', 'Wrong code');
	}
});

Route::group(['before' => 'access_token'], function(){
	Route::get('/', function(){
		return Redirect::to('/usreous');
	});

	Route::resource('ins', 'InsController');
	Route::resource('usreous', 'UsreousController');
});

Route::get('/oauth', ['as' => 'oauth.redirect', function(){
	$url = Config::get('oauth.host').
		Config::get('oauth.url').
		'?client_id='.Config::get('oauth.client_id').
		'&redirect_uri='.Config::get('oauth.redirect_uri').
		'&response_type=code';
	return Redirect::away($url);
}]);

Route::post('/login', function()
{
	$username = Input::get('username', '');
	$password = Input::get('password', '');

	try {
		$client = new GuzzleHttp\Client();

		$request = $client->post(Config::get('oauth.host').'/oauth/access_token', [
			'query' => [
				'grant_type' => 'password',
				'client_id' => Config::get('oauth.client_id'),
				'client_secret' => Config::get('oauth.client_secret'),
				'username' => $username,
				'password' => $password,
			],
		]);

		$json = $request->json();

		Session::put('access_token', $json['access_token']);
		Session::put('token_type', $json['token_type']);
		Session::put('expires', $json['expires']);
		Session::put('expires_in', $json['expires_in']);
		Session::put('refresh_token', $json['refresh_token']);

		return Redirect::to('/usreous')->with('success', 'You are now logged in.');
	} catch (RequestException $e) {
		if ($e->hasResponse()) {
			$res = $e->getResponse();

			if ($res->getStatusCode() == '500') {
				return Redirect::to('login')->with('danger', 'Registry server fault');
			}

			$json = $res->json();

			return Redirect::to('login')->with('danger', $json['error_description']);
		}
		
		return Redirect::to('login')->with('danger', $json['error_description']);
	} catch (ParseException $e) {
		return Redirect::to('login')->with('danger', 'Server fault json');
	} catch (Exception $e) {
		return Redirect::to('login')->with('danger', 'Server fault. ' . $e->getMessage());
	}
});

Route::get('/login', ['as' => 'login', function()
{
	return View::make('auth');
}]);

Route::get('/logout', function(){
	Session::flush();
	return Redirect::to('/login');
});
