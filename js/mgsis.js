function formataCodigo(numero)
{
    if (numero > 99999999)
        return numero;
    
    numero = new String("00000000" + numero);
    numero = numero.substring(numero.length-8, numero.length);
    return numero;
}

function formataCnpjCpf(numero)
{
    //CNPJ
    if (numero > 99999999999)
    {
        numero = new String("00000000000000" + numero);
        numero = numero.substring(numero.length-14, numero.length);
        // 01 234 567 8901 23
        // 04.576.775/0001-60
        numero = numero.substring(0, 2) 
                 + "."
                 + numero.substring(2, 5)
                 + "."
                 + numero.substring(5, 8)
                 + "/"
                 + numero.substring(8, 12)
                 + "-"
                 + numero.substring(12, 14)
                 ;
    }
    //CPF
    else
    {
        numero = "000000000000" + numero;
        numero = numero.substring(numero.length-11, numero.length);
        // 012 345 678 90
        // 123 456 789 01
        // 803.452.710.68
        numero = numero.substring(0, 3) 
                 + "."
                 + numero.substring(3, 6)
                 + "."
                 + numero.substring(6, 9)
                 + "-"
                 + numero.substring(9, 11)
                 ;
    }

    return numero;
}

/*
 * 
 * Funcao para fazer o ENTER funcionar como TAB
 * 
 * 
$(document).ready(function(){
	bootbox.setLocale("br");
	$("input").not( $(":button") ).keypress(function (evt) {
		if (evt.keyCode == 13) {
			iname = $(this).val();
			if (iname !== 'Submit'){
				var fields = $(this).parents('form:eq(0),body').find('button, input, select, button, textarea').filter(':visible');
				//var fields = $(this).parents('form:eq(0),body').find('button, input, textarea, select');
				var index = fields.index( this );
				if ( index > -1 && ( index + 1 ) < fields.length ) {
					fields.eq( index + 1 ).focus();
				}
				return false;
			}
		}
	});
});
*/

function arredondar(value, places) {
    var multiplier = Math.pow(10, places);

    return (Math.round(value * multiplier) / multiplier);
}