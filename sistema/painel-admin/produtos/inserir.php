<?php

require_once("../../../conexao.php"); 

$nome = $_POST['nome-cat'];
$id_cat = $_POST['categoria'];
$id_sub_cat = $_POST['subcategoria'];
$descricao = $_POST['descricao'];
$desc_longa = $_POST['desc_longa'];
$valor = $_POST['valor'];
$estoque = $_POST['estoque'];
$envio = $_POST['envio'];
$ativo = $_POST['ativo'];
$keyword = $_POST['keyword'];
$peso = $_POST['peso'];
$largura = $_POST['largura'];
$altura = $_POST['altura'];
$comprimento = $_POST['comprimento'];
$val_frete = $_POST['val_frete'];

$nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", 
            strtr(utf8_decode(trim($nome)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")
            ));
$slug = preg_replace('/[ -]+/' , '-' , $nome_novo); //Transforma o nome da categoria em minusculo e altera para ficar no formato xxx-xxx
$antigo = $_POST['antigo'];
$id = $_POST['txtid2'];

if ($nome == "") {
	echo 'Preencha com o Nome do produto!';
	exit();
}

if ($descricao == "") {
	echo 'Preencha com uma Descrição para o produto!';
	exit();
}

if ($desc_longa == "") {
	echo 'Preencha com uma Descrição Longa para o produto!';
	exit();
}

if ($valor == "") {
	echo 'Preencha com um Valor para o produto!';
	exit();
}

if ($estoque == "") {
	echo 'Preencha o Estoque do produto!';
	exit();
}

if ($descricao == "") {
	echo 'Informe uma ou mais Palavras Chaves para o produto!';
	exit();
}

//ENVIANDO A IMAGEM PARA A PASTA DE CATEGORIAS
$caminho = '../../../img/produtos/' .@$_FILES['imagem']['name'];

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
    $res = $pdo->prepare("INSERT INTO produtos (id_categoria, id_sub_cat, imagem, id_envio, nome, slug, descricao, desc_longa, valor, estoque, keyword, ativo, peso, largura, altura, comprimento, val_frete) 
                        VALUES (:id_categoria, :id_sub_cat, :imagem, :id_envio, :nome, :slug, :descricao, :desc_longa, :valor, :estoque, :keyword, :ativo, :peso, :largura, :altura, :comprimento, :val_frete)");
    $res->bindValue(":imagem", $imagem);
} else {
    if ($imagem == "sem-foto.jpg") {
        $res = $pdo->prepare("UPDATE sub_categorias SET id_categoria = :id_categoria, nome = :nome, slug = :slug WHERE id_categorias = :id");
    } else {
        $res = $pdo->prepare("UPDATE sub_categorias SET id_categoria = :id_categoria, nome = :nome, slug = :slug, imagem = :imagem WHERE id_categorias = :id");
        $res->bindValue(":imagem", $imagem);
    }

    $res->bindValue(":id", $id);
}

$res->bindValue(":id_categoria", $id_cat);
$res->bindValue(":id_sub_cat", $id_sub_cat);
$res->bindValue(":id_envio", $envio);
$res->bindValue(":nome", $nome);
$res->bindValue(":slug", $slug);
$res->bindValue(":descricao", $descricao);
$res->bindValue(":desc_longa", $desc_longa);
$res->bindValue(":valor", $valor);
$res->bindValue(":estoque", $estoque);
$res->bindValue(":ativo", $ativo);
$res->bindValue(":keyword", $keyword);
$res->bindValue(":peso", $peso);
$res->bindValue(":largura", $largura);
$res->bindValue(":altura", $altura);
$res->bindValue(":comprimento", $comprimento);
$res->bindValue(":val_frete", $val_frete);

$res->execute();

echo 'Salvo com Sucesso!!';

?>