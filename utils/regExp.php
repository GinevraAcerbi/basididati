<?php

function passwordIsValid($pass){
    return preg_match('@[A-Z]@', $pass) && preg_match('@[a-z]@', $pass) && preg_match('@[0-9]@', $pass) && strlen($pass) >= 5;
}
function emailIsValid($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function numeroCartaIsValid($numeroCarta)
{
    return preg_match('/[0-9]{16}/', $numeroCarta);
} 