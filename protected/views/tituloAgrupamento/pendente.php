<?php
$this->pagetitle = Yii::app()->name . ' - Agrupamento de Títulos';
$this->breadcrumbs = array(
    'Agrupamento de Títulos' => array('index'),
    'Pendentes',
);

$this->menu = array(
    array('label' => 'Listagem', 'icon' => 'icon-list-alt', 'url' => array('index')),
);

function vencimentoClass($vencimento) {
    $diff  = round((strtotime($vencimento) - time()) / (60 * 60 * 24));
    // echo "<h1>{$diff}</h1>";
    // die();
    if ($diff < -30) {
        return 'text-error';
    }
    if ($diff > 0) {
        return 'text-success';
    }
    return 'text-warning';
    /*
    echo "<pre><h1>teste</h1>";
    var_dump($vencimento);
    die();
    text-warning
    text-error
    text-info
    */
}
?>

<script type='text/javascript'>
    $(document).ready(function() {
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

<h1>Fechamentos Pendentes</h1>

<br>
<?php $form = $this->beginWidget('MGActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'id' => 'search-form',
    'type' => 'inline',
    'method' => 'get',
));

?>
<div class="well well-small">
    <?php echo $form->textField($model, 'codtituloagrupamento', array('placeholder' => '#', 'class' => 'input-mini')); ?>
    <?php echo $form->select2Pessoa($model, 'codpessoa', array()); ?>
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

    <?php
    echo $form->datepickerRow(
        $model,
        'criacao_de',
        array(
            'class' => 'input-mini text-center',
            'options' => array(
                'format' => 'dd/mm/yy'
            ),
            'placeholder' => 'Criação',
            'prepend' => 'De',
        )
    );
    ?>
    <?php
    echo $form->datepickerRow(
        $model,
        'criacao_ate',
        array(
            'class' => 'input-mini text-center',
            'options' => array(
                'format' => 'dd/mm/yy'
            ),
            'placeholder' => 'Criação',
            'prepend' => 'Até',
        )
    );
    ?>

</div>

<?php $this->endWidget(); ?>
<table class="table table-striped table-bordered table-hover">
    <caption> teste </caption>
    <thead>
        <th>
            Grupo de Cliente
        </th>
        <th>
            Grupo Econômico
        </th>
        <th>
            Cliente
        </th>
        <th>
            Vencimento
        </th>
        <th>
            Saldo
        </th>
        <th>
            Forma
        </th>
    </thead>
    <tbody>
        <?php foreach ($regs as $reg): ?>
            <tr>
                <td>
                    <?php echo CHtml::encode($reg['grupocliente']) ?>
                </td>
                <td>
                    <?php echo CHtml::encode($reg['grupoeconomico']) ?>
                </td>
                <td>
                    <?php echo CHtml::link(CHtml::encode($reg['fantasia']), array('pessoa/view', 'id' => $reg['codpessoa'])) ?>
                </td>
                <td class="<?php echo vencimentoClass($reg['vencimento']) ?>">
                    <?php echo Yii::app()->format->formataData($reg['vencimento']) ?>
                </td>
                <td>
                    <div class="text-right text-bold">

                        <?php
                        echo CHtml::link(
                            Yii::app()->format->formatNumber($reg['saldo']),
                            [
                                'titulo/index',
                                'Titulo' => [
                                    'codpessoa' => $reg['codpessoa'],
                                    'status' => 'A',
                                ]

                            ]
                        ) ?>
                        &nbsp;
                        <a href="<?php echo Yii::app()->createUrl('tituloAgrupamento/create', ['codpessoa' => $reg['codpessoa']]) ?>" class="btn">
                            <i class="icon-play-circle"></i>
                            <!-- Agrupar -->
                        </a>

                        <!-- <?php echo CHtml::link(CHtml::encode('+'), array('tituloAgrupamento/create', 'codpessoa' => $reg['codpessoa'])) ?> -->
                    </div>

                </td>
                <td>
                    <?php echo CHtml::encode($reg['formapagamento']) ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?php
/*
$this->widget(
	'zii.widgets.CListView',
	array(
		'id' => 'Listagem',
		'dataProvider' => $dataProvider,
		'itemView' => '_view',
		'template' => '{items} {pager}',
		'pager' => array(
			'class' => 'ext.infiniteScroll.IasPager',
			'rowSelector'=>'.registro',
			'listViewId' => 'Listagem',
			'header' => '',
			'loaderText'=>'Carregando...',
			'options' => array('history' => false, 'triggerPageTreshold' => 20, 'trigger'=>'Carregar mais registros'),
		)
	)
);
*/
?>