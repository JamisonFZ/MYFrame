<?php

namespace core;

use Diversen\Lang;

class Language
{
    private $lang;

    public function __construct()
    {
        $this->lang = new Lang;
        $this->lang->setSingleDir(CONF_DEFAULT_PATH);
        $this->lang->loadLanguage(CONF_DEFAULT_LANG);
    }

    /**
     *  PT-BR # Carrega o idioma escolhido ou o setado por padrão.
     *  EN # Load the chosen language or the one set by default. 
     *  @param string|null $name
     *  @return void
     */
    public function loadLanguage(string|null $language = null): void
    {
        $dirLang =  null;
        $fileLang = null;

        $dirLang = ! $language ? $dirLang = CONF_DEFAULT_PATH . '\\lang\\en\\' : CONF_DEFAULT_PATH . '\\lang\\' . $language . '\\'; 
        $fileLang = $dirLang . 'language.php';

        // Verifica se o idioma foi passado
        if (! $language) {
            $this->lang->loadLanguage(CONF_DEFAULT_LANG);
        }

        // Verifica se a pasta e o arquivo para o idioma foi criado
        if (! file_exists($dirLang) and ! file_exists($fileLang)) {
            echo "Erro ao encontrar a pasta '$language' e o arquivo 'language.php'";
        }

        // Carrega o idioma informado
        $this->lang->loadLanguage($language);
    }

    /**
    *  PT-BR # Recebe uma string e converte no idioma setado na classe.
    *  EN # Receive a string and convert it into the language sitting in the class. 
    *  @param string $text
    *  @param array|null $array
    *  @return string
    */
    public function translate(string $text, array $array = []): string
    {
        return Lang::translate($text, $array);
    }
}