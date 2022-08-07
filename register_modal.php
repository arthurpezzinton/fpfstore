					<div class="register-card">
						<div class="row" align="center">
							<div class="col-sm-12 p-3">
								<h4>Novo Cadastro</h4>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 p-3">
								<label><strong>Email</strong></label>
								<input class="form-control" type="email" name="registerEmail" id="registerEmail">
							</div>
							<div class="col-sm-6 p-3">
								<label><strong>Senha</strong></label>
								<input class="form-control" type="password" name="registerPassword" id="registerPassword">
							</div>
							<div class="col-sm-6 p-3">
								<label><strong>Nome</strong></label>
								<input class="form-control" type="text" name="registerName" id="registerName">
							</div>
							<div class="col-sm-6 p-3">
								<label><strong>Sobrenome</strong></label>
								<input class="form-control" type="text" name="registerLastName" id="registerLastName">
							</div>
							<br><br>
							<div class="col-8" style="font-size: 11px; vertical-align: middle;text-align: justify;">
								<p><em style="color: red;font-size: 17px;">*</em> Ao confirmar o seu registro, voc&ecirc; concorda em fornecer seus dados para o sistema. N&atilde;o se preocupe, nenhum dado seu ser&aacute; cedido ou utilizado por qualquer outra plataforma.</p>
							</div>
							<div class="col-4">
								<button class="btn btn-product-buy" title="Finalizar Cadastro" style="font-size: 17px" onclick="saveRegister()"><i class='fas fa-upload'></i>&nbsp; Cadastrar</button>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-12 p-3" align="center">
							<div class="loader" id="loaderConfig" style="display: none;"></div>
						</div>
					</div>


					<script type="text/javascript">

						function loginAfterRegister(){
							$.ajax({
								type: "POST",
								url: "login.php",
								dataType: 'json',
								data: {
									email: $("#registerEmail").val(),
									senha: $("#registerPassword").val(),
								},
											
								success: function(result){
									window.location.href = "index.php";
								},

								error: function(message) {
									swal({
									  title: "Erro",
									  text: "Desculpe, houve um erro na leitura dos dados.",
									  icon: "warning",
									  buttons: true,
									  dangerMode: true,
									});
								}
							});
						}
						
						function saveRegister(){
							$("#loaderConfig").css("display", "");
							$.ajax({
								type: "POST",
								url: "save_register.php",
								dataType: 'json',
								data: {
									email: $("#registerEmail").val(),
									senha: $("#registerPassword").val(),
									nome: $("#registerName").val(),
									sobrenome: $("#registerLastName").val()
								},
											
								success: function(result){
									if(result == "emptyMail"){
										swal({
										  title: "Erro",
										  text: "O campo de email deve ser preenchido.\nEste campo n\u00e3o poder\u00e1 ser alterado posteriormente.",
										  icon: "warning",
										  buttons: true,
										  dangerMode: true,
										});
									}else if(result == "emptySenha"){
										swal({
										  title: "Erro",
										  text: "O campo de senha deve ser preenchido.",
										  icon: "warning",
										  buttons: true,
										  dangerMode: true,
										});
									}else if(result == "emptyName"){
										swal({
										  title: "Erro",
										  text: "O campo de nome deve ser preenchido.\nEste campo n\u00e3o poder\u00e1 ser alterado posteriormente.",
										  icon: "warning",
										  buttons: true,
										  dangerMode: true,
										});
									}else if(result == "emptyLastName"){
										swal({
										  title: "Erro",
										  text: "O campo de sobrenome deve ser preenchido.\nEste campo n\u00e3o poder\u00e1 ser alterado posteriormente.",
										  icon: "warning",
										  buttons: true,
										  dangerMode: true,
										});
									}else if(result == "userExists"){
										swal({
										  title: "Erro",
										  text: "Usu\u00e1rio j\u00e1 cadastrado.",
										  icon: "warning",
										  buttons: true,
										  dangerMode: true,
										});
									}else{
										swal({
										  title: "Conclu\u00eddo",
										  text: "Bem vindo \u00e0 FPF Store!\nAproveite!",
										  icon: "success",
										  buttons: true,
										  dangerMode: false,
										}).then((willLog) => {
										  if (willLog) {
												loginAfterRegister();
										  } else {
												loginAfterRegister();
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
								}
							});
						}

					</script>