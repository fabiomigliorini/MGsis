<script>
	function adicionaTitulos(tit, sel)
	{
		// se já tem o registro, cai fora
		if ($('#registro_' + tit.codtitulo).length > 0)
			return
		
		if (sel)
			var checked = 'checked';
		else
			var checked = '';
		
		// html a ser gerado
		html  = '	<div class="registro" id="registro_var_codtitulo"> \n';
		html += '		<small class="row-fluid">';
		html += '			<span class="span1 css_filial"> \n';
		html += '				var_filial';
		html += '			</span> \n';
		html += '			<span class="span2 muted">';
		html += '				<input type="checkbox" name="TituloAgrupamento[codtitulos][]" id="TituloAgrupamento_codtitulos_var_codtitulo" class="codtitulos" value="var_codtitulo" ' + checked + '>&nbsp;';
		html += '				<input type="hidden" name="saldo_var_codtitulo" id="saldo_var_codtitulo" value="var_saldo">';
		html += '				<?php echo CHtml::link('var_numero',array('titulo/view','id'=>'var_codtitulo')); ?>';
		html += '			</span>';
		html += '			<b class="span2 text-right css_valor">';
		html += '				var_saldo_fmt';
		html += '				var_operacao';
		html += '			</b>';
		html += '			<b class="span1 css_vencimento">';
		html += '				var_vencimento';
		html += '			</b>';
		html += '			<span class="span3 muted">';
		html += '				<?php echo CHtml::link('var_fantasia',array('pessoa/view','id'=>'var_codpessoa')); ?>';
		html += '			</span>';
		html += '			<span class="span1">';
		html += '				var_portador';
		html += '			</span>';
		html += '			<span class="span2">';
		html += '				var_boleto';
		html += '				var_nossonumero';
		html += '			</span>';
		html += '		</small>';
		html += '	</div>';
		
		// altera css do html
		html = html.replace(/css_valor/g, tit.css_valor);
		html = html.replace(/css_vencimento/g, tit.css_vencimento);
		html = html.replace(/css_filial/g, tit.css_filial);
		
		if (!tit.nossonumero)
			tit.nossonumero = '';
		
		if (!tit.portador)
			tit.portador = '';
		
		if (!tit.boleto)
			tit.boleto = '';
		else
			tit.boleto = 'Boleto'
		
		// altera valores no html
		html = html.replace(/var_codtitulo/g, tit.codtitulo);
		html = html.replace(/var_filial/g, tit.filial);
		html = html.replace(/var_nossonumero/g, tit.nossonumero);
		html = html.replace(/var_numero/g, tit.numero);
		html = html.replace(/var_vencimento/g, tit.vencimento);
		html = html.replace(/var_saldo_fmt/g, tit.saldo_fmt);
		html = html.replace(/var_saldo/g, tit.saldo);
		html = html.replace(/var_operacao/g, tit.operacao);
		html = html.replace(/var_portador/g, tit.portador);
		html = html.replace(/var_boleto/g, tit.boleto);
		html = html.replace(/var_codpessoa/g, tit.codpessoa);
		html = html.replace(/var_fantasia/g, tit.fantasia);

		// adiciona linha na listagem
		$('#listagem-titulo').append(html);
		
				calculaTotalSelecionado();
		//console.log(html);
	}
	
	function limpaTitulos()
	{
		// remove todos os titulos nao selecionados
		$('.codtitulos').each(function(){
			if (!$(this).attr('checked')){
				$('#registro_' + $(this).attr('value')).remove();
			}
		});
	}
	
	function calculaTotalSelecionado()
	{
		// percorre todos os selecionados
		var total = 0;
		
		$('.registro').each(function(){
			$(this).removeClass('alert-success');
		});
		
		$('.codtitulos:checked').each(function(){
			total += +$('#saldo_' + $(this).attr('value')).val();
			$('#registro_' + $(this).attr('value')).addClass('alert-success');

		});
		
		// formata, troca css e calcula a operacao
		var texto = $.number(Math.abs(total), 2, ',', '.');
		if (total<0)
		{
			$('#total').removeClass('text-success');
			$('#total').addClass('text-warning');
			texto += ' CR';
			//total *= -1;
		}
		else
		{
			$('#total').addClass('text-success');
			$('#total').removeClass('text-warning');
			texto += ' DB';
		}
		
		// altera campo
		$('#total').text(texto);
	}
	
	$(document).ready(function() {
		// cada vez que altera a pessoa, refaz a listagem de títulos
		$("#TituloAgrupamento_codpessoa").on("change", function(e) {
			$.getJSON("<?php echo Yii::app()->createUrl('titulo/ajaxbuscatitulo') ?>&codpessoa="+escape($("#TituloAgrupamento_codpessoa").val()), function(data) {
				limpaTitulos();
				$.each(data, function(linha, val) {
					adicionaTitulos(val, false);
				});
				$('.codtitulos').on("change", function(){
					calculaTotalSelecionado();
				});
			});
		});

		
	<?php
	if (!isset($model->codtitulos))
		$model->codtitulos = array();
	
	foreach ($model->codtitulos as $codtitulo)
	{
		?>
				
		$.getJSON("<?php echo Yii::app()->createUrl('titulo/ajaxbuscatitulo') ?>&codtitulo=<?php echo $codtitulo; ?>", function(data) {
			$.each(data, function(linha, val) {
				adicionaTitulos(val, true);
			});
			$('.codtitulos').on("change", function(){
				calculaTotalSelecionado();
			});
		});
		<?php
	}
	?>	


	});

</script>
<?php

echo $form->select2PessoaRow($model, 'codpessoa');

$html_titulos = '<div id="listagem-titulo">';
$html_titulos .= '</div>';

echo $form->customRow($model, 'codtitulos', $html_titulos);


?>
