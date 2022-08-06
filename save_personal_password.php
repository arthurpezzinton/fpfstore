<?php

	require_once "conexao.php";
	require_once "crud.php";

	@session_start();

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	if(isset($_SESSION['user'])){
		if(empty($_POST['nova'])){
			echo json_encode("noPass");
		}else{
			$passwords = $blog->getUserPassword($_SESSION['user']);

			$password;

			foreach($passwords as $pass):
				$password = $pass->pessoas_password;
			endforeach;

			if(sha1($_POST["antiga"]) == $password){

				$dados = $blog->savePersonalPassword(
													$_SESSION["user"],
													sha1($_POST["nova"])
												);
				echo json_encode($dados);
			}else{
				echo json_encode("wrongPass");
			}
		}
	}
?>