<?php

/**
 * Class Template
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 02/07/2016
 * Time: 23:07
 */

class Template
{
    /**
     * @var null - controller a ser usado no template
     */
    private $controller = null;

    /**
     * Template constructor.
     *
     * @param $ctrl - controller a ser usado no template
     */
    public function __construct($ctrl)
    {
        $this->controller = $ctrl;
    }

    /**
     * Exibe o header da pagina e chama os links de CSS
     */
    public function header()
    {
        echo "<!doctype html>\n<html lang='pt'>\n<head>\n";
            echo "\t<meta charset='UTF-8'>\n";
            echo "\t<title>{$this->controller->getTitle()}</title>\n";
            $this->links();
        echo "</head>\n<body>\n";
    }

    /**
     * Tranforma os links configurados no controller em tag <link> do html.
     */
    private function links()
    {
        foreach ($this->controller->links as $value)
            echo "\t<link rel='stylesheet' href='" . DOMAIN . $value . "' />\n";
    }

    /**
     * Tranforma scripts adicionados ao controller em tag <script> e finaliza o arquivo.
     */
    public function scripts()
    {
        foreach ($this->controller->scripts as $value)
            echo "\t<script src='" . DOMAIN . $value . "' ></script>\n";
        echo "</body>\n</html>";
    }

}