<?php
$host = "localhost";
$banco = "reservahotel";
$user = "root";
$pass = "";

$mysqli = new mysqli($host, $user, $pass, $banco);

if($mysqli->connect_errno){
    die("Falha na conexão com banco");
}