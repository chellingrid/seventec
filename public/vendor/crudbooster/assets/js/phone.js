$(document).ready(function() {

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

	$('#phone').inputFilter(function(value) {
		return /^\d*$/.test(value);    // Allow digits only, using a RegExp
	});

	function phoneMask(telefone) {
		if(telefone.length > 11 || telefone.length < 8){
			$("#phone").val(''); //telefone incorreto
			return;
		}
		let textoAjustado = '';
		if(telefone.length > 9){
			const ddd = telefone.slice(0, 2); //ddd
			textoAjustado = `(${ddd}) `;
			telefone = telefone.substring(2);
		}
		const textoAtual = telefone;
		if (textoAtual.length === 9) {
			const parte1 = textoAtual.slice(0, 5);
			const parte2 = textoAtual.slice(5, 9);
			textoAjustado = textoAjustado+`${parte1}-${parte2}`;
		} else {
			const parte1 = textoAtual.slice(0, 4);
			const parte2 = textoAtual.slice(4, 8);
			textoAjustado = textoAjustado+`${parte1}-${parte2}`;
		}
		$("#phone").val(textoAjustado);
	}

	//Quando o campo phone perde o foco.
	$("#phone").blur(function() {
	
		//Nova variável "phone" somente com dígitos.
		var phone = $(this).val().replace(/\D/g, '');
		phoneMask(phone);
	});
});