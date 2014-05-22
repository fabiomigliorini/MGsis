<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'filial-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'codempresa',array('class'=>'span5'));
		echo $form->textFieldRow($model,'codpessoa',array('class'=>'span5'));
		echo $form->textFieldRow($model,'filial',array('class'=>'span5','maxlength'=>20));
		echo $form->checkBoxRow($model,'emitenfe');
		echo $form->textFieldRow($model,'acbrnfemonitorcaminho',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'acbrnfemonitorcaminhorede',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'acbrnfemonitorbloqueado',array('class'=>'span5'));
		echo $form->textFieldRow($model,'acbrnfemonitorcodusuario',array('class'=>'span5'));
		echo $form->textFieldRow($model,'empresadominio',array('class'=>'span5','maxlength'=>7));
		echo $form->textFieldRow($model,'acbrnfemonitorip',array('class'=>'span5','maxlength'=>20));
		echo $form->textFieldRow($model,'acbrnfemonitorporta',array('class'=>'span5'));
		echo $form->textFieldRow($model,'odbcnumeronotafiscal',array('class'=>'span5','maxlength'=>500));
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