<?php

include "secpass.php";
$secpass = new Secpass();

if($secpass->is_fileAlone("database.php")){
    die("Cannot access");
}

$database = new SQLite3("../../database.db");