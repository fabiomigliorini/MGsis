<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'nota-fiscal-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<div class="row-fluid">
		<div class="span5">
			<?php 	
			echo $form->toggleButtonRow($model,'emitida', array('options' => array('width' => 200,  'enabledLabel' => 'Filial', 'disabledLabel' => 'Contraparte')));
			echo $form->select2Row($model,'modelo', NotaFiscal::getModeloListaCombo() , array('class'=>'input-large'));
			echo $form->textFieldRow($model,'nfechave',array('class'=>'input-xlarge text-center','maxlength'=>100));
			echo $form->select2PessoaRow($model,'codpessoa', array('class'=>'input-xlarge'));
			echo $form->select2Row($model,'codnaturezaoperacao', NaturezaOperacao::getListaCombo() , array('class'=>'input-xlarge'));
			echo $form->textAreaRow($model,'observacoes',array('class'=>'input-xlarge', 'rows'=>'5','maxlength'=>1500));
			?>
		</div>
		<div class="span3">
			<?php
			echo $form->select2Row($model,'codfilial', Filial::getListaCombo() , array('class'=>'input-medium'));
			echo $form->textFieldRow($model,'serie',array('class'=>'input-mini text-right'));
			echo $form->textFieldRow($model,'numero',array('class'=>'input-small text-right'));
			echo $form->datetimepickerRow(
					$model,
					'emissao',
					array(
						'class' => 'input-medium text-center', 
						'options' => array(
							'language' => 'pt',
							'format' => 'dd/mm/yyyy hh:ii:ss',
							),
						//'prepend' => '<i class="icon-calendar"></i>',
						)
					); 

			echo $form->datetimepickerRow(
					$model,
					'saida',
					array(
						'class' => 'input-medium text-center', 
						'options' => array(
							'language' => 'pt',
							'format' => 'dd/mm/yyyy hh:ii:ss',
							),
						//'prepend' => '<i class="icon-calendar"></i>',
						)
					); 
			echo $form->select2Row($model,'frete', NotaFiscal::getFreteListaCombo() , array('class'=>'input-medium'));
			echo $form->textFieldRow($model,'volumes',array('class'=>'input-mini text-right'));

			?>
		</div>
		<div class="span3">
			<?php
			echo $form->textFieldRow($model,'valorprodutos',array('prepend' => 'R$', 'class'=>'input-small text-right','maxlength'=>14, 'disabled'=>true));
			echo $form->textFieldRow($model,'icmsstvalor',array('prepend' => 'R$', 'class'=>'input-small text-right','maxlength'=>14, 'disabled'=>true));
			echo $form->textFieldRow($model,'ipivalor',array('prepend' => 'R$', 'class'=>'input-small text-right','maxlength'=>14, 'disabled'=>true));
			echo $form->textFieldRow($model,'valorfrete',array('prepend' => 'R$', 'class'=>'input-small text-right','maxlength'=>14));
			echo $form->textFieldRow($model,'valorseguro',array('prepend' => 'R$', 'class'=>'input-small text-right','maxlength'=>14));
			echo $form->textFieldRow($model,'valordesconto',array('prepend' => 'R$', 'class'=>'input-small text-right','maxlength'=>14));
			echo $form->textFieldRow($model,'valoroutras',array('prepend' => 'R$', 'class'=>'input-small text-right','maxlength'=>14));
			echo $form->textFieldRow($model,'valortotal',array('prepend' => 'R$', 'class'=>'input-small text-right','maxlength'=>14, 'disabled'=>true));
			?>
		</div>
	</div>
</fieldset>
<div class="form-actions">

    
    <?php 
	

        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Salvar',
                'icon' => 'icon-ok',
                )
            ); 
	?>
    
</div>

<?php $this->endWidget(); ?>

<script type='text/javascript'>
	
function calculaTotal()
{
	//pega valor Desconto
	var total = Number($('#NotaFiscal_valorprodutos').autoNumeric('get'))
		+ Number($('#NotaFiscal_icmsstvalor').autoNumeric('get'))
		+ Number($('#NotaFiscal_ipivalor').autoNumeric('get'))
		+ Number($('#NotaFiscal_valorfrete').autoNumeric('get'))
		+ Number($('#NotaFiscal_valorseguro').autoNumeric('get'))
		- Number($('#NotaFiscal_valordesconto').autoNumeric('get'))
		+ Number($('#NotaFiscal_valoroutras').autoNumeric('get'));
	
	$('#NotaFiscal_valortotal').autoNumeric('set', total);

}

