<?php namespace App\Http\Controllers\Repository;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Service\ResponseFormat\ResponseFormat;
use Illuminate\Http\Request;


abstract class BaseRepository extends BaseController {

	protected $database, $collection;

	public function getDatabase() {
		return $this->database;
	}

	public function setDatabase($database) {
		$this->database = $database;
	}

	public function getCollection() {
		return $this->collection;
	}

	public function setCollection($collection) {
		$this->collection = $collection;
	}

	protected function connect($request, $argument = null, $contentType = null, $method = 'GET')
	{
		$client = new \GuzzleHttp\Client();
 		$Url = \Config::get('app.BASE_SERVICE_URL').$request.\Config::get('app.SERVICE_SECRET_KEY');
	    $request = Request::create($Url, $method);
	    $client->setDefaultOption('headers/Content-Type', 'application/json');
	    
	    if($method == 'POST') {
	    	$response = $client->post($Url, array(), $argument);
	    }else {
			$response = $client->send($client->createRequest($method, $Url));
	    }

		return (new ResponseFormat(200, json_encode(($response->json()))))->getData();
	}

}
