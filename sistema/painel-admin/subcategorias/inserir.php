<?php

require_once("../../../conexao.php"); 

$nome = $_POST['nome-cat'];
$nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", 
            strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")
            ));
$slug = preg_replace('/[ -]+/' , '-' , $nome_novo); //Transforma o nome da categoria em minusculo e altera para ficar no formato xxx-xxx
$antigo = $_POST['antigo'];
$id = $_POST['txtid2'];

if ($nome == "") {
	echo 'Preencha o Campo Nome!';
	exit();
}

//VERIFICA SE A CATEGORIA JÁ ESTÁ CADASTRADA
if ($nome != $antigo) {
	$res = $pdo->query("SELECT * FROM categorias where nome = '$nome'"); 
	$dados = $res->fetchAll(PDO::FETCH_ASSOC);

	if (@count($dados) > 0) {
			echo 'Categoria já Cadastrada no Banco!';
			exit();
		}
}

//ENVIANDO A IMAGEM PARA A PASTA DE CATEGORIAS
$caminho = '../../../img/categorias/' .@$_FILES['imagem']['name'];

if (@$_FILES['imagem']['name'] == "") {
  $imagem = "sem-foto.jpg";
} else {
  $imagem = @$_FILES['imagem']['name']; 
}

$imagem_temp = @$_FILES['imagem']['tmp_name']; 

$ext = pathinfo($imagem, PATHINFO_EXTENSION);

if ($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif') { 
    move_uploaded_file($imagem_temp, $caminho);
} else {
	echo 'Extensão de Imagem não permitida!';
	exit();
}

//ENVIANDO OS DADOS PARA O BANCO DE DADOS
if ($id == "") {
    $res = $pdo->prepare("INSERT INTO categorias (nome, slug, imagem) VALUES (:nome, :slug, :imagem)");
    $res->bindValue(":imagem", $imagem);
} else {
    if ($imagem == "sem-foto.jpg") {
        $res = $pdo->prepare("UPDATE categorias SET nome = :nome, slug = :slug WHERE id_categorias = :id");
    } else {
        $res = $pdo->prepare("UPDATE categorias SET nome = :nome, slug = :slug, imagem = :imagem WHERE id_categorias = :id");
        $res->bindValue(":imagem", $imagem);
    }

    $res->bindValue(":id", $id);
}

$res->bindValue(":nome", $nome);
$res->bindValue(":slug", $slug);

$res->execute();

echo 'Salvo com Sucesso!!';

?>