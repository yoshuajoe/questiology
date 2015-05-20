<?php namespace App\Http\Controllers\Infrastructure\Mapper;


abstract class AbstractMapper {
	protected function compareStructure(array $structure, array $resources) {
		return $structure == $this->recursive_intersect($resources, $structure);
	}

	protected function recursive_intersect($structure, $resources) {
		if (!is_array($structure) || !is_array($resources)) {
			return (string) $structure == (string) $resources;
		}

		$keys = array_intersect(array_keys($structure), array_keys($resources));
		$ret = array();
		foreach ($keys as $key) {
			$ret[$key] = $this->recursive_intersect($structure[$key], $resources[$key]);
		}
		return $ret;
	}
} 