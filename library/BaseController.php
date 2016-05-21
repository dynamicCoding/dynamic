<?php

namespace Illustrator;


use Illustrator\Http\Request;
use Illustrator\Http\Response;
use Illustrator\System\FileSystem;
use Illustrator\View\ViewFactory;

abstract class BaseController extends Application
{
    public function __construct()
    {
        $this['filesystem'] = function($c){
            return new FileSystem();
        };

        $this['view'] = function($c){



            return new ViewFactory();
        };


        $this['request'] = function($c){
            return new Request($this['filesystem']);
        };


        $this['response'] = function($c){
            return new Response($this['request']);
        };
    }
}