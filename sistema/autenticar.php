<?php

    require_once("../conexao.php");

    $email = $_POST['email_login'];
    $senha = md5($_POST['senha_login']);

    $result = $pdo->query("SELECT * FROM usuario where email = '$email' and senha_crip = '$senha'");
    $dados = $result->fetchAll(PDO::FETCH_ASSOC);

    if (@count($dados) > 0) {
        echo "Usuário Encontrado";
    }
?>