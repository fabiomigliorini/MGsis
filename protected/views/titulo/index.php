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

    function selectAllGrupoCliente(e) {
        e.preventDefault();
        $("#Titulo_codgrupocliente > option[value!='']").prop("selected", true);
        $("#Titulo_codgrupocliente").trigger("change");
    }

    function selectNoneGrupoCliente(e) {
        e.preventDefault();
        $("#Titulo_codgrupocliente > option[value!='']").prop("selected", false);
        $("#Titulo_codgrupocliente").trigger("change");
    }

    function selectAllPortador(e) {
        e.preventDefault();
        $("#Titulo_codportador > option[value!='']").prop("selected", true);
        $("#Titulo_codportador").trigger("change");
    }

    function selectNonePortador(e) {
        e.preventDefault();
        $("#Titulo_codportador > option[value!='']").prop("selected", false);
        $("#Titulo_codportador").trigger("change");
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

        $("#Titulo_status").select2({
            allowClear: true
        });
        $("#Titulo_ordem").select2({
            allowClear: true
        });
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
        $("#Titulo_codgrupocliente").select2({
            allowClear: true
        });
        $("#Titulo_pagarreceber").select2({
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

        <!-- COLUNA 1 -->
        <div class="span3">

            <!-- CODTITULO E NUMERO -->
            <div class="row-fluid">
                <div class="span5">
                    <?php echo $form->textField($model, 'codtitulo', array('placeholder' => '#', 'class' => 'span12')); ?>
                </div>
                <div class="span7">
                    <?php echo $form->textField($model, 'numero', array('placeholder' => 'Número', 'class' => 'span12')); ?>
                </div>
            </div>

            <!-- PORTADOR -->
            <div class="row-fluid" style="padding-top: 4px">
                <div class="span5">
                    <?php
                    echo $form->dropDownList(
                        $model,
                        'boleto',
                        array(
                            '' => '',
                            'B' => 'Com Boleto Emitido',
                            'BA' => 'Boleto Aberto no Banco',
                            'BL' => 'Boleto Liquidado no Banco',
                            'SB' => 'Sem Boleto'
                        ),
                        array(
                            'placeholder' => 'Boleto',
                            'class' => 'span12'
                        )
                    );
                    ?>
                </div>
                <div class="span7">
                    <?php echo $form->textField($model, 'nossonumero', array('placeholder' => 'Nosso Número', 'class' => 'span12')); ?>
                </div>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <div class="span5">
                    <?php echo $form->dropDownList($model, 'gerencial', array('' => '', 1 => 'Gerencial', 2 => 'Fiscal'), array('placeholder' => 'Gerencial', 'class' => 'span12')); ?>
                </div>
                <div class="span7">
                    <?php
                    echo $form->dropDownList(
                        $model,
                        'codfilial',
                        Filial::getListaCombo(),
                        array(
                            'prompt' => '',
                            'placeholder' => 'Filial',
                            'class' => 'span12'
                        )
                    );
                    ?>
                </div>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <div class="span5">
                    <?php echo $form->dropDownList($model, 'credito', array('' => '', 1 => 'Credito', 2 => 'Debito'), array('placeholder' => 'Operação', 'class' => 'span12')); ?>
                </div>
                <div class="span7">
                    <?php
                    echo $form->dropDownList(
                        $model,
                        'codusuariocriacao',
                        Usuario::getListaCombo(),
                        array('prompt' => '', 'placeholder' => 'Usuário', 'class' => 'span12')
                    );
                    ?>
                </div>

            </div>

            <div class="row-fluid" style="padding-top: 4px">
                <div class="span12">
                    <?php
                    echo $form->dropDownList(
                        $model,
                        'codtipotitulo',
                        TipoTitulo::getListaCombo(),
                        array('prompt' => '', 'placeholder' => 'Tipo', 'class' => 'span12')
                    );
                    ?>
                </div>

            </div>

        </div>

        <!-- COLUNA 2 -->
        <div class="span5">
            <div class="row-fluid">
                <div class="span7">
                    <?php echo $form->select2Pessoa($model, 'codpessoa', array('class' => 'span12', 'inativo' => true)); ?>
                </div>
                <div class="span5">
                    <?php echo $form->select2GrupoEconomico($model, 'codgrupoeconomico', array('class' => 'span12', 'inativo' => true)); ?>
                </div>
            </div>

            <div class="row-fluid" style="padding-top: 4px">
                <div class="span10">
                    <?php
                    $portadores = Portador::getListaCombo();
                    $portadores[-1] = 'Sem Portador Informado';
                    echo $form->dropDownList(
                        $model,
                        'codportador',
                        $portadores,
                        array(
                            'prompt' => '',
                            'placeholder' => 'Portador',
                            'class' => 'span12',
                            'multiple' => true
                        )
                    );
                    ?>
                </div>
                <div class="span2">
                    <div class="btn-group " style="width: 100%;">
                        <button type="button" class="btn" style="width: 50%; height: 32px" onClick="selectAllPortador(event)"><i class="icon-list"></i></button>
                        <button type="button" class="btn" style="width: 50%; height: 32px" onClick="selectNonePortador(event)"><i class="icon-remove"></i></button>
                    </div>
                </div>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <div class="span10">
                    <?php
                    $gruposcliente = GrupoCliente::getListaCombo();
                    $gruposcliente[-1] = 'Sem Grupo Informado';
                    echo $form->dropDownList(
                        $model,
                        'codgrupocliente',
                        $gruposcliente,
                        array(
                            'prompt' => '',
                            'placeholder' => 'Grupo de Cliente',
                            'class' => 'span12',
                            'multiple' => true
                        )
                    );
                    ?>
                </div>
                <div class="span2">
                    <div class="btn-group " style="width: 100%;">
                        <button type="button" class="btn" style="width: 50%; height: 32px" onClick="selectAllGrupoCliente(event)"><i class="icon-list"></i></button>
                        <button type="button" class="btn" style="width: 50%; height: 32px" onClick="selectNoneGrupoCliente(event)"><i class="icon-remove"></i></button>
                    </div>
                </div>
            </div>
            <div class="row-fluid" style="padding-top: 6px">
                <?php echo $form->dropDownList($model, 'codcontacontabil', ContaContabil::getListaCombo(), array('prompt' => '', 'placeholder' => 'Conta', 'class' => 'span12', 'multiple' => true)); ?>
            </div>
        </div>

        <!-- COLUNA 3 -->
        <div class="span2">
            <div class="row-fluid">
                <?php
                echo $form->dropDownList(
                    $model,
                    'status',
                    array(
                        '' => '',
                        'A' => 'Abertos',
                        'AL' => 'Abertos e Liquidados',
                        'L' => 'Liquidados',
                        'E' => 'Estornados',
                        'LE' => 'Estornados e Liquidados',
                    ),
                    array(
                        'placeholder' => 'Saldo',
                        'class' => 'span12'
                    )
                );
                ?>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <?php
                echo $form->dropDownList(
                    $model,
                    'ordem',
                    array(
                        '' => '',
                        'AV' => 'Alfabética, Vencimento',
                        'AE' => 'Alfabética, Emissão',
                        'CV' => 'Código da Pessoa, Vencimento',
                        'CE' => 'Código da Pessoa, Emissão',
                    ),
                    array(
                        'placeholder' => 'Ordem',
                        'class' => 'span12'
                    )
                );
                ?>
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
            <div class="row-fluid" style="padding-top: 4px">
                <?php
                echo $form->datepickerRow(
                    $model,
                    'liquidacao_de',
                    array(
                        'class' => 'span6 text-center',
                        'options' => array(
                            'format' => 'dd/mm/yy'
                        ),
                        'placeholder' => 'Liquidação',
                        // 'prepend' => 'De',
                    )
                );
                ?>
                <?php
                echo $form->datepickerRow(
                    $model,
                    'liquidacao_ate',
                    array(
                        'class' => 'span6 text-center',
                        'options' => array(
                            'format' => 'dd/mm/yy'
                        ),
                        'placeholder' => 'Liquidação',
                        // 'prepend' => 'Até',
                    )
                );
                ?>
            </div>
        </div>

        <!-- COLUNA 4 -->
        <div class="span2">

            <div class="row-fluid">
                <?php echo $form->dropDownList($model, 'pagarreceber', array('' => '', 'R' => 'Contas à Receber', 'P' => 'Contas à Pagar'), array('placeholder' => 'Pagar / Receber', 'class' => 'span12')); ?>
            </div>

            <!-- DEBITO DE/ATE -->
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

            <!-- CREDITO DE/ATE -->
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

            <!-- SALDO DE/ATE -->
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

            <!-- BOTAO BUSCA -->
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