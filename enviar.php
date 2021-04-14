<?php

require_once("conexao.php");

if ($_POST['nome'] == "") {
    echo 'Preencha o campo Nome';
    exit();
}

if ($_POST['email'] == "") {
    echo 'Preencha o campo Email';
    exit();
}

if ($_POST['mensagem'] == "") {
    echo 'Preencha o campo Mensagem';
    exit();
}

$destinatario = $email;
$assunto = $nome_loja . ' - Propaganda';
$mensagem_email = utf8_decode('Nome: '.$_POST['nome']. "\r\n"."\r\n" .'Mensagem: '.$_POST['mensagem']);
$cabecalhos = "From: " .$_POST['email'];

//ENVIANDO O EMAIL PARA O DESTINATARIO [EMAIL DA LOJA]
mail($destinatario, $assunto, $mensagem_email, $cabecalhos);

echo 'Enviado com Sucesso!';

//ENVIANDO OS DADOS DO FORMULÁRIO [DEIXE SUA MENSAGEM] PARA A TABELA EMAIL
/* Utiliza o prepare para aumentar a segurança e evitar SQL Injection*/
$result = $pdo->query("SELECT * FROM email where email = '$_POST[email]'");
$dados = $result->fetchAll(PDO::FETCH_ASSOC);

if (@count($dados) == 0) {
    $result = $pdo->prepare("INSERT into email (nome, email, ativo) values (:nome, :email, :ativo)");
    $result->bindValue(":nome", $_POST['nome']);
    $result->bindValue(":email", $_POST['email']);
    $result->bindValue(":ativo", "Sim");
    $result->execute();
}

?>
