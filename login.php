<?php

	require_once "conexao.php";
	require_once "crud.php";

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	$dados = $blog->getValidEmail($_POST["email"]);

	if(empty($dados)){
		echo json_encode("noUser");
	}else{
		$dados = $blog->getValidPass($_POST["email"],sha1($_POST["senha"]));

		if(empty($dados)){
			echo json_encode("wrongPass");
		}else{
			@session_start();

			$userCode = 0;
			$userName = "";

			foreach ($dados as $reg):
				$userCode = $reg->pessoas_codigo;
				$userName = $reg->pessoas_nome;
			endforeach;

			$_SESSION["user"] = $userCode;
			$_SESSION["name"] = $userName;

			if($userCode == "1"){
				echo json_encode("admin");
			}else{
				echo json_encode("loged");
			}
		}
	}
?>