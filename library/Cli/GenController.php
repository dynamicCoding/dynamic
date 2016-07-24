<?php

namespace Illustrator\Cli;


use Exception;

trait GenController
{

    protected $filename;

    /**
     * @param array $args
     * @return $this
     */
    public function createController($args = [])
    {
        $this->{'prepare' . ucwords(array_shift($args))}(array_shift($args));
        
        return $this;
    }

    /**
     * @param string $filename
     * @throws Exception
     */
    public function prepareDefault($filename)
    {
        $genC = $this->replace(
            file_get_contents($this->dirGenerator . 'controller.g'),
            $filename
        );

        $filename = $this->controller . $this->name($filename);

        if (!$this->putContent($filename, $genC)) {
            throw new Exception('Error to creating controller');
        }

        $this->msg($filename);
    }

    /**
     * @param array $add
     * @throws Exception
     */
    public function prepareAdd($add = [])
    {
        $plain = $this->dirGenerator . 'controller_plain.g';

        $genC = file_get_contents($plain, false, null, 0, (filesize($plain) - 1));

        $filename = array_shift($add);

        $relativePath = $this->controller  . $this->name($filename);

        $strClass = $this->replace($genC, $filename);

        foreach ($add as $method) {
            $strClass .= <<<EOF_METHODS
    public function {$method}()
    {

    }\r\n

EOF_METHODS;

        }

        $strClass .= '}';

        if (!$this->putContent($relativePath, $strClass)) {
            throw new Exception('Error to creating controller');
        }

        $this->msg($relativePath);
    }

    /**
     * @param $filename
     * @throws Exception
     */
    public function preparePlain($filename)
    {
        $genC = $this->replace(
            file_get_contents($this->dirGenerator . 'controller_plain.g'),
            $filename
        );

        $filename = $this->controller . $this->name($filename);

        if (!$this->putContent($filename, $genC)) {
            throw new Exception('Error to creating controller');
        }

        $this->msg($filename);
    }

    /**
     * @param string $filename
     * @return string
     */
    public function name($filename)
    {
        $this->filename = $filename;

        return str_ireplace('controller', '', ucwords($filename)) . 'Controller.php';
    }

    /**
     * @param $f
     */
    public function msg($f)
    {
        echo 'file created ' . strstr($f, '/') . "\r\n";
    }

    public function genOther()
    {
        $sf = $this->filename;
        $sd = $this->view . '/' . $sf;

        if (!is_dir($sd)) {
            mkdir($sd, 0777);
        }

        while (true) {
            if (is_dir($sd)) {
                break;
            }
        }

        $crea = $sd . '/' . $sf . '.redis.php';

        if ($this->putContent($crea, ' ') == false) {
            throw new Exception('Error to creating view');
        }

        $this->msg($crea);
    }
}