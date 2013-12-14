<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'portador-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'portador',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'codbanco',array('class'=>'span5'));
		echo $form->textFieldRow($model,'agencia',array('class'=>'span5'));
		echo $form->textFieldRow($model,'agenciadigito',array('class'=>'span5'));
		echo $form->textFieldRow($model,'conta',array('class'=>'span5'));
		echo $form->textFieldRow($model,'contadigito',array('class'=>'span5'));
		echo $form->checkBoxRow($model,'emiteboleto');
		echo $form->textFieldRow($model,'codfilial',array('class'=>'span5'));
		echo $form->textFieldRow($model,'convenio',array('class'=>'span5','maxlength'=>20));
		echo $form->textFieldRow($model,'diretorioremessa',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'diretorioretorno',array('class'=>'span5','maxlength'=>100));
		echo $form->textFieldRow($model,'carteira',array('class'=>'span5'));
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

<script type='text/javascript'>
	
$(document).ready(function() {

	//$("#Pessoa_fantasia").Setcase();

	$('#portador-form').submit(function(e) {
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