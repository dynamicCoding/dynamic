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
    protected $model;

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
        $this->model      = ILLUM_PATH . '/app/Models/';
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
     * @param string $with
     * @return string
     */
    public function help($with = '')
    {
        if ($with === '-m' || $with == 'model') {
            return <<<'HELPMODEL'

    usage model: [<filename>] | <options> [migrate | reverse | drop] [all | filename]

Generic options:
    filename            name model
    migrate             migrates tables
    reverse             reverses the changes of the table
    drop                deletes the table

Specific model actions:
    all                 you can migrate all tables as reverse and eliminate all tables
    filename            take some action when only the file name specified

HELPMODEL;

        } elseif ($with === '-c' || $with == 'controller') {
            return <<<'HELPCONTROLLER'

    usage controller:   [<optional> [plain]] <filename> [<optional> [...args]]

Optionals:
    plain               creates a controller without methods
    args                specifies the name of the method without using the option plain


HELPCONTROLLER;
        }

        return  <<<'HELP'

    usage help: <options> [controller | -c | model | -m]

Commands:
    help, -h            displays a list of options
    controller, -c      creates a controller
    middleware, -mdw    creates a middleware
    request, -req       creates a request
    model, -m           creates a modelo

HELP;
    }

    /**
     * @param string $n
     * @return string
     */
    public function noCommand($n)
    {
        if ($n == '') {
            return "type one of these options\r\n {$this->help()}";
        }
        return 'name command ['. $n .'] not exists'. "\r\n" . $this->help();
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