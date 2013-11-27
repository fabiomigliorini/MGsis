<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'usuario-form',
	'type' => 'horizontal',
	'enableAjaxValidation'=>true,
)); ?>

<?php echo $form->errorSummary($model); ?>

	<?php
	
		echo $form->textFieldRow(
				$model,
				'usuario',
				array('class' => 'span6')
				); 

		echo $form->passwordFieldRow($model, 'senha_tela');

		echo $form->passwordFieldRow($model, 'senha_tela_repeat');

		echo $form->dropDownListRow(
				$model,
				'codecf',
				CHtml::listData(Ecf::model()->findAll(), 'codecf', 'ecf'),
				array('prompt'=>'', 'class' => 'span2')                    
				);	

		echo $form->dropDownListRow(
				$model,
				'codfilial',
				CHtml::listData(Filial::model()->findAll(), 'codfilial', 'filial'),
				array('prompt'=>'', 'class' => 'span2')                    
				);	
		echo $form->dropDownListRow(
				$model,
				'codoperacao',
				CHtml::listData(Operacao::model()->findAll(), 'codoperacao', 'operacao'),
				array('prompt'=>'', 'class' => 'span2')                    
				);	

		echo $form->textFieldRow(
				$model,
				'codpessoa',
				array('class' => 'span2')                    
				); 

		echo $form->textFieldRow(
				$model,
				'impressoratelanegocio',
				array('class' => 'span2')                    
				); 

		echo $form->dropDownListRow(
				$model,
				'codportador',
				CHtml::listData(Portador::model()->findAll(), 'codportador', 'portador'),
				array('prompt'=>'', 'class' => 'span3')                    
				);	
	
	?>

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
