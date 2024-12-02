<?php

class MGGridTitulos extends CWidget
{

    public $modelname;
    public $campo;
    public $idPrefix;
    public $namePrefix;
    public $codfilial;
    public $codgrupoeconomico;
    public $codpessoa;
    public $vencimento_de;
    public $vencimento_ate;
    public $codoperacao;
    public $GridTitulos;


    public function run()
    {

        $this->idPrefix = $this->modelname . "_" . $this->campo;
        $this->namePrefix = $this->modelname . "[" . $this->campo . "]";

        $model = new Titulo('search');

        $titulos = array();

        if (!empty($this->GridTitulos['codtitulo'])) {
            if (!is_array($this->GridTitulos['codtitulo']))
                $this->GridTitulos['codtitulo'] = explode(',', trim($this->GridTitulos['codtitulo'], ','));

            foreach ($this->GridTitulos['codtitulo'] as $codtitulo) {
                $model->unsetAttributes();
                $model->attributes = [
                    'codtitulo' => $codtitulo,
                    'status' => 'A'
                ];
                $titulos = array_merge($titulos, $model->search(false));
            }
        } else
            $this->GridTitulos['codtitulo'] = array();

        $attr = [
            'status' => 'A'
        ];

        if (!empty($this->codfilial)) {
            $attr['codfilial'] = $this->codfilial;
        }

        if (!empty($this->codgrupoeconomico)) {
            $attr['codgrupoeconomico'] = $this->codgrupoeconomico;
        }

        if (!empty($this->codpessoa)) {
            $attr['codpessoa'] = $this->codpessoa;
        }

        if (!empty($this->vencimento_de)) {
            $attr['vencimento_de'] = $this->vencimento_de;
        }

        if (!empty($this->vencimento_ate)) {

            $attr['vencimento_ate'] = $this->vencimento_ate;
        }

        if (!empty($this->codoperacao)) {
            $attr['credito'] = $this->codoperacao;
        }

        if (sizeof($attr) > 0) {
            $model->unsetAttributes();
            $model->attributes = $attr;
            foreach ($model->search(false, 100, 't.vencimento, t.saldo') as $titulo)
                if (!in_array($titulo->codtitulo, $this->GridTitulos['codtitulo']))
                    $titulos[] = $titulo;
        }

?>
        <script type='text/javascript'>
            function inicializaFuncoes() {
                calculaTotais();

                $('#<?php echo $this->idPrefix; ?>_codtitulo_todos').change(function() {
                    $('.codtitulo').each(function() {
                        $(this).attr('checked', $('#<?php echo $this->idPrefix; ?>_codtitulo_todos').is(':checked'));
                    });
                    calculaTotais();
                });

                $('.codtitulo').change(function() {
                    calculaTotais();
                });

                $('.numero').change(function() {
                    calculaTotalTitulo(this);
                });

            }

            function calculaTotalTitulo(campo) {

                var idCampo = $(campo).attr('id');
                var arrCampo = idCampo.split('_');
                var codTitulo = arrCampo[3];
                var nomeCampoAlterado = arrCampo[2];

                campoSaldo = "#" + arrCampo[0] + '_' + arrCampo[1] + '_saldo_' + codTitulo;
                campoMulta = "#" + arrCampo[0] + '_' + arrCampo[1] + '_multa_' + codTitulo;
                campoJuros = "#" + arrCampo[0] + '_' + arrCampo[1] + '_juros_' + codTitulo;
                campoDesconto = "#" + arrCampo[0] + '_' + arrCampo[1] + '_desconto_' + codTitulo;
                campoTotal = "#" + arrCampo[0] + '_' + arrCampo[1] + '_total_' + codTitulo;

                var valorSaldo = parseFloat($(campoSaldo).autoNumeric('get'));
                if (isNaN(valorSaldo))
                    valorSaldo = 0;

                var valorMulta = parseFloat($(campoMulta).autoNumeric('get'));
                if (isNaN(valorMulta))
                    valorMulta = 0;

                var valorJuros = parseFloat($(campoJuros).autoNumeric('get'));
                if (isNaN(valorJuros))
                    valorJuros = 0;

                var valorDesconto = parseFloat($(campoDesconto).autoNumeric('get'));
                if (isNaN(valorDesconto))
                    valorDesconto = 0;

                var valorTotal = parseFloat($(campoTotal).autoNumeric('get'));
                if (isNaN(valorTotal))
                    valorTotal = 0;

                var valorSaldoCalculado = parseFloat($(campoSaldo).data('calculado'));
                if (isNaN(valorSaldoCalculado))
                    valorSaldoCalculado = valorTotal;

                var valorMultaCalculado = parseFloat($(campoMulta).data('calculado'));
                if (isNaN(valorMultaCalculado))
                    valorMultaCalculado = 0;

                var valorJurosCalculado = parseFloat($(campoJuros).data('calculado'));
                if (isNaN(valorJurosCalculado))
                    valorJurosCalculado = 0;

                var valorDescontoCalculado = parseFloat($(campoDesconto).data('calculado'));
                if (isNaN(valorDescontoCalculado))
                    valorDescontoCalculado = 0;

                var valorTotalCalculado = parseFloat($(campoTotal).data('calculado'));
                if (isNaN(valorTotalCalculado))
                    valorTotalCalculado = valorTotal;

                if (nomeCampoAlterado == 'saldo') {
                    var perc = 1;
                    if (valorSaldo > valorSaldoCalculado) {
                        valorSaldo = valorSaldoCalculado;
                        perc = 1;
                    } else
                        perc = valorSaldo / valorSaldoCalculado;
                    valorJuros = arredondar(valorJurosCalculado * perc, 2);
                    valorMulta = arredondar(valorMultaCalculado * perc, 2);
                    valorDesconto = arredondar(valorDescontoCalculado * perc, 2);

                } else if (nomeCampoAlterado == 'total') {
                    var perc = 1;
                    if (valorTotal > valorTotalCalculado) {
                        valorTotal = valorTotalCalculado;
                        perc = 1;
                    } else
                        perc = valorTotal / valorTotalCalculado;
                    valorJuros = arredondar(valorJurosCalculado * perc, 2);
                    valorMulta = arredondar(valorMultaCalculado * perc, 2);
                    valorDesconto = arredondar(valorDescontoCalculado * perc, 2);
                    valorSaldo = valorTotal - valorMulta - valorJuros + valorDesconto;
                } else if (nomeCampoAlterado == 'desconto') {
                    if (valorDesconto > (valorSaldo + valorJuros + valorMulta))
                        valorDesconto = (valorSaldo + valorJuros + valorMulta);
                }

                valorTotal = valorSaldo + valorMulta + valorJuros - valorDesconto;

                $(campoSaldo).autoNumeric('set', valorSaldo);
                $(campoMulta).autoNumeric('set', valorMulta);
                $(campoJuros).autoNumeric('set', valorJuros);
                $(campoDesconto).autoNumeric('set', valorDesconto);
                $(campoTotal).autoNumeric('set', valorTotal);

                $('#<?php echo $this->idPrefix; ?>_codtitulo_' + codTitulo).each(function() {
                    $(this).attr('checked', true);
                });

                calculaTotais();

            }

            function calculaTotais() {

                $('.numero').autoNumeric('init', {
                    aSep: '.',
                    aDec: ',',
                    altDec: '.'
                });

                saldo = 0;
                multa = 0;
                juros = 0;
                desconto = 0;
                total = 0;

                $('.codtitulo:checked').each(function() {
                    if ($("#<?php echo $this->idPrefix; ?>_operacao_" + $(this).val()).val() == "CR")
                        var multiplicador = -1;
                    else
                        var multiplicador = 1;

                    if ($("#<?php echo $this->idPrefix; ?>_saldo_" + $(this).val()).autoNumeric('get') != "")
                        saldo += parseFloat($("#<?php echo $this->idPrefix; ?>_saldo_" + $(this).val()).autoNumeric('get')) * multiplicador;

                    if ($("#<?php echo $this->idPrefix; ?>_multa_" + $(this).val()).autoNumeric('get') != "")
                        multa += parseFloat($("#<?php echo $this->idPrefix; ?>_multa_" + $(this).val()).autoNumeric('get')) * multiplicador;

                    if ($("#<?php echo $this->idPrefix; ?>_juros_" + $(this).val()).autoNumeric('get') != "")
                        juros += parseFloat($("#<?php echo $this->idPrefix; ?>_juros_" + $(this).val()).autoNumeric('get')) * multiplicador;

                    if ($("#<?php echo $this->idPrefix; ?>_desconto_" + $(this).val()).autoNumeric('get') != "")
                        desconto -= parseFloat($("#<?php echo $this->idPrefix; ?>_desconto_" + $(this).val()).autoNumeric('get')) * multiplicador;

                    if ($("#<?php echo $this->idPrefix; ?>_total_" + $(this).val()).autoNumeric('get') != "")
                        total += parseFloat($("#<?php echo $this->idPrefix; ?>_total_" + $(this).val()).autoNumeric('get')) * multiplicador;
                });

                if (total < 0) {
                    var classAdicionar = 'text-warning';
                    var classRemover = 'text-success';
                    var operacao = 'CR';
                } else {
                    var classRemover = 'text-warning';
                    var classAdicionar = 'text-success';
                    var operacao = 'DB';
                }

                $('#total_saldo').addClass(classAdicionar);
                $('#total_multa').addClass(classAdicionar);
                $('#total_juros').addClass(classAdicionar);
                $('#total_desconto').addClass(classAdicionar);
                $('#total_total').addClass(classAdicionar);
                $('#total_operacao').addClass(classAdicionar);

                $('#total_saldo').removeClass(classRemover);
                $('#total_multa').removeClass(classRemover);
                $('#total_juros').removeClass(classRemover);
                $('#total_desconto').removeClass(classRemover);
                $('#total_total').removeClass(classRemover);
                $('#total_operacao').removeClass(classRemover);

                $('#total_saldo').autoNumeric('set', Math.abs(saldo));
                $('#total_multa').autoNumeric('set', Math.abs(multa));
                $('#total_juros').autoNumeric('set', Math.abs(juros));
                $('#total_desconto').autoNumeric('set', Math.abs(desconto));
                $('#total_total').autoNumeric('set', Math.abs(total));
                $('#total_operacao').text(operacao);

            }

            function buscaTitulos() {
                //parametro codpessoa
                var params = [];
                params.push({
                    name: 'codfilial',
                    value: $('#Titulo_codfilial').val()
                });
                params.push({
                    name: 'codgrupoeconomico',
                    value: $('#Titulo_codgrupoeconomico').val()
                });
                params.push({
                    name: 'codpessoa',
                    value: $('#<?php echo $this->modelname; ?>_codpessoa').val()
                });
                params.push({
                    name: 'vencimento_de',
                    value: $('#Titulo_vencimento_de').val()
                });
                params.push({
                    name: 'vencimento_ate',
                    value: $('#Titulo_vencimento_ate').val()
                });
                params.push({
                    name: 'codoperacao',
                    value: $('#Titulo_credito').val()
                });


                var params_selecionados = [];

                //parametro para cada linha da grid
                $('.codtitulo:checked').each(function() {
                    params_selecionados.push({
                        name: '<?php echo $this->campo; ?>[codtitulo][]',
                        value: $(this).val()
                    });
                    params_selecionados.push({
                        name: '<?php echo $this->campo; ?>[saldo][' + $(this).val() + ']',
                        value: $("#<?php echo $this->idPrefix; ?>_saldo_" + $(this).val()).autoNumeric('get')
                    });
                    params_selecionados.push({
                        name: '<?php echo $this->campo; ?>[multa][' + $(this).val() + ']',
                        value: $("#<?php echo $this->idPrefix; ?>_multa_" + $(this).val()).autoNumeric('get')
                    });
                    params_selecionados.push({
                        name: '<?php echo $this->campo; ?>[juros][' + $(this).val() + ']',
                        value: $("#<?php echo $this->idPrefix; ?>_juros_" + $(this).val()).autoNumeric('get')
                    });
                    params_selecionados.push({
                        name: '<?php echo $this->campo; ?>[desconto][' + $(this).val() + ']',
                        value: $("#<?php echo $this->idPrefix; ?>_desconto_" + $(this).val()).autoNumeric('get')
                    });
                    params_selecionados.push({
                        name: '<?php echo $this->campo; ?>[total][' + $(this).val() + ']',
                        value: $("#<?php echo $this->idPrefix; ?>_total_" + $(this).val()).autoNumeric('get')
                    });
                })

                //se tem parametros
                if (params.length > 0) {
                    params.push({
                        name: 'modelname',
                        value: '<?php echo $this->modelname; ?>'
                    });
                    params.push({
                        name: 'campo',
                        value: '<?php echo $this->campo; ?>'
                    });

                    //monta url
                    var params_url = $.param(params);

                    //atualiza div listagem-titulos
                    $("#listagem-titulos").load("<?php echo Yii::app()->createUrl('titulo/ajaxbuscatitulo') ?>&" + params_url, params_selecionados, function() {
                        inicializaFuncoes();
                    });

                }
            }

            $(document).ready(function() {

                inicializaFuncoes();

            });
        </script>

        <div class="registro">
            <div class="row-fluid">
                <div class="span4">
                    <div class="row-fluid">
                        <b>Total Selecionado</b>
                        <b class="pull-right text-right" id="total_operacao">
                        </b>
                    </div>
                </div>
                <div class="span5">
                    <b class="row-fluid">
                        <div class="span3 text-right numero" id="total_saldo">
                        </div>
                        <div class="span2 text-right numero" id="total_multa">
                        </div>
                        <div class="span2 text-right numero" id="total_juros">
                        </div>
                        <div class="span2 text-right numero" id="total_desconto">
                        </div>
                        <div class="span3 text-right numero" id="total_total">
                        </div>
                    </b>
                </div>
                <div class="span3">
                    <div class="row-fluid">
                        <input type="checkbox" id="<?php echo $this->idPrefix; ?>_codtitulo_todos">
                    </div>
                </div>
            </div>
            <small class="row-fluid muted">
                <div class="span4">
                    <b class="row-fluid">
                        <div class="span6">
                            Título
                        </div>
                        <div class="span2 text-center ">
                            Vcto
                        </div>
                        <div class="span4 text-right">
                            Saldo
                        </div>
                    </b>
                </div>
                <div class="span5">
                    <b class="row-fluid">
                        <div class="span3 text-right">
                            Capital
                        </div>
                        <div class="span2 text-right">
                            Multa
                        </div>
                        <div class="span2 text-right">
                            Juros
                        </div>
                        <div class="span2 text-right">
                            Desconto
                        </div>
                        <div class="span3 text-right">
                            Total
                        </div>
                    </b>
                </div>
                <div class="span3">
                    <div class="row-fluid">
                        <div class="span1">
                            &nbsp;
                        </div>
                        <div class="span3">
                            Filial
                        </div>
                        <div class="span8">
                            Pessoa
                        </div>
                    </div>
                </div>
        </div>
        </small>
<?

        // percorre resultados
        foreach ($titulos as $titulo)
            $this->controller->renderPartial(
                'application.components.MGGridTitulos._grid_titulos',
                array(
                    'data' => $titulo,

                    'GridTitulos' => $this->GridTitulos,

                    'idPrefix' => $this->idPrefix,
                    'namePrefix' => $this->namePrefix,
                )
            );
    }
}
