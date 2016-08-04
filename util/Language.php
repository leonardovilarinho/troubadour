<?php

/**
 * Class Language
 *
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 07/07/2016
 * Time: 22:02
 */
class Language
{
    /**
     * @var string - diretório definido para ter arquivos de idiomas
     */
    private static $dir = 'languages/';

    /**
     * Resgata o idioma atual sendo utilizado.
     *
     * @return mixed - string contendo a linguagem ou false
     */
    public static function current()
    {
        return Session::get('current_lang');
    }

    /**
     * Define uma linguagem padrão para o site dependendo do idioma do navegador do usuário, caso não encontre
     * arquivo de linguagem para o idioma nativo, pega o primeiro idioma que encontrar.
     */
    public static function init()
    {
       if(Session::get('current_lang') === false)
       {
           $lang = mb_strtolower(explode(",", $_SERVER["HTTP_ACCEPT_LANGUAGE"])[0]);
           if(file_exists(self::$dir .  $lang. Settings::get('langExtension')))
               Session::set('current_lang', $lang);
           else
               Session::set('current_lang', self::all()[0]);
       }

    }

    /**
     * Pega uma string do arquivo de linguagem, por padrao usa section, que permite deixar o arquivo
     * mais organizado. Exemplo:
     * [login]
     *      title = "Faça o login"
     * Ao inves de deixar apenas variaveis espalhadas, porém é possivel usar sem section (nao
     * recomendado), ao ser informado um index, como:
     * Language::get('login')
     * é pego todas variaveis daquela section, para pegar apenas uma use:
     * Language::get('login')['title']
     *
     * @param $index - indice ou section a pegar
     * @param bool $section - uso de section habilitado por padrao
     * @return mixed - a string ou array econtrado ou um false indicando que nao encontrou
     */
    public static function get($index, $section = true)
    {
        $file = self::$dir .  Session::get('current_lang'). Settings::get('langExtension');
        if(file_exists($file))
        {
            $archive = parse_ini_file($file, $section);
            if(key_exists($index, $archive))
                return $archive[$index];
        }
        return false;
    }

    /**
     * Troca a linguagem atual do sistema.
     *
     * @param $lang - nova linguagem a ser estabelecida
     */
    public static function set($lang)
    {
        Session::set('current_lang', in_array($lang, self::all()) ? $lang : null);
    }

    /**
     * Resgata todas linguagens que possuem um arquivo de configuração proprio, retorno pode
     * ser um array ou false indicando que nada foi encontrado.
     *
     * @return array|bool - array com linguagens encontradas ou false
     */
    public static function all()
    {
        if(is_dir(self::$dir))
        {
            $directory = dir(self::$dir);
            $archives = array();
            while(($archive = $directory->read()) !== false)
                if(file_exists(self::$dir . $archive) and !is_dir(self::$dir . $archive))
                    array_push($archives, str_replace(Settings::get('langExtension'), "", $archive));

            $directory->close();
            return $archives;
        }
        return false;
    }
}