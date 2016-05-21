<?php

namespace Illustrator\Contracts\Http;

interface HttpErrorInterface
{
	public function setError($error);
	
	public function getError();
}