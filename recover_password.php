<?php

	require_once "conexao.php";
	require_once "crud.php";

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	if(isset($_POST['email'])){

		$dados = $blog->verifyUser($_POST['email']);

		if(empty($dados)){
		}else{

			$array = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9','!','@','#','$','%');

			$password = "";

			for ($x = 0; $x <= 10; $x++) {
			  	$pass = $array[rand(0,count($array))];
				$password = $password.$pass;
			}

			$blog->updatePassword($_POST['email'],sha1($password));

			$headers = "From: FPF Store". "\r\n";
		    $headers .= "MIME-Version: 1.0"  . "\r\n";
		    $headers .= "Content-Type: text/html; charset='utf-8'" . "\r\n";
		    $mensagem = "<html><body align='center'>Sua senha foi redefinida para: <strong>".$password."</strong><br>Altere-a assim que fizer login no sistema.</body></html>";

		    $to_email = $_POST['email'];
		    $subject = "Redefinição de Senha";

			mail($to_email, $subject, $mensagem, $headers);
		}
	}
?>