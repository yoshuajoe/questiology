<?php namespace App\Http\Controllers\Repository\UserRepository;
use App\Http\Controllers\Repository\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface {

	public function __construct() {
		$this->database = 'larva';
		$this->collections = 'Users';
	}

	public function insert() {
		$requestURI = 'databases/'.$this->database.'/collections/'.$this->collections;
		$response = $this->connect($requestURI, json_encode( array('name' => 'rangga')),null, 'POST');
		echo json_encode($response); die();
	}

}

