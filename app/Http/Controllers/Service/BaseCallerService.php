<?php namespace App\Http\Controllers\Service;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Service\ResponseFormat\ResponseFormat;
use Illuminate\Http\Request;


abstract class BaseCallerService extends BaseController {

	private $database;

	public function getDatabase() {
		return $this->database;
	}

	public function setDatabase($database) {
		$this->database = $database;
	}

	protected function connect($request, $argument = null, $contentType = null, $method = 'GET')
	{
 		$Url = \Config::get('app.BASE_SERVICE_URL').$request.\Config::get('app.SERVICE_SECRET_KEY');
	    $request = Request::create($Url, $method);
	    $client = new \GuzzleHttp\Client();

		$response = $client->send($client->createRequest($method, $Url));
		
		return (new ResponseFormat(200, json_encode(($response->json()))))->getData();
	}

}
