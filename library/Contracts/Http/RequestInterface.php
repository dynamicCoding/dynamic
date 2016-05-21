<?php

namespace Illustrator\Contracts\Http;

interface RequestInterface
{
    public function determinePath();

    public function isGet();

    public function isPost();

    public function isMethod();

    //public function getParsedBody();

    //public function requestMethodPermission();

    //public function getBody();

    public function getPermission();

    public function getResponse();

    public function getFilesystem();
}