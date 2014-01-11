<?php
$form = $this->beginWidget('MGActiveForm', array(
	'id' => 'titulo-form',
	));
?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php
	
	echo $form->select2PessoaRow(
			$model, 
			'codpessoa'
			);
	
	echo $form->textFieldRow($model,'numero',array('class'=>'input-medium','maxlength'=>20));
	echo $form->textFieldRow($model,'fatura',array('class'=>'input-medium','maxlength'=>50));
	  
	echo $form->dropDownListRow(
		$model, 'codfilial', Filial::getListaCombo(), array('prompt' => '', 'class' => 'input-medium')
	);
	echo $form->dropDownListRow(
		$model, 'codtipotitulo', TipoTitulo::getListaCombo(), array('prompt' => '', 'class' => 'input-large')
	);
	echo $form->dropDownListRow(
		$model, 'codcontacontabil', ContaContabil::getListaCombo(), array('prompt' => '', 'class' => 'input-large')
	);
	echo $form->dropDownListRow(
		$model, 'codportador', Portador::getListaCombo(), array('prompt' => '', 'class' => 'input-large')
	);
	
	echo $form->datepickerRow(
			$model,
			'emissao',
			array(
				'class' => 'input-small  text-center', 
				'options' => array(
					'language' => 'pt',
					'format' => 'dd/mm/yyyy'
				),
				'prepend' => '<i class="icon-calendar"></i>',
			)
	); 
	
	echo $form->datepickerRow(
			$model,
			'transacao',
			array(
				'class' => 'input-small text-center', 
				'options' => array(
					'language' => 'pt',
					'format' => 'dd/mm/yyyy'
				),
				'prepend' => '<i class="icon-calendar"></i>',
			)
	); 
	
	echo $form->datepickerRow(
			$model,
			'vencimento',
			array(
				'class' => 'input-small text-center', 
				'options' => array(
					'language' => 'pt',
					'format' => 'dd/mm/yyyy'
				),
				'prepend' => '<i class="icon-calendar"></i>',
			)
	); 
	
	echo $form->datepickerRow(
			$model,
			'vencimentooriginal',
			array(
				'class' => 'input-small text-center', 
				'options' => array(
					'language' => 'pt',
					'format' => 'dd/mm/yyyy'
				),
				'prepend' => '<i class="icon-calendar"></i>',
			)
	); 

	$operacao = "??";
	if (!empty($model->codtipotitulo))
		if (isset($model->TipoTitulo))
			$operacao = ($model->TipoTitulo->credito)?"CR":"DB";
	
	echo $form->textFieldRow($model,'valor',array('prepend' => 'R$', 'append'=>$operacao, 'appendOptions'=>array('id'=>'operacao'), 'class'=>'input-small text-right','maxlength'=>14));
	
	echo $form->toggleButtonRow($model,'gerencial', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
	
	echo $form->textAreaRow($model,'observacao',array('class'=>'input-xxlarge', 'rows'=>'5','maxlength'=>500));
	
	echo $form->toggleButtonRow($model,'boleto', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
	
	echo $form->textFieldRow($model,'nossonumero',array('class'=>'input-small','maxlength'=>20));
	echo $form->textFieldRow($model,'remessa',array('class'=>'input-small text-right'));
	
	/*
	echo $form->customRow($model,'codnegocioformapagamento',array('class'=>'span5'));
	echo $form->textFieldRow($model,'codtituloagrupamento',array('class'=>'span5'));
	echo $form->textFieldRow($model,'estornado',array('class'=>'span5'));
	 * 
	 */
	?>
</fieldset>
<div class="form-actions">


	<?php
	$this->widget(
		'bootstrap.widgets.TbButton', array(
		'buttonType' => 'submit',
		'type' => 'primary',
		'label' => 'Salvar',
		'icon' => 'icon-ok',
		)
	);
	$this->widget(
		'bootstrap.widgets.TbButton', array(
		'buttonType' => 'reset',
		'label' => 'Limpar',
		'icon' => 'icon-refresh'
		)
	);
	?>

</div>

<?php $this->endWidget(); ?>

<script type='text/javascript'>

	$(document).ready(function() {

		$('#Titulo_valor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

		$('#titulo-form').submit(function(e) {
			var currentForm = this;
			e.preventDefault();
			bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
				if (result) {
					currentForm.submit();
				}
			});
		});

	});

</script>