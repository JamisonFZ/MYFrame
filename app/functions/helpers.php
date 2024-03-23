<?php

/**
 *  PT-BR # Retorna uma string com o limite definido.
 *  EN # Returns a string with the defined limit.
 *  @param string $string string
 *  @param int $characterNumber numero para determinar o limite a ser devolvido
 *  @return string Retorna uma string com o limite definido
 */
function truncate_string(string $string, int $characterNumber): string
{
    $truncate_string = substr($string, 0, $characterNumber);
    return $truncate_string . '...';
}
