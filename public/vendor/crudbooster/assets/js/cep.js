$(document).ready(function() {

	function clear_div() {
		// Limpa valores da div
		$('#address').remove();
		$('#postal_code').after('<div id="address"></div>');
	}

	(function($) {
		$.fn.inputFilter = function(inputFilter) {
			return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
				if (inputFilter(this.value)) {
					this.oldValue = this.value;
					this.oldSelectionStart = this.selectionStart;
					this.oldSelectionEnd = this.selectionEnd;
				} else if (this.hasOwnProperty("oldValue")) {
					this.value = this.oldValue;
					this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
				} else {
					this.value = "";
				}
			});
		};
	}(jQuery));

	$('#postal_code').inputFilter(function(value) {
		return /^\d*$/.test(value);    // Allow digits only, using a RegExp
	});

	//Quando o campo cep perde o foco.
	$("#postal_code").blur(function() {
		
		clear_div();	

		//Nova variável "cep" somente com dígitos.
		var cep = $(this).val().replace(/\D/g, '');

		//Verifica se campo cep possui valor informado.
		if (cep != "") {

			//Expressão regular para validar o CEP.
			var validacep = /^[0-9]{8}$/;

			//Valida o formato do CEP.
			if (validacep.test(cep)) {

				//Consulta o webservice viacep.com.br/
				$.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

					if (!("erro" in dados)) {
						//Atualiza os campos com os valores da consulta.
						var endereco = "<br><b>Logradouro:</b> "+dados.logradouro+"<br>"+
						"<b>Bairro:</b> "+dados.bairro+"<br>"+
						"<b>Cidade:</b> "+dados.localidade+"<br>"+
						"<b>Estado:</b> "+dados.uf;
						$("#address").html(endereco);
					} //end if.
					else {
						//CEP pesquisado não foi encontrado.
						$("#address").html("CEP não encontrado.");
					}
				});
			} //end if.
			else {
				//cep é inválido.
				$("#address").html("Formato de CEP inválido.");
			}
		} //end if.
		else {
			//cep sem valor, limpa formulário.
			clear_div();
		}
	});
});