<?php

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 02/07/2016
 * Time: 20:34
 */

class Core
{
    private $kernel = array(
        "Errors", "Access", "Controller", "Database", "Relationships", "Alias",
        "Settings", "Template", "View", "Session", "Security", "Log", "Saved"
    );
    private $util = array(
        "Criteria", "Language", "Pager", "Cookies", "ValidatePost", "Post"
    );

    private $controller = null;
    private $method = null;

    public function __construct()
    {
        $this->importKernelUtil();
        $this->declareVars();

        $this->controller = mb_strtolower(trim($_GET['controller']));
        $this->method = mb_strtolower(trim($_GET['method']));

        if($this->defineAccess())
            $this->callLink();
        else
            Errors::display("Acesso Negado!");
    }

    private function disableUtil()
    {
        $disable = Settings::get('disableUtil');
        if(is_array($disable))
        {
            foreach ($disable as $value)
                if (in_array($value, $this->util))
                    unset($this->util[array_search($value, $this->util)]);
        }
        else
            if(in_array($disable, $this->util))
                unset($this->util[array_search($disable, $this->util)]);
    }

    private function importKernelUtil()
    {
        foreach($this->kernel as $value)
            require_once "kernel/" . "{$value}.php";

        require_once "alias.php";
        require_once "kernel/" . "dispenser.php";

        Session::create();
        require_once "setups.php";
        Security::errors();
        require_once "relations.php";
        $this->disableUtil();

        foreach($this->util as $value)
            require_once "util/" . "{$value}.php";

        require_once "utils.php";
    }

    private function declareVars()
    {
        $path = dirname($_SERVER["SCRIPT_NAME"]);
        if ($path === '/')
            $path = '';
        define('DOMAIN', $path);
        Session::set('initFramework', true);

        $_GET['controller'] = (isset($_GET['controller'])) ? $_GET['controller'] : Settings::get('initialController');
        $_GET['method'] = (isset($_GET['method'])) ? $_GET['method'] : Settings::get('initialMethod');
    }

    private function defineAccess()
    {
        if(!Session::check())
            return false;
        else if(Access::checkPublic($this->controller, $this->method))
            return true;
        else if(Session::get(Settings::get("userIndentifier")) !== false)
            if(Access::checkPrivate(Session::get(Settings::get("userIndentifier")), $this->controller, $this->method))
                return true;
        return false;
    }

    private function callLink()
    {
        $alias = Alias::check($this->controller);
        if($alias != false)
        {
            $_GET['controller'] = $model = explode('/', $alias)[0];
            $_GET['method'] = $this->method = explode('/', $alias)[1];

            $this->controller = $model."Controller";
        }
        else
        {
            $model = $this->controller;
            $this->controller .= "Controller";
        }

        if(file_exists("controller/{$this->controller}.php"))
        {
            $rel = Relationships::get($model);

            if(is_array($rel))
                foreach ($rel as $value)
                    require_once "model/" . "{$value}.php";
            else if(!empty($rel))
                require_once "model/" . "{$rel}.php";

            if(file_exists("model/{$model}.php"))
                require_once "model/" . "{$model}.php";

            require_once "controller" . "/{$this->controller}.php";
            $instance = new $this->controller();

            if(count($_POST))
            {
                Saved::create();
                $this->method = "{$this->method}Posted";
            }
            else
                $this->method = "{$this->method}Deed";

            if(method_exists($instance, $this->method))
                $instance->{$this->method}();
            else
                Errors::display("Página não encontrada");
        }
        else
            Errors::display("Página não encontrada");
    }
}
