<?php

namespace App\Http\Request;

use Illustrator\Contracts\Validator\RulesInterface;

class AuthRequest implements RulesInterface
{
	/**
	 * activa el validador
	 *
	 * @return bool
	 */
	 
	public function active()
	{
		return true;
	}
	
	/**
	 * metodo via get | post | put | patch
	 *
	 * @return string
	 */
	 
	public function requestMethod()
	{
		return 'get';
	}
	
	/**
	 * tipos de validaciones
	 * 
	 * @return array
	 */
	 
	public function rules()
	{
		return [
			'name' => 'required|min:5|max|15',
			'email' => 'required|valid|unique:table@column',
			'password' => 'required|min:6|max:15'
		];
	}
}