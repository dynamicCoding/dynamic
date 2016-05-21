<?php

namespace Illustrator\Routing;

trait RouteUri
{
	public function getRequest()
	{
		$uri = $this->decodeUri($_SERVER['REQUEST_URI']);
		$script = $_SERVER['SCRIPT_NAME'];
		if(strpos($uri, $script) !== false){
			$uri = mb_substr($uri, strlen($script));
		}
		return $uri ? $uri : '/';
	}
	
	protected function decodeUri($uri)
	{
		$dec = html_entity_decode($uri);
		
		return strip_tags($dec);
	}
}