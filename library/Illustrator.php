<?php

namespace Illustrator;

/**
 * Class Illustrator
 *
 * @author Nike Madrid
 * @copyright Nike Madrid
 */

use Illustrator\Contracts\IllustratorInterface;
use Illustrator\Routing\Dispatcher;
use Illustrator\Routing\Route;
use Illustrator\Http\Request;
use Illustrator\Http\Response;
use Illustrator\System\FileSystem;
use Illustrator\View\ViewFactory;
use View\View;

class Illustrator implements IllustratorInterface
{
	/**
	* @var null
	*/

	protected static $instance = null;

	/**
	* @var string directorio principal
	*/

	protected $path;

	/**
	* @var string configuracion de la app
	*/

	protected $config;

	/**
	* @var bool muestra una pagina ee error en modo de debugger oh no
	*/

	protected $debug;

	/**
	* @var bool activar o desactivar errores en modo production oh development
	*/

	protected $displayErrors = true;

	/**
	 * @var array
	 */

	protected $group = [];

	/**
	 * @var string
	 */

	protected $resources;

	/**
	 * @var Route
	 */

	protected $route;

	/**
	 * @var null
	 */

	protected $setParameters;

	/**
	 * @var Config
	 */

	protected $container;

	/**
	* @param string $dir directory path
	* @param string $ini file Eva Antonyia
	*/

	public function __construct($dir, $config)
	{
		$this->path = $dir;

		$this->config = $dir . '/' . static::normalize($config);

		$this->configApplication();
	}

	/**
	* @param string $dir
	* @param string $ini
	* @return Illustrator|null
	*/

	public static function start($dir, $ini)
	{
		if(self::$instance === null){
			self::$instance = new self($dir, $ini);
		}
		return self::$instance;
	}

	/**
	* normaliza un directorio
	* @param string $str
	* @return string
	*/

	private static function normalize($str)
	{
		return str_replace('.', '/', $str);
	}

	/**
	* activa o desactiva los handler errors
	*
	* @param Logger $class
	*/

	public function handler($class)
	{
		if(!($class instanceof LoggerInterface)){
			$logger = $class::instance($this->debug, static::normalize($this->config['log']));
			$logger->handlerErrors();
			$logger->handlerExceptions();
			if($this->displayErrors === false){
				$logger->restoreErrors();
			}
		}

		return $this;
	}

	/**
	* configurar la aplicacion
	*/

	protected function configApplication()
	{
		$c = include $this->config . '.php';

		$this->debug = (bool) $c['debug'];

		switch($c['env']){
			case 'production':
				ini_set('display_errors', true);
				break;
			case 'development':
				ini_set('display_errors', false);

				$this->displayErrors = false;
				break;
		}

		ini_set('date.timezone', $c['timezone']);

		$this->config = $c;
	}

	/**
	 * @access public
	 * @param string $uri
	 * @param callable|string $obj
 	 * @return mixed
	 */
	 
	public function group(array $group, callable $func)
	{
		$this->group = $group;
		
		call_user_func($func, $this);
	}
	
	/**
	 * @access public
	 * @param string $uri
	 * @param callable|string $obj
 	 * @return mixed
	 */
	 
	public function resources($uri, $obj)
	{
		$this->resources = $uri;
		
		call_user_func($obj, $this);
	}
	
	/**
	 * @access public
	 * @param string $uri
	 * @param callable|string $obj
	 * @param  null|string $name
	 * @return mixed
	 */
	 
	public function get($uri, $obj, $name = null)
	{
		$this->sendingRoute('get', $uri, $obj, $name);

		return $this;
	}

	/**
	 * @access public
	 * @param string $uri
	 * @param callable|string $obj
	 * @param  null|string $name
	 * @return mixed
	 */
	 
	public function post($uri, $obj, $name = null)
	{
		$this->sendingRoute('post', $uri, $obj, $name);

		return $this;
	}

