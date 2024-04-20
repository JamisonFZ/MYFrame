<?php

use app\models\user\User;
use core\Connect;
use core\Message;
use core\Session;

/**
 * 
 *  TEXTO / STRING 
 * 
 */


/**
 *  PT-BR # Retorna a instância do PDO.
 *  EN # Return to DOP instance.
 *  @return PDO
 */
function db(): PDO
{
    return Connect::load();
}

/**
 *  PT-BR # Retorna a instância do Message.
 *  EN # Return to Message instance.
 *  @return Message
 */
function message()
{
    return new Message;
}

/**
 *  PT-BR # Retorna a instância do Session.
 *  EN # Return to Session instance.
 *  @return Session
 */
function session()
{
    return new Session;
}

/**
 *  PT-BR # Retorna a instância do User.
 *  EN # Return to User instance.
 *  @return User
 */
function user()
{
    return new User;
}

/**
 *  PT-BR # Retorna uma string com o limite definido.
 *  EN # Returns a string with the defined limit.
 *  @param string $string
 *  @param int $characterNumber
 *  @return string
 */
function truncate_string(string $string, int $characterNumber): string
{
    $truncate_string = substr($string, 0, $characterNumber);
    return $truncate_string . '...';
}

/**
 *  PT-BR # Retorna uma url completa com base na url base do config.
 *  EN # Returns a full url based on the config base url.
 *  @param string $pah
 *  @return string
 */
function url(string $path): string
{
    return CONF_URL_BASE . '/' . ($path[0] == '/' ? mb_substr($path, 1) : $path);
}

/**
 *  PT-BR # Verifica o tipo e url e redireciona.
 *  EN # Check type and url and redirect.
 *  @param string $url
 *  @return void
 */
function redirect_url(string $url): void
{
    header('HTTP/1.1 302 Redirect');
    if (filter_var($url, FILTER_VALIDATE_URL))
    {
        header("Location: {$url}");
        exit;
    }

    $location = url($url);
    header("Location: {$location}");
    exit;
}


/**
 * 
 *  E-MAIL / EMAIL
 * 
 */


/**
 *  PT-BR # Verifica se o e-mail é válido.
 *  EN # Checks if the email is valid.
 *  @param string $email
 *  @return bool
 */
function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


/**
 * 
 *  SENHA / PASSWORD
 * 
 */


/**
 *  PT-BR # Verifica se a senha está no tamanho permitido pelo sistema.
 *  EN # Checks whether the password is the length allowed by the system.
 *  @param string $password
 *  @return bool
 */
function is_passwd(string $password): bool
{
    return (mb_strlen($password) >= CONF_PASSWD_MIN_LEN && mb_strlen($password) <= CONF_PASSWD_MAX_LEN) ? TRUE : FALSE;
}

/**
 *  PT-BR # Retorna uma senha protegido com hash.
 *  EN # Returns a hashed password.
 *  @param string $password
 *  @return string
 */
