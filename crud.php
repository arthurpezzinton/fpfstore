<?php

class crudBlog {
	private $pdo = null; 

	private static $crudBlog = null; 

	private function __construct($conexao){  
	$this->pdo = $conexao; 
	}  

	public static function getInstance($conexao){   
	if (!isset(self::$crudBlog)):    
	self::$crudBlog = new crudBlog($conexao);   
	endif;   
	return self::$crudBlog;    
	}

	public function getBasicHead(){
		echo "<meta charset='UTF-8'>".

		"<link rel='icon' type='image/x-icon' href='images/favicon.ico'>".

		"<link rel='stylesheet' type='text/css' href='css/bootstrap.min.css'>".

		"<link rel='stylesheet' type='text/css' href='css/fpf_store.css'>".

		"<script src='js/all.js'></script>".

		"<script src='js/bootstrap.bundle.min.js'></script>".
		"<script src='js/icons.js'></script>".
		"<script src='js/jquery-1.11.2.min.js' type='text/javascript'></script>".
		"<script src='js/sweetalert.min.js'></script>";
	}

	public function getBasicFooter(){
		echo "<nav class='navbar navbar-expand-sm bg-light navbar-light fixed-bottom'>".
			"<div class='container-fluid justify-content-center'>".
				"<a class='navbar-brand' href=''>".
					"<div class='row'>".
						"<div class='col-3'>".
							"<img class='logo-image' src='images/logo.png' title='FPF Store' style='width:50px;'>".
						"</div>".
						"<div class='col-9' align='center'>".
							"<h5 style='font-size: 17px'><strong>Loja fictícia</strong></h5>".
							"<h6 style='font-size: 13px;'><strong>FPF Tech</strong> - By Arthur Pezzin Ton</h6>".
						"</div>".
					"</div>".					
				"</a>".
			"</div>".
		"</nav>";
	}

	public function getNavBar($where){
		$searchButton = "";
		$homeButton = "<li class='nav-item'>".
									"<a class='nav-link nav-button' href='index.php' title='P&aacute;gina principal'><i class='fas fa-home'></i> Home</a>".
								"</li>";
		$logos = "<div class='container-fluid'>".
							"<a class='navbar-brand' href='index.php'>".
								"<img class='logo-image' src='images/logo_min.png' title='FPF Store' style='width:50px;'>&nbsp;".
								"<img src='images/logo_name_.png' title='FPF Store' style='width:100px;'>".
							"</a>".
						"</div>";
		$about = "<li class='nav-item'>".
									"<a class='nav-link nav-button' href='about.php' title='Conhe&ccedil;a mais sobre a loja'><i class='fas fa-book'></i> Sobre</a>".
								"</li>";
		$live = "<li class='nav-item'>".
									"<a class='nav-link nav-button' onclick='logout()' title='Fazer Logout'><i class='fas fa-sign-out-alt'></i> Sair</a>".
								"</li>";

		if($where == "index"){
			$searchButton = "<li class='nav-item' align='center'>".
									"<a class='nav-link nav-button' data-bs-toggle='collapse' data-bs-target='#searchBox' title='Pesquisar'>".
										"<i class='fas fa-search'></i> Pesquisar".
									"</a>".
								"</li>";
			$homeButton = "";
		}

		if(isset($_SESSION['user'])){
			if($_SESSION['user'] == "1" && $_SESSION['name'] == "Administrador"){
				echo "<nav class='navbar navbar-expand-sm bg-dark'>".
					"<div class='container'>".
						$logos.
						"<div class='container-fluid' align='center'>".
							"<ul class='navbar-nav justify-content-center'>".
								"<li class='nav-item'>".
									"<a class='nav-link nav-button' href='config.php'><i class='fas fa-cog fa-spin'></i> ".$_SESSION['name']."</a>".
								"</li>".
							"</ul>".
						"</div>".
						"<div class='container-fluid' align='center'>".
							"<ul class='navbar-nav justify-content-end'>".
								$searchButton.
								$homeButton.
								$about.
								$live.
							"</ul>".
						"</div>".
					"</div>".
				"</nav>";

			}else{
				echo "<nav class='navbar navbar-expand-sm bg-dark'>".
					"<div class='container'>".
						$logos.
						"<div class='container-fluid' align='center'>".
							"<ul class='navbar-nav justify-content-center'>".
								"<li class='nav-item'>".
									"<a class='nav-link nav-button' href='personal.php'><i class='fas fa-address-card'></i> ".$_SESSION['name']."</a>".
								"</li>".
							"</ul>".
						"</div>".
						"<div class='container-fluid' align='center'>".
							"<ul class='navbar-nav justify-content-end'>".
								$searchButton.
								$homeButton.
								$about.
								"<li class='nav-item'>".
									"<a class='nav-link nav-button' href='cart.php' title='Lista de desejos'>".
										"<i class='fas fa-shopping-cart'></i> Lista".
									"</a>".
								"</li>".
								$live.
							"</ul>".
						"</div>".
					"</div>".
				"</nav>";
			}
		}else{
			echo "<nav class='navbar navbar-expand-sm bg-dark'>".
				"<div class='container'>".
					$logos.
					"<div class='container-fluid' align='center'>".
						"<ul class='navbar-nav justify-content-end'>".
							$searchButton.
							$homeButton.
							$about.
							"<li class='nav-item'>".
								"<a class='nav-link nav-button' data-bs-toggle='modal' data-bs-target='#loginModal' title='Entrar em sua conta'><i class='	fas fa-sign-in-alt'></i> Login</a>".
							"</li>".
						"</ul>".
					"</div>".
				"</div>".
			"</nav>";

			include 'login_modal.php';
		}
	}

