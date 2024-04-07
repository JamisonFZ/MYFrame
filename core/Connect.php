<?php

namespace core;

use PDO;
use PDOException;

class Connect
{
    private static $instance;

    /**
     *  PT-BR # Verifica se uma instância do PDO foi criada e retorna esse objeto.
     *  EN # Checks whether a PDO instance was created and returns that object.
     *  @return PDO
     */
    public static function load(): PDO
    {

        if(empty(self::$instance)) {
            
            try {
                
                self::$instance = new PDO (
                    CONF_DB_TYPE . ":host=" . CONF_DB_HOST . ";dbname=" . CONF_DB_NAME,
                    CONF_DB_USER,
                    CONF_DB_PASS,
                    CONF_DB_OPTS
                );

            } catch (PDOException $error) {
                
                die($error->getMessage() . ": Erro ao conectar..");
                
            }

        }

        return self::$instance;
    }

    /**
     *  PT-BR # Final private ao construtor para manter uma instancia por usuário.
     *  EN # Final private to the constructor to maintain one instance per user.
     */
    final private function __construct()
    {
    }

}
