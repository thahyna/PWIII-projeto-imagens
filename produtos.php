<?php
require 'classes/Produto.class.php';
$p = new Produto();
$p->conecta();
$produtos = $p->buscarProdutos();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<style type="text/css">
	section{
		width: 70%;
		margin: auto;
		font-family: arial;
	}
	div{
		width: 15%;
		float: left;
		padding: 1%;
		background-color: rgb(123,104,238,.4);
		margin: 10px;
	}
	img{
		width: 100%;
		height: 150px;
	}

	h2{
		font-size: 12pt;
		color: white;
		text-align: center;
		background-color: rgba(0,0,0,.5);
		padding: 10px 0px;
		font-weight: normal;
	}
	p{
		font-size: 10pt;
	}
	</style>
</head>
<body>
	<section>
		<?php foreach ($produtos as $produto): ?>
			<a href="exibir_produto.php?id=<?php echo $produto['id_produto']; ?>">
				<div>
					<img src="imagens/<?php echo $produto['capa']; ?>">
					<h2><?php echo $produto['nome_produto']; ?></h2>
				</div>
			</a>
		<?php endforeach; ?>
	</section>
</body>
</html>