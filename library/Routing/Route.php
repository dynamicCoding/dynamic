<?php

namespace Illustrator\Routing;


class Route
{
	protected $routeCollection;
	
	protected $method;
	
	protected $pattern;
	
	protected $action;
	
	protected $name;
	
	protected $match;
	
	use RouteUri;
	
	/**
	 * @param string $method
	 * @param string $pattern
	 * @param callable|string $action
	 * @param null|string $name nombre del pattern
	 */
	 
	public function __construct($method, $pattern, $action, $name = null)
	{
		$this->method = strtoupper($method);
		$this->pattern = $pattern;
		$this->action = $action;
		$this->name = $name;
	}

	/**
	 * añadir nombre a la url
	 *
	 * @param $appendPattern
	 * @return string
     */

	protected function name($appendPattern)
	{
		if(isset($this->name)){
			$name = '(?P<'.$this->name.'>'.$appendPattern.')';
		}else{
			$name = $appendPattern;
		}
		return $name;
	}
	
	public function matchPattern()
	{
		$collection = RouteCollection::instance()->pregConditionPattern(
			$this->pattern
		);
		
		$this->match = $this->name(
			$collection->getConditionPattern()
		);
		
		return $this;
	}

	/**
	 * @return string
     */

	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * @return string
     */

	public function getPattern()
	{
		return $this->pattern;
	}

	/**
	 * @return callable|string
     */

	public function getAction()
	{
		return $this->action;
	}

	/**
	 * @return null|string
     */

	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return mixed
     */

	public function getMatch()
	{
		return $this->match;
	}
}