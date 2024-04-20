<?php

namespace core;

/**
 * Class Session
 * @package core
 */
class Session
{
    /**
     * Session constructor
     */
    public function __construct()
    {
        if(! session_id()) {
            session_save_path(CONF_SES_PATH);
            session_start();
        }
    }

    /**
     * PT-BR # Tenta acessar uma propriedade que não está definida 
     * explicitamente na classe.
     * EN # Attempts to access a property that is not explicitly
     * defined in the class.
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (! empty($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    /**
     * PT-BR # Verifica se uma propriedade existe em um objeto.
     * EN # Checks whether a property exists on an object.
     * @param $name
     * @return bool
     */
    public function __isset($name): bool
    {
        return $this->has($name);
    }

    /**
     * PT-BR # Devolve toda a sessão.
     * EN # Returns the entire session.
     * @return object|null
     */
    public function all(): object|null
    {
        return (object)$_SESSION;
    }

     /**
     * PT-BR # Seta atributos para a sessão.
     * EN # Arrow attributes for the session.
     * @param string $key
     * @param mixed $value
     * @return Session
     */
    public function set(string $key, $value): Session
    {
        $_SESSION[$key] = (is_array($value) ? (object)$value : $value);
        return $this;
    }

    /**
     * PT-BR # Remove atributos da sessão.
     * EN # Remove session attributes.
     * @param string $key
     * @return Session
     */
    public function unset(string $key): Session
    {
        unset($_SESSION[$key]);
        return $this;
    }

    /**
     * PT-BR # Verifica se a sessão já existe.
     * EN # Checks if the session already exists.
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * PT-BR # Gera um novo id de sessão.
     * EN # Generates a new session id.
     * @return Session
     */
    public function regenerate(): Session
    {
        session_regenerate_id(true);
        return $this;
    }

    /**
     * PT-BR # Destroi a sessão.
     * EN # Destroy the session.
     * @return Session
     */
    public function destroy(): Session
    {   
        session_destroy();
        return $this;
    }


    /**
     * PT-BR # Monitora as mensagens do tipo flash da classe message.
     * EN # Monitors flash messages from the message class.
     * @return Session|null
     */
    public function flash(): Session|null
    {
        if($this->has('flash')) {
            $flash = $this->flash;
            $this->unset('flash');
            return $flash;
        }

        return null;
    }

    /**
     * PT-BR # Gera um novo token csrf para garantir a segurança pós requisição.
     * EN # Generates a new csrf token to ensure post-request security.
     * @return void
     */
    public function csrf(): void
    {
        $_SESSION['csrf_token'] = base64_encode(random_bytes(20));
    }
}