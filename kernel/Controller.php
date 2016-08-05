<?php

/**
 * Class Controller
 * 
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 02/07/2016
 * Time: 20:18
 */

abstract class Controller
{
    /**
     * Atributos publicos
     * @var array - links de CSS e scripts para template.
     * @var null - instancia do template criada
     */
    public $links = array("/libs/bootstrap/css/bootstrap.css", "/libs/font-awesome/css/font-awesome.css" );
    public $scripts = array("/libs/jquery.min.js");
    public $template = null;

    /**
     * Atributos privados
     * @var array - variaveis de comunicacao com view, lista contendo diretorio, arquivo do view e parametros url
     * @var null - titulo da pagina
     * @var true - se tem o nao template
     */
    private $variables = array();
    private $view = array("dir" => null, "archive" => null);
    private $title = null;
    private $hasTemplate = true;
    private $params = array();

    /**
     * Controller constructor.
     * Pega um diretorio e arquivo padrao de visao e cria um novo template passando essa classe.
     */
    public function __construct()
    {
        $array_post = is_array(Session::get('post_backup')) ? Session::get('post_backup') : array();
        foreach ($array_post as $key => $value)
            $_POST[$key] = $value;

        unset($_SESSION['post_backup']);
        $this->view['dir'] = mb_strtolower($_GET['controller']);
        $this->view['archive'] = mb_strtolower($_GET['method']);

        if(isset($_GET['params']))
        {            $this->params = $_GET['params'];
            unset($_GET['params']);
        }

        $this->template = new Template($this);
    }

    /**
     * Pega um parametro da URL
     *
     * @param $index - indice do parametro em numero
     * @return bool|mixed - valor do parametro ou false
     */
    protected function param($index)
    {
        if(key_exists($index, $this->params))
            return $this->params[$index];
        return false;
    }

    /**
     * Desativa o template do controller
     */
    protected function noTemplate()
    {
        $this->hasTemplate = false;
        return $this;
    }
    
    /**
     * Adiciona um link de CSS para o template.
     * 
     * @param $link - string com url de um link
     */
    protected function addLink($link)
    {
        array_push($this->links, $link);
        return $this;
    }

    /**
     * Adiciona um novo javascript ao template atual.
     * 
     * @param $script - string com o link de um script
     */
    protected function addScript($script)
    {
        array_push($this->scripts, $script);
        return $this;
    }

    /**
     * Vai para outra pagina.
     * 
     * @param $controller - controlador a ser chamado
     * @param $method - metodo a ser chamado
     * @param array $attributes - atributos do link
     */
    protected function to($controller, $method, $attributes = array())
    {
        $attr = "";
        if(is_array($attributes))
            $attr = implode("/", $attributes);
        else
            if(!empty($attributes))
                $attr = $attributes;
        $controller = mb_strtolower($controller);
        $method = mb_strtolower($method);
        $attr = mb_strtolower($attr);
        header("Location:" . DOMAIN . "/{$controller}/{$method}/{$attr}");
    }

    /**
     * Troca a view padrao desse controlador. (caminho a ser iniciado da pasta /view)
     *
     * @param null $directory - diretorio onde esta a view
     * @param null $archive - arquivo da view
     */
    protected function view($directory = null, $archive = null)
    {
        if(!is_null($directory))
            $this->view['dir'] = $directory;
        if(!is_null($archive))
            $this->view['archive'] = $archive;
        return $this;
    }

    /**
     * Pega o arquivo de view, incluindo el no script atual.
     */
    private function  getView()
    {
        if(is_dir("view/{$this->view['dir']}"))
            if(file_exists("view/{$this->view['dir']}/{$this->view['archive']}.php"))
                include "view/{$this->view['dir']}/{$this->view['archive']}.php";
            else
                Errors::display('Arquivo da interface não foi encontrado');
        else
            Errors::display('Diretório da interface não foi encontrado');
    }

    /**
     * Metodo para mostrar uma tela, chama o template que cuidara do resto, se template tiver desativado
     * chama a view apenas.
     */
    protected function display()
    {
        if(!$this->isAjax())
        {
            if($this->hasTemplate)
                include 'skeleton/' . Settings::get('skeleton') . '/index.php';
            else
                $this->getView();
        }

    }

    /**
     * Pega o titulo da pagina atual.
     *
     * @return string - titulo da pagina
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Atribui um novo titulo a pagina.
     *
     * @param $title - titulo da pagina
     */
    protected function title($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Adiciona uma variavel para a visao.
     *
     * @param $key - nome da variavel
     * @param $value - valor da variavel
     */
    protected function addVar($key, $value)
    {
        $this->variables[$key] = $value;
        return $this;
    }

    /**
     * Pega uma variavel de visao, caso ela exista, se não retorna false.
     *
     * @param $key - nome da variavel
     * @return bool|mixed - false ou o valor da variavel
     */
    protected function getVar($key)
    {
        if(array_key_exists($key, $this->variables))
            return $this->variables[$key];
        return false;
    }

    /**
     * Verifica se a requisicao foi feita por ajax.
     * 
     * @return bool - true foi ajax, false nao usou ajax
     */
    protected function isAjax()
    {
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? $_SERVER['HTTP_X_REQUESTED_WITH'] : null;
        return (strtolower($isAjax) === 'xmlhttprequest');
    }

    /**
     * Exibe uma mensagem de erro na tela.
     *
     * @param string $title - título da página
     */
    protected function error($title = "Error", $msg = null)
    {
        $this->title($title);
        $this->addVar('error', $msg);
        $this->view("/", "error");
        $this->display();
    }

}