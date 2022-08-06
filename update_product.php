<?php

	require_once "conexao.php";
	require_once "crud.php";

	@session_start();

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	if(isset($_SESSION['user']) && isset($_SESSION['name']) && $_SESSION['user'] == "1" && $_SESSION['name'] == "Administrador"){
		$dados = $blog->updateProduct(
										$_POST["codigo"],
										$_POST["nome"],
										$_POST["categoria"],
										$_POST["marca"],
										$_POST["tamanho"],
										$_POST["descricao"],
										$_POST["valor"],
										$_POST["desconto"],
										$_POST["qtd"]
									);

		echo json_encode($dados);
	}
?>