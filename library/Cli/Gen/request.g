<?php

namespace App\Http\Middleware;

namespace Illustrator\Contracts\Validator

class {nameClass} implements
{
	/**
	 * metodo de implementacion para los validadores
	 * esta metodo activa oh desactiva el validador
	 *
	 * @return bool
	 */

	public function active()
	{
	    return false;
	}

	/**
	 * especifica el tipo de metodo enviado ya se por GET | POST
	 *
	 * @return string
	 */

	public function requestMethod()
	{
	    return 'post';
	}

	/**
	 * implementa los tipos de validador que especificando en los keys
	 * los nombres que vienen por $_POST | $_GET y las claves los validadores
	 *
	 * @return array
	 */

	public function rules()
	{
	    return [

	    ];
	}
}