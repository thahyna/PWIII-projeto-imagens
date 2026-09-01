<?php
require 'classes/Produto.class.php';
$p = new Produto();
$p->conecta();
$produto = $p->buscarProdutosPorId($_GET['id']);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<style>
		section{
			width: 70%;
			margin: auto;
			font-family: arial;
		}
		h1{
			color: rgba(0,0,0,.8);
			border-bottom: 1px solid rgba(0,0,0,.1);
			height: 60px;
			line-height: 70px;
			margin-bottom: 40px;
		}
		#imagens{
			background-color: red;
		}
		.caixa-img{
			width: 15%;
			float: left;
			padding: 1%;
			background-color: rgb(123,104,238,.4);
			margin: 10px;
			height: 150px;
			cursor: pointer;
		}
		img{
			width: 100%;
		}
		p{
			width: 70%;
			text-align: justify;
			line-height: 30px;
		}
	</style>
</head>
<body>
	<section>
		<div>
			<h1><?php echo $produto['nome_produto']; ?></h1>
			<p><b>Descrição: </b><?php echo $produto['descricao']; ?></p>
			<p><b>Valor: </b>R$ <?php echo number_format($produto['valor'], 2, ',', '.'); ?></p>
		</div>
		<div id="imagens">
			<?php foreach ($produto['imagens'] as $imagem): ?>
				<div class="caixa-img">
					<img src="imagens/<?php echo $imagem; ?>">
				</div>
			<?php endforeach; ?>
		</div>
	</section>
</body>
</html>