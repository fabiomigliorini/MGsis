<?php 
$form=$this->beginWidget('MGActiveForm',array(
	'id'=>'nota-fiscal-carta-correcao-form',
)); 

$form->enableAjaxValidation = false;
?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		//echo $form->textFieldRow($model,'codnotafiscal',array('class'=>'span5'));
		//echo $form->textFieldRow($model,'lote',array('class'=>'span5'));
		//echo $form->textFieldRow($model,'data',array('class'=>'span5'));
		//echo $form->textFieldRow($model,'sequencia',array('class'=>'span5'));
		echo $form->textAreaRow($model,'texto',array('rows'=>6, 'cols'=>50, 'class'=>'span8'));
		//echo $form->textFieldRow($model,'protocolo',array('class'=>'span5','maxlength'=>100));
		//echo $form->textFieldRow($model,'protocolodata',array('class'=>'span5'));
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

	$('#nota-fiscal-carta-correcao-form').submit(function(e) {
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