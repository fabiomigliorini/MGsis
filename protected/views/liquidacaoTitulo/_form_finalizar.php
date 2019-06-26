<div class="row-fluid">
    <div class="span2">
        Data Transação
    </div>
    <div class="span2">
        <?php
            echo $form->datePickerRow(
                $model, 
                'transacao', 
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
        ?>
        
    </div>
    <div class="span6">
        <?php
            echo $form->dropDownListRow($model, 'codportador', Portador::getListaCombo(), array('prompt' => '', 'class' => 'input-large'));
        ?>
    </div>
</div>
<br>
<div class="row-fluid">
    <div class="span2">
        Observações
    </div>
    <div class="span9">
        <?php
            echo $form->textAreaRow($model,'observacao',array('class'=>'span6','maxlength'=>200, 'rows' => 5));
        ?>
    </div>
</div>
<div class="form-actions">
    <div class="span2">
    </div>
    <div class="span9">
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
</div>