function desabilitaCamposEmitida()
{
	
	var emitida = $('#NotaFiscal_emitida').is(':checked');
	var valorbanco = ((emitida == <?php echo ($model->emitida)?"true":"false" ?>) &&  <?php echo ($model->isNewRecord)?"false":"true" ?>);
   
	if (valorbanco)
	{
		$("#NotaFiscal_serie").val("<?php echo $model->serie; ?>");
		$("#NotaFiscal_numero").val("<?php echo $model->numero; ?>");
		$("#NotaFiscal_nfechave").val("<?php echo $model->nfechave; ?>");
		$("#NotaFiscal_modelo").select2("val", "<?php echo $model->modelo; ?>");
	}
	else if (emitida)
	{
		$("#NotaFiscal_serie").val(1);
		$("#NotaFiscal_numero").val(0);
		$("#NotaFiscal_nfechave").val("");
		$("#NotaFiscal_modelo").select2("val", "<?php echo $model->modelo; ?>");
	}
	
	$("#NotaFiscal_serie").prop('disabled', emitida);
	$("#NotaFiscal_numero").prop('disabled', emitida);
	$("#NotaFiscal_nfechave").prop('disabled', emitida);
	
	if (emitida && $("#NotaFiscal_numero").val() != 0)
		$("#NotaFiscal_modelo").prop('disabled', true);
	else
		$("#NotaFiscal_modelo").prop('disabled', false);
	
}

var codnaturezaoperacaoantigo = <?php echo empty($model->codnaturezaoperacao)?0:$model->codnaturezaoperacao; ?>;
var codfilialantigo = <?php echo empty($model->codfilial)?0:$model->codfilial; ?>;

function atualizaObservacoes()
{
	var codnaturezaoperacao = $("#NotaFiscal_codnaturezaoperacao").val();
	var codfilial = $("#NotaFiscal_codfilial").val();
	
	$.getJSON("<?php echo Yii::app()->createUrl('naturezaOperacao/buscaObservacoesNf')?>", 
		{ 
			id: codnaturezaoperacao,
			idantigo: codnaturezaoperacaoantigo,
			codfilial: codfilial,
			codfilialantigo: codfilialantigo,
		})
		.done(function(data) {
			
			//pega observacao da tela
			observacoes = $("#NotaFiscal_observacoes").val();
			
			//se havia algo preenchido automaticamente, apaga
			if (data.observacoesnfantigo != null)
				observacoes = observacoes.replace(data.observacoesnfantigo, "");
		
			if (data.mensagemprocomantigo != null)
				observacoes = observacoes.replace(data.mensagemprocomantigo, "");
			
			observacoes = observacoes.replace(/^\s*[\r\n]/gm, '');
			//observacoes = observacoes.replace(/\n\n/g, '\n');

			//preenche observacao de acordo com natureza de operacao
			if (data.mensagemprocom != null)
			{
				if (observacoes.length > 0)
					observacoes += "\n";
				observacoes += data.mensagemprocom;
			}
			
			if (data.observacoesnf != null && $("#NotaFiscal_modelo").select2("val") == <?php echo NotaFiscal::MODELO_NFE; ?>)
			{
				if (observacoes.length > 0)
					observacoes += "\n";
				observacoes += data.observacoesnf;
			}
			
			
			//joga na tela
			$("#NotaFiscal_observacoes").val(observacoes);

		})
		.fail(function( jqxhr, textStatus, error ) {
			var err = textStatus + ", " + error;
			console.log( "Request Failed: " + err );
		});
	
	codnaturezaoperacaoantigo = $("#NotaFiscal_codnaturezaoperacao").val();
	codfilialantigo = $("#NotaFiscal_codfilial").val();
}
	
$(document).ready(function() {

	//$("#Pessoa_fantasia").Setcase();
	$('#NotaFiscal_valorprodutos').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscal_icmsstvalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscal_ipivalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscal_valorfrete').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscal_valorseguro').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscal_valordesconto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscal_valoroutras').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscal_valortotal').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NotaFiscal_valorprodutos').change(function(e){ calculaTotal(); });
	$('#NotaFiscal_icmsstvalor').change(function(e){ calculaTotal(); });
	$('#NotaFiscal_ipivalor').change(function(e){ calculaTotal(); });
	$('#NotaFiscal_valorfrete').change(function(e){ calculaTotal(); });
	$('#NotaFiscal_valorseguro').change(function(e){ calculaTotal(); });
	$('#NotaFiscal_valordesconto').change(function(e){ calculaTotal(); });
	$('#NotaFiscal_valoroutras').change(function(e){ calculaTotal(); });

	$('#NotaFiscal_nfechave').change(function(e){ 
		$(this).val($(this).val().replace(/\s+/g, ''));
	});


	$('#NotaFiscal_codnaturezaoperacao').change(function(e){ atualizaObservacoes(); });

	$('#NotaFiscal_emitida').change(function(e){ desabilitaCamposEmitida(); });
	$('#NotaFiscal_codfilial').change(function(e){ desabilitaCamposEmitida(); atualizaObservacoes(); });

	$('#nota-fiscal-form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
            if (result) {
                currentForm.submit();
            }
        });
    });
	
	desabilitaCamposEmitida();
});

</script>