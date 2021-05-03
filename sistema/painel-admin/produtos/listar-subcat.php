<?php

require_once("../../../conexao.php");

$id_categoria = $_POST['txtNomeCat'];

echo "<select class='sm-width form-control form-control-sm' name='subcategoria' id='subcategoria'>";

$result = $pdo->query("SELECT * FROM sub_categorias WHERE id_categoria = '$id_categoria' order by nome asc");
$dados = $result->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($dados); $i++) {
    foreach ($dados[$i] as $key => $value) {
    }

    echo "<option value='" . $dados[$i]['id_categoria'] . "'>" . $dados[$i]['nome'] . "</option>";
}

echo "</select>";

?>

