<?php

$model_titulo = new Titulo;
$model_titulo->credito = 2;
$model->codpessoa = 1;

?>
<div class="row-fluid" style="padding-top: 4px">
    <?php
    echo $form->select2(
        $model_titulo,
        'codfilial',
        Filial::getListaCombo(),
        [
            'placeholder' => 'Filial',
            'class' => 'input-medium'
        ]
    );
    ?>
    &nbsp;
    <?php
    echo $form->select2GrupoEconomico(
        $model_titulo,
        'codgrupoeconomico',
        [
            'class' => 'input-xlarge',
            'inativo' => true
        ]
    );
    ?>
    &nbsp;
    <?php
    echo $form->select2Pessoa(
        $model,
        'codpessoa',
        [
            'class' => 'input-xlarge',
            'inativo' => true
        ]
    );
    ?>
    &nbsp;
    <?php
    echo $form->datepickerRow(
        $model_titulo,
        'vencimento_de',
        array(
            'class' => 'input-small text-center',
            'options' => array(
                'format' => 'dd/mm/yy'
            ),
            'placeholder' => 'Vencimento',
            'prepend' => 'De',
        )
    );
    ?>
    &nbsp;
    <?php
    echo $form->datepickerRow(
        $model_titulo,
        'vencimento_ate',
        array(
            'class' => 'input-small text-center',
            'options' => array(
                'format' => 'dd/mm/yy'
            ),
            'placeholder' => 'Vencimento',
            'prepend' => 'Até',
        )
    );
    ?>
    &nbsp;
    <?php
    echo $form->dropDownList(
        $model_titulo,
        'credito',
        [
            '' => '',
            1 => 'Credito',
            2 => 'Debito'
        ],
        [
            'placeholder' => 'Operação',
            'class' => 'input-medium'
        ]
    );
    ?>
</div>
<br>
<div id="listagem-titulos">
    <?

    // Grid de Títulos
    $this->widget(
        'MGGridTitulos',
        array(
            'modelname'   => 'LiquidacaoTitulo',
            'campo'          => 'GridTitulos',
            'GridTitulos' => $model->GridTitulos,
            'codpessoa'   => $model->codpessoa,
            'codoperacao' => $model_titulo->credito
        )
    );
    ?>
</div>