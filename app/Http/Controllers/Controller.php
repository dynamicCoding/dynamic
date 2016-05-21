<?php

namespace App\Http\Controllers;


abstract class Controller
{
    /**
     * @var \View\View
     */

    protected $view;

    /**
     * @var \Illustrator\Http\Request
     */

    protected $request;

    /**
     * @var \Illustrator\Http\Response
     */

    protected $response;

    /**
     * @var \Illustrator\Config
     */

    protected $container;

    /**
     * @param View $view
     * @param Request $request
     * @param Response $response
     * @param Config $container
     */
    public function __construct($view, $request, $response, $container)
    {
        $this->view = $view;

        $this->request = $request;

        $this->response = $response;

        $this->container = $container;
    }
}