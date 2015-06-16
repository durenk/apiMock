<?php

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

Route::get('/', function()
{
	return View::make('site.pages.home');
});

Route::post('/submit', function()
{
	$input = Input::all();
	$output = array(
		'url' => '',
	);

	$api = new Api;
	$api->code = Input::get('code', 200);
	$api->charset = Input::get('charset', "UTF-8");
	$api->content_type = Input::get('content_type', "application/json");
	$api->redirect_location = Input::get('redirect_location', "");
	$api->body = Input::get('body', "");

	$headerNames = Input::get('headerNames', array());
	foreach ($headerNames as $key => $value) {
		if($value == "") unset($headerNames[$key]);
	}
	$headerValues = Input::get('headerValues', array());
	foreach ($headerValues as $key => $value) {
		if($value == "") unset($headerValues[$key]);
	}
	$headers = array_combine($headerNames, $headerValues);
	$api->headers = serialize($headers);

	$api->save();

	$output['url'] = url($api->id);

	return Response::json($output);
});

Route::any('/{id}', function($id)
{
	if($api = Api::find($id)) {

		if(Input::has('callback') && $api->content_type == "application/json")
			$api->body = Input::get('callback')."(".$api->body.");";

		$response = Response::make($api->body, $api->code);

		$content_type = $api->content_type."; charset=".$api->charset;
		$response->header('Content-Length', strlen($api->body));
		$response->header('Content-Type', $content_type);
		foreach (unserialize($api->headers) as $key => $value) {
			$response->header($key, $value);
		}
		if(strlen($api->redirect_location) > 0)
			$response->header('Location', $api->redirect_location);

		return $response;
	}

	return "error not found euy..";
});