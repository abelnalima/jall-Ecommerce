<?php

$pag = "produtos";
require_once("../../conexao.php");

//VERIFICAR SE O USUÁRIO ESTÁ AUTENTICADO, SE NÃO ESTIVER RETORNA PARA A INDEX
@session_start();
if (@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin') {
    echo "<script language='javascript'> window.location='../index.php' </script>";
}
?>

<div class="row mt-4 mb-4">
    <a type="button" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo">Novo Produto</a>
    <a type="button" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo">+</a>
</div>

<!-- DATATABLE -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Valor</th>
                        <th>Estoque</th>
                        <th>Subcategoria</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = $pdo->query("SELECT * FROM produtos order by id_produtos desc ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < count($res); $i++) {
                        foreach ($res[$i] as $key => $value) {
                        }

                        $nome = $res[$i]['nome'];
                        $valor = $res[$i]['valor'];
                        $estoque = $res[$i]['estoque'];
                        $subcategoria = $res[$i]['id_sub_cat'];
                        $imagem = $res[$i]['imagem'];
                        $ativo = $res[$i]['ativo'];
                        $id = $res[$i]['id_produtos'];

                        //RECUPERANDO O NOME DAS SUBCATEGORIAS ATRAVÉS DO ID
                        $query2 = $pdo->query("SELECT * FROM sub_categorias WHERE id_sub_cat = '$subcategoria'");
                        $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        $nomeSub = $result2[0]['nome'];
                    ?>

                        <tr>
                            <td><?php echo $nome ?></td>
                            <td><?php echo $valor ?></td>
                            <td><?php echo $estoque ?></td>
                            <td><?php echo $nomeSub ?></td>
                            <td><img src="../../img/produtos/<?php echo $imagem ?>" width="50"></td>
                            <td>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo $id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit'></i></a>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo $id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL PARA INSERÇÃO/EDIÇÃO DOS DADOS RELACIONADOS AS CATEGORIAS -->
<div class="modal fade" id="modalDados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php if (@$_GET['funcao'] == 'editar') {
                    $titulo = "Editar Registro";
                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM produtos where id_produtos = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $nome2 = $res[0]['nome'];
                    $slug2 = $res[0]['slug'];
                    $descricao2 = $res[0]['descricao'];
                    $desc_longa2 = $res[0]['desc_longa'];
                    $keyword2 = $res[0]['keyword'];
                    $imagem2 = $res[0]['imagem'];
                    $subcategoria2 = $res[0]['id_sub_cat'];
                    $valor2 = $res[0]['valor'];
                    $estoque2 = $res[0]['estoque'];
                    $envio2 = $res[0]['id_envio'];
                    $id_categoria = $res[0]['id_categoria'];
                    $ativo2 = $res[0]['ativo'];
                    $peso2 = $res[0]['peso'];
                    $largura2 = $res[0]['largura'];
                    $altura2 = $res[0]['altura'];
                    $comprimento2 = $res[0]['comprimento'];
                    $val_frete2 = $res[0]['val_frete'];
                } else {
                    $titulo = "Inserir Registro";
                } ?>

                <h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo ?></h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nome</label>
                                <input value="<?php echo @$nome2 ?>" type="text" class="form-control form-control-sm" id="nome-cat" name="nome-cat" placeholder="Nome">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Categorias</label>
                                <select name="categoria" id="categoria" class="form-control form-control-sm">
                                    <?php
                                    if (@$_GET['funcao'] == 'editar') {
                                        $query = $pdo->query("SELECT * FROM categorias WHERE id_categorias = '$id_categoria'");
                                        $result = $query->fetchAll(PDO::FETCH_ASSOC);
                                        $nomeCat = $result[0]['nome'];

                                        echo "<option value='" . $id_categoria . "'>" . $nomeCat . "</option>";
                                    }

                                    $query2 = $pdo->query("SELECT * FROM categorias order by nome asc");
                                    $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);

                                    for ($i = 0; $i < count($result2); $i++) {
                                        foreach ($result2[$i] as $key => $value) {
                                        }

                                        if (@$nomeCat != $result2[$i]['nome']) {
                                            echo "<option value='" . $result2[$i]['id_categorias'] . "'>" . $result2[$i]['nome'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>

                                <input type="hidden" id="txtNomeCat" name="txtNomeCat">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sub-Categoria</label>
                                <span id="listar-subcat"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Descrição Curta <small>(500 caracteres)</small></label>
                        <textarea maxlenght="1000" class="form-control-file" id="descricao" name="descricao"><?php echo @$descricao2 ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Descrição Longa</label>
                        <textarea class="form-control-file" id="desc_longa" name="desc_longa"><?php echo @$desc_longa2 ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor</label>
                                <input value="<?php echo @$valor2 ?>" type="text" class="form-control form-control-sm" id="valor" name="valor" placeholder="Valor">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Estoque</label>
                                <input value="<?php echo @$estoque2 ?>" type="text" class="form-control form-control-sm" id="estoque" name="estoque" placeholder="Quantidade">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tipo de Envio</label>
                                <select name="envio" id="envio" class="form-control form-control-sm">
                                    <?php
                                    if (@$_GET['funcao'] == 'editar') {
                                        $query = $pdo->query("SELECT * FROM envios WHERE id_envio = '$envio2'");
                                        $result = $query->fetchAll(PDO::FETCH_ASSOC);
                                        $tipoEnvio = $result[0]['tipo'];

                                        echo "<option value='" . $id_envio . "'>" . $tipoEnvio . "</option>";
                                    }

                                    $query2 = $pdo->query("SELECT * FROM envios order by tipo asc");
                                    $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);

                                    for ($i = 0; $i < count($result2); $i++) {
                                        foreach ($result2[$i] as $key => $value) {
                                        }

                                        if (@$tipoEnvio != $result2[$i]['tipo']) {
                                            echo "<option value='" . $result2[$i]['id_envio'] . "'>" . $result2[$i]['tipo'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Ativo</label>
                                <select name="ativo" id="ativo" class="form-control form-control-sm">
                                    <?php

                                    if (@$_GET['funcao'] == 'editar') {
                                        echo "<option value='" . $ativo2 . "'>" . $ativo2 . "</option>";
                                    }

                                    if (@$ativo2 != "Sim") {
                                        echo "<option value='Sim'> Sim </option>";
                                    }

                                    if (@$ativo2 != "Não") {
                                        echo "<option value='Não'> Não </option>";
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Palavras Chaves</label>
                        <input value="<?php echo @$keyword2 ?>" type="text" class="form-control form-control-sm" id="keyword" name="keyword" placeholder="Palavras Chaves">
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Peso</label>
                                <input value="<?php echo @$peso2 ?>" type="text" class="form-control form-control-sm" id="peso" name="peso" placeholder="Peso em gramas">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Largura</label>
                                <input value="<?php echo @$largura2 ?>" type="text" class="form-control form-control-sm" id="largura" name="largura" placeholder="Largura">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Altura</label>
                                <input value="<?php echo @$altura2 ?>" type="text" class="form-control form-control-sm" id="altura" name="altura" placeholder="Altura">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Comprimento</label>
                                <input value="<?php echo @$comprimento2 ?>" type="text" class="form-control form-control-sm" id="comprimento" name="comprimento" placeholder="Comprimento">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <!-- Se quiser adicionar um campo com frete fixo -->
                                <label>Valor Frete</label>
                                <input value="<?php echo @$val_frete2 ?>" type="text" class="form-control form-control-sm" id="val_frete" name="val_frete" placeholder="Valor do Frete (Fixo)">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Imagem</label>
                                <input type="file" value="<?php echo @$imagem2 ?>" class="form-control-file" id="imagem" name="imagem" onChange="carregarImg();">
                            </div>

                            <?php if (@$imagem2 != "") { ?>
                                <img src="../../img/subcategorias/<?php echo $imagem2 ?>" width="100" height="100" id="target">
                            <?php  } else { ?>
                                <img src="../../img/subcategorias/sem-foto.jpg" width="100" height="100" id="target">
                            <?php } ?>

                        </div>
                    </div>

                    <small>
                        <div id="mensagem"></div>
                    </small>
                </div>

                <div class="modal-footer">
                    <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
                    <input value="<?php echo @$nome2 ?>" type="hidden" name="antigo" id="antigo">
                    <button type="button" id="btn-fechar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="btn-salvar" id="btn-salvar" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA EXCLUSÃO DE UMA CATEGORIA -->
<div class="modal" id="modalDeletar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>Deseja realmente escluir este registro?</p>
                <div id="mensagem_excluir" text-align="center" class=""></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-excluir">Cancelar</button>
                <form method="post">
                    <input type="hidden" id="id" name="id" value="<?php echo @$_GET['id'] ?>" required>
                    <button type="button" id="btn-deletar" name="btn-deletar" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- VERIFICAÇÃO DE QUAL FUNÇÃO ESTÁ SENDO CHAMADA -->
<?php
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "novo") {
    echo "<script>$('#modalDados').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "editar") {
    echo "<script>$('#modalDados').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir") {
    echo "<script>$('#modalDeletar').modal('show');</script>";
}
?>

<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
    $("#form").submit(function() {
        var pag = "<?= $pag ?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/inserir.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {
                $('#mensagem').removeClass()

                if (mensagem.trim() == "Salvo com Sucesso!!") {
                    $('#btn-fechar').click();
                    window.location = "index.php?pag=" + pag;
                } else {

                    $('#mensagem').addClass('text-danger')
                }

                $('#mensagem').text(mensagem)
            },

            cache: false,
            contentType: false,
            processData: false,
            xhr: function() { // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function() {
                        /* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            }
        });
    });
</script>

<!-- AJAX PARA EXCLUIR UMA CATEGORIA -->
<script type="text/javascript">
    $(document).ready(function() {
        var pag = "<?= $pag ?>";
        $('#btn-deletar').click(function(event) {
            event.preventDefault();

            $.ajax({
                url: pag + "/excluir.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",

                success: function(mensagem) {
                    if (mensagem.trim() == "Excluído com Sucesso!") {
                        $('#btn-cancelar-excluir').click();
                        window.location = "index.php?pag=" + pag;
                    }

                    $('#mensagem-excluir').text(mensagem);
                },
            })
        });
    });
</script>

<!-- AJAX PARA LISTAR AS SUBCATEGORIAS DE ACORDO COM A CATEGORIA SELECIONADA -->
<script type="text/javascript">
    function listarSubCat() {
        var pag = "<?= $pag ?>";

        $.ajax({
            url: pag + "/listar-subcat.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "html",
            success: function(result) {
                $('#listar-subcat').html(result);
            }
        })
    }
</script>

<!--SCRIPT PARA CARREGAR IMAGEM -->
<script type="text/javascript">
    function carregarImg() {
        var target = document.getElementById('target');
        var file = document.querySelector("input[type=file]").files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            target.src = "";
        }
    }
</script>

<!-- SCRIPT PARA DESABILITAR A ORDENAÇÃO PADRÃO DO DATATABLE -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').dataTable({
            "ordering": false
        })
    });
</script>

<!-- SCRIPT CAPTURAR QUAL CATEGORIA FOI SELECIONADA NO SELECT -->
<script type="text/javascript">
    $(document).ready(function() {
        document.getElementById('txtNomeCat').value = document.getElementById('categoria').value;
        listarSubCat();
    })
</script>

<!-- SCRIPT PARA BUSCAR PELO SELECT -->
<script type="text/javascript">
    $('#categoria').change(function() {
        document.getElementById('txtNomeCat').value = $(this).val();
        listarSubCat();
    })
</script>