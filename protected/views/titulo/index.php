<?php
$this->pagetitle = Yii::app()->name . ' - Titulo';
$this->breadcrumbs = array(
    'Titulo',
);

$this->menu = array(
    array('label' => 'Novo', 'icon' => 'icon-plus', 'url' => array('create')),
    //array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
    array(
        'label' => 'Relatório',
        'icon' => 'icon-print',
        'url' => array('relatorio'),
        'linkOptions' => array('id' => 'btnMostrarRelatorio'),
    ),
);
?>

<script type='text/javascript'>
    function perguntarDetalhado() {

        bootbox.dialog("Deseja o relatório com as informações de Tipo do Título, Conta Contábil e Observações?",
            [{
                "label": "Sim, detalhado",
                "class": "btn-primary",
                "callback": function() {
                    abrirRelatorio(1);
                }
            }, {
                "label": "Não, simplificado",
                "class": "btn-primary",
                "callback": function() {
                    abrirRelatorio(0);
                }
            }]);

    }

    function abrirRelatorio(detalhado) {
        var frameSrcRelatorio = $('#btnMostrarRelatorio').attr('href') + "&detalhado=" + detalhado;
        $('#modalRelatorio').on('show', function() {
            $('#frameRelatorio').attr("src", frameSrcRelatorio);
        });
        $('#modalRelatorio').modal({
            show: true
        })
        $('#modalRelatorio').css({
            'width': '80%',
            'margin-left': 'auto',
            'margin-right': 'auto',
            'left': '10%'
        });

    }

    $(document).ready(function() {

        //abre janela Relatorio
        $('#btnMostrarRelatorio').click(function(event) {
            event.preventDefault();
            perguntarDetalhado();
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

        $("#Titulo_saldo").select2();
        $("#Titulo_codportador").select2({
            allowClear: true
        });
        $("#Titulo_boleto").select2({
            allowClear: true
        });
        $("#Titulo_codusuariocriacao").select2({
            allowClear: true
        });
        $("#Titulo_credito").select2({
            allowClear: true
        });
        $("#Titulo_gerencial").select2({
            allowClear: true
        });
        $("#Titulo_codcontacontabil").select2({
            allowClear: true
        });
        $("#Titulo_codtipotitulo").select2({
            allowClear: true
        });
        $("#Titulo_codfilial").select2({
            allowClear: true
        });

    });
</script>

<div id="modalRelatorio" class="modal hide fade" tabindex="-1" role="dialog">
    <div class="modal-header">
        <div class="pull-right">
            <button class="btn" data-dismiss="modal">Fechar</button>
        </div>
        <h3>Relatório de Títulos</h3>
    </div>
    <div class="modal-body">
        <iframe src="" id="frameRelatorio" name="frameRelatorio" width="99.6%" height="400" frameborder="0"></iframe>
    </div>
</div>

<h1>Títulos</h1>
<?php $form = $this->beginWidget('MGActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'id' => 'search-form',
    'type' => 'inline',
    'method' => 'get',
));

?>
<div class="well well-small hidden-print">
    <div class="row-fluid">
        <div class="span3">
            <div class="row-fluid">
                <?php echo $form->textField($model, 'codtitulo', array('placeholder' => '#', 'class' => 'span6')); ?>
                <?php echo $form->textField($model, 'numero', array('placeholder' => 'Número', 'class' => 'span6')); ?>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <?php
                echo $form->dropDownList(
                    $model,
                    'codportador',
                    Portador::getListaCombo(),
                    array(
                        'prompt' => '',
                        'placeholder' => 'Portador',
                        'class' => 'span12'
                    )
                );
                ?>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <?php echo $form->dropDownList($model, 'boleto', array('' => '', 1 => 'Com Boleto', 2 => 'Sem Boleto'), array('placeholder' => 'Boleto', 'class' => 'span12')); ?>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <?php echo $form->textField($model, 'nossonumero', array('placeholder' => 'Nosso Número', 'class' => 'span12')); ?>
            </div>
        </div>
        <div class="span5">
            <div class="row-fluid">
                <?php echo $form->select2Pessoa($model, 'codpessoa', array('class' => 'span12', 'inativo' => true)); ?>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <?php
                echo $form->dropDownList(
                    $model,
                    'codfilial',
                    Filial::getListaCombo(),
                    array(
                        'prompt' => '',
                        'placeholder' => 'Filial',
                        'class' => 'span6'
                    )
                );
                ?>
                <?php echo $form->dropDownList($model, 'gerencial', array('' => '', 1 => 'Gerencial', 2 => 'Fiscal'), array('placeholder' => 'Gerencial', 'class' => 'span6')); ?>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <?php echo $form->dropDownList($model, 'codcontacontabil', ContaContabil::getListaCombo(), array('prompt' => '', 'placeholder' => 'Conta', 'class' => 'span6')); ?>
                <?php
                echo $form->dropDownList(
                    $model,
                    'codtipotitulo',
                    TipoTitulo::getListaCombo(),
                    array('prompt' => '', 'placeholder' => 'Tipo', 'class' => 'span6')
                );
                ?>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <?php echo $form->dropDownList($model, 'credito', array('' => '', 1 => 'Credito', 2 => 'Debito'), array('placeholder' => 'Operação', 'class' => 'span6')); ?>
                <?php
                echo $form->dropDownList(
                    $model,
                    'codusuariocriacao',
                    Usuario::getListaCombo(),
                    array('prompt' => '', 'placeholder' => 'Usuário', 'class' => 'span6')
                );
                ?>
            </div>
        </div>
        <div class="span2">
            <div class="row-fluid">
                <?php echo $form->dropDownList($model, 'saldo', array('0' => 'Em Aberto', 1 => 'Liquidados', 9 => 'Todos'), array('placeholder' => 'Saldo', 'class' => 'span12')); ?>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <?php
                echo $form->datepickerRow(
                    $model,
                    'vencimento_de',
                    array(
                        'class' => 'span6 text-center',
                        'options' => array(
                            'format' => 'dd/mm/yy'
                        ),
                        'placeholder' => 'Vencimento',
                        // 'prepend' => 'De',
                    )
                );
                ?>
                <?php
                echo $form->datepickerRow(
                    $model,
                    'vencimento_ate',
                    array(
                        'class' => 'span6 text-center',
                        'options' => array(
                            'format' => 'dd/mm/yy'
                        ),
                        'placeholder' => 'Vencimento',
                        // 'prepend' => 'Até',
                    )
                );
                ?>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <?php
                echo $form->datepickerRow(
                    $model,
                    'emissao_de',
                    array(
                        'class' => 'span6 text-center',
                        'options' => array(
                            'format' => 'dd/mm/yy'
                        ),
                        'placeholder' => 'Emissão',
                        // 'prepend' => 'De',
                    )
                );
                ?>
                <?php
                echo $form->datepickerRow(
                    $model,
                    'emissao_ate',
                    array(
                        'class' => 'span6 text-center',
                        'options' => array(
                            'format' => 'dd/mm/yy'
                        ),
                        'placeholder' => 'Emissão',
                        // 'prepend' => 'Até',
                    )
                );
                ?>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <?php
                echo $form->datepickerRow(
                    $model,
                    'criacao_de',
                    array(
                        'class' => 'span6 text-center',
                        'options' => array(
                            'format' => 'dd/mm/yy'
                        ),
                        'placeholder' => 'Criação',
                        // 'prepend' => 'De',
                    )
                );
                ?>
                <?php
                echo $form->datepickerRow(
                    $model,
                    'criacao_ate',
                    array(
                        'class' => 'span6 text-center',
                        'options' => array(
                            'format' => 'dd/mm/yy'
                        ),
                        'placeholder' => 'Criação',
                        // 'prepend' => 'Até',
                    )
                );
                ?>
            </div>
        </div>
        <div class="span2">
            <div class="row-fluid" style="padding-top: 4px">
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
            <div class="row-fluid" style="padding-top: 4px">
                <?php
                echo $form->textFieldRow(
                    $model,
                    'debito_de',
                    [
                        // 'prepend' => 'R$',
                        'class' => 'span6 text-right',
                        'maxlength' => 14
                    ]
                );

                echo $form->textFieldRow(
                    $model,
                    'debito_ate',
                    [
                        // 'prepend' => 'Até',
                        'class' => 'span6 text-right',
                        'maxlength' => 14
                    ]
                );
                ?>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <?php
                echo $form->textFieldRow(
                    $model,
                    'credito_de',
                    [
                        // 'prepend' => 'R$',
                        'class' => 'span6 text-right',
                        'maxlength' => 14
                    ]
                );

                echo $form->textFieldRow(
                    $model,
                    'credito_ate',
                    [
                        // 'prepend' => 'Até',
                        'class' => 'span6 text-right',
                        'maxlength' => 14
                    ]
                );
                ?>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <?php
                echo $form->textFieldRow(
                    $model,
                    'saldo_de',
                    [
                        // 'prepend' => 'R$',
                        'class' => 'span6 text-right',
                        'maxlength' => 14
                    ]
                );

                echo $form->textFieldRow(
                    $model,
                    'saldo_ate',
                    [
                        // 'prepend' => 'Até',
                        'class' => 'span6 text-right',
                        'maxlength' => 14
                    ]
                );
                ?>
            </div>
        </div>

    </div>
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

<script type='text/javascript'>
    $(document).ready(function() {

        $('#Titulo_debito_de').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            altDec: '.'
        });

        $('#Titulo_debito_ate').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            altDec: '.'
        });

        $('#Titulo_credito_de').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            altDec: '.'
        });

        $('#Titulo_credito_ate').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            altDec: '.'
        });

        $('#Titulo_saldo_de').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            altDec: '.'
        });

        $('#Titulo_saldo_ate').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            altDec: '.'
        });

        $('#titulo-form').submit(function(e) {
            var currentForm = this;
            e.preventDefault();
            bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
                if (result) {
                    currentForm.submit();
                }
            });
        });

    });
</script>