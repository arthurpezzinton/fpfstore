<?php

	require_once "conexao.php";
	require_once "crud.php";

	require_once "card_function.php";

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	@session_start();

	if(isset($_SESSION['user']) && isset($_SESSION['name']) && isset($_POST['code']) && $_SESSION['user'] == "1" && $_SESSION['name'] == "Administrador"){
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
		<?php

		$target_dir = "images/".$_POST['code']."/";

		$countfiles = count($_FILES['fileToUpload']['name']);

		for($i=0;$i<$countfiles;$i++){

			$fileName = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"][$i]));
			$message = "";
			$span = "";
			$color = "";
			$icon = "";

			if(empty($_FILES["fileToUpload"]["tmp_name"][$i])){
				echo "<div align='center'>Nenhum arquivo escolhido</div>";
			}else{
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

				if(isset($_POST["submit"])) {
					$check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$i]);
					if($check !== false) {
						$uploadOk = 1;
					} else {
						$message = $message."Arquivo n&atilde;o &eacute; imagem.<br>";
						$color = "#e6e6e6";
						$icon = "fas fa-times-circle";
						$uploadOk = 0;
					}
				}

				if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG"
				&& $imageFileType != "gif" && $imageFileType != "GIF" ) {
					//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
					$message = $message."Somente os formatos JPG, JPEG, PNG e GIF s&atilde;o permitidos.<br>";
					$color = "#e6e6e6";
					$icon = "fas fa-times-circle";
					$uploadOk = 0;
				}

				if ($uploadOk == 0) {
					$message = $message."Arquivo n&atilde;o enviado.<br>";
					$color = "#e6e6e6";
					$icon = "fas fa-times-circle";
				} else {
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
						$message = $message."Envio do arquivo conclu&iacute;do.<br>";
						$color = "#aed136";
						$icon = "fas fa-check-circle";
						$blog->insertProductPhoto($_POST['code'],$fileName);
					} else {
						$message = $message."Erro durante envio do arquivo.<br>";
						$color = "#e6e6e6";
						$icon = "fas fa-times-circle";
					}
				}
				echo "<div align='center'>".
				"<i style='color: ".$color.";' class='".$icon."'></i>&nbsp;<strong>".$fileName."</strong><br>".$message."<br>".
				"</div>";
			}
		}
		?>		
				<br>
				<div align="center">
					<a class="text-link" onclick="goBackConfigPicture('<?php echo $_POST['code']; ?>')"><h4>Voltar</h4></a>	
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
	
	function goBackConfigPicture(code){
		window.location.href = "pictures_config.php?code="+code;
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