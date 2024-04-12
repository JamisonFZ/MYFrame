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

 /**
 * PT-BR # URls.
 * EN # URls.
 */

 define("CONF_URL_BASE", "localhost");
 define("CONF_URL_ADMIN", CONF_URL_BASE . "/admin");
 define("CONF_URL_ERROR", CONF_URL_BASE . "/404");

 /**
 * PT-BR # Datas.
 * EN # Dates.
 */

 define("CONF_DATE_BR", "d/m/Y H:i:s");
 define("CONF_DATE_APP", "Y-m-d H:i:s");

 /**
 * PT-BR # Sessões.
 * EN # Sessions.
 */

 define("CONF_SES_PATH", __DIR__ . "/storage/sessions/");

 /**
 * PT-BR # Mensagem.
 * EN # Message.
 */

 define("CONF_MESSAGE_CLASS", "trigger");
 define("CONF_MESSAGE_SUCCESS", "success");
 define("CONF_MESSAGE_INFO", "info");
 define("CONF_MESSAGE_WARNING", "warning");
 define("CONF_MESSAGE_ERROR", "error");