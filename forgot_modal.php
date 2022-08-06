					<div class="register-card">
						<div class="row" align="center">
							<div class="col-sm-12 p-3">
								<h4>Recupera&ccedil;&atilde;o de Senha</h4>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12 p-3">
								<label><strong>Email</strong></label>
								<input class="form-control" type="email" name="registerEmail" id="registerEmail">
							</div>
							<div class="col-7" style="font-size: 11px; vertical-align: middle;text-align: justify;">
								<p><em style="color: red;font-size: 17px;">*</em> Se o email fornecido estiver cadastrado no sistema, uma nova senha gerada ser&aacute; enviada para o destinat&aacute;rio.</p>
							</div>
							<div class="col-5">
								<button class="btn btn-product-gallery" title="Recuperar Senha" style="font-size: 17px" onclick="recoverPassword()"><i class='fas fa-lock'></i>&nbsp; Recuperar</button>
							</div>
						</div>
					</div>


					<script type="text/javascript">

						function recoverPassword(){
							$.ajax({
								type: "POST",
								url: "recover_password.php",
								dataType: 'json',
								data: {
									email: $("#registerEmail").val()
								},
							});

							window.location.href = "index.php";
						}

					</script>