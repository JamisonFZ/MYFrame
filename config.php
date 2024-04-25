<?php

/**
 *  DOC:
 *  [ ! ] Deve ser alterado / Must be changed
 *  [ * ] Pode ser alterado / Can be changed
 *  [ # ] Evite alterar / Avoid changing
 */
 

/**
 * PT-BR # Prioridades.
 * EN # Priorities.
 */
define("CONF_URL_BASE", "localhost:8888"); // !


/**
 * PT-BR # Banco de dados.
 * EN # Database.
 */
define("CONF_DB_TYPE", "mysql"); // *
define("CONF_DB_HOST", "localhost"); // !
define("CONF_DB_NAME", "teste"); // !
define("CONF_DB_USER", "root"); // !
define("CONF_DB_PASS", ""); // !
define("CONF_DB_OPTS", [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_CASE => PDO::CASE_NATURAL
]); // #


/**
 * PT-BR # E-mail.
 * EN # Email.
 */
define("CONF_MAIL_HOST", ""); // !
define("CONF_MAIL_PORT", ""); // !
define("CONF_MAIL_USER", ""); // !
define("CONF_MAIL_PASS", ""); // !
define("CONF_MAIL_SENDER", [
    "name" => "",
    "adress" => ""
]); // !

define("CONF_MAIL_OPTION_LANG", "br"); // *
define("CONF_MAIL_OPTION_HMTL", true); // *
define("CONF_MAIL_OPTION_AUTH", true); // *
define("CONF_MAIL_OPTION_SECURE", "tls"); // *
define("CONF_MAIL_OPTION_CHARSET", "utf-8"); // *


/**
 * PT-BR # Senha.
 * EN # Password.
 */
define("CONF_PASSWD_MIN_LEN", 8); // *
define("CONF_PASSWD_MAX_LEN", 40); // *
define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT); // #
define("CONF_PASSWD_OPTION", ['cost' => 10]); // #


/**
 * PT-BR # URls.
 * EN # URls.
 */
define("CONF_URL_ADMIN", CONF_URL_BASE . "/admin"); // #
define("CONF_URL_DASHBOARD", CONF_URL_BASE . "/dashboard"); // #
define("CONF_URL_ERROR", CONF_URL_BASE . "/error"); // #


 /**
 * PT-BR # Datas.
 * EN # Dates.
 */
 define("CONF_DATE_BR", "d/m/Y H:i:s"); // #
 define("CONF_DATE_APP", "Y-m-d H:i:s"); // #


 /**
 * PT-BR # Sessões.
 * EN # Sessions.
 */
 define("CONF_SES_PATH", __DIR__ . "/storage/sessions/"); // #


 /**
 * PT-BR # Mensagem.
 * EN # Message.
 */
 define("CONF_MESSAGE_CLASS", "trigger"); // #
 define("CONF_MESSAGE_SUCCESS", "success"); // #
 define("CONF_MESSAGE_INFO", "info"); // #
 define("CONF_MESSAGE_WARNING", "warning"); // #
 define("CONF_MESSAGE_ERROR", "error"); // #