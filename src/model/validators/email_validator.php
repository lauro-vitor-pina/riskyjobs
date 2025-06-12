<?php


function email_validator($email) //retorna true para um e-email é valido.
{
    $regex = '/^[a-zA-Z09][a-zA-Z09\._\-&!?=#]*@/';

    if (!preg_match($regex, $email)) { // se não contém o padrão o e-mail é inválido.
        return false;
    }

    $domain = preg_replace($regex, '', $email); //obtem o domínio do e-mail

    if (!checkdnsrr($domain)) { //verifica se o domínio está registrado, caso não estiver é um e-mail inválido.
        return false;
    }

    return true;
}
