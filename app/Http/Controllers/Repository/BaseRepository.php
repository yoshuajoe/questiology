<?php namespace App\Http\Controllers\Repository;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Service\ResponseFormat\ResponseFormat;
use App\Http\Controllers\Infrastructure\Mapper\CoreMapper;
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

	/*
		"q" example - return all documents with "active" field of true:
		https://api.mongolab.com/api/1/databases/my-db/collections/my-coll?q={"active": true}&apiKey=myAPIKey

		"c" example - return the count of documents with "active" of true:
		https://api.mongolab.com/api/1/databases/my-db/collections/my-coll?q={"active": true}&c=true&apiKey=myAPIKey

		"f" example (include) - return all documents but include only the "firstName" and "lastName" fields:
		https://api.mongolab.com/api/1/databases/my-db/collections/my-coll?f={"firstName": 1, "lastName": 1}&apiKey=myAPIKey

		"f" example (exclude) - return all documents but exclude the "notes" field:
		https://api.mongolab.com/api/1/databases/my-db/collections/my-coll?f={"notes": 0}&apiKey=myAPIKey

		"fo" example - return a single document matching "active" field of true:
		https://api.mongolab.com/api/1/databases/my-db/collections/my-coll?q={"active": true}&fo=true&apiKey=myAPIKey

		"s" example - return all documents sorted by "priority" ascending and "difficulty" descending:
		 https://api.mongolab.com/api/1/databases/my-db/collections/my-coll?s={"priority": 1, "difficulty": -1}&apiKey=myAPIKey

		"sk" and "l" example - sort by "name" ascending and return 10 documents after skipping 20
		 https://api.mongolab.com/api/1/databases/my-db/collections/my-coll?s={"name":1}&sk=20&l=10&apiKey=myAPIKey
	*/

	public function find($parameter = null) {
		$uri = 'databases/'.$this->getDatabase().'/collections/'.$this->getCollection();
		return $this->connect($uri, $parameter, 'application/json', null, 'GET');
	}

	public function getAll() {
		$this->find();
	}

	public function update($oldval, $newval) {
		$g_param = '{"$set":'.$newval.'}';
		$uri = 'databases/'.$this->getDatabase().'/collections/'.$this->getCollection();
		return $this->connect($uri, $oldval, 'application/json', $g_param, 'PUT');
	}

	public function insert($newval) {
		$uri = 'databases/'.$this->getDatabase().'/collections/'.$this->getCollection();
		return $this->connect($uri, array(), 'application/json', $newval, 'POST');
	}

	public function delete($value) {
		$uri = 'databases/'.$this->getDatabase().'/collections/'.$this->getCollection().'/'.$value;
		return $this->connect($uri, array(), 'application/json', null, 'DELETE');
	}


	protected function connect($request, array $argument = null, $contentType = null, $param = null, $method = 'GET')
	{
		$client = new \GuzzleHttp\Client();
		$url = CoreMapper::buildUrl($request, $argument);
	    $request = Request::create($url, $method);

	    if($method == 'POST' || $method == 'PUT') {
	    	$response = $client->{strtolower($method)}($url, ['body' => $param, 'headers' => ['Content-Type' => $contentType]]);
	    }else if($method == 'DELETE'){
	    	$response = $client->delete($url, ['body' => $param, 'headers' => ['Content-Type' => $contentType]]);
	    }else {
			$response = $client->send($client->createRequest($method, $url));
	    }

		return (new ResponseFormat($response->getStatusCode(), $response->json()))->getData();
	}

}
