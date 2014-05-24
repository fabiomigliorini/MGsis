<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'conta-contabil-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'contacontabil',array('class'=>'span3','maxlength'=>50));
		echo $form->textFieldRow($model,'numero',array('class'=>'span1','maxlength'=>15));
		echo $form->toggleButtonRow($model,'inativo', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
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

	$("#ContaContabil_contacontabil").Setcase();

	$('#conta-contabil-form').submit(function(e) {
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