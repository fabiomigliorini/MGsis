<?php
$this->pagetitle = Yii::app()->name . ' - Agrupamento de Títulos';
$this->breadcrumbs = array(
    'Agrupamento de Títulos' => array('index'),
    'Pendentes',
);

$this->menu = array(
    array('label' => 'Listagem', 'icon' => 'icon-list-alt', 'url' => array('index')),
    array(
        'label' => 'Relatório',
        'icon' => 'icon-print',
        'url' => array('relatorioPendente'),
        'linkOptions' => array('id' => 'btnMostrarRelatorio'),
    ),
);

function vencimentoClass($vencimento)
{
    $diff  = round((strtotime($vencimento) - time()) / (60 * 60 * 24));
    if ($diff < -30) {
        return 'text-error';
    }
    if ($diff > 45) {
        return 'text-success';
    }
    return 'text-warning';
}
?>

<script type='text/javascript'>
    $(document).ready(function() {

        $('#btnMostrarRelatorio').click(function(event) {
            event.preventDefault();
            abrirRelatorio();
        });

        $('#search-form').change(function() {
            atualizarListagem();
        });

        $("#TituloAgrupamento_codportador").select2({
            allowClear: true
        });

        $("#TituloAgrupamento_codgrupocliente").select2({
            allowClear: true
        });

        $("#TituloAgrupamento_codportador").select2({
            allowClear: true
        });

        $("#TituloAgrupamento_codtipotitulo").select2({
            allowClear: true
        });

        $("#TituloAgrupamento_codformapagamento").select2({
            allowClear: true
        });

        $('#TituloAgrupamento_valor_de').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            altDec: '.'
        });

        $('#TituloAgrupamento_valor_ate').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            altDec: '.'
        });

    });

    function atualizarListagem() {
        var filtro = $("#search-form").serialize();
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('negocio/atualizatotais') ?>",
            data: filtro,
            type: "GET",
            dataType: "html",
            async: true,
            success: function(data) {
                $('#Listagem').html($(data).find("#Listagem"));
                // $('#totais').animate({
                //     opacity: 0.25,
                // }, 200);
                // $('#totais').animate({
                //     opacity: 1,
                // }, 200);
            },
            error: function(xhr, status) {
                bootbox.alert("Erro ao atualizar listagem!");
                console.log(xhr);
                console.log(status);
            },
        });
    }

    function selectAllGrupoCliente(e) {
        e.preventDefault();
        $("#TituloAgrupamento_codgrupocliente > option[value!='']").prop("selected", true);
        $("#TituloAgrupamento_codgrupocliente").trigger("change");
    }

    function selectNoneGrupoCliente(e) {
        e.preventDefault();
        $("#TituloAgrupamento_codgrupocliente > option[value!='']").prop("selected", false);
        $("#TituloAgrupamento_codgrupocliente").trigger("change");
    }

    function selectAllPortador(e) {
        e.preventDefault();
        $("#TituloAgrupamento_codportador > option[value!='']").prop("selected", true);
        $("#TituloAgrupamento_codportador").trigger("change");
    }

    function selectNonePortador(e) {
        e.preventDefault();
        $("#TituloAgrupamento_codportador > option[value!='']").prop("selected", false);
        $("#TituloAgrupamento_codportador").trigger("change");
    }

    function selectFechamentoPadrao(e) {
        e.preventDefault();
        $("#TituloAgrupamento_codgrupoeconomico").select2("val", null);
        $("#TituloAgrupamento_codpessoa").select2("val", null);
        $("#TituloAgrupamento_codtipotitulo").select2("val", null);
        $("#TituloAgrupamento_vencimento_de").val(null);
        $("#TituloAgrupamento_vencimento_ate").val(null);
        $("#TituloAgrupamento_valor_de").val(null);
        $("#TituloAgrupamento_valor_ate").val(null);
        $("#TituloAgrupamento_codgrupocliente > option[value!='']").prop("selected", true);
        // DESMARCA COLABORADOR
        $("#TituloAgrupamento_codgrupocliente > option[value='8']").prop("selected", false);
        // DESMARCA ESCOLA PUBLICA
        $("#TituloAgrupamento_codgrupocliente > option[value='1']").prop("selected", false);
        $("#TituloAgrupamento_codgrupocliente").trigger("change");
        $("#TituloAgrupamento_codportador > option[value!='']").prop("selected", true);
        // DESMARCA PERDA POR PRAZO
        $("#TituloAgrupamento_codportador > option[value='202035']").prop("selected", false);
        $("#TituloAgrupamento_codportador").trigger("change");

    }

    function abrirRelatorio() {
        var frameSrcRelatorio = $('#btnMostrarRelatorio').attr('href');
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
</script>

<h1>Fechamentos Pendentes</h1>

<div id="modalRelatorio" class="modal hide fade" tabindex="-1" role="dialog">
    <div class="modal-header">
        <div class="pull-right">
            <button class="btn" data-dismiss="modal">Fechar</button>
        </div>
        <h3>Relatório de Fechamentos Pendentes</h3>
    </div>
    <div class="modal-body">
        <iframe src="" id="frameRelatorio" name="frameRelatorio" width="99.6%" height="400" frameborder="0"></iframe>
    </div>
</div>


<?php $form = $this->beginWidget('MGActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'id' => 'search-form',
    'type' => 'inline',
    'method' => 'get',
));

