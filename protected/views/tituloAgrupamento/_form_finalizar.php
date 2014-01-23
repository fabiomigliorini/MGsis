<?php
	echo $form->datePickerRow(
		$model, 
		'emissao', 
		array(
			'class' => 'input-small text-center', 
			'options' => array(
				'language' => 'pt',
				'format' => 'dd/mm/yyyy'
			),
			'prepend' => '<i class="icon-calendar"></i>',
			//'disabled' => true,
		)
	);
	echo $form->textAreaRow($model,'observacao',array('class'=>'span5','maxlength'=>200, 'rows' => 5));
	/*
	 * 
	 * 
	echo $form->textFieldRow($model,'cancelamento',array('class'=>'span5'));
	* 
	*/
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
