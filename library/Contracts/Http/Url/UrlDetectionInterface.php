<?php

namespace Illustrator\Contracts\Http\Url;

interface UrlDetectionInterface
{
    public function getQueryString();

    /**
     * obtiene el http oh https
     */

    public function getHttpScheme();

    /**
     * obtener los key de $_SERVER
     */


    public function getHeaders($key);
}