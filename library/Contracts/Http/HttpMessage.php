<?php

namespace Illustrator\Contracts\Http;

interface HttpMessage
{
	public function withHeader($key, $msg);
	
	public function withAddedHeader($key, $msg);
	
	public function getHeaderLine($key);
	
	public function withStatus($code, $reasonPrased = null);
	
	public function getStatusCode();
	
	public function getReason();
} 