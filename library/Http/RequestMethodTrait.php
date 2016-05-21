<?php

namespace Illustrator\Http;

trait RequestMethodTrait
{
	 /**
	  * obtiene el nombre del metodo
	  *
	  * @access protected
	  * @return string|null
	  */
	  
	 protected function getInputMethod()
	 {
	 	return isset($_POST['_method']) ? $_POST['_method'] : null;
	 }
	 
	 /**
	  * obtiene el metodo
	  *
	  * @access public 
	  * @return string
	  */
	  
	 public function getMethod()
	 {
	 	return $this->getVar('REQUEST_METHOD');
	 }
	 
	 /**
	  * @access public
	  * @return bool
	  */
	  
	 public function isPost()
	 {
	 	return $this->getMethod() === 'POST' && !$this->getInputMethod();
	 }
	 
	 /**
	  * @access public
	  * @return bool
	  */
	  
	 public function isGet()
	 {
	 	return $this->getMethod() === 'GET';
	 }
	 
	 /**
	  * @access public
	  * @return bool
	  */
	  
	 public function isPut()
	 {
	 	return $this->getInputMethod() === 'PUT';
	 }
	 
	 /**
	  * @access public
	  * @return bool
	  */
	  
	 public function isPatch()
	 {
	 	return $this->getInputMethod() === 'PATCH';
	 }
	 
	 /**
	  * @access public
	  * @return bool
	  */
	  
	 public function isDelete()
	 {
	 	return $this->getInputMethod() === 'DELETE';
	 }
	 
	 /**
	  * @access public
	  * @return bool
	  */
	  
	 public function isHead()
	 {
	 	return $this->getInputMethod() === 'HEAD';
	 }
	 
	 /**
	  * todos los metodos permitidos
	  *
	  * @access protected
	  * @return array
	  */
	  
	 public function getAllMethod()
	 {
	 	return ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];
	 }

	 /**
	  * @access public
	  * @return bool
	  */
	  
	 public function isOptions()
	 {
	 	return $this->getInputMethod() === 'OPTIONS';
	 }
}