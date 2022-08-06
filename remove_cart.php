<?php

	require_once "conexao.php";
	require_once "crud.php";

	@session_start();

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	if(isset($_SESSION['user']) && isset($_POST['codigo'])){

		$dados = $blog->removeCart($_SESSION['user'],$_POST["codigo"]);

		echo json_encode($dados);
	}else{
		echo json_encode("logedOut");
	}
?>