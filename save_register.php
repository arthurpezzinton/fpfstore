<?php

	require_once "conexao.php";
	require_once "crud.php";

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	if(empty($_POST['email'])){
		echo json_encode("emptyMail");
	}
	else if(empty($_POST['senha'])){
		echo json_encode("emptySenha");
	}
	else if(empty($_POST['nome'])){
		echo json_encode("emptyName");
	}
	else if(empty($_POST['sobrenome'])){
		echo json_encode("emptyLastName");
	}
	else{
		$user = $blog->verifyUser($_POST['email']);

		if(empty($user)){
			$dados = $blog->insertUser(
								$_POST['email'],
								sha1($_POST['senha']),
								$_POST['nome'],
								$_POST['sobrenome']
							);

			echo json_encode($dados);
		}else{
			echo json_encode("userExists");
		}
	}
?>