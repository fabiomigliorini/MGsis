<div style="min-height: 120px">
<?php
if ($model->codnegociostatus == 1)
{
	?>
	<form>
		<div class="row-fluid">
			<div class="input-prepend">
				<label class="add-on" for="quantidade">Quantidade</label>
				<input class="input-mini text-right" id="quantidade" type="text" value="1">
			</div>
			<div class="input-prepend input-append">
				<label class="add-on" for="barras">Código</label>
				<input class="input-medium text-right" id="barras" type="text">
				<button class="btn" type="submit" id="btnAdicionar" tabindex="-1">Adicionar</button>
			</div>
		</div>
		<div class="row-fluid">
			<?php
			$this->widget('MGSelect2ProdutoBarra', 
				array(
					'name' => 'codprodutobarra', 
					'htmlOptions' => array(
						'class' => 'span12', 
						'placeholder' => 'Pesquisa de Produtos'
						),
					)
				); 
			?>
		</div>
	</form>
	<?php
}



?>
<div id="listagemProdutos">
	<?php
	$this->renderPartial('_view_produtos_listagem',
		array(
			'model'=>$model,
		));		
	?>
</div>
</div>
<script>
	
function atualizaListagemProdutos()
{
	$.ajax({
		url: "<?php echo Yii::app()->createUrl('negocio/atualizalistagemprodutos') ?>",
		data: {
			codnegocio: <?php echo $model->codnegocio; ?>
		},
		type: "GET",
		dataType: "html",
		async: true,
		success: function (data) {
			$('#listagemProdutos').html(data);
		},
		error: function (xhr, status) {
			bootbox.alert("Erro ao atualizar listagem de produtos!");
		},
	});				

}

function atualizaTotais()
{
	$.ajax({
		url: "<?php echo Yii::app()->createUrl('negocio/atualizatotais') ?>",
		data: {
			codnegocio: <?php echo $model->codnegocio; ?>
		},
		type: "GET",
		dataType: "html",
		async: true,
		success: function (data) {
			$('#totais').html(data);
			$('#totais').animate({opacity: 0.25,}, 200 );			
			$('#totais').animate({opacity: 1,}, 200 );			
		},
		error: function (xhr, status) {
			bootbox.alert("Erro ao atualizar totais!");
		},
	});				
}

function atualizaTela()
{
	atualizaListagemProdutos();
	atualizaTotais();
}

function adicionaProduto()
{
	
	var barras = $("#barras").val();
	var quantidade = $('#quantidade').autoNumeric('get');
	$("#barras").val("");
	$.ajax({
		url: "<?php echo Yii::app()->createUrl('negocio/adicionaproduto') ?>",
		data: {
			codnegocio: <?php echo $model->codnegocio; ?>,
			barras: barras,
			quantidade: quantidade,
		},
		type: "GET",
		dataType: "json",
		async: false,
		success: function(data) {
			if (!data.Adicionado)
			{
				bootbox.dialog(data.Mensagem, 
					[{
						"label" : "Fechar",
						"class" : "btn-warning",
						"callback": function() {
								$("#barras").focus();
							}						
					}]);
				$.notify(barras + " Não Localizado!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
			}
			else
			{
				//$("#barras").notify("Adicionado!", "success", { position:"left" });
				$("#quantidade").autoNumeric('set', 1);
				$.notify(barras + " Adicionado!", { position:"right bottom", className:"success", autoHideDelay: 15000 });
				atualizaTela();
			}
		},
		error: function (xhr, status) {
			bootbox.alert("Erro ao adicionar produto!");
		},
	});
}

function preencheQuantidade()
{
	//pega campo com codigo de barras
	var barras = $("#barras").val().trim();
	
	//o tamanho com o asterisco deve ser entre 2 e 5
	if (barras.length > 5 || barras.length < 2)
		return;
	
	// se o último dígito é o asterisco
	if (barras.slice(-1) != "*")
		return;
	
	//se o valor antes do asterisco é um número
	barras = barras.substr(0, barras.length - 1).trim().replace(',', '.');
	if (!$.isNumeric(barras))
		return;
	
	// se o número é maior ou igual à 1
	barras=parseFloat(barras);
	if (barras < 0.01)
		return;
	
	//preenche o campo de quantidade
	//$("#quantidade").val(barras);
	$("#quantidade").autoNumeric('set', barras);
	
	//limpa o código de barras
	$("#barras").val("");
	
	$('#quantidade').animate({opacity: 0.25,}, 200 );			
	$('#quantidade').animate({opacity: 1,}, 200 );			
}
	
$(document).ready(function() {

	$("#barras").focus();
	$('#quantidade').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	
    $("#btnAdicionar").click(function(e){ 
		e.preventDefault();
		adicionaProduto (); 
	});
	
    $("#barras").keyup(function(){ 
		preencheQuantidade();
	});
	
	$('#codprodutobarra').change(function(e) { 
		if ($("#codprodutobarra").select2('data') != null)
		{
			$("#barras").val($("#codprodutobarra").select2('data').barras);
			window.setTimeout(function(){$('#barras').focus();}, 0);
			$('#codprodutobarra').select2('data', null);
			adicionaProduto ();
		}
	});
	// botão delete da embalagem
	jQuery(document).on('click','a.delete-barra',function(e) {
	
		//evita redirecionamento da pagina
		e.preventDefault();
		
		// pega url para delete
		var url = jQuery(this).attr('href');
		
		//pede confirmacao
		bootbox.confirm("Excluir este Item?", function(result) {
			
			// se confirmou
			if (result) {
				
				//faz post
				jQuery.ajax({
					type: 'POST',
					url: url,
					
					//se sucesso, atualiza listagem de embalagens
					success: function(){
						atualizaTela();
					},
					
					//caso contrário mostra mensagem com erro
					error: function (XHR, textStatus) {
						var err;
						if (XHR.readyState === 0 || XHR.status === 0) {
							return;
						}
						//tipos de erro
						switch (textStatus) {
							case 'timeout':
								err = 'O servidor não responde (timed out)!';
								break;
							case 'parsererror':
								err = 'Erro de parâmetros (Parser error)!';
								break;
							case 'error':
								if (XHR.status && !/^\s*$/.test(XHR.status)) {
									err = 'Erro ' + XHR.status;
								} else {
									err = 'Erro';
								}
								if (XHR.responseText && !/^\s*$/.test(XHR.responseText)) {
									err = err + ': ' + XHR.responseText;
								}
								break;
						}
						//abre janela do bootbox com a mensagem de erro
						if (err) {
							bootbox.alert(err);
						}
					}
				});
			}	
		});
	});			
	
});
	
</script>