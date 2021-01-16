<?php
function db_init() {
    $source = "mysql:host=localhost;dbname=friekobo";
    $dbuser = "sysuser";
    $dbpass = "secret";

    $pdo = new PDO($source,$dbuser,$dbpass);

    $pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo -> exec("SET NAMES utf8");

    return $pdo;

}