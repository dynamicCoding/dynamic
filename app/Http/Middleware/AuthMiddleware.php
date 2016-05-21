<?php

namespace App\Http\Middleware;

class AuthMiddleware
{
	/**
	 * @access public
	 * @param Request $request
	 * @param Response $response
	 * @param callable $next
	 * @return
	 */
	 
	public function handle($request, $response, $next)
	{
		if(!$request->body('csrf_tk')){
			$response->redirect("/");
		}
		return $next($request, $response);
	}
}