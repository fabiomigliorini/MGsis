<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'codigo-form',
	'type' => 'horizontal',
	'enableAjaxValidation'=>true,
)); ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'tabela',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'codproximo',array('class'=>'span5')); ?>

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
