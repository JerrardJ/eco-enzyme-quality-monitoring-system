<?php 

function validateUser($user) 
{
    global $conn;
    $errors = array();
    
    if (empty($user['username'])) {
        array_push($errors, 'Username Required!');

    }
    if (empty($user['password'])) {
        array_push($errors, 'Password Required!');

    }
    if (($user['passwordConf'] !== $_POST['password'])) {
        array_push($errors, 'Password do not match!');
    }

    return $errors;
}

function validateLogin($user) 
{
    global $conn;
    $errors = array();
    
    if (empty($user['username'])) {
        array_push($errors, "Username Required!");

    }
    if (empty($user['password'])) {
        array_push($errors, 'Password Required!');

    }
    return $errors;
}