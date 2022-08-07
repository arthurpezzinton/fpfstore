<?php

	require_once "conexao.php";
	require_once "crud.php";

	@session_start();

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	if((empty($_POST["quantidade"])) || (empty($_POST["email"])) || (empty($_POST["nome"])) || (empty($_POST["endereco"])) || (empty($_POST["cidade"])) || (empty($_POST["estado"])) || (empty($_POST["cep"]))){
		echo json_encode("missingData");
	}else{
		$pessoa = 0;

		if(isset($_SESSION['user'])){
			$pessoa = $_SESSION['user'];
		}

		$amounts = $blog->getAmountProduct($_POST["codigo"]);

		$amount;
		$value;
		$left;

		foreach($amounts as $am):
			$amount = $am->produtos_qtd;
			$value = $am->produtos_valor*(1-($am->produtos_desconto/100));
		endforeach;

		
		if($amount >= $_POST["quantidade"]){
			$dados = $blog->insertBought(
											$_POST["codigo"],
											$pessoa,
											$value,
											$_POST["quantidade"],
											$_POST["email"],
											$_POST["nome"],
											$_POST["endereco"],
											$_POST["cidade"],
											$_POST["estado"],
											$_POST["cep"]
										);
			$left = $amount - $_POST["quantidade"];

			$updater = $blog->updateProductAmount($_POST["codigo"],$left);

			$textValue = number_format(($value/100),2,",",".");
			$textTotal = number_format(($_POST["quantidade"]*($value/100)),2,",",".");

			$headers = "From: FPF Store". "\r\n";
		    $headers .= "MIME-Version: 1.0"  . "\r\n";
		    $headers .= "Content-Type: text/html; charset='utf-8'" . "\r\n";
		    $mensagem = "<html>".
		    				"<body align='left'>".
		    					"<strong>Compra Registrada</strong>".
		    					"<br><br>".
		    					"Valor: R$ <strong>".$textValue."</strong><br>".
		    					"Quantidade: <strong>".$_POST["quantidade"]."</strong> un.<br>".
		    					"Total: <strong>".$textTotal."</strong><br>".
		    					"Respons&aacute;vel: <strong>".$_POST["nome"]."</strong><br>".
		    					"Envio:<br>".
		    					"<strong>".$_POST["endereco"]."<br>".$_POST["cidade"]."<br>".$_POST["estado"]."<br>".$_POST["cep"].
		    					"</strong>".
		    				"</body>".
		    			"</html>";

		    $to_email = $_POST['email'];
		    $subject = "Compra Realizada";

			mail($to_email, $subject, $mensagem, $headers);

			echo json_encode($updater);
		}else{
			echo json_encode("noAmount");
		}
	}
?>