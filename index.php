<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Formulario de Cadastro</title>
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>

<body>
    <section>
        <a href="produtos.php" class="sombra">Ver todos os produtos</a>
        <form method="post" enctype="multipart/form-data">
            <h1>ENVIO DE IMAGENS</h1>
            <label for="nome">Nome do Produto</label>
            <input type="text" name="nome" id="nome" class="sombra">

            <label for="des">Descrição</label>
            <textarea name="desc" id="desc" class="sombra"></textarea>

            <label for="val">Valor</label>
            <input type="number" name="valor" id="val" class="sombra" step="0.01" min="0">

            <input type="file" name="foto[]" multiple id="foto" class="sombra meuInput">
            <input type="submit" id="botao">
        </form>
    </section>
</body>

</html>

<?php
//checa se o usuario preencheu ao menos o nome
if (isset($_POST['nome']) && !empty($_POST['nome'])) {
    //coloca o dado preenchido em uma variavel nome e checa se nao tem injection
    $nome = addslashes($_POST['nome']);
    $descricao = addslashes($_POST['desc']); //faz o mesmo para a descricao
    $valor = addslashes($_POST['valor']);

    //cria um array vazio para guardar os nomes das fotos caso tenha enviado
    $fotos = array();

    //checa se foi enviada alguma foto
    if (isset($_FILES['foto'])) {
        $tipo = '';
        //cria um laco e repete enquanto houver fotos
        for ($i = 0; $i < count($_FILES['foto']['name']); $i++) {
            if ($_FILES['foto']['type'][$i] == "image/png") {
                $tipo = ".png";
            } elseif ($_FILES['foto']['type'][$i] == 'image/jpeg') {
                $tipo = ".jpg";
            } else {
                $tipo = "outro";
            }

            if ($tipo == 'outro') {
?>
                <script>
                    alert("Só é possível enviar arquivos JPG e PNG");
                </script>
<?php
            } else {
                $nome_arquivo = md5($_FILES['foto']['name'][$i]) . rand(1, 999) . $tipo; //encripta

                //move o arquivo para a pasta imagens ja com o nome novo do arquivo
                move_uploaded_file($_FILES['foto']['tmp_name'][$i], 'imagens/' . $nome_arquivo);

                //armazena o nome do arquivo no vetor fotos
                array_push($fotos, $nome_arquivo);
            }
        }
    }

    //Verifica se todos os campos foram digitados no formulario
    if (!empty($nome) && !empty($descricao) && !empty($fotos)) {
        require 'classes/Produto.class.php';
        $p = new Produto();
        $p->conecta();
        $p->enviarProduto($nome, $descricao, $valor, $fotos);
    } else {
?>
        <script>
            alert("Preencha os campos obrigatorios!")
        </script>
<?php
    }
}
?>