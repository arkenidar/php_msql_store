<?php

function pdo(){

    require 'db_variables.php';

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname",
        $username,
        $password
    );
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}

$pdo = pdo();
assert($pdo!=null);

?>