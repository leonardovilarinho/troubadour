<?php

namespace Llab\Troubadour;

use Llab\Troubadour\Control\Errors;
use Llab\Troubadour\Collections\Session;
use Llab\Troubadour\Collections\Settings;
use Llab\Troubadour\Development\Security;
use Llab\Troubadour\Routes\Alias;
use Llab\Troubadour\Routes\Access;
use Llab\Troubadour\Collections\Saved;

/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 02/07/2016
 * Time: 20:34
 */

class Core
{
    private $controller = null;
    private $method = null;

    public function __construct()
    {
        if(!defined("DOMAIN")) {
            $path = dirname($_SERVER["SCRIPT_NAME"]);
            $path = str_replace('/public', '', $path);
            if ($path === '/')
                $path = '';
            define('DOMAIN', $path);
        }

        $this->importKernelUtil();
        $this->declareVars();

        $this->controller = ucfirst(mb_strtolower(trim($_GET['controller'])));
        $this->method = mb_strtolower(trim($_GET['method']));

        if($this->defineAccess())
            $this->callLink();
        //else
          //  Errors::display("Acesso Negado!");
    }

    private function importKernelUtil()
    {

        require_once __DIR__."/../../../settings/alias.php";
        require_once __DIR__ . "/dispenser.php";

        Session::create();
        require_once __DIR__."/../../../settings/setups.php";

        if(Settings::get('deployment'))
            require_once __DIR__."/../../../settings/database.php";

        Security::errors();
        require_once __DIR__."/../../../settings/utils.php";

        require_once __DIR__."/../../../settings/access.php";
    }

    private function declareVars()
    {
        Session::set('initFramework', true);

        $_GET['controller'] = (isset($_GET['controller'])) ? $_GET['controller'] : Settings::get('initialController');
        $_GET['method'] = (isset($_GET['method'])) ? $_GET['method'] : Settings::get('initialMethod');
    }

    private function defineAccess()
    {
        $alias = Alias::check($this->controller);
        if($alias != false) {
            $explode = explode('/', $alias);
            $_GET['controller'] = $this->controller = $explode[0];
            $_GET['method'] = $this->method = $explode[1];
        }

        if(!Session::check())
            return false;
        else if(Access::checkPublic($this->controller, $this->method))
            return true;
        else if(Session::get(Settings::get("accessIndentifier")) !== false)
            if(Access::checkPrivate(Session::get(Settings::get("accessIndentifier")), $this->controller, $this->method))
                return true;
        return false;
    }

    private function callLink()
    {
        $methods = Settings::get('methodsStart');
        if($methods) {
            foreach ($methods as $key => $value) {
                if(is_array($value)) {
                    foreach ($value as $v) {
                        $vars = $this->addControllerAndModel($key, $v)->allVars();
                        foreach ($vars as $k => $var) {
                            $_GET['vars'][$k] = $var;
                        }
                    }
                }
                else {
                    $vars = $this->addControllerAndModel($key, $value)->allVars();
                    foreach ($vars as $k => $var) {
                        $_GET['vars'][$k] = $var;
                    }
                }
            }
        }

        $this->addControllerAndModel($this->controller, $this->method, true);

    }

    private function addControllerAndModel($class, $method, $page = false)
    {
        $class = ucfirst($class);
        $controller = "{$class}Controller";
        if(file_exists(__DIR__."/../../Controllers/{$controller}.php")) {

            $controller = "\\Controllers\\{$controller}";
            $instance = new $controller();

            if($page) {
                if(count($_POST)) {
                    if($_POST['token'] === Session::get('token') or in_array($_POST['token'], Settings::get('allowsAjax'))) {
                        Session::set('token', false);
                        Saved::create();
                        $method = "{$method}Posted";
                    }
                    else {
                        Errors::display('Token inválido', DOMAIN);
                        exit();
                    }

                }
                else {
                    if(!Session::get('token'))
                        Session::set('token', md5(crypt(time(), '$1$rasmusle$')));
                    $method = "{$method}Deed";
                }
            }


            if(method_exists($instance, $method)) {
                $instance->{$method}();
                return $instance;
            }
            else
                Errors::display("Método não encontrado [{$controller}/{$method}]");
        }
        else
            Errors::display("Controlador não encontrado [{$controller}]");

        return false;

    }


}
