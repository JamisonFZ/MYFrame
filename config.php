<?php

/**
 * PT-BR # Banco de dados.
 * EN # Database.
 */

define("CONF_DB_TYPE", "mysql");
define("CONF_DB_HOST", "localhost");
define("CONF_DB_NAME", "teste");
define("CONF_DB_USER", "root");
define("CONF_DB_PASS", "");
define("CONF_DB_OPTS", [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_CASE => PDO::CASE_NATURAL
]);

/**
 * PT-BR # E-mail.
 * EN # Email.
 */