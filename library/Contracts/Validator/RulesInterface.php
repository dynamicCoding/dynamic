<?php

namespace Illustrator\Contracts\Validation;

interface RulesInterface
{
	/**
	 * metodo de implementacion para los validadores
	 * esta metodo activa oh desactiva el validador
	 *
	 * @return bool 
	 */
	 
	public function active();
	
	/**
	 * especifica el tipo de metodo enviado ya se por GET | POST
	 *
	 * @return string 
	 */
	 
	public function requestMethod();
	
	/**
	 * implementa los tipos de validador que especificando en los keys
	 * los nombres que vienen por $_POST | $_GETy las claves los validadores
	 *
	 * @return array
	 */
	 
	public function rules();
}