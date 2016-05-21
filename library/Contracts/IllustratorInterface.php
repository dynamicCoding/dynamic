<?php

namespace Illustrator\Contracts;

interface IllustratorInterface
{
    /**
     * @param string $uri
     * @param callable|string $obj
     * @return mixed
     */

    public function get($uri,$obj);

    /**
     * @param string $uri
     * @param callable|string $obj
     * @return mixed
     */

    public function post($uri,$obj);

    /**
     * @param string $uri
     * @param callable|string $obj
     * @return mixed
     */

    public function put($uri,$obj);

    /**
     * @param string $uri
     * @param callable|string $obj
     * @return mixed
     */

    public function patch($uri,$obj);

    /**
     * @param string $uri
     * @param callable|string $obj
     * @return mixed
     */

    public function delete($uri,$obj);

    /**
     * @param string $uri
     * @param callable|string $obj
     * @return mixed
     */

    public function head($uri,$obj);

    /**
     * @param string $uri
     * @param callable|string $obj
     * @return mixed
     */

    public function options($uri,$obj);
}