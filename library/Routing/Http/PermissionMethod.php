<?php

namespace Illustrator\Routing\Http;

use Illustrator\Handler\Exceptions\HttpMethodNotAllowed;
use Illustrator\Http\Request;

final class PermissionMethod
{
	/**
	 * via o metodo que se a enviado
	 *
	 * @access public
	 * @param Request $request
	 * @param string|closure $closure
	 * @param array $access almacena datos
	 * @param array $error sirve para almacenar un error
	 * @throw HttpMethodNotAllowed
	 * @return string|closure
	 */
	 
	public function via(Request $request, $closure, $args,$access = [], $error = [])
	{
		if($methods = $request->getWithMethod()){
			$x = 0;
			foreach($methods as $index => $method){
				$call = $closure[$x];
				if(in_array($method, $request->getAllMethod()) && count($methods) > 1){
					//var_dump($methods);
				} 
				switch($method){
					case 'GET': 
						if($request->isGet()){
							$closure = [$call, $args[$x]];
							$request->execMethod($method);
						}
						$access = ['method' => $method, 'uri' => $request->getUri()];
						break;
					case 'POST':
						if($request->isPost()){
							$closure = [$call, $args[$x]];
							$request->execMethod($method);
						}
						
						if(empty($access) && !$request->isPost()){
							$error[] = $method;
						}
						break;
					case 'PUT':
						if($request->isPut()){	
							$closure = [$call, $args[$x]];
							$request->execMethod($method);
						}
						
						if(empty($access) && !$request->isPut()){
							$error[] = $method;
						}
						break;
					case 'PATCH':
						if($request->isPatch()){
							$closure = [$call, $args[$x]];
							$request->execMethod($method);
						}
						
						if(empty($access) && !$request->isPatch()){
							$error[] = $method;
						}
						break;
					case 'DELETE':
						if($request->isDelete()){
							$closure = [$call, $args[$x]];
							$request->execMethod($method);
						}
						
						if(empty($access) && !$request->isDelete()){
							$error[] = $method;
						}
						break;
					case 'HEAD': 
						if($request->isHead()){
							$closure = [$call, $args[$x]];
							$request->execMethod($method);
						}
						
						if(empty($access) && !$request->isHead()){
							$error[] = $method;
						}
						break;
					case 'OPTIONS':
						if($request->isOptions()){
							
						}
						break;
				}
				$x++;
			}
			
			if(!empty($error)){
				throw new HttpMethodNotAllowed(vsprintf("metodo no permitido [%s]",$error));
			}

			return $closure;
		}
		return null;
	}
}