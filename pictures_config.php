<?php

	require_once "conexao.php";
	require_once "crud.php";

	require_once "card_function.php";

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	@session_start();

	if(isset($_SESSION['user']) && isset($_SESSION['name']) && isset($_GET['code']) && $_SESSION['user'] == "1" && $_SESSION['name'] == "Administrador"){

		if(empty($blog->getDadosProduto($_GET['code']))){
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
			<div id="produtos" class="config-card">
				<form action="upload_foto.php" method="post" enctype="multipart/form-data">
					<input type="text" name="code" id="code" value="<?php echo $_GET['code']; ?>" hidden>
					<div class="row">
						<div class="col-sm-4 p-3">
							<input type="file" name="fileToUpload[]" id="fileToUpload" class="btn" multiple>
						</div>
						<div class="col-sm-4 p-3">
						</div>
						<div class="col-sm-4 p-3" align="right">
							<button class="btn btn-primary" type="submit" name="submit"><i class='fas fa-plus-circle'></i>  Enviar Foto(s)</button>
						</div>
					</div>
				</form>
				<hr>
				<div class="table-responsive">
					<table class="table table-striped table-hover" style="vertical-align: middle;">
						<thead>
							<tr>
								<th style="width:30%">Foto</th>
								<th style="width:55%">Nome do arquivo</th>
								<th style="width:15%"></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$dados = $blog->getPicturesProduto($_GET['code']);

								foreach($dados as $reg):
							?>
							<tr>
								<td align="center">
									<img src="<?php echo 'images/'.$_GET['code'].'/'.$reg->fotos_nome; ?>" style="height:auto; width: 100%;">
								</td>
								<td align="center"><?php echo $reg->fotos_nome; ?></td>
								<td align="right"><button class="btn btn-product-gallery" title="Excluir foto" onclick="deletePicture('<?php echo $reg->fotos_nome; ?>','<?php echo $_GET['code']; ?>')"><i class='fas fa-trash-alt'></i>  Excluir</button></td>
							</tr>
							<?php
								endforeach;
							?>
						</tbody>
					</table>
				</div>

				<div class="row">
					<div class="col-sm-2 p-3">
						<a href="product_config.php?code=<?php echo $_GET['code']; ?>"><button class="btn btn-product-cart" title="Salvar"><i class='fas fa-arrow-alt-circle-left'></i>&nbsp; Voltar</button></a>
					</div>
				</div>
			</div>
		</div>
		<br><br><br><br>
		<?php
			$blog->getBasicFooter();
		?>
	</body>
</html>

<script type="text/javascript">

	function deletePicture(name,code){
		swal({
			  title: "Aten\u00e7\u00e3o!",
			  text: "Ao excluir esta foto, ela n\u00e3o ser\u00e1 mais exibida aos clientes e esta opera\u00e7\u00e3o n\u00e3o poder\u00e1 ser desfeita. Confirmar exclus\u00e3o?",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			}).then((willLock) => {
			  if (willLock) {
			  		$.ajax({
						type: "POST",
						url: "delete_photo_product.php",
						dataType: 'json',
						data: {
							codigo: code,
							nome: name,
						},
									
						success: function(result){
							window.location.href = "pictures_config.php?code="+code;
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
			});
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