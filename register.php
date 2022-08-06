<?php

	require_once "conexao.php";
	require_once "crud.php";

	require_once "card_function.php";

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	@session_start();
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
			$blog->getNavBar("index");
		?>
		<br><br><br><br>
		<div class="container">
			<div class="row">
				<div class="col-sm-2 p-3"></div>
				<div class="col-sm-8 p-3">
					<?php
						include 'register_modal.php';
					?>
				</div>
				<div class="col-sm-2 p-3"></div>
			</div>
		</div>
		<br><br><br><br>
		<?php
			$blog->getBasicFooter();
		?>
	</body>
</html>