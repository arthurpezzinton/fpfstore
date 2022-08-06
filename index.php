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
			$blog->getNavBar("index");
		?>
		<div class="container">
			
			<?php
				include 'search_modal.php';
			?>

			<div class="row" id="productsList">
				<?php
					if(isset($_GET['category']) && isset($_GET['size']) && isset($_GET['name'])){
						$dados = $blog->getProductsSearchCSN($_GET['category'],$_GET['size'],$_GET['name']);
						echo "<input type='text' id='choosenCategory' value='".$_GET['category']."' hidden>";
						echo "<input type='text' id='choosenSize' value='".$_GET['size']."' hidden>";
						echo "<input type='text' id='choosenName' value='".$_GET['name']."' hidden>";
					?>
					<script type="text/javascript">
						$("#searchBox").addClass("show");
						$("#searchCategory").val($("#choosenCategory").val());
						$("#searchSize").val($("#choosenSize").val());
						$("#searchName").val($("#choosenName").val());
					</script>
					<?php
					}else if(isset($_GET['category']) && isset($_GET['size'])){
						$dados = $blog->getProductsSearchCS($_GET['category'],$_GET['size']);
						echo "<input type='text' id='choosenCategory' value='".$_GET['category']."' hidden>";
						echo "<input type='text' id='choosenSize' value='".$_GET['size']."' hidden>";
					?>
					<script type="text/javascript">
						$("#searchBox").addClass("show");
						$("#searchCategory").val($("#choosenCategory").val());
						$("#searchSize").val($("#choosenSize").val());
					</script>
					<?php
					}else if(isset($_GET['category']) && isset($_GET['name'])){
						$dados = $blog->getProductsSearchCN($_GET['category'],$_GET['name']);
						echo "<input type='text' id='choosenCategory' value='".$_GET['category']."' hidden>";
						echo "<input type='text' id='choosenName' value='".$_GET['name']."' hidden>";
					?>
					<script type="text/javascript">
						$("#searchBox").addClass("show");
						$("#searchCategory").val($("#choosenCategory").val());
						$("#searchName").val($("#choosenName").val());
					</script>
					<?php
					}else if(isset($_GET['size']) && isset($_GET['name'])){
						$dados = $blog->getProductsSearchSN($_GET['size'],$_GET['name']);
						echo "<input type='text' id='choosenSize' value='".$_GET['size']."' hidden>";
						echo "<input type='text' id='choosenName' value='".$_GET['name']."' hidden>";
					?>
					<script type="text/javascript">
						$("#searchBox").addClass("show");
						$("#searchSize").val($("#choosenSize").val());
						$("#searchName").val($("#choosenName").val());
					</script>
					<?php
					}else if(isset($_GET['category'])){
						$dados = $blog->getProductsSearchC($_GET['category']);
						echo "<input type='text' id='choosenCategory' value='".$_GET['category']."' hidden>";
					?>
					<script type="text/javascript">
						$("#searchBox").addClass("show");
						$("#searchCategory").val($("#choosenCategory").val());
					</script>
					<?php
					}else if(isset($_GET['size'])){
						$dados = $blog->getProductsSearchS($_GET['size']);
						echo "<input type='text' id='choosenSize' value='".$_GET['size']."' hidden>";
					?>
					<script type="text/javascript">
						$("#searchBox").addClass("show");
						$("#searchSize").val($("#choosenSize").val());

					</script>
					<?php
					}else if(isset($_GET['name'])){
						$dados = $blog->getProductsSearchN($_GET['name']);
						echo "<input type='text' id='choosenName' value='".$_GET['name']."' hidden>";
					?>
					<script type="text/javascript">
						$("#searchBox").addClass("show");
						$("#searchName").val($("#choosenName").val());
					</script>
					<?php
					}else{
						$dados = $blog->getAllProducts();
					}

					$emptyStore = true;

					foreach ($dados as $reg):

						$emptyStore = false;

						$pictureDefined = "";
						
						$pictures = $blog->getPicture($reg->produtos_codigo);
						foreach ($pictures as $pict):
							$pictureDefined = $pict->fotos_nome;
						endforeach;

						getCard($reg->produtos_codigo,$reg->produtos_nome,$reg->produtos_categoria_nome,$reg->produtos_marca,$reg->produtos_tamanho,$reg->produtos_descricao,$reg->produtos_preco,$reg->produtos_desconto,$pictureDefined,$reg->produtos_qtd);

					endforeach;


					if($emptyStore){
						include 'empty_store.php';
					}
				?>
			</div>
		</div>
		<br><br><br><br>
		<?php
			$blog->getBasicFooter();
		?>
	</body>
</html>