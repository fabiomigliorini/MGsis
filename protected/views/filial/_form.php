<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'filial-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		//echo $form->textFieldRow($model,'codempresa',array('class'=>'span5'));
		//echo $form->select2Row($model, 'codempresa', Empresa::getListaCombo());
		//echo $form->textFieldRow($model,'codpessoa',array('class'=>'span5'));
		// codpessoa
		echo $form->select2PessoaRow($model, 'codpessoa',array('class'=>'span4'));
		echo $form->textFieldRow($model,'filial',array('class'=>'input-medium','maxlength'=>20));
		echo $form->select2Row(
			$model, 
			'crt', 
			array(
				Filial::CRT_SIMPLES => 'Simples Nacional',
				Filial::CRT_SIMPLES_EXCESSO => 'Simples Nacional - Excesso de Sublimite de Receita Bruta',
				Filial::CRT_REGIME_NORMAL => 'Regime Normal'
			),
			array('class' => 'input-xxlarge')
		);		
		echo $form->select2Row(
			$model, 
			'nfeambiente', 
			array(
				Filial::NFEAMBIENTE_PRODUCAO => 'Produção',
				Filial::NFEAMBIENTE_HOMOLOGACAO => 'Homologação (Testes)',
			),
			array('class' => 'input-large')
		);		
		//echo $form->checkBoxRow($model,'emitenfe');
		echo $form->textFieldRow($model,'acbrnfemonitorcaminho',array('class'=>'input-large','maxlength'=>100));
		echo $form->textFieldRow($model,'acbrnfemonitorcaminhorede',array('class'=>'input-large','maxlength'=>100));
		echo $form->textFieldRow($model,'nfcetoken',array('class'=>'input-xlarge text-center','maxlength'=>32));
		echo $form->textFieldRow($model,'nfcetokenid',array('class'=>'input-mini text-center','maxlength'=>6));
		//echo $form->textFieldRow($model,'acbrnfemonitorbloqueado',array('class'=>'input-medium'));
		//echo $form->textFieldRow($model,'acbrnfemonitorcodusuario',array('class'=>'span5'));
		//echo $form->select2Row($model, 'acbrnfemonitorcodusuario', Usuario::getListaCombo(), array('class' => 'input-medium'));
		
		


		echo $form->textFieldRow($model,'empresadominio',array('class'=>'input-mini text-right','maxlength'=>7));
		echo $form->textFieldRow($model,'acbrnfemonitorip',array('class'=>'input-medium','maxlength'=>20));
		echo $form->textFieldRow($model,'acbrnfemonitorporta',array('class'=>'input-mini text-right'));
		//echo $form->textFieldRow($model,'odbcnumeronotafiscal',array('class' => 'input-larg','maxlength'=>500));
		echo $form->textFieldRow($model,'tokenibpt',array('class'=>'input-xxlarge text-center','maxlength'=>32));
	?>
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
	
$(document).ready(function() {
		$('#Filial_acbrnfemonitorporta').autoNumeric('init', {aSep:'', aDec:',', altDec:'.', mDec:0 });
		$('#Filial_empresadominio').autoNumeric('init', {aSep:'', aDec:',', altDec:'.', mDec:0 });

	$("#Filial_filial").Setcase();

	$('#filial-form').submit(function(e) {
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