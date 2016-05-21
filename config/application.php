<?php

return [

	/**
		clave de la aplicacion para iniciar
	*/
	
	'app_key' => config('app.app_key'),
	
	/**
		si la app esta en modo produccion o enviroment
	*/
	
	'env' => config('app.app_env'),
	
	/**
		depurar envia los errores de la app que se han cometido
	*/
	
	'debug' => config('app.app_debug'),
	
	/**
		idioma de la aplicacion
	*/
	
	'locale' => 'es',
	
	/**
		url del servidor
	*/
	
	'url' => 'http://localhost',
	
	/**
		zona horaria || GMT
	*/
	
	'timezone' => 'America/Bogota',

	/**
	  charset lang
	 */

	'charset' => 'UTF-8',

	/**
		ruta del log
	 */
	
	'log' => config('app_path.log'),

	/**
		route app
	 */
	
	'route' => config('app_path.route'),
	
	/**
		servicio para optimizar tipeo del usuario
	*/
	
	'providers' => [
		
	],
	
	/**
		los middleware
	*/
	
	'middleware' => [
		\App\Http\Middleware\AuthMiddleware::class
	]
];