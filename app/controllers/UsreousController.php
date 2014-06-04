<?php

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientErrorResponseException;
use GuzzleHttp\Exception\AdapterException;

class UsreousController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$client = new GuzzleHttp\Client();

		try {
			$request = $client->get(Config::get('oauth.host').'api/usreous',[
				'query' => [
					'access_token' => Session::get('access_token'),
				]
			]);

			if (Input::get('format') === 'json' || Request::ajax()) {
				return $request->json();
			}

			return View::make('usreous.index', ['usreous' => $request->json()]);
		} catch (Exception $e) {
			if ($e->getCode() === 401) {
				return Redirect::to('/login');
			}
			return $e->getMessage();
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$client = new GuzzleHttp\Client();

		try {
			// Get INs
			$request = $client->get(Config::get('oauth.host').'api/ins',[
				'query' => [
					'access_token' => Session::get('access_token'),
				]
			]);

			$ins = $request->json();

			$ins_r = array();

			foreach ($ins as $in){
				$ins_r[$in['id']] = $in['in'];
			}

			// Get Addresses
			$request = $client->get(Config::get('oauth.host').'api/addresses',[
				'query' => [
					'access_token' => Session::get('access_token'),
				]
			]);

			$addresses = $request->json();

			$addresses_r = array();

			foreach ($addresses as $address){
				$addresses_r[$address['id']] = $address['name'] . ', г.' . $address['city']['name'];
			}

			// Get Registries
			$request = $client->get(Config::get('oauth.host').'api/registries',[
				'query' => [
					'access_token' => Session::get('access_token'),
				]
			]);

			$registries = $request->json();

			$registries_r = array();

			foreach ($registries as $registry){
				$registries_r[$registry['id']] = $registry['name'] . ', ' . $registry['address']['name'] . ', г.' . $registry['address']['city']['name'];
			}

			// Get Activities
			$request = $client->get(Config::get('oauth.host').'api/activities',[
				'query' => [
					'access_token' => Session::get('access_token'),
				]
			]);

			$activities = $request->json();

			$activities_r = array();
			
			foreach ($activities as $activity){
				$activities_r[$activity['id']] = $activity['name'];
			}

			return View::make('usreous.create', array('ins' => $ins_r, 'addresses' => $addresses_r,
					'registries' => $registries_r, 'activities' => $activities_r));
		} catch (Exception $e) {
			if ($e->getCode() === 401) {
				if (Request::ajax()) {
					return Response::json(
						array(
							'error' => true
						), 401
					);
				}

				return Redirect::to('/login');
			}

			if (Request::ajax()) {
				return Response::json(
					array(
						'error' => true,
						'errors' => [$e->getResponse()]
					), $e->getCode()
				);
			}

			return Redirect::back()->with('danger', $e->getResponse());
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::only('organization', 
							'in_id',
							'address_id',
							'ceo',
							'phone',
							'fax',
							'email',
							'registry_id',
							'activity_id');

		try {
			$client = new GuzzleHttp\Client();

			$request = $client->post(Config::get('oauth.host').'api/usreous', [
				'headers' => ['Authorization' => 'Bearer ' . Session::get('access_token')],
				'body' => $data
			]);

			if (Input::get('format') === 'json' || Request::ajax()) {
				return $request->json();
			}

			$usreou = $request->json();

			return Redirect::route('usreous.show', $usreou['id']);
		} catch (RequestException $e) {
			if ($e->hasResponse()) {
				$res = $e->getResponse();
				$json = $res->json();
				$errors = $json['errors'];

				if (Request::ajax()) {
					return Response::json(
						array(
							'error' => true,
							'errors' => $errors
						)
					);
				}

				return Redirect::back()->withErrors($errors)->withInput();
			}
			
			return Redirect::back()->with('danger', $e->getMessage())->withInput();
		} catch (Exception $e) {
			if ($e->getCode() === 401) {
				if (Request::ajax()) {
					return Response::json(
						array(
							'error' => true
						), 401
					);
				}

				return Redirect::to('/login');
			}

			if (Request::ajax()) {
				return Response::json(
					array(
						'error' => true,
						'errors' => [$e->getMessage()]
					), $e->getCode()
				);
			}

			return Redirect::back()->with('danger', $e->getMessage());
		}

		return Redirect::to(action('UsreousController@index'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$client = new GuzzleHttp\Client();

		try {
			$request = $client->get(Config::get('oauth.host').'api/usreous/'.$id,[
				'query' => [
					'access_token' => Session::get('access_token'),
				]
			]);

			if (Input::get('format') === 'json' || Request::ajax()) {
				return $request->json();
			}
			return View::make('usreous.show', ['usreou' => $request->json()]);
		} catch (Exception $e) {
			if ($e->getCode() === 401) {
				if (Request::ajax()) {
					return Response::json(
						array(
							'error' => true
						), 401
					);
				}

				return Redirect::to('/login');
			}

			if (Request::ajax()) {
				return Response::json(
					array(
						'error' => true,
						'errors' => [$e->getMessage()]
					), $e->getCode()
				);
			}

			return Redirect::back()->with('danger', $e->getMessage());
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$client = new GuzzleHttp\Client();

		try {
			$request = $client->get(Config::get('oauth.host').'api/usreous/'.$id,[
				'query' => [
					'access_token' => Session::get('access_token'),
				]
			]);
			
			$usreou = $request->json();

			// Get INs
			$request = $client->get(Config::get('oauth.host').'api/ins',[
				'query' => [
					'access_token' => Session::get('access_token'),
				]
			]);

			$ins = $request->json();

			$ins_r = array();

			foreach ($ins as $in){
				$ins_r[$in['id']] = $in['in'];
			}

			// Get Addresses
			$request = $client->get(Config::get('oauth.host').'api/addresses',[
				'query' => [
					'access_token' => Session::get('access_token'),
				]
			]);

			$addresses = $request->json();

			$addresses_r = array();

			foreach ($addresses as $address){
				$addresses_r[$address['id']] = $address['name'] . ', г.' . $address['city']['name'];
			}

			// Get Registries
			$request = $client->get(Config::get('oauth.host').'api/registries',[
				'query' => [
					'access_token' => Session::get('access_token'),
				]
			]);

			$registries = $request->json();

			$registries_r = array();

			foreach ($registries as $registry){
				$registries_r[$registry['id']] = $registry['name'] . ', ' . $registry['address']['name'] . ', г.' . $registry['address']['city']['name'];
			}

			// Get Activities
			$request = $client->get(Config::get('oauth.host').'api/activities',[
				'query' => [
					'access_token' => Session::get('access_token'),
				]
			]);

			$activities = $request->json();

			$activities_r = array();
			
			foreach ($activities as $activity){
				$activities_r[$activity['id']] = $activity['name'];
			}

			return View::make('usreous.edit', ['ins' => $ins_r, 'addresses' => $addresses_r,
					'registries' => $registries_r, 'activities' => $activities_r, 'usreou' => $usreou]);
		} catch (RequestException $e) {
			if ($e->hasResponse()) {
				$res = $e->getResponse();
				$json = $res->json();
				$errors = $json['errors'];

				if (Request::ajax()) {
					return Response::json(
						array(
							'error' => true,
							'errors' => $errors
						)
					);
				}

				return Redirect::back()->withErrors($errors)->withInput();
			}
			
			return Redirect::back()->with('danger', $e->getMessage());
		} catch (Exception $e) {
			if ($e->getCode() === 401) {
				if (Request::ajax()) {
					return Response::json(
						array(
							'error' => true
						), 401
					);
				}

				return Redirect::to('/login');
			}

			if (Request::ajax()) {
				return Response::json(
					array(
						'error' => true,
						'errors' => [$e->getMessage()]
					), $e->getCode()
				);
			}

			return Redirect::back()->with('danger', $e->getMessage());
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$data = Input::only('organization', 
							'in_id',
							'address_id',
							'ceo',
							'phone',
							'fax',
							'email',
							'registry_id',
							'activity_id');

		try {
			$client = new GuzzleHttp\Client();

			$request = $client->patch(Config::get('oauth.host').'api/usreous/'.$id, [
				'headers' => ['Authorization' => 'Bearer ' . Session::get('access_token')],
				'body' => $data
			]);


			if (Input::get('format') === 'json' || Request::ajax()) {
				return $request->json();
			}
		
			$usreou = $request->json();

			return Redirect::route('usreous.show', $usreou['id']);
		} catch (RequestException $e) {
			if ($e->hasResponse()) {
				$res = $e->getResponse();
				$json = $res->json();
				$errors = $json['errors'];

				if (Request::ajax()) {
					return Response::json(
						array(
							'error' => true,
							'errors' => $errors
						)
					);
				}

				return Redirect::back()->withErrors($errors)->withInput();
			}
			
			return Redirect::back()->with('danger', $e->getMessage());
		} catch (Exception $e) {
			return $e;
			if ($e->getCode() === 401) {
				if (Request::ajax()) {
					return Response::json(
						array(
							'error' => true
						), 401
					);
				}

				return Redirect::to('/login');
			}

			if (Request::ajax()) {
				return Response::json(
					array(
						'error' => true,
						'errors' => [$e->getMessage()]
					), $e->getCode()
				);
			}

			dd($e->getCode());

			return Redirect::back()->with('danger', $e->getMessage())->withInput();
		}

		return Redirect::to(action('UsreousController@index'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try {
			$client = new GuzzleHttp\Client();

			$request = $client->delete(Config::get('oauth.host').'api/usreous/'.$id, [
				'headers' => ['Authorization' => 'Bearer ' . Session::get('access_token')]
			]);

			if (Input::get('format') === 'json' || Request::ajax()) {
				return $request->json();
			}

			return Redirect::to(action('UsreousController@index'));
		} catch (RequestException $e) {
			if ($e->hasResponse()) {
				$res = $e->getResponse();
				$json = $res->json();
				$errors = $json['errors'];

				if (Request::ajax()) {
					return Response::json(
						array(
							'error' => true,
							'errors' => $errors
						)
					);
				}

				return Redirect::back()->withErrors($errors);
			}
			
			return Redirect::back()->with('danger', $e->getMessage());
		} catch (Exception $e) {
			if ($e->getCode() === 401) {
				if (Request::ajax()) {
					return Response::json(
						array(
							'error' => true
						), 401
					);
				}

				return Redirect::to('/login');
			}

			if (Request::ajax()) {
				return Response::json(
					array(
						'error' => true,
						'errors' => [$e->getResponse()]
					), $e->getCode()
				);
			}

			return Redirect::back()->with('danger', $e->getResponse());
		}

		return Redirect::to(action('UsreousController@index'));
	}

}