?>

<div class="well well-small" style="overflow-y: auto; max-height: 500px" ;>

    <div class="row-fluid">

        <!-- Coluna Esquerda -->
        <div class="span4">
            <div class="row-fluid">
                <button type="button" class="btn" style="width: 100%; height: 32px" onClick="selectFechamentoPadrao(event)">
                    Trazer Tudo Menos Escolas, Colaboradores e Perdas
                </button>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <div class="span9">
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
                <div class="span3">
                    <div class="btn-group " style="width: 100%;">
                        <button type="button" class="btn" style="width: 50%; height: 32px" onClick="selectAllGrupoCliente(event)"><i class="icon-list"></i></button>
                        <button type="button" class="btn" style="width: 50%; height: 32px" onClick="selectNoneGrupoCliente(event)"><i class="icon-remove"></i></button>
                    </div>
                </div>
            </div>

            <div class="row-fluid" style="padding-top: 4px">
                <div class="span9">
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
                            'multiple' => true,
                        )
                    );
                    ?>
                </div>
                <div class="span3">
                    <div class="btn-group " style="width: 100%;">
                        <button type="button" class="btn" style="width: 50%; height: 32px" onClick="selectAllPortador(event)"><i class="icon-list"></i></button>
                        <button type="button" class="btn" style="width: 50%; height: 32px" onClick="selectNonePortador(event)"><i class="icon-remove"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Meio -->
        <div class="span5">
            <div class="row-fluid" style="padding-top: 4px">
                <?php echo $form->select2GrupoEconomico($model, 'codgrupoeconomico', array('class' => 'span12', 'inativo' => true)); ?>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <?php echo $form->select2Pessoa($model, 'codpessoa', array('class' => 'span12')); ?>
            </div>
            <div class="row-fluid" style="padding-top: 4px">
                <div class="span6">
                    <?php
                    echo $form->dropDownList(
                        $model,
                        'codtipotitulo',
                        TipoTitulo::getListaCombo(),
                        array('prompt' => '', 'placeholder' => 'Tipo', 'class' => 'span12')
                    );
                    ?>
                </div>
                <div class="span6">
                    <?php
                    echo $form->dropDownList(
                        $model,
                        'codformapagamento',
                        FormaPagamento::getListaComboNaoIntegracao(),
                        array('prompt' => '', 'placeholder' => 'Forma Pagamento Cliente', 'class' => 'span12')
                    );
                    ?>
                </div>
            </div>
        </div>

        <!-- Coluna Direita -->
        <div class="span3">


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

            <!-- DEBITO DE/ATE -->
            <div class="row-fluid" style="padding-top: 4px">
                <?php
                echo $form->textFieldRow(
                    $model,
                    'valor_de',
                    [
                        // 'prepend' => 'R$',
                        'class' => 'span6 text-right',
                        'maxlength' => 14
                    ]
                );

                echo $form->textFieldRow(
                    $model,
                    'valor_ate',
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

<div id="Listagem">
    <table class="table table-striped table-bordered table-hover">
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
</div>