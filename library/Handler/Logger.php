<?php

namespace Illustrator\Handler;

use Illustrator\Handler\Exceptions\ReportErrorHandler;

class Logger implements LoggerInterface
{
    /**
     * @var null
     */

    protected static $instance = null;

    /**
     * @var bool
     */

    protected $debug;

    /**
     * @var string
     */

    protected $logPath;

    /**
     * @var array
     */

    protected static $code = [
        1 => E_USER_ERROR,
        2 => E_USER_WARNING,
        3 => E_USER_DEPRECATED,
    ];

    /**
     * @var array
     */

    protected static $is = [
        1 => 'error',
        2 => 'warning',
        3 => 'deprecated'
    ];

    /**
     * @param bool $debug
     */

    public function __construct($debug, $log)
    {
        $this->debug = $debug;
        $this->logPath = $log;
    }

    /**
     * @param bool $debug
     * @return Logger|null
     */

    public static function instance($debug, $log)
    {
        if(self::$instance === null){
            self::$instance = new self($debug, $log);
        }
        return self::$instance;
    }

    /**
     * generar un error y pasar que typo de error es el cometido
     *
     * @param string $msg
     * @param int $level
     */

    public static function errors($msg, $level = self::ERROR)
	{
		if(isset(self::$code[$level])){
            trigger_error(vsprintf("{msg @%s@}~{type_error @%s@}", [$msg, self::$is[$level]]), self::$code[$level]);
        }
	}

    /**
     * convierte un error un excepcion para el manejador de excepciones
     *
     * @throws ReportErrorHandler
     */

	public function handlerErrors()
	{
		set_error_handler(function($code, $msg, $file, $line){
			if((error_reporting() & $code) !== 0){
				throw new ReportErrorHandler($msg, $code, 0, $file, $line);
				exit;
			}
			return $code === 0 ? error_log("[{date('Y-m-d H:i:s')}] {$msg}",3, $this->logPath.'errors.log') & true : 0;
		});
	}

    /**
     * envia una vista los errores que se han cometido oh un throw
     */

	public function handlerExceptions()
	{
		set_exception_handler(array(new Handler($this->debug, $this->logPath), 'initialize'));
	}
	
	public function restoreErrors()
	{
		restore_error_handler();
	}
}