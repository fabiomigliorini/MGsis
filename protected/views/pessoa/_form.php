<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'pessoa-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'fantasia',array('class'=>'input-large','maxlength'=>50));
		echo $form->textFieldRow($model,'pessoa',array('class'=>'input-xlarge','maxlength'=>100));
		echo $form->textFieldRow($model,'contato',array('class'=>'input-large','maxlength'=>100));
		
		echo $form->select2CidadeRow($model,'codcidade',array('class'=>'input-large'));

		echo $form->checkBoxRow($model,'fisica');
		
		echo $form->maskedTextFieldRow($model,'cnpj', ($model->fisica)?'999.999.999-99':'99.999.999/9999-99', array('class'=>'input-medium','maxlength'=>20));
		
		echo $form->textFieldRow($model,'ie',array('class'=>'input-medium','maxlength'=>20));
	?>
	<div class="bootstrap-widget bootstrap-widget-table" id="CamposPessoaFisica">
		<div class="bootstrap-widget-header">
			<h3>Dados Pessoa Física</h3>
		</div>
		<div class="bootstrap-widget-content">
			<br>
			<?php
				echo $form->textFieldRow($model,'rg',array('class'=>'input-medium','maxlength'=>30));

				echo $form->dropDownListRow(
						$model,
						'codsexo',
						Sexo::getListaCombo(),
						array('prompt'=>'', 'class' => 'input-small')                    
						);	

				echo $form->dropDownListRow(
						$model,
						'codestadocivil',
						EstadoCivil::getListaCombo(),
						array('prompt'=>'', 'class' => 'input-medium')                    
						);

				echo $form->textFieldRow($model,'conjuge',array('class'=>'span5','maxlength'=>100));
			?>
		</div>
	</div>
			
	<?php
		echo $form->checkBoxRow($model,'cliente');
	?>
	<div class="bootstrap-widget bootstrap-widget-table" id="CamposCliente">
		<div class="bootstrap-widget-header">
			<h3>Dados Cliente</h3>
		</div>
		<div class="bootstrap-widget-content">
			<br>
			<?php
			
				echo $form->checkBoxRow($model,'consumidor');
				
				echo $form->dropDownListRow(
						$model,
						'codformapagamento',
						FormaPagamento::getListaCombo(),
						array('prompt'=>'', 'class' => 'input-xxlarge')                    
						);	
				
				
				echo $form->textFieldRow($model,'credito',array('prepend' => 'R$', 'class'=>'input-small','style'=>'text-align: right','maxlength'=>14));
				echo $form->checkBoxRow($model,'creditobloqueado');
				echo $form->textAreaRow($model,'mensagemvenda',array('class'=>'input-xxlarge', 'rows'=>'5','maxlength'=>500));

				echo $form->textFieldRow($model,'desconto',array('append' => '%', 'class'=>'input-small','style'=>'text-align: right','maxlength'=>5));

				echo $form->dropDownListRow(
						$model,
						'notafiscal',
						Pessoa::getNotaFiscalOpcoes(),
						array('prompt'=>'', 'class' => 'input-large')                    
						);	
			?>
		</div>
	</div>
	<?php
		
		echo $form->checkBoxRow($model,'fornecedor');

		echo $form->datepickerRow(
				$model,
				'inativo',
				array(
					'class' => 'input-small', 
					'options' => array(
						'language' => 'pt',
						'format' => 'dd/mm/yyyy'
						),
					'prepend' => '<i class="icon-calendar"></i>',
					)
				); 
		
		/*
		echo $form->textFieldRow($model,'endereco',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'numero',array('class'=>'span5','maxlength'=>10));
		echo $form->textFieldRow($model,'complemento',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'bairro',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'cep',array('class'=>'span5','maxlength'=>8));
		echo $form->textFieldRow($model,'enderecocobranca',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'numerocobranca',array('class'=>'span5','maxlength'=>10));
		echo $form->textFieldRow($model,'complementocobranca',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'codcidadecobranca',array('class'=>'span5'));
		echo $form->textFieldRow($model,'bairrocobranca',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'cepcobranca',array('class'=>'span5','maxlength'=>8));
		echo $form->textFieldRow($model,'telefone1',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'telefone2',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'telefone3',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'emailnfe',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'emailcobranca',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'observacoes',array('class'=>'span5','maxlength'=>255));
		echo $form->checkBoxRow($model,'vendedor');
		 * 
		 */
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
	<?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'reset',
                'label' => 'Limpar',
                'icon' => 'icon-refresh'
                )
            );
    ?>
    
</div>

<?php $this->endWidget(); ?>

<script>

function escondeCamposCliente()
{
	if($('#Pessoa_cliente').is(':checked')==true)
		$('#CamposCliente').slideDown('slow');
	else
		$('#CamposCliente').slideUp('slow');
}

function escondeCamposPessoaFisica() 
{
	var mascara;
	if($('#Pessoa_fisica').is(':checked')==true)
	{
		$('#CamposPessoaFisica').slideDown('slow');
		mascara="999.999.999-99";
	}
	else
	{
		$('#CamposPessoaFisica').slideUp('slow');
		mascara="99.999.999/9999-99";
	}
	$("#Pessoa_cnpj").mask(mascara);	
}

$(document).ready(function() {
	
    escondeCamposPessoaFisica();
	escondeCamposCliente();
	
	$("#Pessoa_fantasia").Setcase();
	$("#Pessoa_pessoa").Setcase();
	$("#Pessoa_contato").Setcase();
	$("#Pessoa_conjuge").Setcase();
	
	$('#Pessoa_credito').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#Pessoa_desconto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	
	
	$('#Pessoa_fisica').change(function() {
		escondeCamposPessoaFisica();
	});	
	
	$('#Pessoa_cliente').change(function() {
		escondeCamposCliente();
	});	
	
	$(":reset").on("click", function(){
		escondeCamposPessoaFisica();
		escondeCamposCliente();
	});	
	
});

</script>