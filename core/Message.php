<?php

namespace core;

/**
 * Class Message
 * @package core
 */
class Message
{

    private $text;
    private $type;

    /**
     *  PT-BR # Pega os dados da variável text.
     *  EN # Gets data from the text variable.
     *  @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     *  PT-BR # Pega os dados da variável type.
     *  EN # Gets data from the type variable.
     *  @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     *  PT-BR # Mensagem de sucesso.
     *  EN # Success Message.
     *  @return 
     */
    public function render(): string
    {
        $myText = $this->getText() ?? 'vazio';
        $myType = $this->getType() ?? 'error';
        return message_type($myText, $myType);
    }

    /**
     *  PT-BR # Mensagem de sucesso.
     *  EN # Success Message.
     *  @param string $message
     *  @return Message
     */
    public function success(string $message): Message
    {
        $this->type = CONF_MESSAGE_SUCCESS;
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     *  PT-BR # Mensagem de informação.
     *  EN # Info Message.
     *  @param string $message
     *  @return Message
     */
    public function info(string $message): Message
    {
        $this->type = CONF_MESSAGE_INFO;
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     *  PT-BR # Mensagem de atenção.
     *  EN # Warning Message.
     *  @param string $message
     *  @return Message
     */
    public function warning(string $message): Message
    {
        $this->type = CONF_MESSAGE_WARNING;
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     *  PT-BR # Mensagem de erro.
     *  EN # Error Message.
     *  @param string $message
     *  @return Message
     */
    public function error(string $message): Message
    {
        $this->type = CONF_MESSAGE_ERROR;
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     *  PT-BR # Filtra dados esternos passados por usuários.
     *  EN # Filters external data passed by users.
     *  @param string $message
     *  @return string
     */
    private function filter(string $message): string
    {
        return filter_var($message, FILTER_SANITIZE_SPECIAL_CHARS);
    }

}