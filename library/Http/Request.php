<?php

namespace Illustrator\Http;

use Illustrator\Contracts\Http\HttpProtocoloInterface;
use Illustrator\Contracts\Http\RequestInterface;
use Illustrator\System\FileSystem;

class Request implements HttpProtocoloInterface, RequestInterface
{
	/**
	 * @var string
	 */
	 
	protected $withUri;
	
	/**
	 * @var array
	 */
	 
	protected $requestMethod = [];
	
	/**
	 * @var string
	 */
	 
	protected $attribute = [];
	
	/**
	 * @var FileSystem
	 */
	 
	protected $filesystem;
	
	/** 
	 * @var string protocol version 
	 */
	
	protected $minVersion = '1.0';
	
	/**
	 * @var string
	 */
	 
	protected $maxVersion;
	
	use GetDataServer;

	/**
	 * @param FileSystem $fileSystem
     */

	public function __construct(FileSystem $fileSystem)
	{
		$this->filesystem = $fileSystem;
	}
	
	/**
	 * @param string $method
	 */
	 
	public function withMethod($method)
	{
		$this->requestMethod[] = $method;
	}
	
	public function execMethod($method)
	{
		$this->requestMethod = $method;
	}
	
	/**
	 * @param string $uri
	 */
	 
	public function withUri($uri)
	{
		$this->withUri = $uri;
	}
	
	/**
	 * @param string $target
	 */
	 
	public function withRequestTarget($target)
	{
		
	}
	
	/**
	 * @param string $attr
	 * @param string $value
	 */
	 
	public function withAttribute($attr, $value)
	{
		$this->attribute[$attr] = $value;
	}
	
	/**
	 * @return string
	 */
	 
	public function getWithMethod()
	{
		return $this->requestMethod;
	}
	
	/**
	 * @return string
	 */
	 
	public function getUri()
	{
		return $this->withUri;
	}
	
	public function getRequestTarget()
	{
		
	}
	
	public function getAttribute()
	{
		
	}
	
	public function permissionMethod($permission = null, $all = false)
	{
		
	}
	
	public function getPermission()
	{
		return;
	}
	
	/**
	 * {@inheritDoc}
	 */
	
	public function protocol($protocol = 'HTTP')
	{
		
	}
	
	/**
	 * {@inheritDoc}
	 */
	
	public function minorVersion($minor) 
	{
		$this->minVersion = $minor;
	}

	/**
	 * {@inheritDoc}
	 */
	
	public function majorVersion($major) 
	{
		$this->maxVersion = $major;
	}
	
	public function getMinorVersion() 
	{
		return $this->minVersion;
	}

	/**
	 * {@inheritDoc}
	 */
	
	public function getMajorVersion() 
	{
		return $this->maxVersion;
	}

	/**
	 * {@inheritDoc} 
	 */
	
	public function getVersion() 
	{
		if($this->minVersion < $this->maxVersion){
			return (float)$this->maxVersion;
		}
		return (float)$this->minVersion;
	}
	
	public function determinePath()
	{
		
	}
	
	public function isMethod()
	{
		
	}

	/**
	 * {@inheritDoc}
	 */
	 
	public function setError($error) 
	{
		
	}

	/**
	 * {@inheritDoc}
	 */
	 
	public function getError() 
	{

	}
	
	public function getResponse()
	{
		
	}
	
	/**
	 * @return FileSystem
	 */
	 
	public function getFilesystem()
	{
		return $this->filesystem;
	}
}