<?php

namespace Illustrator\Handler;

use Exception;
use Illustrator\Handler\Exceptions\HttpMethodNotAllowed;

final class Handler
{
    /**
     * @var bool
     */

    protected $showError;

    /**
     * @var string path log
     */

    protected $log;

    /**
     * @param bool $debug
     * @param string $log
     */

    public function __construct($debug, $log)
    {
        $this->showError = $debug;
        $this->log = $log;
    }

    /**
     * @param Exception $e
     */

    public function initialize(Exception $e = null)
	{
        $title = '';
        $date = date('Y-m-d H:i:s');
        $type_handler = '['.get_class($e).']';
        $code = $e->getCode();
		$msg = $e->getMessage();
        $file = $e->getFile();
        $line = $e->getLine();
        $trace = $trace = str_replace(['#', "\n"], ['<div>#', '</div>'], $e->getTraceAsString());

        if(strstr($msg, '{') || strpos($msg, '{') !== false){
            $title = 'error en la aplicacion';
            if(preg_match_all('/\@([0-9a-zA-Z_\s\@]+)/i', $msg, $values, PREG_PATTERN_ORDER)){
                $get = array_shift($values);
                $msg = "<b>[{$this->replace($get[1], '@')}]</b> " . $this->replace($get[0], '@');

            }
        }

        $send = '500 Internal Server Error';

        if($e instanceof HttpMethodNotAllowed){
            $title = 'metodo no permitido';
            $send = '405 Method Not Allowed';
            if(preg_match('/((.*)?\s\[(.*)?\])/', $msg, $m)){
           	    $type_handler .= '<span class="method"> ['.array_pop($m).']</span>';
           	    $msg = array_pop($m);
            }
        }

        ob_start();
            extract([
                'code' => $code,
                'msg' => $msg,
                'file' => $file,
                'line' => $line,
                'trace' => $trace,
                'title' => $title,
                'type_handler' => $type_handler,
                'show' => $this->showError
            ]);
            include __DIR__."/template_error.php";
            $content = ob_get_contents();
        ob_end_clean();

        if(!headers_sent())
            header("HTTP/1.1 ".$send);

        echo $content;

        $logMsg = "[{$date}] {$msg}, file: {$file}, line: {$line}, status: $send\n";

        error_log($logMsg, 3, $this->log.'errors.log');
	}

    /**
     * reemplaza caracteres que se envia en un error
     *
     * @param string $str
     * @param string $rpl
     * @return mixed
     */

    private function replace($str, $rpl)
    {
        return str_replace($rpl, '', $str);
    }
}