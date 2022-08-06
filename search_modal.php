<?php

	require_once "conexao.php";
	require_once "crud.php";

	require_once "card_function.php";

	$blog  = crudBlog::getInstance(Conexao::getInstance());
?>
<div id="searchBox" class="collapse">
				<div class="search-card container-fluid mt-3">
					<div class="row">
						<div class="col-sm-6 col-md-3 p-3">
							<label><strong>Categoria</strong></label>
							<select class="form-control" name="searchCategory" id="searchCategory">
								<option value="0">...</option>
								<?php
									$dados = $blog->getCategories();

									foreach ($dados as $reg):
								?>
								<option value="<?php echo $reg->categorias_codigo; ?>"><?php echo $reg->categorias_nome; ?></option>
								<?php
									endforeach;
								?>
							</select>
						</div>
						<div class="col-sm-6 col-md-3 p-3">
							<label><strong>Tamanho</strong></label>
							<input class="form-control" type="text" name="searchSize" id="searchSize">
						</div>
						<div class="col-sm-6 col-md-3 p-3">
							<label><strong>Nome / Marca</strong></label>
							<input class="form-control" type="text" name="searchName" id="searchName">
						</div>
						<div class="col-sm-6 col-md-3 p-3">
							<label></label>
							<button class="btn btn-product-buy" title="Pesquisar" onclick="search()"><i class='fas fa-search'></i>&nbsp; Pesquisar</button>
						</div>
					</div>
				</div>
			</div><br>

		<script type="text/javascript">
			
			function search(){
				if($("#searchCategory").val() == "0" && $("#searchSize").val() == "" && $("#searchName").val() == ""){
					window.location.href = "index.php";
				}else{
					var searchURL = "index.php?";
					if($("#searchCategory").val() != "0"){
						searchURL = searchURL + "category=" + $("#searchCategory").val();
					}
					if($("#searchSize").val() != ""){
						if($("#searchCategory").val() != "0"){
							searchURL = searchURL + "&";	
						}
						searchURL = searchURL + "size=" + $("#searchSize").val();
					}
					if($("#searchName").val() != ""){
						if($("#searchCategory").val() != "0" || $("#searchSize").val() != ""){
							searchURL = searchURL + "&";	
						}
						searchURL = searchURL + "name=" + $("#searchName").val();
					}
					window.location.href = searchURL;
				}
				//$("#productsList").html("");
			}
		</script>