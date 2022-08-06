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
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-9 p-3">
			<?php
				$dados = $blog->getUserInfo($_SESSION['user']);

				foreach($dados as $reg):
			?>
				<div class="personal-card">
					<div class="row" align="center">
						<div class="col-sm-12 p-3"><h4>Endere&ccedil;o Completo</h4></div>
					</div>
					<div class="row">
						<div class="col-sm-6 p-3">
							<label><strong>Endere&ccedil;o</strong></label>
							<input class="form-control" type="text" name="personalAddress" id="personalAddress" value="<?php echo (empty($reg->pessoas_endereco))?'':$reg->pessoas_endereco; ?>">
						</div>
						<div class="col-sm-6 p-3">
							<label><strong>Cidade</strong></label>
							<input class="form-control" type="text" name="personalCity" id="personalCity" value="<?php echo (empty($reg->pessoas_cidade))?'':$reg->pessoas_cidade; ?>">
						</div>
						<div class="col-sm-6 p-3">
							<label><strong>Estado</strong></label>
							<input class="form-control" type="text" name="personalState" id="personalState" value="<?php echo (empty($reg->pessoas_estado))?'':$reg->pessoas_estado; ?>">
						</div>
						<div class="col-sm-6 p-3">
							<label><strong>CEP</strong></label>
							<input class="form-control" type="text" name="personalCEP" id="personalCEP" value="<?php echo (empty($reg->pessoas_cep))?'':$reg->pessoas_cep; ?>">
						</div>
					</div>
					<div class="row" align="right">
						<div class="col-sm-9"></div>
						<div class="col-sm-3">
							<label></label>
							<button class="btn btn-product-buy" title="Salvar" onclick="savePersonalData()"><i class='fas fa-upload'></i>  Salvar Dados</button>
						</div>
					</div>
				</div>
			<?php
				endforeach;
			?>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-3 p-3">
					<div class="personal-card">
						<div class="row" align="center">
							<div class="col-sm-12 p-3"><h4>Alterar Senha</h4></div>
						</div>
						<div class="row">
							<div class="col-sm-12 p-3">
								<label><strong>Senha antiga</strong></label>
								<input class="form-control" type="password" name="oldPassword" id="oldPassword">
							</div>
							<div class="col-sm-12 p-3">
								<label><strong>Nova senha</strong></label>
								<input class="form-control" type="password" name="newPassword" id="newPassword">
							</div>
							<div class="col-sm-12 p-3">
								<label></label>
								<button class="btn btn-product-buy" title="Salvar" onclick="savePersonalPassword()"><i class='fas fa-upload'></i>  Salvar Senha</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 p-3" align="center">
				<div class="loader" id="loaderPersonal" style="display: none;"></div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 p-3">
					<div class="personal-card">
						<div class="row" align="center">
							<div class="col-sm-12 p-3"><h4>Registro de Compras</h4></div>
						</div>
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th style="width:15%"></th>
										<th style="width:15%">Produto</th>
										<th style="width:8%">Valor</th>
										<th style="width:8%">Qtd</th>
										<th style="width:9%">Total</th>
										<th style="width:15%">Data</th>
										<th style="width:15%">CEP</th>
										<th style="width:15%">Rastreio</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$dados = $blog->getUserBought($_SESSION['user']);

										if(empty($dados)){
											echo "<tr style='vertical-align: middle;' align='center'>".
													"<td colspan='7'>Nenhum registro encontrado.</td></tr>";
										}else{

											foreach($dados as $reg):
									?>
										<tr style="vertical-align: middle;">
											<td align="center"><img src="<?php echo (empty($reg->nome_foto))?'images/no_image.png':'images/'.$reg->vendas_produto_codigo.'/'.$reg->nome_foto; ?>" style="height:100px; width: auto;"></td>
											<td><?php echo (empty($reg->produtos_nome))?"Nome n&atilde;o encontrado":$reg->produtos_nome; ?></td>
											<td>R$ <?php echo number_format($reg->vendas_preco,2,",","."); ?></td>
											<td><?php echo $reg->vendas_qtd; ?></td>
											<td>R$ <?php echo number_format($reg->vendas_preco*$reg->vendas_qtd,2,",","."); ?></td>
											<td><?php echo $reg->vendas_data; ?></td>
											<td><?php echo $reg->vendas_cep; ?></td>
											<td><?php echo $reg->vendas_rastreio; ?></td>
										</tr>
									<?php
											endforeach;
										}
									?>
								</tbody>
							</table>
						</div>
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

	function savePersonalData(){
		$("#loaderPersonal").css("display", "");
		$.ajax({
		type: "POST",
		url: "save_personal_data.php",
		dataType: 'json',
		data: {
			endereco: $("#personalAddress").val(),
			cidade: $("#personalCity").val(),
			estado: $("#personalState").val(),
			cep: $("#personalCEP").val()
		},
					
		success: function(result){
			swal({
				  title: "Conclu\u00eddo",
				  text: "Dados salvos com sucesso.",
				  icon: "success",
				  buttons: true,
				  dangerMode: false,
				});
			$("#loaderPersonal").css("display", "none");
		},
		
		error: function(message) {
			swal({
			  title: "Erro",
			  text: "Desculpe, houve um erro na escrita dos dados.",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			});
			$("#loaderPersonal").css("display", "none");
		}
	});
	}

	function savePersonalPassword(){
		$("#loaderPersonal").css("display", "");
		$.ajax({
		type: "POST",
		url: "save_personal_password.php",
		dataType: 'json',
		data: {
			antiga: $("#oldPassword").val(),
			nova: $("#newPassword").val()
		},
					
		success: function(result){
			if(result == "noPass"){
				swal({
				  title: "Erro",
				  text: "O campo de nova senha n\u00e3o pode ser vazio.",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
				});
				$("#loaderPersonal").css("display", "none");
			}else if(result == "wrongPass"){
				swal({
				  title: "Erro",
				  text: "Senha antiga incorreta.",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
				});
				$("#loaderPersonal").css("display", "none");
			}else{
				swal({
				  title: "Conclu\u00eddo",
				  text: "Senha alterada com sucesso.",
				  icon: "success",
				  buttons: true,
				  dangerMode: false,
				}).then((willGo) => {
				  if (willGo) {
						window.location.href = "personal.php";
				  } else {
						window.location.href = "personal.php";
				  }
				});
			}
		},
		
		error: function(message) {
			swal({
			  title: "Erro",
			  text: "Desculpe, houve um erro na escrita dos dados.",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			});
			$("#loaderPersonal").css("display", "none");
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