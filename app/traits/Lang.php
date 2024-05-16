<?php

namespace app\traits;

use core\Language;

trait Lang
{   
    private $lang;

    public function __construct()
    {
        $this->lang = new Language();
    }

    /**
    *  PT-BR # Recebe uma string e converte no idioma setado na classe.
    *  EN # Receive a string and convert it into the language sitting in the class. 
    *  @param string $text
    *  @param array|null $array
    *  @return string
    */
    public function trans(string $text, array $array = []): string
    {
        return $this->lang->translate($text, $array);
    }

    /**
    *  PT-BR # Define a linguagem que o projeto vai utilizar.
    *  EN # Defines the language that the project will use. 
    *  @param string $language
    *  @return void
    */
    public function setLang(string $language): void
    {
        $this->lang->loadLanguage($language);
    }
}