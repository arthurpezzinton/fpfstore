function logout(){
	$.ajax({
		type: "POST",
		url: "logout.php",
		dataType: 'json',
		data: {
		},
					
		success: function(result){
			if(result == "logedOut"){
				window.location.href = "index.php";
			}
		},
		
		error: function(message) {
			swal({
			  title: "Erro",
			  text: "Desculpe, houve um erro na sa\u00edda do usu\u00e1rio.",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			});
		}
	});
}

function buyNow(code){
	window.location.href = "buy_now.php?code="+code;
}

function endBuyNow(code){
	$("#loaderPay").css("display", "");
	$.ajax({
		type: "POST",
		url: "finish_buy_now.php",
		dataType: 'json',
		data: {
			codigo: code,
			quantidade: $("#buyNowQtd").val(),
			email: $("#buyNowEmail").val(),
			nome: $("#buyNowName").val(),
			endereco: $("#buyNowAddress").val(),
			cidade: $("#buyNowCity").val(),
			estado: $("#buyNowState").val(),
			cep: $("#buyNowCEP").val()
		},
					
		success: function(result){
			if(result == "noAmount"){
				swal({
				  title: "Erro",
				  text: "Desculpe, n\u00e3o possu\u00edmos a quantidade deste produto desejado em estoque.",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
				});
			}else if(result == "missingData"){
				swal({
				  title: "Erro",
				  text: "Todos os dados para a compra devem ser preenchidos.",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
				});
			}else{
				swal({
					  title: "Conclu\u00eddo",
					  text: "Parab\u00e9ns! Sua compra foi registrada em nosso sistema.\nEntraremos em contato por email.",
					  icon: "success",
					  buttons: true,
					  dangerMode: false,
					}).then((willDelete) => {
					  if (willDelete) {
							window.location.href = "index.php";
					  } else {
							window.location.href = "index.php";
					  }
					});
			}
			$("#loaderPay").css("display", "none");
		},
		
		error: function(message) {
			swal({
			  title: "Erro",
			  text: "Desculpe, houve um erro na escrita dos dados.",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			});
			$("#loaderPay").css("display", "none");
		}
	});
}

function addToCart(code){
	$.ajax({
		type: "POST",
		url: "add_cart.php",
		dataType: 'json',
		data: {
			codigo: code,
		},
					
		success: function(result){
			if(result == "logedOut"){
				swal({
				  title: "Erro",
				  text: "Fa\u00e7a login para adicionar produtos \u00e0 sua lista de desejos.",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
				});
			}else{
				swal({
					  title: "Conclu\u00eddo",
					  text: "Item adicionado ao carrinho.",
					  icon: "success",
					  buttons: true,
					  dangerMode: false,
					});
			}
		},
		
		error: function(message) {
			swal({
			  title: "Erro",
			  text: "Desculpe, houve um erro na escrita dos dados.",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			});
		}
	});
}


function removeCart(code){
	$.ajax({
		type: "POST",
		url: "remove_cart.php",
		dataType: 'json',
		data: {
			codigo: code,
		},
					
		success: function(result){
			if(result == "logedOut"){
				swal({
				  title: "Erro",
				  text: "Erro na obten\u00e7\u00e3o dos par\u00e2metros.",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
				});
			}else{
				swal({
					  title: "Conclu\u00eddo",
					  text: "Item removido do carrinho.",
					  icon: "success",
					  buttons: true,
					  dangerMode: false,
					}).then((willDelete) => {
					  if (willDelete) {
							window.location.href = "cart.php";
					  } else {
							window.location.href = "cart.php";
					  }
					});
			}
		},
		
		error: function(message) {
			swal({
			  title: "Erro",
			  text: "Desculpe, houve um erro na escrita dos dados.",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			});
		}
	});
}