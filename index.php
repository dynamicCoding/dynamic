<?php

use Illustrator\Illustrator;

/**
 * incluir eutoload
 */
 
 
include 'app/start.php';


/**
 *
 *	psa como parametro el directorio root y la configuracion
 *
 */
 
$app = Illustrator::start(ILLUM_PATH, 'config.application');

/**
 *
 *	inicia el handle error de la aplicacion 
 *
 */

$app->handler(
	\Illustrator\Handler\Logger::class
)->run();