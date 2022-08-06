<?php

	require_once "conexao.php";
	require_once "crud.php";

	require_once "card_function.php";

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	@session_start();

	if(isset($_SESSION['user']) && isset($_SESSION['name']) && isset($_GET['code']) && $_SESSION['user'] == "1" && $_SESSION['name'] == "Administrador"){

		if(empty($blog->getDadosProduto($_GET['code'])) && $_GET['code'] != "0"){
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
			<br>
			<?php
				if($_GET['code'] == '0'){
			?>
			<div class="search-card container-fluid mt-3">	
				<div class="row">
					<div class="col-sm-4 p-3">
						<label><strong>Nome do produto</strong></label>
						<input class="form-control" type="text" name="productName" id="productName">
					</div>
					<div class="col-sm-3 p-3">
						<label><strong>Categoria</strong></label>
						<select class="form-control" name="productCategory" id="productCategory">
							<option value="0">...</option>
							<?php
								$dados = $blog->getCategories();

								foreach ($dados as $reg):
							?>
							<option value="<?php echo $reg->categorias_codigo; ?>"><?php echo $reg->categorias_nome; ?></option>
							<?php
								endforeach;
							?>
						</select>
					</div>
					<div class="col-sm-4 p-3">
						<label><strong>Marca</strong></label>
						<input class="form-control" type="text" name="producBrand" id="producBrand">
					</div>
					<div class="col-sm-1 p-3">
						<label><strong>Tamanho</strong></label>
						<input class="form-control" type="text" name="productSize" id="productSize">
					</div>
					<div class="col-sm-6 p-3">
						<label><strong>Descri&ccedil;&atilde;o</strong></label>
						<input class="form-control" type="text" name="productDescription" id="productDescription">
					</div>
					<div class="col-sm-2 p-3">
						<label><strong>Valor (R$)</strong></label>
						<input class="form-control" type="text" name="productValue" id="productValue">
					</div>
					<div class="col-sm-2 p-3">
						<label><strong>Desconto (%)</strong></label>
						<input class="form-control" type="number" name="productDiscount" id="productDiscount">
					</div>
					<div class="col-sm-2 p-3">
						<label><strong>Quantidade</strong></label>
						<input class="form-control" type="number" name="productAmount" id="productAmount">
					</div>
					<div class="col-sm-2 p-3">
						<label></label>
						<a href="config.php"><button class="btn btn-product-cart" title="Salvar"><i class='fas fa-arrow-alt-circle-left'></i>&nbsp; Voltar</button></a>
					</div>
					<div class="col-sm-8 p-3">
					</div>
					<div class="col-sm-2 p-3">
						<label></label>
						<button class="btn btn-product-buy" title="Salvar" onclick="saveProduct('<?php echo $_GET['code']; ?>')"><i class='fas fa-upload'></i>&nbsp; Salvar</button>
					</div>
				</div>
			</div>
			<?php
				}else{
					$dados = $blog->getDadosProduto($_GET['code']);

					foreach($dados as $reg):
			?>
			<div class="search-card container-fluid mt-3">	
				<div class="row">
					<div class="col-sm-4 p-3">
						<label><strong>Nome do produto</strong></label>
						<input class="form-control" type="text" name="productName" id="productName" value="<?php echo $reg->produtos_nome; ?>">
					</div>
					<div class="col-sm-3 p-3">
						<label><strong>Categoria</strong></label>
						<select class="form-control" name="productCategory" id="productCategory">
							<option value="0">...</option>
							<?php
								$categorias = $blog->getCategories();

								foreach ($categorias as $cat):
							?>
							<option value="<?php echo $cat->categorias_codigo; ?>" <?php echo ($cat->categorias_nome == $reg->produtos_categoria_nome)?"selected":""; ?>><?php echo $cat->categorias_nome; ?></option>
							<?php
								endforeach;
							?>
						</select>
					</div>
					<div class="col-sm-4 p-3">
						<label><strong>Marca</strong></label>
						<input class="form-control" type="text" name="producBrand" id="producBrand" value="<?php echo $reg->produtos_marca; ?>">
					</div>
					<div class="col-sm-1 p-3">
						<label><strong>Tamanho</strong></label>
						<input class="form-control" type="text" name="productSize" id="productSize" value="<?php echo $reg->produtos_tamanho; ?>">
					</div>
					<div class="col-sm-6 p-3">
						<label><strong>Descri&ccedil;&atilde;o</strong></label>
						<input class="form-control" type="text" name="productDescription" id="productDescription" value="<?php echo $reg->produtos_descricao; ?>">
					</div>
					<div class="col-sm-2 p-3">
						<label><strong>Valor (R$)</strong></label>
						<input class="form-control" type="text" name="productValue" id="productValue" value="<?php echo number_format($reg->produtos_preco,2,",","."); ?>">
					</div>
					<div class="col-sm-2 p-3">
						<label><strong>Desconto (%)</strong></label>
						<input class="form-control" type="number" name="productDiscount" id="productDiscount" value="<?php echo $reg->produtos_desconto; ?>">
					</div>
					<div class="col-sm-2 p-3">
						<label><strong>Quantidade</strong></label>
						<input class="form-control" type="number" name="productAmount" id="productAmount" value="<?php echo $reg->produtos_qtd; ?>">
					</div>
					<div class="col-sm-2 p-3">
						<label></label>
						<a href="config.php"><button class="btn btn-product-cart" title="Salvar"><i class='fas fa-arrow-alt-circle-left'></i>&nbsp; Voltar</button></a>
					</div>
					<div class="col-sm-6 p-3">
					</div>
					<div class="col-sm-2 p-3">
						<label></label>
						<button class="btn btn-product-gallery" title="Galeria do produto" onclick="viewPictures('<?php echo $_GET['code']; ?>')"><i class='	fas fa-photo-video'></i>&nbsp; Galeria</button>
					</div>
					<div class="col-sm-2 p-3">
						<label></label>
						<button class="btn btn-product-buy" title="Salvar" onclick="saveProduct('<?php echo $_GET['code']; ?>')"><i class='fas fa-upload'></i>&nbsp; Salvar</button>
					</div>
				</div>
			</div>
			<?php
					endforeach;
				}
			?>
		</div>
		<br><br><br><br>
		<?php
			$blog->getBasicFooter();
		?>
	</body>
</html>

<script type="text/javascript">
	
	function saveProduct(code){

		if($("#productName").val()=="" &&
			$("#productCategory").val()=="0" &&
			$("#productSize").val()=="" &&
			$("#productDescription").val()=="" &&
			$("#productValue").val()=="" &&
			$("#productDiscount").val()=="" &&
			$("#productAmount").val()==""
			){
			window.location.href = "config.php";
		}else{
			if($("#productValue").val()<0){
				swal("Valor do produto inv\u00e1lido.");
			}
			else if($("#productDiscount").val()<0 || $("#productDiscount").val()>100){
				swal("Valor de desconto inv\u00e1lido.");
			}
			else if($("#productAmount").val()<0){
				swal("Quantidade inv\u00e1lida.");
			}
			else{
				var ulrUsed = "";

				if(code == "0"){
					ulrUsed = "insert_product.php";
				}else{
					ulrUsed = "update_product.php";
				}

				var valueNumber = parseInt(100*Number($("#productValue").val().replace(",",".")));

				$.ajax({
					type: "POST",
					url: ulrUsed,
					dataType: 'json',
					data: {
						codigo: code,
						nome: $("#productName").val(),
						categoria: $("#productCategory").val(),
						marca: $("#producBrand").val(),
						tamanho: $("#productSize").val(),
						descricao: $("#productDescription").val(),
						valor: valueNumber,
						desconto: $("#productDiscount").val(),
						qtd: $("#productAmount").val(),
					},
								
					success: function(result){
						swal({
							  title: "Conclu\u00eddo",
							  text: "Salvamento conclu\u00eddo",
							  icon: "success",
							  buttons: true,
							  dangerMode: false,
							}).then((willGo) => {
							  if (willGo) {
							  		if(code == "0"){
							  			window.location.href = "config.php";
							  		}else{
										window.location.href = "product_config.php?code="+code;
									}
							  } else {
									if(code == "0"){
							  			window.location.href = "config.php";
							  		}else{
										window.location.href = "product_config.php?code="+code;
									}
							  }
							});
					},
					error: function(message) {
						swal({
						  title: "Erro",
						  text: "Desculpe, houve um erro na escrita dos dados.",
						  icon: "warning",
						  buttons: true,
						  dangerMode: true,
						});
					}
				});
			}
		}
	}

	function viewPictures(code){
		window.location.href = "pictures_config.php?code="+code;
	}

</script>


<?php
		}
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