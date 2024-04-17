<?php

$mysqli = new mysqli("localhost", "root", "", "finances");

if($mysqli->connect_errno){
    echo "Fallo la conexión " . $mysqli->connect_errno;
    die();
}