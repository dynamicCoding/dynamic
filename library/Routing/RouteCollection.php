<?php

namespace Illustrator\Routing;

use Illustrator\Routing\Exceptions\BadRouteParameterException;

class RouteCollection
{
	/**
	 * @var null instancia de la clase
	 */
	 
	public static $instance = null;
	
	/**
	 * @var string|null 
	 */
	 
	protected $pattern;
	
	/**
	 * @var string url condicion del pattern
	 */
	 
	protected $condition;
	
	/**
	 * @var array remplazar  al tipo de regex  requerido
	 */
	 
	protected $replaceSpecialCondition = [
			'([a-zA-Z]+)',
			'([0-9]+)'
	];
	
	/**
	 * @var string regex global
	 */
	 
	protected $globalCondition = '/{([0-9a-zA-Z_\:]+)}/i';
	
	/**
	 * @param string|null $pattern
	 */
	 
	public function __construct($pattern = null)
	{
		$this->pattern = $pattern; 
	}
	/**
	 * instancia de la clase
	 *
	 * @access public
	 * @param string|null $pattern
	 * @return RouteCollextion
	 */
	 
	public static function instance($pattern = null)
	{
		if(self::$instance === null){
			self::$instance = new static($pattern);
		}
		return self::$instance;
	}
	
	/** 
	 * cambia todos los parametros recibido por un regex para comprobar 
	 * un error del requirimiento del parametro
	 *
	 * @access public
	 * @return string
	 */
	 
	public function getDetermineUrl()
	{
		return $this->callbackReplaceUrl($this->pattern);
	}

	/**
	 * cambia los tipo de condicion del pattern puede ser :number oh :string
	 * escrito dentro del parametro y a su vez los parametros sin condicion
	 *
	 * @access public
	 * @param string|null $pattern
	 * @return $this
	 * @throws BadRouteParameterException
	 */

	public function pregConditionPattern($pattern = '')
	{
		$pattern = isset($pattern) ? $pattern : $this->pattern;
		if(preg_match_all($this->globalCondition, $pattern, $values, PREG_PATTERN_ORDER)){
			$hash = array_shift($values);
			foreach($hash as $condition){
				if(preg_match('/{(.*?)[:number|:string]}/', $condition)){
					$this->condition = preg_replace(array(
						'/{(.*?):string}/', 
						'/{(.*?):number}/'), 
						$this->replaceSpecialCondition, 
						$pattern
					);
				}else{
					$this->condition = $pattern;
				}
				break; 
			}
		}else{
			$this->condition = preg_quote($pattern, '/');
		}
		
		if($p_error = $this->pregNot()){
			throw new BadRouteParameterException(vsprintf("error en la condicional %s tipo [%s] no valido", $p_error));
		}

		return $this;
	}
	
	/** 
	 * reemplaza la peticion de parametro por un rgx
	 *
	 * @access public
	 * @param  string $p
	 * @return string
	 */
	  
	public function callbackReplacePattern($p)
	{
		 return preg_replace_callback($this->globalCondition, function(){
			return '([a-zA-Z0-9_\+\-%]+)';
		}, $p);
	}
	 	
	/**
	 * comprobar que la condicion  en los parametros no exista y si el rgx
	 * 
	 * @access protected
	 * @return array
	 */
	 
	protected function pregNot()
	{
		if(preg_match('/{(.*?):(.*?)}/', $this->condition, $m)){
			$error['parameter'] = array_shift($m);
			$error['parameter_passed'] = array_pop($m);
			
			return $error;
		}
		
		return [];
	}

	/**
	 * @return string
	 */

	public function getConditionPattern()
	{
		return $this->callbackReplacePattern($this->condition).'/?';
	}
	 	
	/**
	 * @return array 
	 */
	 
	public function getErrorParameter()
	{
		return $this->pregNot();
	}
}