<?php

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $errorMessageEmail="<div class='alert alert-danger' role='alert'> inserire una email valida </div>";
}

if (strlen($_POST["password"]) < 8) {
    $errorMessagePassword="<div class='alert alert-danger' role='alert'> inserire una password di almeno 8 caratteri </div>";
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    $errorMessagePassword="<div class='alert alert-danger' role='alert'> inserire una password con almeno una lettera </div>";
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    $errorMessagePassword="<div class='alert alert-danger' role='alert'> inserire una password con almeno un numero</div>";
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";
