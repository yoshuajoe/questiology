<?php namespace App\Http\Controllers\Repository\UserRepository;

use App\Http\Controllers\Repository\BaseRepository;
use Illuminate\Http\Request;

class UserRepository extends BaseRepository implements UserRepositoryInterface {

	public function __construct() {
		$this->database = 'larva';
		$this->collection = 'Users';
	}

	public function findC() {
		$params = json_decode(\Input::get('parameter'), true);
		$response = self::find($params);
		echo json_encode($response);
	}

	public function updateC() {
		$params = json_decode(\Input::get('parameter'), true);
		$putparams = \Input::get('putparam');
		$response = self::update($params, $putparams);
		echo json_encode($response);
	}

	public function insertC() {
		$postparams = \Input::get('postparam');
		$response = self::insert($postparams);
		echo json_encode($response);
	}


	public function deleteC() {
		$response = self::delete('555b1a31e4b02d8c787682b6');
		echo json_encode($response);
	}

}

