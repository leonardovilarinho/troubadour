<?php

namespace LegionLab\Troubadour\Control;
use LegionLab\Troubadour\Collections\Settings;
use LegionLab\Urban\UrbanTemplate;

/**
 * Control Template
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 02/07/2016
 * Time: 23:07
 */

abstract class Template extends UrbanTemplate
{
    private $title;
    private $links = array();
    private $scripts = array();

    public function __construct($dir)
    {
        parent::__construct($dir);
        $this->scripts = Settings::get('defaultJS');
        $this->links = Settings::get('defaultCSS');
    }

    /**
     * Atribui um novo titulo a pagina.
     *
     * @param $title - titulo da pagina
     * @return $this
     */
    public function title($title = '@')
    {
        if($title !== '@') {
            $this->title = $title;
            return $this;
        }
        else {
            return $this->title;
        }

    }

    /**
     * Atribui um novo link a pagina.
     *
     * @param $link - link da pagina
     * @return mixed
     */
    public function link($link = '@')
    {
        if($link !== '@') {
            array_push($this->links, $link);
            return $this;
        }
        else {
            return $this->links;
        }
    }

    /**
     * Atribui um novo script a pagina.
     *
     * @param $script - script da pagina
     * @return mixed
     */
    public function script($script = '@')
    {
        if($script !== '@') {
            array_push($this->scripts, $script);
            return $this;
        }
        else {
            return $this->scripts;
        }
    }

    /**
     * Exibe o header da pagina e chama os links de CSS
     */
    public function header()
    {
        $h = "<!doctype html>\n<html lang='pt'>\n<head>\n";
            $h .=  "\t<meta charset='UTF-8'>\n";
            $h .= "\t<meta http-equiv='X-UA-Compatible' content='IE=edge'>\n";
            $h .= "\t<meta name='viewport' content='width=device-width, initial-scale=1'>\n";
            $h .= "\t<meta name='description' content=''>\n";
            $h .= "\t<meta name='author' content=''>\n";
            $h .= "\t<title>{$this->title()}</title>\n";
            $h .=   $this->links();
        $h .= "</head>\n<body>\n";
        return $h;
    }

    /**
     * Tranforma os links configurados no controller em tag <link> do html.
     */
    private function links()
    {
        $l = "";
        foreach ($this->links as $value) {
            $l .= "\t<link rel='stylesheet' href='" . DOMAIN . $value . "' />\n";
        }
        return $l;
    }

    /**
     * Tranforma scripts adicionados ao controller em tag <script> e finaliza o arquivo.
     */
    public function scripts()
    {
        $s = "";
        foreach ($this->scripts as $value) {
            $s .= "\t<script src='" . DOMAIN . $value . "' ></script>\n";
        }
        $s .= "</body>\n</html>";
        return $s;
    }

}
