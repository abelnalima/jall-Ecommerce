<?php

require_once("../../../conexao.php");

$id = $_POST['id'];

$pdo->query("DELETE FROM categorias WHERE id_categorias = '$id'");

echo 'Excluído com Sucesso!';

?>