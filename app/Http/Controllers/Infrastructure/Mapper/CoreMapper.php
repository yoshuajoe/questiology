<?php namespace App\Http\Controllers\Infrastructure\Mapper;

class CoreMapper extends AbstractMapper {

	public static function buildURL($request, array $arr) {
		
		$url = \Config::get('app.BASE_SERVICE_URL').$request;
 		
 		$uriWithParam = "";
 		if($arr !== null) {		
 			foreach($arr as $param) {
 				$uriWithParam .= $param['key'].'='.json_encode($param['value']).'&'; 
	 		}
 		}

 		return $url.'?'.$uriWithParam.\Config::get('app.SERVICE_SECRET_KEY');
	}
} 