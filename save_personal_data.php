<?php

	require_once "conexao.php";
	require_once "crud.php";

	@session_start();

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	if(isset($_SESSION['user'])){
		$dados = $blog->savePersonalData(
										$_SESSION["user"],
										$_POST["endereco"],
										$_POST["cidade"],
										$_POST["estado"],
										$_POST["cep"]
									);

		echo json_encode($dados);
	}
?>