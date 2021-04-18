<?php
    require_once("../conexao.php");

    $email = $_POST['email_rec'];

    if ($email == "") {
        echo 'Insira o seu email!';
        exit();
    }

    $result = $pdo->query("SELECT * FROM usuario where email = '$email'");
    $dados = $result->fetchAll(PDO::FETCH_ASSOC);
    
    if (@count($dados) > 0) {
        $senha = $dados[0]['senha'];
        
        //ENVIANDO A SENHA PARA O EMAIL
        $destinatario = $email;
        $assunto = $nome_loja . ' - Recuperação de Senha';
        $mensagem = utf8_decode('Sua senha é $senha');
        $cabecalho = "From: " . $email;

        mail ($destinatario, $assunto, $mensagem, $cabecalho);

        echo 'Senha enviada para o email!';
    } else {
        echo 'Este email não esta cadastrado!';
        exit();
    }
?>