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
				$pictureDefined;
						
				$pictures = $blog->getPicture($_GET['code']);
				foreach ($pictures as $pict):
					$pictureDefined = $pict->fotos_nome;
				endforeach;
		?>

			<div class="view-card">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-3 col-xl-4 p-3" align="center">
						<img src="images/<?php echo (empty($pictureDefined))?'no_image.png':$_GET['code'].'/'.$pict->fotos_nome; ?>" style="width: 100%">
					</div>
					<div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 p-3">
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
						<hr>
						<div class="row">
							<div class="col-6" align="left">
								<label><strong>Quantidade</strong></label>
								<input class="form-control" type="number" name="buyNowQtd" id="buyNowQtd" min="1" max="<?php echo $reg->produtos_qtd; ?>" value="1" onchange="changeTotal()">
							</div>
							<div class="col-6" align="right">
								<input type="number" name="totalNumber" id="totalNumber" value="<?php echo $reg->produtos_preco; ?>" hidden>
								<strong>R$&nbsp;</strong><strong style="font-size: 35px" class="product-price" id="totalText"><?php echo number_format($reg->produtos_preco,2,",","."); ?></strong><br>Total
							</div>
							<?php
								$userEmail;
								$userCompleteName;
								$userAddress;
								$userCity;
								$userState;
								$userCEP;

								if(isset($_SESSION['user'])){
									$userData = $blog->getUserData($_SESSION['user']);

									foreach($userData as $usr):
										$userEmail = $usr->pessoas_email;
										$userCompleteName = $usr->pessoas_nome." ".$usr->pessoas_sobrenome;
										$userAddress = $usr->pessoas_endereco;
										$userCity = $usr->pessoas_cidade;
										$userState = $usr->pessoas_estado;
										$userCEP = $usr->pessoas_cep;
									endforeach;
								}
							?>
						</div>
						<hr>
						<div class="row">
							<div class="col-12" align="left">
								<label><strong>Email</strong></label>
								<input class="form-control" type="email" name="buyNowEmail" id="buyNowEmail" value="<?php echo (empty($userEmail))?'':$userEmail; ?>">
							</div>
						</div><br>
						<div class="row">
							<div class="col-12" align="left">
								<label><strong>Destinat&aacute;rio</strong></label>
								<input class="form-control" type="text" name="buyNowName" id="buyNowName" value="<?php echo (empty($userCompleteName))?'':$userCompleteName; ?>">
							</div>
						</div>
					</div>

					<div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 p-3" align="center">
						<div class="row">
							<div class="col-12" align="left">
								<label><strong>Endere&ccedil;o</strong></label>
								<input class="form-control" type="text" name="buyNowAddress" id="buyNowAddress" value="<?php echo (empty($userAddress))?'':$userAddress; ?>">
							</div>
						</div><br>
						<div class="row">
							<div class="col-4" align="left">
								<label><strong>Cidade</strong></label>
								<input class="form-control" type="text" name="buyNowCity" id="buyNowCity" value="<?php echo (empty($userCity))?'':$userCity; ?>">
							</div>
							<div class="col-4" align="left">
								<label><strong>Estado</strong></label>
								<input class="form-control" type="text" name="buyNowState" id="buyNowState" value="<?php echo (empty($userState))?'':$userState; ?>">
							</div>
							<div class="col-4" align="left">
								<label><strong>CEP</strong></label>
								<input class="form-control" type="number" name="buyNowCEP" id="buyNowCEP" value="<?php echo (empty($userCEP))?'':$userCEP; ?>">
							</div>
						</div><br>
						<div class="row">
							<div class="col-12"><h4><strong><i>Pagamento</i></strong></h4></div>
						</div><br>
						<div class="row">
							<div class="col-12">
								<label><strong><i>Nome no cart&atilde;o</i></strong></label>
								<input class="form-control" type="text" name="paymentCardName" id="paymentCardName" placeholder="Nome do Propriet&aacute;rio" disabled>
							</div>
						</div><br>
						<div class="row">
							<div class="col-12">
								<label><strong><i>N&uacute;mero do cart&atilde;o</i></strong></label>
								<input class="form-control" type="number" name="paymentCardNumber" id="paymentCardNumber" placeholder="111222333444" disabled>
							</div>
						</div><br>
						<div class="row">
							<div class="col-8">
								<label><strong><i>Validade (m&ecirc;s e ano)</i></strong></label>
								<input class="form-control" type="month" name="paymentCardDate" id="paymentCardDate" disabled>
							</div>
							<div class="col-4">
								<label><strong><i>CVV</i></strong></label>
								<input class="form-control" type="number" name="paymentCardCVV" id="paymentCardCVV" placeholder="999" disabled>
							</div>
						</div><br>
						<div class="row">
							<div class="col-8" style="font-size: 11px">
								<em style="color: red;font-size: 17px;">*</em> Sendo uma loja fict&iacute;cia, os dados de pagamento n&atilde;o ser&atilde;o utilizados.
							</div>
							<div class="col-4">
								<button class="btn btn-product-buy" title="Finalizar a compra" style="font-size: 17px" onclick="endBuyNow('<?php echo $_GET['code']?>')"><i class='fas fa-credit-card'></i> Finalizar</button>						
							</div>						
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 p-3" align="center">
						<div class="loader" id="loaderPay" style="display: none;"></div>
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