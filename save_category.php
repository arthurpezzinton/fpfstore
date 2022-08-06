<?php

	require_once "conexao.php";
	require_once "crud.php";

	@session_start();

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	if(isset($_SESSION['user']) && isset($_SESSION['name']) && $_SESSION['user'] == "1" && $_SESSION['name'] == "Administrador"){
		$dados = $blog->saveCategory($_POST["codigo"],$_POST["valor"]);

		echo json_encode($dados);
	}
?>