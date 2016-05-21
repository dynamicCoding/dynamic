<?php

namespace Illustrator\Contracts\Http;

interface ResponseInterface
{
    /**
     * @param $code
     */

    public function setStatus($code);

    /**
     * @param $type
     */

    public function type($type);

    /**
     * @param $charset
     */

    public function charset($charset);

    /**
     * @param $name
     * @param $value
     */

    public function header($name, $value);

    /**
     * @param $name
     * @param $value
     * @param null $time
     * @param array $options
     */

    public function signedCookie($name, $value, $time = null,$options = []);

    /**
     * @param $value
     * @param array $options
     */

    public function deleteCookie($value, $options = []);

    /**
     * @param ViewInterface $view
     */

    public function body($view);

    /**
     * @param string $location
     */

    public function redirect($location);

    /**
     * @param int $status
     */

    public function back($status = 302);

    /**
     * @return mixed
     */

    public function sendHeaders();

    /**
     * @param array|string $data
     */

    public function rawData($data);

    /**
     * @return void
     */

    public function send();

    /**
     * @return int
     */

    public function getStatus();

    /**
     * @return string
     */

    public function getMessage();

    /**
     * @return string
     */

    public function getCharset();

    /**
     * @return string
     */

    public function getType();
}