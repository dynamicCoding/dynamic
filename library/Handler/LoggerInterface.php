<?php

namespace Illustrator\Handler;


interface LoggerInterface
{
	/**
		las constantes tienen el nivel de error que se ejecutara
	*/
	
	const ERROR = 1;
	
	const WARNING = 2;
	
	const DEPRECATED = 3;
}