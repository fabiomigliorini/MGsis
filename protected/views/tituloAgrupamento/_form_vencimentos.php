<?php

echo $form->dropDownListRow($model, 'codfilial', Filial::getListaCombo(), array('prompt' => '', 'class' => 'input-small'));
echo $form->toggleButtonRow($model, 'boleto', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
echo $form->dropDownListRow($model, 'codportador', Portador::getListaCombo(), array('prompt' => '', 'class' => 'input-large'));


echo $form->textFieldRow($model, 'parcelas', array('class' => 'input-mini text-right'));
echo $form->textFieldRow($model, 'primeira', array('class' => 'input-mini text-right'));
echo $form->textFieldRow($model, 'demais', array('class' => 'input-mini text-right'));

// Grid de Títulos
echo $form->customRow($model, 'vencimentos', '<input type="button" class="btn" id="btnCalcularParcelas" value="Calcular Parcelas"><hr><div id="listagem-vencimentos"></div>');

?>
<script>
	
	//calcula parelas 
	function calculaParcelas()
	{
		var valor;
		var valores = [];
		var vencimento = new Date();
		var vencimentos = [];
		
		var total = parseFloat($('#total_total').autoNumeric('get'));
		
		var parcelas = parseInt($('#TituloAgrupamento_parcelas').autoNumeric('get'));
		var primeira = parseInt($('#TituloAgrupamento_primeira').autoNumeric('get'));
		var demais = parseInt($('#TituloAgrupamento_demais').autoNumeric('get'));
		
		//limpa DIV dos vencimentos
		$('#listagem-vencimentos').empty();
		
		//gera parcelas
		for (i=1; i <= parcelas; i++)
		{
			//calcula vencimentos, diferente caso primeira parcela
			if (i == 1)
				vencimento.setDate(vencimento.getDate() + primeira);
			else
				vencimento.setDate(vencimento.getDate() + demais);
			
			//calcula valores, arredondando e jogando diferenca na ultima parcela
			if (i == parcelas)
				valor = total - valores.reduce(function(pv, cv) { return pv + cv; }, 0);
			else
				valor = Math.floor(total/parcelas);
			
			//cria array com vencimentos e valores
			vencimentos.push(vencimento);
			valores.push(valor);
			
			//chama funcao que desenha formulario na tela
			adicionaParcela(valor, $.datepicker.formatDate('dd/mm/yy', vencimento), i);
		}
		console.log($('#listagem-vencimentos').html());
	}
	
	//desenha html parcelas
	function adicionaParcela(valor, vencimento, numero)
	{
		var html = '';
		html += '<div class="row-fluid">';
		
		//campo Vencimentos
		html += '<div class="input-prepend"><span class="add-on"><i class="icon-calendar"></i></span><input class="input-small text-center" type="text" autocomplete="off" name="TituloAgrupamento[vencimentos][]" id="TituloAgrupamento_vencimentos_' + numero + '" value="' + vencimento + '" /></div>'
		
		//campo Valores
		html += '<div class="input-prepend"><span class="add-on">R$</span><input class="input-small text-right" type="text" autocomplete="off" name="TituloAgrupamento[valores][]" id="TituloAgrupamento_valores_' + numero + '" value="' + valor + '" /></div>'
		
		html += '</div>';
		$('#listagem-vencimentos').append(html);
		
		// Monta Calendario e Numero
		$('#TituloAgrupamento_vencimentos_' + numero).datepicker({'language':'pt','format':'dd/mm/yyyy'});
		$('#TituloAgrupamento_valores_' + numero).autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', vMin: '0.00'});
	}
	
	$(document).ready(function () {
		
		//formata numeros
		$('#TituloAgrupamento_parcelas').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', vMin: '0', vMax: '99' });
		$('#TituloAgrupamento_primeira').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', vMin: '0', vMax: '99' });
		$('#TituloAgrupamento_demais').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', vMin: '0', vMax: '99' });
		
		//calcula parcelas
		$('#btnCalcularParcelas').click(function(){ calculaParcelas(); });
		
		<?php
		for ($i=0; $i<sizeof($model->vencimentos); $i++)
		{
			?>
			adicionaParcela(<?php echo Yii::app()->format->unformatNumber($model->valores[$i]); ?>, '<?php echo $model->vencimentos[$i]; ?>', <?php echo $i; ?>);
			<?php
		}
		?>
		
	});
</script>