<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'nota-fiscal-produto-barra-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'codnotafiscal',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codprodutobarra',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codcfop',array('class'=>'span5'));
		echo $form->textFieldRow($model,'descricaoalternativa',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'quantidade',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'valorunitario',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'valortotal',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'icmsbase',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'icmspercentual',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'icmsvalor',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'ipibase',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'ipipercentual',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'ipivalor',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'icmsstbase',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'icmsstpercentual',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'icmsstvalor',array('class'=>'span5','maxlength'=>14));
		echo $form->textFieldRow($model,'csosn',array('class'=>'span5','maxlength'=>4));
		echo $form->textFieldRow($model,'codnegocioprodutobarra',array('class'=>'span5'));
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

	//$("#Pessoa_fantasia").Setcase();

	$('#nota-fiscal-produto-barra-form').submit(function(e) {
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