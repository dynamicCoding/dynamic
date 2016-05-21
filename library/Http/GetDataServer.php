<?php

namespace Illustrator\Http;

trait GetDataServer
{
	/**
	 * @var array añade los parametros de la cookie 
	 */
	 
	protected $cookie = [];
	
	/**
	 * @var array añade parametros al stream php
	 */
	 
	protected $streamInput = [];
	 
	 /**
	  * @var  null|object|array obtiene stream input
	  */
	  
	protected $body;
	
	/**
	 * validaciom de metodos http
	 */
	 
	use RequestMethodTrait;
	 
	 /**
	  * parametros enviado por get
	  *
	  * @access public
	  * @return string
	  */
	  
	public function getQueryParams()
	{
		return $this->getVar('QUERY_STRING');
	}
	
	/**
	 *  obtiene los valores enviados por el form y añade los valores en array
	 *
	 * @access protected
	 * @return array|string
	 */
	 
	protected function streamInput($name = null)
	{
		$content = file_get_contents('php://input');
		if(!empty($content) && empty($this->streamInput)){
			parse_str($content, $this->streamInput);
		}
		return (is_null($name)) ? $this->streamInput : $this->streamInput[$name];
	}
	
	/**
	 * @access public
	 * @return array
	 */
	 
	public function body($name = null)
	{
		return $this->streamInput($name);
	}
	
	/**
	 * content type enviados o aceptados
	 *
	 * @access public
	 * @return array
	 */
	 
	public function getAccept()
	{
		$accept = $this->getHeader('ACCEPT');
		$divide = explode(';', $accept);
		$content = array_shift($divide);
		if(is_string($content)){
			$getType = explode(',', $content);
		}
		$qv = is_array($divide) ? array_shift($divide) : '';
		if(strpos($qv, ',') !== false){
			$q = explode(',', $qv);
		}
		$qv = isset($q) ? array_merge($q, $divide) : [];
		
		return array_merge($getType, $qv);
	}
	
	/**
	 * @access public
	 * @return array|string
	 */ 	
	  
	 public function getBodyParams()
	 {
	 	$type = $this->getVar('CONTENT_TYPE');
	 	switch($type){
	 		case 'multipart/form-data':
	 		case 'application/x-www-form-urlencoded':
	 			$this->body = $this->streamInput();
	 			break;
	 		case 'text/json':
	 		case 'application/json':
	 			$this->body = json_encode($this->streamInput());
	 			break;
	 	}
	 	return $this->body;
	 }
	 
	 /**
	  * @access public
	  * @return array
	  */
	  
	 public function getUploadedFiles()
	 {
	 	return $_FILES;
	 }
	 
	 /**
	  * @access public
	  * @return array
	  */
	  
	 public function getCookieParams()
	 {
	 	return $_COOKIE;
	 }
	 
	 /**
	  * @access public
	  * @return array
	  */
	  
	 public function getServerParams()
	 {
	 	return $_SERVER;
	 }
	 
	 /**
	  * obtien el path de la url removiendo el script que se esta ejecutando
	  *
	  * @access public
	  * @return string 
	  */
	  
	public function getPath()
	{
		$request = $this->getVar('REQUEST_URI');
        	if(strpos($request, '/') !== false){
	            $script = strrchr($this->getVar('SCRIPT_NAME'), '/');
	            if(0 === substr_compare($request, $script, 0, strlen($script))){
	                $request = substr($request, strlen($script));
	            }
        	}
         return $request ? $request : '/';
	}
	
	 /**
	  * obtiene las cookie principales enviadas por php
	  *
	  * @access public
	  * @return array
	  */
	  
	public function getCookie()
	{
		$cookie = $this->getHeader('COOKIE');
		$cookie = str_replace(';', '&', $cookie);
		if(!empty($cookie)){
			parse_str($cookie, $this->cookie);
		}
		
		$trackid = isset($this->cookie['TRACKID']) ? ['TRACKID' => $this->cookie['TRACKID']] : [];
		
		$phpsessid = isset($this->cookie['PHPSESSID']) ? ['PHPSESSID' => $this->cookie['PHPSESSID']] : [];
		
		return $trackid + $phpsessid;
	}
	
	 /**
	  * @access public
	  * @return array
	  */
	  
	public function getAllCookie()
	{
		return  $this->cookie;
	}
	
	 /**
	  * obtiene la version del protocol que se esta ejecutando
	  *
	  * @access public
	  * @return float|string
	  */
	  
	public function getVersionProtocol()
	{
		$protocol = $this->getVar('SERVER_PROTOCOL');
		if($int = strpos($protocol, '/')){
			$version = substr($protocol, $int + 1);
		}
		return isset($version) ? (float)$version : $protocol;
	}
	
	 /**
	  * protocol http | https
	  *
	  * @access public
	  * @return string
	  */
	  
	public function getHttpProtocol()
	{
		return $this->isSsl();
	}
	
	/**
	 * @access public
	 * @return string numero del puerto
	 */
	 
	public function getPort()
	{
		return $this->getVar('SERVER_PORT');
	}
	
	/**
	 * obtiene el host con el puerto
	 *
	 * @access public
	 * @return string
	 */
	 
	public function getNameHost()
	{
		$ssl = $this->isSsl();
		$port = $this->getPort();
		 switch($ssl){
			case 'http':
				if($port === '80') {
					$port = '80';
				}
				$port = (int)$port;
				break;
			case 'https':
				$port = $port === '443' ? 433 : (int)$port;
				break;
		}
		return $ssl . '://'. $this->getHost() . ':' . $port;
	}
	
	/**
	 * obtiene nombre del host removiendo el puerto si existe	 
	 *
	 * @access public
	 * @return string
	 */
	  
	public function getHost()
	{
		$host = $this->getHeader('HOST');
		if($length = strpos($host, ':')){
			$host = substr($host, 0, $length);
		}
		return (string)$host;
	}
	
	 /**
	  * @access protected
	  * @return string
	  */
	  
	protected function isSsl()
	{
		return $this->getVar('HTTPS') ? 'https' : 'http';
	}
	
	 /**
	  * @access protected 
	  * @return string|null
	  */
	  
	protected function getVar($key)
	{
		return isset($_SERVER[$key]) ? $_SERVER[$key] : null;
	}
	
	 /**
	  * @access public
	  * {@inheritDoc}
	  * @return string|null
	  */
	  
	public function getHeader($key) 
	{
		return $this->getVar('HTTP_'.$key);
	}
}