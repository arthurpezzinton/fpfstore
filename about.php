<?php

	require_once "conexao.php";
	require_once "crud.php";

	require_once "card_function.php";

	$blog  = crudBlog::getInstance(Conexao::getInstance());

	@session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>FPF Store</title>
		<?php
			$blog->getBasicHead();
		?>
	</head>
	<body>
		<?php
			$blog->getNavBar("");
		?>
		<br><br>
		<div class="container">
			<div class="about-card">
				<div class="row">
					<div class="col-lg-6 col-xl-4 p-3" align="center">
						<img src="images/logo.png" style="width: 80%;">
					</div>
					<div class="col-lg-6 col-xl-8 p-3" style="text-align: justify;">
						<h2>FPF Store</h2>
						<p>
							&nbsp;&nbsp;Esta loja virtual fict&iacute;cia foi desenvolvida com o intuito de atender a uma proposta de desafio de programa&ccedil;&atilde;o, dentro do processo seletivo da Funda&ccedil;&atilde;o Paulo Feitoza. Esta tem car&aacute;ter meramente demonstrativo, sem inten&ccedil;&atilde;o de realizar qualquer venda real. A logo apresentada &eacute; derivada da logo original da funda&ccedil;&atilde;o e n&atilde;o &eacute; registrada oficialmente.<br>
							&nbsp;&nbsp;A proposta &eacute; que seja desenvolvido um sistema de uma loja virtual em que o propriet&aacute;rio possa controlar os produtos, compras, cliente etc, manipulando um banco de dados do pr&oacute;prio sistema, com o requisito de que os clientes pudessem realizar buscas de produtos dentro da loja virtual.<br>
							&nbsp;&nbsp;O sistema foi desenvolvido usando php, javascript, sql, html, css e bootstrap 5.<br><br>
							&nbsp;&nbsp;Para conhecer mais sobre a funda&ccedil;&atilde;o, acesse o site <a class="text-link" href="https://fpftech.com/principal">https://fpftech.com/principal</a> neste link ou continue rolando a barra para ler como a pr&oacute;pria funda&ccedil;&atilde;o se descreve.<br><br><br><br>
							Att., Arthur.
						</p>
					</div>
				</div>
			</div>
		</div>
		<br><br><br>
		<div class="about-card fpf-history" align="center" style="background-image: url(images/fpf/background.png);background-position: center;background-size: cover;background-repeat: no-repeat;">
			<br><br><br>
			<div class="container about-text">
				<br>
				<h2>FPF Tech</h2>
				<p>Fundada em 1998, a Funda&ccedil;&atilde;o Paulo Feitoza – FPF Tech &eacute; uma institui&ccedil;&atilde;o de Pesquisa e Desenvolvimento, sem fins lucrativos, focada na gera&ccedil;&atilde;o de solu&ccedil;&otilde;es inovadoras, servi&ccedil;os e cases de sucesso globais nas &aacute;reas de Automa&ccedil;&atilde;o Industrial, Tecnologias M&oacute;veis e Assistivas, Internet, Qualidade de Software e Capacita&ccedil;&atilde;o Tecnol&oacute;gica. H&aacute; 23 anos a FPF Tech atua em Manaus com estreita coopera&ccedil;&atilde;o com Universidades e investe continuamente na forma&ccedil;&atilde;o t&eacute;cnico-cient&iacute;fica de seus colaboradores, estudantes e profissionais do mercado.
				</p>
				<br>
			</div>
			<br><br><br>
		</div>
		<br><br><br><br><br><br>
		<?php
			$blog->getBasicFooter();
		?>
	</body>
</html>