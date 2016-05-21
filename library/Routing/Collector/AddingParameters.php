<?php

namespace Illustrator\Routing\Collector;

use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;
use RuntimeException;
use Illustrator\Routing\Exceptions\ControllerNotFount;
use Illustrator\Routing\Exceptions\MethodNotFount;

final class AddingParameters implements AddingInterface
{
	/**
	 * @var array callable|string
	 */

	protected $callback;

	/**
	 * @var array
	 */

	protected $parameter = array();

	/**
	 * @var array|null
	 */

	protected $constructor;

	/**
	 * @param callable $callback
	 * @param array $append
     */

	public function __construct($callback, array $append)
	{
		$this->callback[] = $callback;
		$this->parameter = $append;
	}

	/**
	 * @param object $add
	 * @return array
     */

	public function appendParams($add)
	{
		$append = $this->parameter;
		if(!is_object($add)){
			throw new RuntimeException("parametro a recibir es un objecto");
		}
		
		$params = $add->getParameters();
		if($add->getNumberOfParameters() > 0){
			foreach($params as $param){
				if($class = $param->getClass()){
					$append[] = new $class->name;
				}
			}
		}
		return $append;
	}

	/** @noinspection PhpInconsistentReturnPointsInspection */

	/**
	 * @return null|ReflectionFunction|ReflectionMethod
	 * @throws ControllerNotFount
	 * @throws MethodNotFount
	 */

	public function reflection()
	{
		if(is_array($this->callback)){
			foreach($this->callback as $type){
				return is_string($type) ? $this->resolverClass($type) : new ReflectionFunction($type);
			}
		}
		return null;
	}
	
	public function getAdding()
	{
		return $this;
	}

	/**
	 * @param string $string
	 * @param null $max
	 * @return array
     */

	private function namespacedDivide($string, $max = null)
	{
		return explode('::', $string, $max);
	}


	/**
	 * @param string $class
	 * @return ReflectionMethod
	 * @throws ControllerNotFount
	 * @throws MethodNotFount
     */

	protected function resolverClass($class)
	{
		list($class, $method) = self::namespacedDivide($class, 2);
			
		if(!class_exists($class)){
			throw new ControllerNotFount(sprintf("controlador %s no encontrado", $class));
		}
			
		if(!method_exists($class, $method)){
			throw new MethodNotFount(vsprintf("metodo %s->%s no encontrado", [$class, $method]));
		}

		$reflection = new ReflectionClass($class);
		$params = $reflection->getConstructor();

		if(method_exists($params, 'getParameters')){
			foreach ($params->getParameters() as $c) {
				if ($constructor = $c->getClass()) {
					$this->constructor[] = ($constructor->name == 'Illustrator\View\ViewFactory') ? 'view' : $constructor->name;
				}
				if (isset($c->name) && in_array($c->name, ['view', 'request', 'response', 'filesystem', 'container'])) {
					$this->constructor[] = $c->name;
				}
			}
		}
		return $reflection->getMethod($method);
	}

	/**
	 * @return array|null
	 */

	public function getConstructor()
	{
		return $this->constructor;
	}
}