<?php

namespace Illustrator\Http;

class UrlManipulator
{
	use GetDataServer;
	
	/**
	 * añadir parametros a la url
	 *
	 * @param string $url
	 * @param array $builder
	 * @return string
	 */
	 
	public function appendParamsUrlBase($url, array $builder = [])
	{
		$base = $url.$this->getQueryParams();
		if(!$builder){
			return $base;
		}
		
		if(strpos($base, '?') === false){
			return $base . '?' . http_build_query($builder, null ,'&');
		}
		
		list($path, $query) = explode('?', $base, 2);
		
		$extP = [];

		parse_str($query, $extP);
		//une el query
		$builder = array_merge($builder, $extP);
		//ordena el query
		ksort($builder); 
		
		return $path . '?' . http_build_query($builder, null , '&');
	}

	/**
	 * obtiene el query de la url
	 *
	 * @param string $url
	 * @return array
	 */
	 
	public function getParamArray($url)
	{
		$query = parse_url($url, PHP_URL_QUERY);
		if(!$query){
			return [];
		}
		$params = [];

		parse_str($query, $params);
		
		return $params;
	}
}