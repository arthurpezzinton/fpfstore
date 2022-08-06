<?php

	require_once "conexao.php";
	require_once "crud.php";

	require_once "card_function.php";

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	@session_start();

	if(isset($_GET['code'])){
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
			$dados = $blog->getDadosProduto($_GET['code']);

			foreach($dados as $reg):
		?>
			<div class="view-card">
				<div class="row">
					<div class="col-sm-6 p-3">
						<div id="productPictures" class="carousel slide" data-bs-ride="carousel" align="center">
							<div class="carousel-inner">
							<?php
								$pictures = $blog->getPicturesProduto($_GET['code']);

								if(empty($pictures)){
							?>
								<div class="carousel-item active">
									<img src="images/no_image.png" class="d-block" style="height: 600px">
								</div>
							<?php
								}else{

									$firstPict = true;

									foreach($pictures as $pict):
							?>
								<div class="carousel-item <?php echo ($firstPict == true)?'active':'';?>">
									<img src="images/<?php echo $_GET['code']; ?>/<?php echo $pict->fotos_nome; ?>" class="d-block" style="height: 600px">
								</div>
							<?php
										$firstPict = false;
									endforeach;
								}
							?>
								<button class="carousel-control-prev" type="button" data-bs-target="#productPictures" data-bs-slide="prev">
									<i class='fas fa-chevron-left text-link' style="font-size: 30px;"></i>
								</button>
								<button class="carousel-control-next" type="button" data-bs-target="#productPictures" data-bs-slide="next">
									<i class='fas fa-chevron-right text-link' style="font-size: 30px;"></i>
								</button>
							</div>
						</div>
					</div>
					<div class="col-sm-1 p-3">
					</div>
					<div class="col-sm-5 p-3">
						<div class="row">
							<div class="col-12" align="center">
								<img src="images/logo.png" class="d-block" style="width:40%">
							</div>
						</div><br><br>
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
										$discountText = "De <strong>R$<s style='color: darkred;'>&nbsp;".number_format($reg->produtos_preco,2,",",".")."</s></strong> por ";
										$reg->produtos_preco = $reg->produtos_preco*(1-($reg->produtos_desconto/100));
									}
								?>
								<p align="right"><?php echo $discountText; ?><strong>R$&nbsp;</strong><strong style="font-size: 35px" class="product-price"><?php echo number_format($reg->produtos_preco,2,",","."); ?></strong></p>
							</div>
						</div>
						<br><br>
						<div class="row">
							<div class="col-sm-6 p-3">
								<button class="btn btn-product-cart" title="Adicionar o produto &agrave; lista de desejos" style="font-size: 17px" onclick="addToCart('<?php echo $_GET['code']; ?>')"><i class='fas fa-cart-plus'></i> Adicionar ao carrinho</button>
							</div>
							<div class="col-sm-6 p-3">
								<button class="btn btn-product-buy" title="Comprar o produto agora!" style="font-size: 17px" onclick="buyNow('<?php echo $_GET['code']; ?>')"><i class='fas fa-cart-arrow-down'></i> Comprar agora!</button>
							</div>
						</div>
					</div>					
				</div>
			</div>
		<?php

			endforeach;
		?>
		</div>
		<br><br><br><br>
		<?php
			$blog->getBasicFooter();
		?>
	</body>
</html>
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