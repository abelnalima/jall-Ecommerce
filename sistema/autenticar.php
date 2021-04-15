<?php
    require_once("../conexao.php");
    @session_start(); //@ para evitar que seja mostrado avisos de alerta dependendo da versão do PHP

    $email = $_POST['email_login'];
    $senha = md5($_POST['senha_login']);

    $result = $pdo->query("SELECT * FROM usuario where email = '$email' and senha_crip = '$senha'");
    $dados = $result->fetchAll(PDO::FETCH_ASSOC);

    if (@count($dados) > 0) {
        $_SESSION['nome_usuario'] = $dados[0]['nome'];  //session recebe o nome do primeiro usuario encontrado pela query
        $_SESSION['email_usuario'] = $dados[0]['email'];
        $_SESSION['cpf_usuario'] = $dados[0]['cpf'];
        $_SESSION['nivel_usuario'] = $dados[0]['nivel'];
        
        if ($_SESSION['nivel_usuario'] == 'Admin') {
            echo "<script language=javascript> 
                    windows.location='painel_admin'
                </script>";
        }

        if ($_SESSION['nivel_usuario'] == 'Cliente') {
            echo "<script language=javascript> windows.location='painel_cliente' </script>";
        }

    } else {
        echo "<script language=javascript> windows.alert('Dados inseridos estão incorretos!') </script>";
        echo "<script language=javascript> windows.location='index.php' </script>";
    }
?>