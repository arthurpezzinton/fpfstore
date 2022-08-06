<?php

	require_once "conexao.php";
	require_once "crud.php";

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	function getCard($code,$name,$category,$marca,$tamanho,$description,$price,$discount,$picture,$qtd){
?>
	<div class="product-column">
					<div class="product-card choosen" align="center">
						<div class="product-gallery">
							<?php
								if(empty($picture)){
							?>
								<img src="images/no_image.png" style="height:300px; width: auto;">
							<?php
								}else{
							?>
								<img src="images/<?php echo $code.'/'.$picture; ?>" style="height:300px; width: auto;">
							<?php
								}
							?>
						</div>
						<br>
						<div class="product-text" align="left">
							<div class="row">
								<div class="col-9" align="left">
									<h2><?php echo $name; ?></h2>
									<h6><?php echo $marca; ?></h6>
								</div>
								<div class="col-3" align="right">
									<h2><?php echo $tamanho; ?></h2>Tamanho
								</div>
							</div>
							<p><?php echo $description; ?></p>
							<div class="row">
								<div class="col-6">
									<p>Dispon&iacute;veis: <strong><?php echo $qtd; ?></strong> un.</p>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<?php
										$discountText = "";
										if($discount != "0"){
											$discountText = "De <strong>R$<s style='color: darkred;'>&nbsp;".number_format($price,2,",",".")."</s></strong> por ";
											$price = $price*(1-($discount/100));
										}
									?>
									<br><?php echo $discountText; ?>
									</div>
									<div class="col-6">
									<p align="right"><strong>R$&nbsp;</strong><strong style="font-size: 200%" class="product-price"><?php echo number_format($price,2,",","."); ?></strong></p>
								</div>
							</div>
							<div class="row">
								<div class="col-4">
									<a href="view_product.php?code=<?php echo $code; ?>"><button class="btn btn-product-gallery" title="Ver mais sobre este produto" style="font-size: 30px"><i class='fas fa-search-plus'></i></button></a>
								</div>
								<div class="col-4">
									<button class="btn btn-product-cart" title="Adicionar o produto &agrave; lista de desejos" style="font-size: 30px" onclick="addToCart('<?php echo $code; ?>')"><i class='fas fa-cart-plus'></i></button>
								</div>
								<div class="col-4">
									<button class="btn btn-product-buy" title="Comprar o produto agora!" style="font-size: 30px" onclick="buyNow('<?php echo $code; ?>')"><i class='fas fa-cart-arrow-down'></i></button>
								</div>
							</div>
						</div>
					</div>
				</div>
<?php
	}
?>