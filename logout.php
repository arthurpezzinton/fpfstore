<?php

	require_once "conexao.php";
	require_once "crud.php";

	require_once "card_function.php";

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	@session_start();

	@session_unset();

	@session_destroy();

	echo json_encode("logedOut");
?>
