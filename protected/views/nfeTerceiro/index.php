<?php
$this->pagetitle = Yii::app()->name . ' - NFe\'s de Terceiro';
$this->breadcrumbs = array(
    'NFe de Terceiros',
);

$this->menu = array(
    array('label' => 'Nova', 'icon' => 'icon-plus', 'url' => array('create')),
    // array('label'=>'Pesquisar na Sefaz', 'icon'=>'icon-plus', 'url'=>array('pesquisarSefaz')),
    array('label' => 'Carregar Via Arquivo XML', 'icon' => 'icon-upload', 'url' => array('upload')),
    //array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<script type='text/javascript'>
    $(document).ready(function() {

        $('#NfeTerceiro_nfechave').change(function(e) {
            $(this).val($(this).val().replace(/\s+/g, ''));
        });

        $('#search-form').change(function() {
            var ajaxRequest = $("#search-form").serialize();
            $.fn.yiiListView.update(
                // this is the id of the CListView
                'Listagem', {
                    data: ajaxRequest
                }
            );
        });
    });
</script>

<h1>NFe de Terceiros</h1>
<br>

<?php $form = $this->beginWidget('MGActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'id' => 'search-form',
    'type' => 'inline',
    'method' => 'get',
));

?>
<div class="well well-small">
    <?php echo $form->numberField($model, 'codnfeterceiro', array('placeholder' => '#', 'class' => 'input-small text-right', 'type' => 'number', 'min' => 1, 'step' => 1)); ?>
    <?php echo $form->select2($model, 'codfilial', Filial::getListaCombo(), array('placeholder' => 'Filial', 'class' => 'input-medium')); ?>
    <?php echo $form->textField($model, 'nfechave', array('placeholder' => 'Chave', 'class' => 'input-xxlarge', 'autofocus' => true)); ?>
    <?php echo $form->select2GrupoEconomico($model, 'codgrupoeconomico', array('placeholder' => 'Grupo Econoômico', 'class' => 'input-large')); ?>
    <?php echo $form->select2Pessoa($model, 'codpessoa', array('placeholder' => 'Pessoa', 'class' => 'input-xlarge')); ?>
    <?php echo $form->numberField($model, 'valor_de', array('placeholder' => 'Valor De', 'class' => 'input-small text-right', 'type' => 'number', 'min' => 0.01, 'step' => 0.01)); ?>
    <?php echo $form->numberField($model, 'valor_ate', array('placeholder' => 'Valor Até', 'class' => 'input-small text-right', 'type' => 'number', 'min' => 0.01, 'step' => 0.01)); ?>
    <?php
    echo $form->datepickerRow(
        $model,
        'emissao_de',
        array(
            'class' => 'input-mini text-center',
            'options' => array(
                'format' => 'dd/mm/yy'
            ),
            'placeholder' => 'Emissão',
            'prepend' => 'De',
        )
    );
    ?>
    <?php
    echo $form->datepickerRow(
        $model,
        'emissao_ate',
        array(
            'class' => 'input-mini text-center',
            'options' => array(
                'format' => 'dd/mm/yy'
            ),
            'placeholder' => 'Emissão',
            'prepend' => 'Até',
        )
    );
    ?>
    <?php echo $form->select2($model, 'indmanifestacao', NfeTerceiro::getIndManifestacaoListaCombo(), array('placeholder' => 'Manifestação', 'class' => 'input-xlarge')); ?>
    <?php echo $form->select2($model, 'revisao', ['R' => 'Revisadas', 'N' => 'Não Revisadas'], array('placeholder' => 'Revisão', 'class' => 'input-medium')); ?>
    <?php echo $form->select2($model, 'conferencia', ['C' => 'Conferidas', 'N' => 'Não Conferidas'], array('placeholder' => 'Conferência', 'class' => 'input-medium')); ?>
    <?php echo $form->select2($model, 'indsituacao', NfeTerceiro::getIndSituacaoListaCombo(), array('placeholder' => 'Situação', 'class' => 'input-medium')); ?>
    <?php
    echo $form->select2(
        $model,
        'codnotafiscal',
        array(
            "1" => "Pendentes",
            "2" => "Importadas",
            "3" => "Ignoradas"
        ),
        array(
            'placeholder' => 'Importação',
            'class' => 'input-large'
        )
    );
    ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'icon' => 'icon-search',
            //'label'=>'',
            'htmlOptions' => array('class' => 'pull-right btn btn-info')
        )
    );
    ?>
</div>

<?php $this->endWidget(); ?>


<?php

$this->widget(
    'zii.widgets.CListView',
    array(
        'id' => 'Listagem',
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
        'template' => '{items} {pager}',
        'pager' => array(
            'class' => 'ext.infiniteScroll.IasPager',
            'rowSelector' => '.registro',
            'listViewId' => 'Listagem',
            'header' => '',
            'loaderText' => 'Carregando...',
            'options' => array('history' => false, 'triggerPageTreshold' => 10, 'trigger' => 'Carregar mais registros'),
        )
    )
);
?>