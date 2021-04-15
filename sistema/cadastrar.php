<?php

require_once("../conexao.php");

$senha_crip = md5($_POST['senha-cad']);

if ($_POST['nome'] == "") {
    echo 'Preencha o campo nome!';
    exit();
}

if ($_POST['cpf'] == "") {
    echo 'Preencha o campo cpf!';
    exit();
}

if ($_POST['email'] == "") {
    echo 'Preencha o campo email!';
    exit();
}

if ($_POST['senha-cad'] == "") {
    echo 'Preencha o campo senha!';
    exit();
}

if ($_POST['senha-cad'] != $_POST['conf-senha']) {
    echo 'As senhas não conferem, por favor verifique!';
    exit();
}

//ENVIANDO OS DADOS DA MODAL CADASTRO PARA A TABELA USUARIO
/* Utiliza o prepare para aumentar a segurança e evitar SQL Injection*/
$result = $pdo->query("SELECT * FROM usuario where cpf = '$_POST[cpf]'");
$dados = $result->fetchAll(PDO::FETCH_ASSOC);

if (@count($dados) == 0) {
    $result = $pdo->prepare("INSERT into usuario (nome, cpf, email, senha, senha_crip, nivel) values (:nome, :cpf, :email, :senha, :senha_crip, :nivel)");
    $result->bindValue(":nome", $_POST['nome']);
    $result->bindValue(":cpf", $_POST['cpf']);
    $result->bindValue(":email", $_POST['email']);
    $result->bindValue(":senha", $_POST['senha-cad']);
    $result->bindValue(":senha_crip", $senha_crip);
    $result->bindValue(":nivel", 'Cliente');
    $result->execute();

    echo 'Cadastrado com Sucesso!';
} else {
    echo 'CPF já cadastrado!';
}

//ENVIANDO OS DADOS DA MODAL CADASTRO PARA A TABELA EMAIL
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