<?php

//Variáveis globais
$nome_loja = 'JALL';
$email = 'jall@gmail.com';
$telefone = '(99) 9999-9999';
$whatsapp = '(99) 9.9999-9999';
$whatsapp_link = '5599999999999';
$title = 'Jall | Comércio Eletrônico';
$texto_destaque = 'Inserir alguma informação pertinente';
$endereco_loja = 'Inserir endereço da loja';
$texto_cupom = 'Insira o seu código de cupom';

//VARIÁVEIS DO BANCO DE DADOS
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "jalldb";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];

?>