<?php

$model_titulo = new Titulo;
// $model_titulo->credito = 2;
// $model->codpessoa = 1;

?>
<div class="row-fluid" style="padding-top: 4px">
    <div class="span3">
        <?php
        echo $form->select2Row(
            $model_titulo,
            'codfilial',
            Filial::getListaCombo(),
            [
                'placeholder' => 'Filial',
                'class' => 'input-medium'
            ]
        );
        ?>
        <?php
        echo $form->dropDownListRow(
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
    <div class="span4">
        <?php
        echo $form->select2GrupoEconomicoRow(
            $model_titulo,
            'codgrupoeconomico',
            [
                'class' => 'input-xlarge',
                'inativo' => true
            ]
        );
        ?>
        <?php
        echo $form->select2PessoaRow(
            $model,
            'codpessoa',
            [
                'class' => 'input-xlarge',
                'inativo' => true
            ]
        );
        ?>

    </div>
    <div class="span3">
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

    </div>

</div>
<?php

// Pessoa
// echo $form->select2PessoaRow($model, 'codpessoa');



// Grid de Títulos
$html_titulos = '<div id="listagem-titulos">';
$html_titulos .=
    $this->widget(
        'MGGridTitulos',
        array(
            'modelname'   => 'TituloAgrupamento',
            'campo'          => 'GridTitulos',
            'GridTitulos' => $model->GridTitulos,
            'codpessoa'   => $model->codpessoa,
        ),
        true
    );
$html_titulos .= '</div>';
echo $form->customRow($model, 'GridTitulos', $html_titulos);
