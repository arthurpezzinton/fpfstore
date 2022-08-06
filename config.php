<?php

	require_once "conexao.php";
	require_once "crud.php";

	require_once "card_function.php";

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	@session_start();

	if(isset($_SESSION['user']) && isset($_SESSION['name']) && $_SESSION['user'] == "1" && $_SESSION['name'] == "Administrador"){
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

			<div class="config-card">
				<div class="row" align="center">
					<div class="col-sm-4 p-4">
						<a class="text-link <?php echo (isset($_GET['view']))?:'text-selected'; ?>" onclick="turnView('#produtos','#buttonProdutos')" id="buttonProdutos"><h4>Produtos</h4></a>
					</div>
					<div class="col-sm-4 p-4">
						<a class="text-link <?php echo (isset($_GET['view']) && $_GET['view']=='category')?'text-selected':''; ?>" onclick="turnView('#categorias','#buttonCategorias')" id="buttonCategorias"><h4>Categorias</h4></a>
					</div>
					<div class="col-sm-4 p-4">
						<a class="text-link <?php echo (isset($_GET['view']) && $_GET['view']=='compras')?'text-selected':''; ?>" onclick="turnView('#compras','#buttonCompras')" id="buttonCompras"><h4>Compras</h4></a>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-12 p-3" align="center">
					<div class="loader" id="loaderConfig" style="display: none;"></div>
				</div>
			</div>
			<div id="produtos" class="config-card collapse <?php echo (isset($_GET['view']))?:'show'; ?>">
				<div class="table-responsive">
					<button class="btn btn-primary" title="Adicionar produto" onclick="productConfig('0')"><i class='fas fa-plus-circle'></i>  Adicionar</button>
					<hr>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th style="width:5%">C&oacute;digo</th>
								<th style="width:5%"></th>
								<th style="width:20%">Nome</th>
								<th style="width:12%">Categoria</th>
								<th style="width:5%">Tamanho</th>
								<th style="width:12%" align="right">Valor</th>
								<th style="width:5%">Quatidade</th>
								<th style="width:10%"></th>
								<th style="width:15%"></th>
								<th style="width:15%"></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$dados = $blog->getProductsConfig();

								if(empty($dados)){
										echo "<tr style='vertical-align: middle;' align='center'>".
												"<td colspan='10'>Nenhum registro encontrado.</td></tr>";
									}else{

								foreach($dados as $reg):

									$pictureDefined = "";
						
									$pictures = $blog->getPicture($reg->produtos_codigo);
									foreach ($pictures as $pict):
										$pictureDefined = $pict->fotos_nome;
									endforeach;
							?>
							<tr style="vertical-align: middle">
								<td align="center"><?php echo $reg->produtos_codigo; ?></td>
								<td align="center">
									<img src="<?php echo ($pictureDefined == '')?'images/no_image.png':'images/'.$reg->produtos_codigo.'/'.$pictureDefined; ?>" style="height:50px; width: auto;">
								</td>
								<td><?php echo $reg->produtos_nome; ?></td>
								<td><?php echo $reg->produtos_categoria_nome; ?></td>
								<td align="center"><?php echo $reg->produtos_tamanho; ?></td>
								<td>R$ <?php echo number_format($reg->produtos_preco,2,",","."); ?></td>
								<td align="center"><?php echo $reg->produtos_qtd; ?></td>
								<td align="right"><button class="btn btn-product-buy" title="Editar produto" onclick="productConfig('<?php echo $reg->produtos_codigo; ?>')"><i class='fas fa-edit'></i>  Editar</button></td>
								<?php
									if($reg->produtos_ativo == 'A'){
								?>
								<td align="right"><button class="btn btn-product-cart" title="Inativar produto" onclick="lockProduct('<?php echo $reg->produtos_codigo; ?>')"><i class='fas fa-lock'></i>  Bloquear</button></td>
								<?php
									}else{
								?>
								<td align="right"><button class="btn btn-product-cart" title="Ativar produto" onclick="unlockProduct('<?php echo $reg->produtos_codigo; ?>')"><i class='fas fa-lock-open'></i>  Desbloquear</button></td>
								<?php
									}
								?>
								<td align="right"><button class="btn btn-product-gallery" title="Excluir produto" onclick="deleteProduct('<?php echo $reg->produtos_codigo; ?>')"><i class='fas fa-trash-alt'></i>  Excluir</button></td>
							</tr>
							<?php
									endforeach;
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div id="categorias" class="config-card collapse <?php echo (isset($_GET['view']) && $_GET['view']=='category')?'show':''; ?>">
				<div class="row">
					<div class="col-sm-6 p-3">
						<input class="form-control" type="text" name="newCategory" id="newCategory" placeholder="Nova categoria" style="width: 100%;">
					</div>
					<div class="col-sm-2 p-3">
						<button class="btn btn-primary" title="Adicionar categoria" onclick="addCategory()"><i class='fas fa-plus-circle'></i>  Adicionar</button>
					</div>
				</div>
				<hr>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th style="width:55%">Categoria</th>
								<th style="width:15%"></th>
								<th style="width:15%"></th>
								<th style="width:15%"></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$dados = $blog->getCategoriesConfig();

								if(empty($dados)){
										echo "<tr style='vertical-align: middle;' align='center'>".
												"<td colspan='4'>Nenhum registro encontrado.</td></tr>";
									}else{

								foreach($dados as $reg):
							?>
							<tr>
								<td align="left">
									<input class="form-control" type="text" name="category_<?php echo $reg->categorias_codigo; ?>" id="category_<?php echo $reg->categorias_codigo; ?>" value="<?php echo $reg->categorias_nome; ?>" style="width: 100%;">
								</td>
								<td align="right"><button class="btn btn-product-buy" title="Salvar" onclick="saveCategory('<?php echo $reg->categorias_codigo; ?>','category_<?php echo $reg->categorias_codigo; ?>')"><i class='fas fa-upload'></i>  Salvar</button></td>
								<?php
									if($reg->categorias_ativo == 'A'){
								?>
								<td align="right"><button class="btn btn-product-cart" title="Inativar categoria" onclick="lockCategory('<?php echo $reg->categorias_codigo; ?>')"><i class='fas fa-lock'></i>  Bloquear</button></td>
								<?php
									}else{
								?>
								<td align="right"><button class="btn btn-product-cart" title="Ativar categoria" onclick="unlockCategory('<?php echo $reg->categorias_codigo; ?>')"><i class='fas fa-lock-open'></i>  Desbloquear</button></td>
								<?php
									}
								?>
								<td align="right"><button class="btn btn-product-gallery" title="Excluir categoria" onclick="deleteCategory('<?php echo $reg->categorias_codigo; ?>')"><i class='fas fa-trash-alt'></i>  Excluir</button></td>
							</tr>
							<?php
								endforeach;
								}
							?>
						</tbody>
					</table>
				</div>
			</div>

			<div id="compras" class="config-card collapse <?php echo (isset($_GET['view']) && $_GET['view']=='compras')?'show':''; ?>">

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th style="width:5%">C&oacute;digo</th>
								<th style="width:10%"></th>
								<th style="width:5%">Produto</th>
								<th style="width:7%">Valor</th>
								<th style="width:5%">Qtd</th>
								<th style="width:10%">Total</th>
								<th style="width:10%">Data</th>
								<th style="width:20%">email</th>
								<th style="width:10%">CEP</th>
								<th style="width:10%">Rastreio</th>
								<th style="width:8%"></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$qtdTotal = 0;
								$vendasTotal = 0;

								$dados = $blog->getAllBought();

								if(empty($dados)){
									echo "<tr style='vertical-align: middle;' align='center'>".
											"<td colspan='11'>Nenhum registro encontrado.</td></tr>";
								}else{

									foreach($dados as $reg):
										$qtdTotal = $qtdTotal + $reg->vendas_qtd;
										$vendasTotal = $vendasTotal + ($reg->vendas_preco*$reg->vendas_qtd);
							?>
							<tr style="vertical-align: middle;">
								<td align="center"><?php echo $reg->vendas_codigo; ?></td>
								<td align="center">
									<img src="<?php echo (empty($reg->nome_foto))?'images/no_image.png':'images/'.$reg->vendas_produto_codigo.'/'.$reg->nome_foto; ?>" style="height:100px; width: auto;">
								</td>
								<td align="center"><?php echo $reg->vendas_produto_codigo; ?></td>
								<td>R$ <?php echo number_format($reg->vendas_preco,2,",","."); ?></td>
								<td align="center"><?php echo $reg->vendas_qtd; ?></td>
								<td>R$ <?php echo number_format($reg->vendas_preco*$reg->vendas_qtd,2,",","."); ?></td>
								<td><?php echo $reg->vendas_data; ?></td>
								<td><?php echo $reg->vendas_email; ?></td>
								<td><?php echo $reg->vendas_cep; ?></td>
								<td>
									<input class="form-control" type="text" name="tracker_<?php echo $reg->vendas_codigo; ?>" id="tracker_<?php echo $reg->vendas_codigo; ?>" value="<?php echo $reg->vendas_rastreio; ?>" style="width: 100%;">
								</td>
								<td>
									<button class="btn btn-product-cart" title="Enviar" onclick="saveTracker('<?php echo $reg->vendas_codigo; ?>','tracker_<?php echo $reg->vendas_codigo; ?>')"><i style="font-size: 20px" class='fab fa-telegram-plane'></i></button>
								</td>
							</tr>
							<?php
									endforeach;
								}
							?>
						</tbody>
						<tfoot>
							<tr>
								<td align="center"><strong>Totais</strong></td>
								<td colspan="3"></td>
								<td align="center"><strong><?php echo $qtdTotal; ?></strong></td>
								<td><strong>R$ <?php echo number_format($vendasTotal,2,",","."); ?></strong></td>
								<td colspan="5"></td>
							</tr>
						</tfoot>
					</table>
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
	
	function turnView(actualView,actualButton){
		var idNames = ["#produtos","#categorias","#compras"];
		var idButtons = ["#buttonProdutos","#buttonCategorias","#buttonCompras"];

		for(i=0;i<idNames.length;i++){
			$(idNames[i]).removeClass("show");
			$(idButtons[i]).removeClass("text-selected");
		}

		$(actualView).addClass("show");
		$(actualButton).addClass("text-selected");
	}

	function productConfig(code){
		if(code){
			window.location.href = "product_config.php?code="+code;
		}
	}

	function lockProduct(code){
		swal({
			  title: "Aten\u00e7\u00e3o!",
			  text: "Ao bloquear este produto, ele n\u00e3o ser\u00e1 mais exibido aos clientes. Confirmar bloqueio?",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			}).then((willLock) => {
			  if (willLock) {
			  		$("#loaderConfig").css("display", "");
			  		$.ajax({
						type: "POST",
						url: "lock_product.php",
						dataType: 'json',
						data: {
							codigo: code,
						},
									
						success: function(result){
							window.location.href = "config.php";
						},
						error: function(message) {
							swal({
							  title: "Erro",
							  text: "Desculpe, houve um erro na escrita dos dados.",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							});
							$("#loaderConfig").css("display", "none");
						}
					});
			  }
			});
	}

	function unlockProduct(code){
		swal({
			  title: "Aten\u00e7\u00e3o!",
			  text: "Ao desbloquear este produto, ele ser\u00e1 exibido aos clientes. Confirmar desbloqueio?",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			}).then((willLock) => {
			  if (willLock) {
			  		$("#loaderConfig").css("display", "");
			  		$.ajax({
						type: "POST",
						url: "unlock_product.php",
						dataType: 'json',
						data: {
							codigo: code,
						},
									
						success: function(result){
							window.location.href = "config.php";
						},
						error: function(message) {
							swal({
							  title: "Erro",
							  text: "Desculpe, houve um erro na escrita dos dados.",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							});
							$("#loaderConfig").css("display", "none");
						}
					});
			  }
			});
	}

	function deleteProduct(code){
		swal({
			  title: "Aten\u00e7\u00e3o!",
			  text: "Ao excluir este produto, ele n\u00e3o ser\u00e1 mais exibido aos clientes e esta opera\u00e7\u00e3o n\u00e3o poder\u00e1 ser desfeita. Confirmar exclus\u00e3o?",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			}).then((willLock) => {
			  if (willLock) {
			  		$("#loaderConfig").css("display", "");
			  		$.ajax({
						type: "POST",
						url: "delete_product.php",
						dataType: 'json',
						data: {
							codigo: code,
						},
									
						success: function(result){
							window.location.href = "config.php";
						},
						error: function(message) {
							swal({
							  title: "Erro",
							  text: "Desculpe, houve um erro na escrita dos dados.",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							});
							$("#loaderConfig").css("display", "none");
						}
					});
			  }
			});
	}

	function lockCategory(code){
		swal({
			  title: "Aten\u00e7\u00e3o!",
			  text: "Ao bloquear esta categoria, ela n\u00e3o ser\u00e1 mais exibida aos clientes. Confirmar bloqueio?",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			}).then((willLock) => {
			  if (willLock) {
			  		$("#loaderConfig").css("display", "");
			  		$.ajax({
						type: "POST",
						url: "lock_category.php",
						dataType: 'json',
						data: {
							codigo: code,
						},
									
						success: function(result){
							window.location.href = "config.php?view=category";
						},
						error: function(message) {
							swal({
							  title: "Erro",
							  text: "Desculpe, houve um erro na escrita dos dados.",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							});
							$("#loaderConfig").css("display", "none");
						}
					});
			  }
			});
	}

	function unlockCategory(code){
		swal({
			  title: "Aten\u00e7\u00e3o!",
			  text: "Ao desbloquear esta categoria, ela ser\u00e1 exibida aos clientes. Confirmar desbloqueio?",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			}).then((willLock) => {
			  if (willLock) {
			  		$("#loaderConfig").css("display", "");
			  		$.ajax({
						type: "POST",
						url: "unlock_category.php",
						dataType: 'json',
						data: {
							codigo: code,
						},
									
						success: function(result){
							window.location.href = "config.php?view=category";
						},
						error: function(message) {
							swal({
							  title: "Erro",
							  text: "Desculpe, houve um erro na escrita dos dados.",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							});
							$("#loaderConfig").css("display", "none");
						}
					});
			  }
			});
	}

	function deleteCategory(code){
		swal({
			  title: "Aten\u00e7\u00e3o!",
			  text: "Ao excluir esta categoria, ela n\u00e3o ser\u00e1 mais exibida aos clientes e esta opera\u00e7\u00e3o n\u00e3o poder\u00e1 ser desfeita. Confirmar exclus\u00e3o?",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			}).then((willLock) => {
			  if (willLock) {
			  		$("#loaderConfig").css("display", "");
			  		$.ajax({
						type: "POST",
						url: "delete_category.php",
						dataType: 'json',
						data: {
							codigo: code,
						},
									
						success: function(result){
							window.location.href = "config.php?view=category";
						},
						error: function(message) {
							swal({
							  title: "Erro",
							  text: "Desculpe, houve um erro na escrita dos dados.",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							});
							$("#loaderConfig").css("display", "none");
						}
					});
			  }
			});
	}

	function saveCategory(code,value){
		$("#loaderConfig").css("display", "");
		$.ajax({
				type: "POST",
				url: "save_category.php",
				dataType: 'json',
				data: {
					codigo: code,
					valor: $("#"+value).val()
				},
							
				success: function(result){
					swal({
					  title: "Conclu\u00eddo",
					  text: "Salvamento conclu\u00eddo.",
					  icon: "success",
					  buttons: true,
					  dangerMode: false,
					});
					$("#loaderConfig").css("display", "");
				},
				error: function(message) {
					swal({
					  title: "Erro",
					  text: "Desculpe, houve um erro na escrita dos dados.",
					  icon: "warning",
					  buttons: true,
					  dangerMode: true,
					});
					$("#loaderConfig").css("display", "");
				}
			});
	}

	function addCategory(){
		$("#loaderConfig").css("display", "");
		$.ajax({
				type: "POST",
				url: "add_category.php",
				dataType: 'json',
				data: {
					valor: $("#newCategory").val()
				},
							
				success: function(result){
					window.location.href = "config.php?view=category";
				},
				error: function(message) {
					swal({
					  title: "Erro",
					  text: "Desculpe, houve um erro na escrita dos dados.",
					  icon: "warning",
					  buttons: true,
					  dangerMode: true,
					});
					$("#loaderConfig").css("display", "none");
				}
			});
	}

	function saveTracker(code,value){
		$("#loaderConfig").css("display", "");
		$.ajax({
				type: "POST",
				url: "save_tracker.php",
				dataType: 'json',
				data: {
					codigo: code,
					valor: $("#"+value).val()
				},
							
				success: function(result){
					swal({
					  title: "Conclu\u00eddo",
					  text: "Salvamento conclu\u00eddo.",
					  icon: "success",
					  buttons: true,
					  dangerMode: false,
					});
					$("#loaderConfig").css("display", "none");
				},
				error: function(message) {
					swal({
					  title: "Erro",
					  text: "Desculpe, houve um erro na escrita dos dados.",
					  icon: "warning",
					  buttons: true,
					  dangerMode: true,
					});
					$("#loaderConfig").css("display", "none");
				}
			});
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