	public function getAllProducts(){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							produtos_codigo, produtos_nome, (SELECT categorias_nome FROM categorias WHERE categorias_codigo=produtos_categoria) AS produtos_categoria_nome, produtos_marca, produtos_tamanho, produtos_descricao, (produtos_valor/100) AS produtos_preco, produtos_desconto, produtos_qtd
	    							FROM
	    							produtos
	    							WHERE
	    							produtos_ativo = 'A' AND produtos_qtd > 0
	    							");
	    //$stm->bindValue(1, $codigo);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function getProductsSearchCSN($categoria,$tamanho,$nome){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							produtos_codigo, produtos_nome, (SELECT categorias_nome FROM categorias WHERE categorias_codigo=produtos_categoria) AS produtos_categoria_nome, produtos_marca, produtos_tamanho, produtos_descricao, (produtos_valor/100) AS produtos_preco, produtos_desconto, produtos_qtd, produtos_categoria
	    							FROM
	    							produtos
	    							WHERE
	    							produtos_ativo = 'A' AND produtos_qtd > 0 AND produtos_categoria = ? AND produtos_tamanho LIKE ? AND (produtos_marca LIKE '%".$nome."%' OR produtos_nome LIKE '%".$nome."%' OR produtos_descricao LIKE '%".$nome."%')
	    							");
	    $stm->bindValue(1, $categoria);
	    $stm->bindValue(2, $tamanho);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function getProductsSearchCS($categoria,$tamanho){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							produtos_codigo, produtos_nome, (SELECT categorias_nome FROM categorias WHERE categorias_codigo=produtos_categoria) AS produtos_categoria_nome, produtos_marca, produtos_tamanho, produtos_descricao, (produtos_valor/100) AS produtos_preco, produtos_desconto, produtos_qtd, produtos_categoria
	    							FROM
	    							produtos
	    							WHERE
	    							produtos_ativo = 'A' AND produtos_qtd > 0 AND produtos_categoria = ? AND produtos_tamanho LIKE ?
	    							");
	    $stm->bindValue(1, $categoria);
	    $stm->bindValue(2, $tamanho);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function getProductsSearchCN($categoria,$nome){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							produtos_codigo, produtos_nome, (SELECT categorias_nome FROM categorias WHERE categorias_codigo=produtos_categoria) AS produtos_categoria_nome, produtos_marca, produtos_tamanho, produtos_descricao, (produtos_valor/100) AS produtos_preco, produtos_desconto, produtos_qtd, produtos_categoria
	    							FROM
	    							produtos
	    							WHERE
	    							produtos_ativo = 'A' AND produtos_qtd > 0 AND produtos_categoria = ? AND (produtos_marca LIKE '%".$nome."%' OR produtos_nome LIKE '%".$nome."%' OR produtos_descricao LIKE '%".$nome."%')
	    							");
	    $stm->bindValue(1, $categoria);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function getProductsSearchSN($tamanho,$nome){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							produtos_codigo, produtos_nome, (SELECT categorias_nome FROM categorias WHERE categorias_codigo=produtos_categoria) AS produtos_categoria_nome, produtos_marca, produtos_tamanho, produtos_descricao, (produtos_valor/100) AS produtos_preco, produtos_desconto, produtos_qtd, produtos_categoria
	    							FROM
	    							produtos
	    							WHERE
	    							produtos_ativo = 'A' AND produtos_qtd > 0 AND produtos_tamanho = ? AND (produtos_marca LIKE '%".$nome."%' OR produtos_nome LIKE '%".$nome."%' OR produtos_descricao LIKE '%".$nome."%')
	    							");
	    $stm->bindValue(1, $tamanho);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function getProductsSearchC($categoria){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							produtos_codigo, produtos_nome, (SELECT categorias_nome FROM categorias WHERE categorias_codigo=produtos_categoria) AS produtos_categoria_nome, produtos_marca, produtos_tamanho, produtos_descricao, (produtos_valor/100) AS produtos_preco, produtos_desconto, produtos_qtd, produtos_categoria
	    							FROM
	    							produtos
	    							WHERE
	    							produtos_ativo = 'A' AND produtos_qtd > 0 AND produtos_categoria = ?
	    							");
	    $stm->bindValue(1, $categoria);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function getProductsSearchS($size){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							produtos_codigo, produtos_nome, (SELECT categorias_nome FROM categorias WHERE categorias_codigo=produtos_categoria) AS produtos_categoria_nome, produtos_marca, produtos_tamanho, produtos_descricao, (produtos_valor/100) AS produtos_preco, produtos_desconto, produtos_qtd, produtos_categoria
	    							FROM
	    							produtos
	    							WHERE
	    							produtos_ativo = 'A' AND produtos_qtd > 0 AND produtos_tamanho LIKE ?
	    							");
	    $stm->bindValue(1, $size);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function getProductsSearchN($nome){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							produtos_codigo, produtos_nome, (SELECT categorias_nome FROM categorias WHERE categorias_codigo=produtos_categoria) AS produtos_categoria_nome, produtos_marca, produtos_tamanho, produtos_descricao, (produtos_valor/100) AS produtos_preco, produtos_desconto, produtos_qtd, produtos_categoria
	    							FROM
	    							produtos
	    							WHERE
	    							produtos_ativo = 'A' AND produtos_qtd > 0 AND (produtos_marca LIKE '%".$nome."%' OR produtos_nome LIKE '%".$nome."%' OR produtos_descricao LIKE '%".$nome."%')
	    							");
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function getPicture($codigo){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							fotos_nome
	    							FROM
	    							fotos_produtos
	    							WHERE
	    							fotos_produtos_codigo=?
	    							LIMIT 1");
	    $stm->bindValue(1, $codigo);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	} 

	public function getPicturesProduto($codigo){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							fotos_nome
	    							FROM
	    							fotos_produtos
	    							WHERE
	    							fotos_produtos_codigo=?
	    							");
	    $stm->bindValue(1, $codigo);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	} 

	public function getCategories(){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							categorias_codigo, categorias_nome
	    							FROM
	    							categorias
	    							WHERE
	    							categorias_ativo='A'");
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	} 

	public function getValidEmail($email){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							pessoas_codigo
	    							FROM
	    							pessoas
	    							WHERE
	    							pessoas_email=?
	    							LIMIT 1");
	    $stm->bindValue(1, $email);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	}

	public function getValidPass($email,$senha){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							pessoas_codigo, pessoas_nome
	    							FROM
	    							pessoas
	    							WHERE
	    							pessoas_email=? AND pessoas_password=?
	    							LIMIT 1");
	    $stm->bindValue(1, $email);
	    $stm->bindValue(2, $senha);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	} 

	public function getProductsConfig(){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							produtos_codigo, produtos_nome, (SELECT categorias_nome FROM categorias WHERE categorias_codigo=produtos_categoria) AS produtos_categoria_nome, produtos_marca, produtos_tamanho, produtos_descricao, (produtos_valor/100) AS produtos_preco, produtos_desconto, produtos_qtd, produtos_ativo
	    							FROM
	    							produtos
	    							ORDER BY produtos_codigo DESC
	    							");
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function getDadosProduto($codigo){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							produtos_nome, (SELECT categorias_nome FROM categorias WHERE categorias_codigo=produtos_categoria) AS produtos_categoria_nome, produtos_marca, produtos_tamanho, produtos_descricao, (produtos_valor/100) AS produtos_preco, produtos_desconto, produtos_qtd
	    							FROM
	    							produtos
	    							WHERE
	    							produtos_codigo=?
	    							LIMIT 1");
	    $stm->bindValue(1, $codigo);
	    $stm->execute();  
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function updateProduct($codigo,$nome,$categoria,$marca,$tamanho,$descricao,$valor,$desconto,$qtd){
		try{   
	    $stm = $this->pdo->prepare("UPDATE
	    							produtos
	    							SET
	    							produtos_nome=?, produtos_categoria=?, produtos_marca=?, produtos_tamanho=?, produtos_descricao=?, produtos_valor=?, produtos_desconto=?, produtos_qtd=?
	    							WHERE
	    							produtos_codigo=?
	    							");
	    $stm->bindValue(1, $nome);
	    $stm->bindValue(2, $categoria);
	    $stm->bindValue(3, $marca);
	    $stm->bindValue(4, $tamanho);
	    $stm->bindValue(5, $descricao);
	    $stm->bindValue(6, $valor);
	    $stm->bindValue(7, $desconto);
	    $stm->bindValue(8, $qtd);
	    $stm->bindValue(9, $codigo);
	    $stm->execute();  
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function insertProduct($nome,$categoria,$marca,$tamanho,$descricao,$valor,$desconto,$qtd){
		try{   
	    $stm = $this->pdo->prepare("INSERT INTO produtos VALUES(0,?,?,?,?,?,?,?,?,'A')");

	    $stm->bindValue(1, $nome);
	    $stm->bindValue(2, $categoria);
	    $stm->bindValue(3, $marca);
	    $stm->bindValue(4, $tamanho);
	    $stm->bindValue(5, $descricao);
	    $stm->bindValue(6, $valor);
	    $stm->bindValue(7, $desconto);
	    $stm->bindValue(8, $qtd);
	    $stm->execute();

	    $stm = $this->pdo->prepare("SELECT produtos_codigo FROM produtos");

	    $stm->execute();

	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);

	    $folder;

	    foreach($dados as $reg):
	    	$folder = $reg->produtos_codigo;
	    endforeach;

	    mkdir("images/".$folder);

	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function lockProduct($codigo){
		try{   
	    $stm = $this->pdo->prepare("UPDATE produtos SET produtos_ativo='N' WHERE produtos_codigo=?");

	    $stm->bindValue(1, $codigo);
	    $stm->execute();  
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>";
	   }
	}

	public function unlockProduct($codigo){
		try{   
	    $stm = $this->pdo->prepare("UPDATE produtos SET produtos_ativo='A' WHERE produtos_codigo=?");

	    $stm->bindValue(1, $codigo);
	    $stm->execute();  
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>";
	   }
	}

	public function deleteProduct($codigo){
		try{   
	    $stm = $this->pdo->prepare("DELETE FROM produtos WHERE produtos_codigo=?");
	    $stm->bindValue(1, $codigo);
	    $stm->execute();

	    $stm = $this->pdo->prepare("DELETE FROM fotos_produtos WHERE fotos_produtos_codigo=?");
	    $stm->bindValue(1, $codigo);
	    $stm->execute();

	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);

	    rmdir("images/".$codigo);

	    return true;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>";
	   }
	}

	public function insertProductPhoto($codigo,$nome){
		try{   
	    $stm = $this->pdo->prepare("DELETE FROM fotos_produtos WHERE fotos_produtos_codigo=? AND fotos_nome=?;
	    							INSERT INTO fotos_produtos VALUES(0,?,?)");

	    $stm->bindValue(1, $codigo);
	    $stm->bindValue(2, $nome);
	    $stm->bindValue(3, $codigo);
	    $stm->bindValue(4, $nome);
	    $stm->execute();
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function deleteProductPhoto($codigo,$nome){
		try{   
	    $stm = $this->pdo->prepare("DELETE FROM fotos_produtos WHERE fotos_produtos_codigo=? AND fotos_nome=?");

	    $stm->bindValue(1, $codigo);
	    $stm->bindValue(2, $nome);
	    $stm->execute();
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);
	    return true;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function getCategoriesConfig(){
		try{   
	    $stm = $this->pdo->prepare("SELECT * FROM categorias");
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function lockCategory($codigo){
		try{   
	    $stm = $this->pdo->prepare("UPDATE categorias SET categorias_ativo='N' WHERE categorias_codigo=?");

	    $stm->bindValue(1, $codigo);
	    $stm->execute();  
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>";
	   }
	}

	public function unlockCategory($codigo){
		try{   
	    $stm = $this->pdo->prepare("UPDATE categorias SET categorias_ativo='A' WHERE categorias_codigo=?");

	    $stm->bindValue(1, $codigo);
	    $stm->execute();  
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>";
	   }
	}

	public function deleteCategory($codigo){
		try{   
	    $stm = $this->pdo->prepare("DELETE FROM categorias WHERE categorias_codigo=?");

	    $stm->bindValue(1, $codigo);
	    $stm->execute();
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);
	    return true;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function saveCategory($codigo,$valor){
		try{   
	    $stm = $this->pdo->prepare("UPDATE categorias SET categorias_nome=? WHERE categorias_codigo=?");

	    $stm->bindValue(1, $valor);
	    $stm->bindValue(2, $codigo);
	    $stm->execute();
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);
	    return true;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function saveTracker($codigo,$valor){
		try{   
	    $stm = $this->pdo->prepare("UPDATE vendas SET vendas_rastreio=? WHERE vendas_codigo=?");

	    $stm->bindValue(1, $valor);
	    $stm->bindValue(2, $codigo);
	    $stm->execute();
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);
	    return true;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function addCategory($valor){
		try{   
	    $stm = $this->pdo->prepare("INSERT INTO categorias VALUES(0,?,'A')");

	    $stm->bindValue(1, $valor);
	    $stm->execute();
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);
	    return true;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   }
	}

	public function getUserData($codigo){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							pessoas_nome, pessoas_sobrenome, pessoas_email, pessoas_endereco, pessoas_cidade, pessoas_estado, pessoas_cep
	    							FROM
	    							pessoas
	    							WHERE
	    							pessoas_codigo=?
	    							LIMIT 1");
	    $stm->bindValue(1, $codigo);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	}

	public function getAmountProduct($codigo){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							produtos_qtd, produtos_valor, produtos_desconto
	    							FROM
	    							produtos
	    							WHERE
	    							produtos_codigo=?
	    							LIMIT 1");
	    $stm->bindValue(1, $codigo);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	}

	public function insertBought($codigo,$pessoa,$valor,$qtd,$email,$nome,$endereco,$cidade,$estado,$cep){
		try{   
	    $stm = $this->pdo->prepare("INSERT INTO vendas VALUES(0,?,?,?,?,CURDATE(),?,?,?,?,?,?,NULL)");

	    $stm->bindValue(1, $pessoa);
	    $stm->bindValue(2, $codigo);
	    $stm->bindValue(3, $valor);
	    $stm->bindValue(4, $qtd);
	    $stm->bindValue(5, $email);
	    $stm->bindValue(6, $nome);
	    $stm->bindValue(7, $endereco);
	    $stm->bindValue(8, $cidade);
	    $stm->bindValue(9, $estado);
	    $stm->bindValue(10, $cep);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	}

	public function updateProductAmount($codigo,$qtd){
		try{   
	    $stm = $this->pdo->prepare("UPDATE produtos SET produtos_qtd=? WHERE produtos_codigo=?");

	    $stm->bindValue(1, $qtd);
	    $stm->bindValue(2, $codigo);
	    $stm->execute();  
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>";
	   }
	}

	public function getUserInfo($codigo){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							pessoas_endereco, pessoas_cidade, pessoas_estado, pessoas_cep
	    							FROM
	    							pessoas
	    							WHERE
	    							pessoas_codigo=?
	    							LIMIT 1");
	    $stm->bindValue(1, $codigo);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	} 

	public function getUserBought($codigo){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							vendas_produto_codigo, (vendas_valor/100) AS vendas_preco, vendas_qtd, vendas_data, vendas_cep, (SELECT fotos_nome FROM fotos_produtos WHERE fotos_produtos_codigo=vendas_produto_codigo LIMIT 1) AS nome_foto, (SELECT produtos_nome FROM produtos WHERE produtos_codigo=vendas_produto_codigo LIMIT 1) AS produtos_nome, vendas_rastreio
	    							FROM
	    							vendas
	    							WHERE
	    							vendas_pessoas_codigo=?
	    							ORDER BY vendas_codigo DESC");
	    $stm->bindValue(1, $codigo);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	}

	public function getAllBought(){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							*, (vendas_valor/100) AS vendas_preco, (SELECT fotos_nome FROM fotos_produtos WHERE fotos_produtos_codigo=vendas_produto_codigo LIMIT 1) AS nome_foto, (SELECT produtos_nome FROM produtos WHERE produtos_codigo=vendas_produto_codigo LIMIT 1) AS produtos_nome
	    							FROM
	    							vendas
	    							ORDER BY vendas_codigo DESC");
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	}

	public function savePersonalData($codigo,$endereco,$cidade,$estado,$cep){
		try{   
	    $stm = $this->pdo->prepare("UPDATE
	    							pessoas
	    							SET
	    							pessoas_endereco=?, pessoas_cidade=?, pessoas_estado=?, pessoas_cep=?
	    							WHERE
	    							pessoas_codigo=?");

	    $stm->bindValue(1, $endereco);
	    $stm->bindValue(2, $cidade);
	    $stm->bindValue(3, $estado);
	    $stm->bindValue(4, $cep);
	    $stm->bindValue(5, $codigo);
	    $stm->execute();  
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>";
	   }
	}

	public function getUserPassword($codigo){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							pessoas_password
	    							FROM
	    							pessoas
	    							WHERE
	    							pessoas_codigo=?
	    							LIMIT 1");
	    $stm->bindValue(1, $codigo);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	} 

	public function savePersonalPassword($codigo,$senha){
		try{   
	    $stm = $this->pdo->prepare("UPDATE
	    							pessoas
	    							SET
	    							pessoas_password=?
	    							WHERE
	    							pessoas_codigo=? LIMIT 1");

	    $stm->bindValue(1, $senha);
	    $stm->bindValue(2, $codigo);
	    $stm->execute();  
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>";
	   }
	}

	public function verifyUser($email){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							pessoas_codigo
	    							FROM
	    							pessoas
	    							WHERE
	    							pessoas_email=?
	    							LIMIT 1");
	    $stm->bindValue(1, $email);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	} 

	public function insertUser($email,$senha,$nome,$sobrenome){
		try{   
	    $stm = $this->pdo->prepare("INSERT INTO pessoas VALUES(0,?,?,?,?,NULL,NULL,NULL,NULL)");

	    $stm->bindValue(1, $nome);
	    $stm->bindValue(2, $sobrenome);
	    $stm->bindValue(3, $email);
	    $stm->bindValue(4, $senha);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	}

	public function addCart($nome,$codigo){
		try{   
	    $stm = $this->pdo->prepare("INSERT INTO carrinho VALUES(0,?,?)");

	    $stm->bindValue(1, $nome);
	    $stm->bindValue(2, $codigo);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	}

	public function removeCart($nome,$codigo){
		try{   
	    $stm = $this->pdo->prepare("DELETE FROM carrinho WHERE carrinho_pessoas_codigo=? AND carrinho_codigo=?");

	    $stm->bindValue(1, $nome);
	    $stm->bindValue(2, $codigo);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	}

	public function getCartData($codigo){
		try{   
	    $stm = $this->pdo->prepare("SELECT
	    							a.*, b.*, (SELECT fotos_nome FROM fotos_produtos WHERE fotos_produtos_codigo=a.carrinho_produtos_codigo LIMIT 1) AS nome_foto, (b.produtos_valor/100) AS produtos_preco
	    							FROM
	    							carrinho a, produtos b
	    							WHERE
	    							a.carrinho_pessoas_codigo=? AND
	    							b.produtos_codigo=a.carrinho_produtos_codigo
	    							");

	    $stm->bindValue(1, $codigo);
	    $stm->execute();   
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>"; 
	   } 
	}

	public function updatePassword($email,$senha){
		try{   
	    $stm = $this->pdo->prepare("UPDATE
	    							pessoas
	    							SET
	    							pessoas_password=?
	    							WHERE
	    							pessoas_email=? LIMIT 1");

	    $stm->bindValue(1, $senha);
	    $stm->bindValue(2, $email);
	    $stm->execute();  
	    $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
	    return $dados;   
	   }catch(PDOException $erro){   
	    echo "<script>alert('Erro na linha: {$erro->getLine()}')</script>";
	   }
	}
}

?>