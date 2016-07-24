<?php

namespace Illustrator\Cli;

class Generator
{
    use GenController, GenModel;

    /**
     * @var string
     */
    protected $dirGenerator;

    /**
     * @var string
     */
    protected $controller;

    /**
     * @var string
     */
    protected $middleware;

    /**
     * @var string
     */
    protected $request;

    /**
     * @var string
     */
    private $typeGen;

    /**
     * @var string
     */
    private $view;

    /**
     * @var string
     */
    private $css;

    /**
     * @var string
     */
    private $js;

    /**
     * @param $typeGen
     */
    public function __construct($typeGen)
    {
        $this->typeGen      = $typeGen;
        $this->dirGenerator = dirname(__FILE__) . '/gen/';

    }

    /**
     * default directories
     */
    public function defaultPaths()
    {
        $this->view = config('app_path.view');
        $this->css  = config('app_path.css');
        $this->js   = config('app_path.js');

        $this->controller = ILLUM_PATH . '/app/Http/Controllers/';
        $this->middleware = ILLUM_PATH . '/app/Http/Middleware/';
        $this->request    = ILLUM_PATH . '/app/Http/Request/';
    }

    /**
     * @return bool
     */
    public function isGenController()
    {
        return 'controller' == $this->typeGen || '-c' == $this->typeGen;
    }

    /**
     * @return bool
     */
    public function isGenMiddleware()
    {
        return 'middleware' == $this->typeGen || '-mdw' == $this->typeGen;
    }

    /**
     * @return bool
     */
    public function isGenRequest()
    {
        return 'request' == $this->typeGen || '-req' == $this->typeGen;
    }

    /**
     * @return bool
     */
    public function isGenHelp()
    {
        return 'help' == $this->typeGen || '-h' == $this->typeGen;
    }

    /**
     * @return bool
     */
    public function isGenModel()
    {
        return 'model' == $this->typeGen || '-m' == $this->typeGen;
    }

    /**
     * @param string $str
     * @param string $class
     * @return mixed
     */
    public function replace($str, $class)
    {
        return str_replace('{nameClass}', $class, $str);
    }

    /**
     * @param string $f
     * @param string $c
     * @return int
     */
    public function putContent($f, $c)
    {
        return file_put_contents($f, $c);
    }

    /**
     * @return string
     */
    public function help()
    {
        return  <<<'HELP'
    comandos de ayuda

    help, -h            despliega una lista de opciones
    controller, -c      controlador
    middleware, -mdw    middleware
    request, -req       request
    model, -m [         modelo
        options
        -------

        migrate[
            all,        migra todas las tablas
            name table  migra una tabla especifica
        ],
        reverse[
            all,        reviertre todo los cambios
            name table  revierte cambio
        ],
        drop[
            name table  elimina la tabla especificada
        ]
    ]

HELP;
    }

    /**
     * @param mixed $controller
     */
    public function setPathController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @param mixed $middleware
     */
    public function setPathMiddleware($middleware)
    {
        $this->middleware = $middleware;
    }

    /**
     * @param mixed $request
     */
    public function setPathRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @param string $view
     */
    public function setPathView($view)
    {
        $this->view = $view;
    }

    /**
     * @param string $css
     */
    public function setPathCss($css)
    {
        $this->css = $css;
    }

    /**
     * @param string $js
     */
    public function setPathJs($js)
    {
        $this->js = $js;
    }

    /**
     * @param $obtain
     * @param $filename
     * @throws Exception
     */
    public function create($obtain, $filename)
    {
        $g = $this->{'getContent' . $obtain}();
        $rf = $g[0] . str_ireplace($obtain, '', ucwords($filename)) . $obtain . '.php';
        $cf = $g[1];

        $rplc = $this->replace($cf, ucwords($filename) . $obtain);

        if ($this->putContent($rf, $rplc) == false) {
            throw new Exception('Error to creating middleware');
        }

        $this->msg($rf);
    }

    /**
     * @return array
     */
    public function getContentMiddleware()
    {
        return [$this->middleware, file_get_contents($this->dirGenerator . 'middleware.g')];
    }

    /**
     * @return array
     */
    public function getContentRequest()
    {
        return [$this->request, file_get_contents($this->dirGenerator . 'request.g')];
    }
}