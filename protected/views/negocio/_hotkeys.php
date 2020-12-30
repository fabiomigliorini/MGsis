<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.hotkeys.js');
// Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.ba-throttle-debounce.min.js');

Yii::app()->clientScript->registerScript("hotkeys", <<<EOF
function redireciona (btn)
{
	var url = $(btn).attr("href");
	if (url != null)
	{
		window.location = url;
		return true;
	}
	return false;
}

function fechaJanelas()
{
	bootbox.hideAll();
	$(".modal").modal('hide');
	if ($("#barras").length)
		$("#barras").focus();
	if ($("#Negocio_codpessoavendedor").length)
		$("#Negocio_codpessoavendedor").select2('focus');
	$(".btn").removeAttr("disabled");
	return false;
}

function acaoF3 ()
{
	if (redireciona ("#btnFechar"))
		return true;

	adicionaFormaPagamento();
	$("#btnSalvarFechar").trigger( "click" );

}

function acaoF7()
{
    mostrarPrancheta();
}

function acaoF8()
{
	$.debounce(250, function(e) {
		console.log('F8 Devounce');
	});
	console.log('F8 Fora');
	// if (typeof consultarPixCob === 'function') {
	// 	consultarPixCob();
	// }
}


$(document).ready(function() {
	$("*").bind('keydown.f1',function (e){ e.preventDefault(); return redireciona ("#btnListagem"); });
	$("*").bind('keydown.f2',function (e){ e.preventDefault(); return redireciona ("#btnNovo"); });
	$("*").bind('keydown.f3',function (e){ e.preventDefault(); return acaoF3(); });
	$("*").bind('keydown.f4',function (e){ e.preventDefault(); return redireciona ("#btnDetalhes"); });
	$("*").bind('keydown.f7',function (e){ e.preventDefault(); return acaoF7(); });
	$("*").bind('keydown.f8',function (e){ e.preventDefault(); return acaoF8(); });
	$("*").bind('keydown.esc',function (e){ return fechaJanelas(); });
});

EOF
	);
?>
<script type="text/javascript">


</script>