	/**
	 * @access public
	 * @param string $uri
	 * @param callable|string $obj
	 * @param  null|string $name
	 * @return mixed
	 */
	 
	public function put($uri, $obj, $name = null)
	{
		$this->sendingRoute('put', $uri, $obj, $name);

		return $this;
	}

	/**
	 * @access public
	 * @param string $uri
	 * @param callable|string $obj
	 * @param  null|string $name
	 * @return mixed
	 */
	 
	public function patch($uri, $obj, $name = null)
	{
		$this->sendingRoute('patch', $uri, $obj, $name);

		return $this;
	}

	/**
	 * @access public
	 * @param string $uri
	 * @param callable|string $obj
	 * @param  null|string $name
	 * @return mixed
	 */
	 
	public function delete($uri, $obj, $name = null)
	{
		$this->sendingRoute('delete', $uri, $obj, $name);

		return $this;
	}

	/**
	 * @access public
	 * @param string $uri
	 * @param callable|string $obj
	 * @param  null|string $name
	 * @return mixed
	 */
	 
	public function head($uri, $obj, $name = null)
	{
		$this->sendingRoute('head', $uri, $obj, $name);

		return $this;
	}

	/**
	 * @access public
	 * @param string $uri
	 * @param callable|string $obj
	 * @param  null|string $name
 	 * @return mixed
	 */
	 
	public function options($uri, $obj, $name = null)
	{
		$this->sendingRoute('options', $uri, $obj, $name);

		return $this;
	}

	/**
	 * recibe el tipo de peticion que se ah solicitado
	 *
	 * @access public
	 * @param string $uri
	 * @param callable|string $obj
	 * @param  null|string $name
 	 * @return mixed
	 */
	 
	protected function sendingRoute($method, $uri, $obj, $name = null)
	{
		$defined_uri = function() use($uri){
				if(isset($this->resources)){
					$uri = $this->resources.$uri;
				}
				return $uri;
		};
		$this->route[] = (new Route($method, $defined_uri(), $obj, $name))->matchPattern();
	}

	/**
	 * @return mixed
     */

	protected function appRoute()
	{
		$route = function($route){
			$f = $this->path . '/' . self::normalize($this->config['route']).'.php';
			if(!file_exists($f))
				throw new \RuntimeException("archivo de ruta no encontrado {$f}");
			include $f;
		};
		return $route($this);
	}

	/**
	 * @access public
	 * @return Config
	 */

	public function container()
	{
		if(!isset($this->container) || empty($this->container)){
			$this->container = new Config();
		}
		return $this->container;
	}

	/**
	 * @access protected
	 * @return Config
	 */

	protected function registerApp()
	{
		$config = $this->container();

		$config->register('container', $config);

		$config->register('viewConfig', $this->getView());

		$path = $config['viewConfig'];

		$config->register('view', View::class, [$path['view'], $path['options']]);

		$config->register('filesystem', FileSystem::class);

		$config->register('request', Request::class, $config['filesystem']);

		$config->register('response', Response::class, $config['request']);

		return $config;
	}

	/**
	 * @access public
	 * @return mixed
	 */
	public function run()
	{
		$this->appRoute();

		$config = $this->registerApp();

		return (new Dispatcher(
			$config['request'],
			$config['response'],
			$config
		))->namespaced($this->group)->send($this->route); 
	}
	 	
	/**
	 * @access public
 	 * @return array
	 */
	 
	public function getView()
	{
		return include $this->getPath() . '/config/view.php';
	}
	
	/**
	 * @access public
 	 * @return array Route
	 */
	 
	public function getRoute()
	{
		return $this->route;
	}
	
	/**
	 * @access public
 	 * @return array
	 */
	 
	public function getConfigApp()
	{
		return $this->config;
	}
	 	
	/**
	 * @access public
 	 * @return string
	 */
	 
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * @access public
	 * @return Config
	 */

	public function getContainer()
	{
		return $this->container;
	}
}