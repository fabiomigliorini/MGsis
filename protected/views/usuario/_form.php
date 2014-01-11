<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'usuario-form',
)); ?>

<?php echo $form->errorSummary($model); ?>
<fieldset>
	<?php
	
		echo $form->textFieldRow(
				$model,
				'usuario',
				array('class' => 'span2')
				); 

		echo $form->passwordFieldRow($model, 'senha_tela', array('class' => 'span2'));

		echo $form->passwordFieldRow($model, 'senha_tela_repeat', array('class' => 'span2'));

		echo $form->dropDownListRow(
				$model,
				'codecf',
				Ecf::getListaCombo(),
				array('prompt'=>'', 'class' => 'span2')                    
				);	
		
		echo $form->dropDownListRow(
				$model,
				'codfilial',
				Filial::getListaCombo(),
				array('prompt'=>'', 'class' => 'span2')                    
				);	
		
		echo $form->dropDownListRow(
				$model,
				'codoperacao',
				Operacao::getListaCombo(),
				array('prompt'=>'', 'class' => 'span2')                    
				);	

		echo $form->select2PessoaRow(
				$model, 
				'codpessoa'
				);
		
		echo $form->textFieldRow(
				$model,
				'impressoratelanegocio',
				array('class' => 'span2')                    
				); 

		echo $form->dropDownListRow(
				$model,
				'codportador',
				Portador::getListaCombo(),
				array('prompt'=>'', 'class' => 'span3')                    
				);	

		echo $form->datepickerRow(
				$model,
				'inativo',
				array(
					'class' => 'input-small text-center', 
					'options' => array(
						'language' => 'pt',
						'format' => 'dd/mm/yyyy'
						),
					'prepend' => '<i class="icon-calendar"></i>',
					)
				); 

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
