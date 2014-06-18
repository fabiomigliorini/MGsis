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

		echo $form->select2Row(
				$model,
				'codecf',
				Ecf::getListaCombo(),
				array('prompt'=>'', 'class' => 'span2')                    
				);	
		
		echo $form->select2Row(
				$model,
				'codfilial',
				Filial::getListaCombo(),
				array('prompt'=>'', 'class' => 'span2')                    
				);	
		
		echo $form->select2Row(
				$model,
				'codoperacao',
				Operacao::getListaCombo(),
				array('prompt'=>'', 'class' => 'span2')                    
				);	

		echo $form->select2PessoaRow(
				$model, 
				'codpessoa'
				);

		function getActivePrinters() 
		{

			$o = shell_exec("lpstat -d -p");
			$res = explode("\n", $o);
			
			foreach ($res as $r) 
			{
				if (strpos($r, "printer") !== FALSE) 
				{
					$r = str_replace("printer ", "", $r);
					$r = explode(" ", $r);
					$printers[] = $r[0];
				}
			}
			
			return $printers;
		}

		$imp = getActivePrinters();

		
		echo $form->typeAheadRow(
			$model,
			'impressoramatricial',
			array('source' => $imp)
		);

		echo $form->typeAheadRow(
			$model,
			'impressoratermica',
			array('source' => $imp)
		);		

		echo $form->select2Row(
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
</div>

<?php $this->endWidget(); ?>
