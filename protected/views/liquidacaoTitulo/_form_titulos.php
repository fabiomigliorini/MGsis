<?php

// Pessoa

$model_titulo = new Titulo;
$model_titulo->credito = 2;
$model->codpessoa = 1;

?>
<div class="row-fluid" style="padding-top: 4px">
    <div class="span5">
        <?php 
            echo $form->select2Pessoa($model, 'codpessoa');
        ?>
    </div>
    <div class="span3">
        <?php 
            echo $form->datepickerRow(
                    $model_titulo,
                    'vencimento_de',
                    array(
                        'class' => 'input-mini text-center', 
                        'options' => array(
                            'format' => 'dd/mm/yy'
                            ),
                        'placeholder' => 'Vencimento',
                        'prepend' => 'De',
                        )
                    ); 	
        ?>
        <?php 
            echo $form->datepickerRow(
                    $model_titulo,
                    'vencimento_ate',
                    array(
                        'class' => 'input-mini text-center', 
                        'options' => array(
                            'format' => 'dd/mm/yy'
                            ),
                        'placeholder' => 'Vencimento',
                        'prepend' => 'Até',
                        )
                    ); 	
        ?>
    </div>
    <div class="span2">
        <?php echo $form->dropDownList($model_titulo, 'credito', array('' => '', 1 => 'Credito', 2 => 'Debito'), array('placeholder' => 'Operação', 'class'=>'span12')); ?>
    </div>
</div>
<br>
<div id="listagem-titulos">
    <?

    // Grid de Títulos
    $this->widget(
        'MGGridTitulos',
        array(
            'modelname'   => 'LiquidacaoTitulo',
            'campo'		  => 'GridTitulos',
            'GridTitulos' => $model->GridTitulos,
            'codpessoa'   => $model->codpessoa,
	    'codoperacao' => $model_titulo->credito
        )
    );
    ?>
</div>
