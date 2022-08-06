		<div class="modal" id="loginModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">							
						<img src='images/logo_name.png' title='FPF Store' style='width:100px;'>
						<br>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						<div class="row" align="center">
							<div class="col-12"><h4>Login</h4></div>
						</div>
						<br>
						<div class="row" align="left">
							<div class="col-6" align="center">
								<input id="userEmail" type="email" class="form-control" placeholder="Email" required>
							</div>
							<div class="col-6" align="center">
								<input id="userPassword" type="password" class="form-control" placeholder="Senha" required>
							</div>
						</div>
						<br>
						<div class="row" align="center">
							<div class="col-12" align="center">
								<button type="submit" onclick="tryLogin()" class="btn btn-dark btn-fpf" style="width: 100%">Entrar</button>
							</div>
						</div>
						<br><br>
						<div class="row">
							<div class="col-6" align="left">
								<a class="text-link" href="register.php">Novo cadastro</a>
							</div>
							<div class="col-6" align="right">
								<?php $email=false; echo ($email)?"<a class='text-link' href='forgot_password.php'>Esqueci minha senha</a>":""; ?>
							</div>
						</div>					
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			function tryLogin(){
				if($("#userEmail").val() == "" || $("#userPassword").val() == ""){
					swal({
						title: "Erro",
						text: "Os campos de email e senha devem estar preenchidos",
						icon: "warning",
						buttons: true,
						dangerMode: true,
					});
				}else{
					$.ajax({
						type: "POST",
						url: "login.php",
						dataType: 'json',
						data: {
							email: $("#userEmail").val(),
							senha: $("#userPassword").val(),
						},
									
						success: function(result){
							if(result == "noUser"){
								swal({
								  title: "Erro",
								  text: "Desculpe, este usuário não está cadastrado no nosso sistema.",
								  icon: "warning",
								  buttons: true,
								  dangerMode: true,
								});
							}else if(result == "wrongPass"){
								swal({
								  title: "Erro",
								  text: "Senha incorreta.",
								  icon: "warning",
								  buttons: true,
								  dangerMode: true,
								});
							}else if(result == "admin"){
								window.location.href = "config.php";
							}else if(result == "loged"){
								window.location.href = "index.php";
							}
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
			}
		</script>