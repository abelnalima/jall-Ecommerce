<?php

require_once("config.php");

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

mail($destinatario, $assunto, $mensagem, $cabecalhos);

echo 'Enviado com sucesso!';

?>