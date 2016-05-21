<?php

namespace Illustrator\Contracts\Http;

interface HttpProtocoloInterface extends HttpErrorInterface
{
	public function protocol($protocol = 'HTTP');
	
	public function minorVersion($minor);
	
	public function majorVersion($major);
	
	public function getVersion();
	
	public function getVersionProtocol();
}