<?php

	require_once "conexao.php";
	require_once "crud.php";

	require_once "card_function.php";

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	@session_start();

	if(isset($_SESSION['user'])){
?>
<!DOCTYPE html>
<html>
	<head>
		<title>FPF Store</title>
		<?php
			$blog->getBasicHead();
		?>
	</head>
	<body>
		<?php
			$blog->getNavBar("");
		?>
		<br>
		<div class="container">
		<?php
			$emptyLoop = true;

			$dados = $blog->getCartData($_SESSION['user']);

			foreach($dados as $reg):
				$emptyLoop = false;
		?>
			<div class="product-column">
				<div class="product-card" align="center">
					<div class="product-gallery">
						<?php
							if(empty($reg->nome_foto)){
						?>
							<img src="images/no_image.png" style="height:300px; width: auto;">
						<?php
							}else{
						?>
							<img src="images/<?php echo $reg->produtos_codigo.'/'.$reg->nome_foto; ?>" style="height:300px; width: auto;">
						<?php
							}
						?>
					</div>
					<br>
					<div class="product-text" align="left">
						<div class="row">
							<div class="col-6" align="left">
								<h2><?php echo $reg->produtos_nome; ?></h2>
								<h6><?php echo $reg->produtos_marca; ?></h6>
							</div>
							<div class="col-6" align="right">
								<h2><?php echo $reg->produtos_tamanho; ?></h2>Tamanho
							</div>
						</div>
						<p><?php echo $reg->produtos_descricao; ?></p>
						<div class="row">
							<div class="col-6">
								<p>Dispon&iacute;veis: <strong><?php echo $reg->produtos_qtd; ?></strong> un.</p>
							</div>
							<div class="col-6">
								<?php
									$discountText = "";
									if($reg->produtos_desconto != "0"){
										$discountText = "De <strong>R$&nbsp;".number_format($reg->produtos_preco,2,",",".")."</strong> por ";
										$reg->produtos_preco = $reg->produtos_preco*(1-($reg->produtos_desconto/100));
									}
								?>
								<p align="right"><?php echo $discountText; ?><strong>R$&nbsp;</strong><strong style="font-size: 35px" class="product-price"><?php echo number_format($reg->produtos_preco,2,",","."); ?></strong></p>
							</div>
						</div>
						<div class="row">
							<div class="col-6 p-3">
								<button class="btn btn-product-cart" title="Remover da lista" onclick="removeCart('<?php echo $reg->carrinho_codigo; ?>')"><i style="font-size: 20px" class='fas fa-trash-alt'></i> Remover da lista</button>
							</div>
							<div class="col-6 p-3">
								<button class="btn btn-product-buy" title="Comprar o produto agora!" onclick="buyNow('<?php echo $reg->produtos_codigo; ?>')"><i style="font-size: 20px" class='fas fa-cart-arrow-down'></i> Comprar agora!</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
			endforeach;

			if($emptyLoop){
				include 'empty_cart.php';
			}
		?>

		<br><br><br><br>
		</div>
		<br><br><br><br>
		<?php
			$blog->getBasicFooter();
		?>
	</body>
</html>

<script type="text/javascript">

	function changeTotal(){
		$("#totalText").empty();
		$("#totalText").append((($("#buyNowQtd").val()*$("#totalNumber").val()).toFixed(2)).replace(".", ","));
	}

</script>
<?php

	}else{
?>
<!DOCTYPE html>
<html>
	<head>
		<title>FPF Store</title>
		<?php
			$blog->getBasicHead();
		?>
	</head>
	<body>
		<?php
			$blog->getNavBar("");
		?>
		<div class="container">
			
			<?php
				include 'error.php';
			?>
		</div>
		<br><br><br><br>
		<?php
			$blog->getBasicFooter();
		?>
	</body>
</html>
<?php
	}
?>