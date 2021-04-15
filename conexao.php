<?php
require_once("config.php");

date_default_timezone_set('America/Recife');

try {
    //PDO forma mais seguro para conectar com o banco de dados
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;port=3306;charset=utf8mb4", $usuario, $senha);
    //echo "Conexão realizada com sucesso!";
} catch (Exception $e) {
    echo "Erro ao conectar com o banco de dados! " . $e;
}

?>