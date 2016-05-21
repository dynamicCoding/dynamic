<?php

if(!function_exists('data')){
	function data($data){
		$data = is_array($data) ? $data : (new \ArrayObject((array)$data));
		foreach($data as $key => $value){
			print_r([$key => $value]);
		}
	}
}

if(!function_exists('config')){
	function config($data){
		$ini = parse_ini_file(ILLUM_PATH.'/dest.ini', true);
		if($data){
			$data = explode('.', $data);
			foreach($data as $key_array){
				if(isset($ini[$key_array])){
					$ini = $ini[$key_array];
				}else{
					$ini = null;
				}
			}
			return $ini;
		}
		return false;
	}
}