function passwd(string $password): string
{
    return password_hash($password, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

/**
 *  PT-BR # Verifca o hash de uma senha.
 *  EN # Checks the hash of a password.
 *  @param string $password
 *  @param string $hash
 *  @return bool
 */
function passwd_verify(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}

/**
 *  PT-BR # Verifca o hash de uma senha.
 *  EN # Checks the hash of a password.
 *  @param string $hash
 *  @return bool
 */
function passwd_rehash(string $hash): bool
{
    return password_needs_rehash($hash, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

/**
 * 
 *  VALIDAR / VALIDATE
 * 
 */


 /**
 *  PT-BR # Criar um novo campo de input já adicionando um token csrf.
 *  EN # Create a new input field by adding a csrf token.
 *  @return string
 */
 function csrf_input(): string
 {
    session()->csrf();
    return "<input type='hidden' name='csrf' value='". (session()->csrf_token ?? "") ."'/>";
 }

 /**
 *  PT-BR # Verifica se o token foi passado via input e si é o mesmo da requisição.
 *  EN # Checks whether the token was passed via input and whether it is the same as the request.
 *  @param string $request
 *  @return bool
 */
 function csrf_verify($request): bool
 {
    if(empty(session()->csrf_token) or empty($request['csrf']) or $request['csrf'] != session()->csrf_token)
    {
        return false;
    }

    return true;
 }


/**
 * 
 *  MENSAGEM / MESSAGE 
 * 
 */


/**
 *  PT-BR # Retorna uma string com o corpo da mensagem com base no tipo.
 *  EN # Returns a string with the message body based on type.
 *  @param string $message
 *  @param string $type
 *  @return string
 */
function message_type($message, $type): string
{
    switch ($type) {
        case 'success':
            return "<div id='alert-border-3' class='flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800' role='alert'>
		
                        <svg class='flex-shrink-0 w-4 h-4' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewbox='0 0 20 20'>
                            <path d='M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z'/>
                        </svg>
            
                        <div class='ms-3 text-sm font-medium'>
                            $message
                        </div>
            
                        <button type='button' class='ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700' data-dismiss-target='#alert-border-3' aria-label='Close'>
                            <span class='sr-only'>Dismiss</span>
                            <svg class='w-3 h-3' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewbox='0 0 14 14'>
                                <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6'/>
                            </svg>
                        </button>
    
                    </div>";

        case 'info':
            return "<div id='alert-border-1' class='flex items-center p-4 mb-4 text-blue-800 border-t-4 border-blue-300 bg-blue-50 dark:text-blue-400 dark:bg-gray-800 dark:border-blue-800' role='alert'>
    
                        <svg class='flex-shrink-0 w-4 h-4' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 20 20'>
                            <path d='M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z'/>
                        </svg>
        
                        <div class='ms-3 text-sm font-medium'>
                            $message
                        </div>
        
                        <button type='button' class='ms-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700' data-dismiss-target='#alert-border-1' aria-label='Close'>
                        <span class='sr-only'>Dismiss</span>
                        <svg class='w-3 h-3' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 14 14'>
                            <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6'/>
                        </svg>
                        </button>
        
                    </div>";

        case 'warning':
            return "<div id='alert-border-4' class='flex items-center p-4 mb-4 text-yellow-800 border-t-4 border-yellow-300 bg-yellow-50 dark:text-yellow-300 dark:bg-gray-800 dark:border-yellow-800' role='alert'>
            
                        <svg class='flex-shrink-0 w-4 h-4' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewbox='0 0 20 20'>
                            <path d='M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z'/>
                        </svg>
            
                        <div class='ms-3 text-sm font-medium'>
                            $message
                        </div>
            
                        <button type='button' class='ms-auto -mx-1.5 -my-1.5 bg-yellow-50 text-yellow-500 rounded-lg focus:ring-2 focus:ring-yellow-400 p-1.5 hover:bg-yellow-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-yellow-300 dark:hover:bg-gray-700' data-dismiss-target='#alert-border-4' aria-label='Close'>
                            <span class='sr-only'>Dismiss</span>
                            <svg class='w-3 h-3' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewbox='0 0 14 14'>
                                <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6'/>
                            </svg>
                        </button>

                    </div>
        ";

        case 'error':
            return "<div id='alert-border-2' class='flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800' role='alert'>
    
                        <svg class='flex-shrink-0 w-4 h-4' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 20 20'>
                            <path d='M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z'/>
                        </svg>
        
                        <div class='ms-3 text-sm font-medium'>
                            $message
                        </div>
        
                        <button type='button' class='ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700'  data-dismiss-target='#alert-border-2' aria-label='Close'>
                        <span class='sr-only'>Dismiss</span>
                        <svg class='w-3 h-3' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 14 14'>
                            <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6'/>
                        </svg>
                        </button>
        
                    </div>";
            
        default:
            return 'vazio';
    }

}