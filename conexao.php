<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ttc_automacao";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn) {
    echo "";
}

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
