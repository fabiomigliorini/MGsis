<?php
require_once(Yii::app()->basePath . '/.env.php');

$this->pagetitle = Yii::app()->name . ' - Detalhes Nota Fiscal';
$this->breadcrumbs = array(
    'Notas Fiscais' => array('index'),
    Yii::app()->format->formataNumeroNota($model->emitida, $model->serie, $model->numero, $model->modelo),
);

$bloqueado = !$model->podeEditar();

$this->menu = array(
    array('label' => 'Listagem', 'icon' => 'icon-list-alt', 'url' => array('index')),
    array('label' => 'Nova', 'icon' => 'icon-plus', 'url' => array('create')),
    array('label' => 'Alterar', 'icon' => 'icon-pencil', 'url' => array('update', 'id' => $model->codnotafiscal), 'visible' => !$bloqueado),
    array('label' => 'Excluir', 'icon' => 'icon-trash', 'url' => '#', 'linkOptions' =>    array('id' => 'btnExcluir'), 'visible' => !$bloqueado),
    array('label' => 'Duplicar', 'icon' => 'icon-retweet', 'url' => array('create', 'duplicar' => $model->codnotafiscal)),
    array('label' => 'Ver Arquivo XML', 'icon' => ' icon-file', 'url' => MGSPA_NFEPHP_URL . "{$model->codnotafiscal}/xml", 'linkOptions' =>    array('id' => 'btnArquivoXml'), 'visible' => $bloqueado),
    array('label' => 'Operacao Inversa', 'icon' => 'icon-random', 'url' => array('create', 'inverter' => $model->codnotafiscal)),
    array('label' => 'Tirar Desconto/Outros', 'icon' => 'icon-wrench', 'url' => '#', 'linkOptions' =>    array('id' => 'btnValorLiquido'), 'visible' => !$bloqueado),
    //array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

?>

<script type="text/javascript">
    /*<![CDATA[*/
    $(document).ready(function() {

        jQuery('body').on('click', '#btnSalvarCartaCorrecao', function() {
            var texto = $("#txtCartaCorrecao").val();
            var codnotafiscal = <?php echo $model->codnotafiscal; ?>;
            bootbox.confirm("<h3>Confirma emissão da carta de correção?</h3><br><pre>" + texto + "</pre>", function(result) {
                if (result) {

                    $.ajax({
                        type: 'GET',
                        url: "<?php echo MGSPA_NFEPHP_URL; ?>" + codnotafiscal + "/carta-correcao/",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        data: {
                            texto: texto
                        }
                    }).done(function(resp) {
                        console.log(resp)
                        $('#modalProgressoNfe').modal('hide');
                        if (resp.sucesso == true) {
                            var css = "text-success";
                        } else {
                            var css = "text-error";
                        }
                        mensagem = "<h3 class='" + css + "'>" + resp.cStat + " - " + resp.xMotivo + "</h3>";
                        bootbox.alert(mensagem, function() {
                            location.reload();
                        });
                    }).fail(function(jqxhr, textStatus, error) {
                        $('#modalProgressoNfe').modal('hide');
                        var mensagem = jQuery.parseJSON(jqxhr.responseText).message;
                        mensagem = "<h3 class='text-error'>" + mensagem + "</h3>";
                        bootbox.alert(mensagem, function() {
                            location.reload();
                        });
                    });

                }
            });
        });

        jQuery('body').on('click', '#btnExcluir', function() {
            bootbox.confirm("Excluir este registro?", function(result) {
                if (result)
                    jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('notaFiscal/delete', array('id' => $model->codnotafiscal)) ?>", {});
            });
        });

        jQuery('body').on('click', '#btnValorLiquido', function() {
            bootbox.confirm("Tem certeza que deseja remover os valores de Desconto, Frete, etc e deixar os preços pelo valor líquido?", function(result) {
                if (result)
                    jQuery.yii.submitForm(
                        document.body.childNodes[0],
                        "<?php echo Yii::app()->createUrl('notaFiscal/valorLiquido', array('id' => $model->codnotafiscal)) ?>", {}
                    );
            });
        });


        // botão delete da embalagem
        jQuery(document).on('click', 'a.delete', function(e) {
            //evita redirecionamento da pagina
            e.preventDefault();
            // pega url para delete
            var url = jQuery(this).attr('href');
            //pede confirmacao
            bootbox.confirm("Excluir este Item?", function(result) {
                // se confirmou
                if (result) {
                    //faz post
                    jQuery.ajax({
                        type: 'POST',
                        url: url,
                        //se sucesso, atualiza listagem de embalagens
                        success: function() {
                            location.reload();
                        },
                        //caso contrário mostra mensagem com erro
                        error: function(XHR, textStatus) {
                            var err;
                            if (XHR.readyState === 0 || XHR.status === 0) {
                                return;
                            }
                            //tipos de erro
                            switch (textStatus) {
                                case 'timeout':
                                    err = 'O servidor não responde (timed out)!';
                                    break;
                                case 'parsererror':
                                    err = 'Erro de parâmetros (Parser error)!';
                                    break;
                                case 'error':
                                    if (XHR.status && !/^\s*$/.test(XHR.status)) {
                                        err = 'Erro ' + XHR.status;
                                    } else {
                                        err = 'Erro';
                                    }
                                    if (XHR.responseText && !/^\s*$/.test(XHR.responseText)) {
                                        err = err + ': ' + XHR.responseText;
                                    }
                                    break;
                            }
                            //abre janela do bootbox com a mensagem de erro
                            if (err) {
                                bootbox.alert(err);
                            }
                        }
                    });
                }
            });
        });

    });
    /*]]>*/
</script>



<h1><?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codnotafiscal)); ?> - <?php echo CHtml::encode(Yii::app()->format->formataNumeroNota($model->emitida, $model->serie, $model->numero, $model->modelo)); ?></h1>


<div class="row-fluid">
    <div class="span4">
        <?php
        $pessoa = CHtml::link(CHtml::encode($model->Pessoa->fantasia), array("pessoa/view", "id" => $model->codpessoa));
        if (!empty($model->Pessoa->cnpj)) {
            $pessoa .= '<br /><small>' . Yii::app()->format->formataCnpjCpf($model->Pessoa->cnpj, $model->Pessoa->fisica) . '</small>';
        }
        if (!empty($model->Pessoa->ie) && $model->Pessoa->codcidade) {
            $pessoa .= '<br /><small>' . Yii::app()->format->formataInscricaoEstadual($model->Pessoa->ie, $model->Pessoa->Cidade->Estado->sigla) . '</small>';
        }
        if (!empty($model->cpf)) {
            $pessoa .= '<br /><small>' . Yii::app()->format->formataCnpjCpf($model->cpf, true) . '</small>';
        }

        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'codnotafiscal',
                    'value' => Yii::app()->format->formataCodigo($model->codnotafiscal),
                ),
                array(
                    'name' => 'codfilial',
                    'value' => CHtml::link(CHtml::encode($model->Filial->filial), array("filial/view", "id" => $model->codfilial)) . ' (' . $model->EstoqueLocal->estoquelocal . ')',
                    'type' => 'raw',
                ),
                array(
                    'name' => 'codnaturezaoperacao',
                    'value' => ((isset($model->Operacao)) ? $model->Operacao->operacao : null)
                        . " - " .
                        ((isset($model->NaturezaOperacao)) ? $model->NaturezaOperacao->naturezaoperacao : null),
                ),
                'serie',
                array(
                    'name' => 'numero',
                    'value' => Yii::app()->format->formataPorMascara($model->numero, "########"),
                ),
                array(
                    'name' => 'codpessoa',
                    'value' => $pessoa,
                    'type' => "raw",
                ),
                array(
                    'name' => 'emissao',
                    'value' => str_replace(' ', '&nbsp', $model->emissao),
                    'type' => 'raw'
                ),
                array(
                    'name' => 'saida',
                    'value' => str_replace(' ', '&nbsp', $model->saida),
                    'type' => 'raw'
                ),
            ),
        ));
        ?>
    </div>
    <small class="span3">
        <?php

        $fretes = NotaFiscal::getFreteListaCombo();
        if (isset($fretes[$model->frete]))
            $frete = $fretes[$model->frete];
        else
            $frete = $model->frete;

        $placa = $model->placa;
        if (!empty($model->codestadoplaca)) {
            $placa .=  '/' . $model->EstadoPlaca->sigla;
        }

        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'codpessoatransportador',
                    'value' => ((isset($model->PessoaTransportador)) ? CHtml::link(CHtml::encode($model->PessoaTransportador->fantasia), array("pessoa/view", "id" => $model->codpessoatransportador)) : null),
                    'type' => "raw",
                ),
                array(
                    'name' => 'placa',
                    'value' => CHtml::encode($placa),
                    'type' => "raw",
                ),
                array(
                    'name' => 'frete',
                    'value' => $frete,
                ),
                array(
                    'name' => 'volumes',
                    'value' => Yii::app()->format->formatNumber($model->volumes, 0),
                ),
                'volumesespecie',
                'volumesmarca',
                'volumesnumero',
                array(
                    'name' => 'pesobruto',
                    'value' => Yii::app()->format->formatNumber($model->pesobruto, 3),
                ),
                array(
                    'name' => 'pesoliquido',
                    'value' => Yii::app()->format->formatNumber($model->pesoliquido, 3),
                ),
            ),
        ));
        ?>
    </small>
    <small class="span4" style="overflow-x: hidden">
        <?php
        $css_label = "";
        $staus = "&nbsp";
        $css = "";

        switch ($model->codstatus) {
            case NotaFiscal::CODSTATUS_DIGITACAO;
                $css_label = "label-warning";
                break;

            case NotaFiscal::CODSTATUS_AUTORIZADA;
                $css_label = "label-success";
                break;

            case NotaFiscal::CODSTATUS_LANCADA;
                $css_label = "label-info";
                break;

            case NotaFiscal::CODSTATUS_NAOAUTORIZADA;
                break;

            case NotaFiscal::CODSTATUS_INUTILIZADA;
            case NotaFiscal::CODSTATUS_CANCELADA;
                $css_label = "label-important";
                break;
        }

        $modelo = NotaFiscal::getModeloListaCombo();
        if (isset($modelo[$model->modelo]))
            $modelo = $modelo[$model->modelo];
        else
            $modelo = $model->modelo;

        $arrTpEmis = NotaFiscal::getTpEmisListaCombo();
        $tpEmis = @$arrTpEmis[$model->tpemis];

        $attr = array(
            array(
                'name' => 'emitida',
                'value' => ($model->emitida) ? "Pela Filial" : "Pela Contraparte",
                'type' => "raw",
            ),
            array(
                'name' => 'modelo',
                'value' => $modelo
            ),
            array(
                'label' => 'Status',
                'value' => "<small class='label $css_label'>$model->status</small> $tpEmis",
                'type' => 'raw',
            ),
        );

        if (!empty($model->nfechave))
            $attr[] =
                array(
                    'name' => 'nfechave',
                    'value' => str_replace(" ", "&nbsp;", CHtml::encode(Yii::app()->format->formataChaveNfe($model->nfechave))),
                    'type' => 'raw',
                );

        foreach ($model->NfeTerceiros as $nfet)
            $attr[] =
                array(
                    'label' => 'NF-e Terceiro',
                    'value' => CHtml::link('Abrir', array("nfeTerceiro/view", "id" => $nfet->codnfeterceiro)),
                    'type' => 'raw',
                );


        if (!empty($model->nfereciboenvio) || !empty($model->nfedataenvio))
            $attr[] =
                array(
                    'name' => 'nfereciboenvio',
                    'value' => $model->nfereciboenvio . " - " . $model->nfedataenvio,
                    'type' => 'raw',
                );

        if (!empty($model->nfeautorizacao) || !empty($model->nfedataautorizacao))
            $attr[] =
                array(
                    'name' => 'nfeautorizacao',
                    'value' => $model->nfeautorizacao . " - " . $model->nfedataautorizacao,
                    'type' => 'raw',
                );

        if (!empty($model->nfecancelamento) || !empty($model->nfedatacancelamento))
            $attr[] =
                array(
                    'name' => 'nfecancelamento',
                    'value' => $model->nfecancelamento . " - " . $model->nfedatacancelamento,
                    'type' => 'raw',
                );

        if (!empty($model->nfeinutilizacao) || !empty($model->nfedatainutilizacao))
            $attr[] =
                array(
                    'name' => 'nfeinutilizacao',
                    'value' => $model->nfeinutilizacao . " - " . $model->nfedatainutilizacao,
                    'type' => 'raw',
                );

        if (!empty($model->justificativa))
            $attr[] = 'justificativa';

        if ($model->codstatus == NotaFiscal::CODSTATUS_AUTORIZADA) {
            $attr[] = [
                'label' => 'MDFe',
                'value' => "<a href='" . MGSPA_URL . "mdfe/create-nfechave/{$model->nfechave}' target='_blank'>Criar nova MDFe</a>",
                'type' => 'raw'
            ];
        }

        $arrCorStatusMdfe = [
            1 => 'label-warning',
            2 => 'label-warning',
            3 => 'label-info',
            4 => 'label-important',
            5 => 'label-inverse',
            9 => 'label-important',
        ];

        foreach ($model->MdfeNfes as $mdfeNfe) {
            $cormdfestatus = @$arrCorStatusMdfe[$mdfeNfe->Mdfe->codmdfestatus];
            if (!empty($mdfeNfe->Mdfe->chmdfe)) {
                $texto = Yii::app()->format->formataChaveNfe($mdfeNfe->Mdfe->chmdfe);
            } else {
                $texto = Yii::app()->format->formataCodigo($mdfeNfe->codmdfe);
            }
            $attr[] = [
                'label' => 'MDFe Gerado',
                'value' => "<small><a href='" . MGSPA_URL . "mdfe/{$mdfeNfe->codmdfe}' target='_blank'><small class='label {$cormdfestatus}'>{$mdfeNfe->Mdfe->MdfeStatus->mdfestatus}</small><br />" . $texto . "</a> </small>",
                'type' => 'raw'
            ];
        }

        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => $attr,
        ));

        ?>
    </small>
    <div class="span1">
        <?php $this->widget('MGNotaFiscalBotoes', array('model' => $model)); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span2">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'valorprodutos',
                    'value' => Yii::app()->format->formatNumber($model->valorprodutos),
                ),
                array(
                    'name' => 'valortotal',
                    'value' => Yii::app()->format->formatNumber($model->valortotal),
                ),
            ),
        ));
        ?>
    </div>
    <small class="span2">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'valordesconto',
                    'value' => Yii::app()->format->formatNumber($model->valordesconto),
                ),
                array(
                    'name' => 'valoroutras',
                    'value' => Yii::app()->format->formatNumber($model->valoroutras),
                ),
            ),
        ));
        ?>
    </small>
    <small class="span2">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'valorfrete',
                    'value' => Yii::app()->format->formatNumber($model->valorfrete),
                ),
                array(
                    'name' => 'valorseguro',
                    'value' => Yii::app()->format->formatNumber($model->valorseguro),
                ),
            ),
        ));
        ?>
    </small>
    <small class="span2">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'icmsbase',
                    'value' => Yii::app()->format->formatNumber($model->icmsbase),
                ),
                array(
                    'name' => 'icmsvalor',
                    'value' => Yii::app()->format->formatNumber($model->icmsvalor),
                ),
            ),
        ));
        ?>
    </small>
    <small class="span2">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'icmsstbase',
                    'value' => Yii::app()->format->formatNumber($model->icmsstbase),
                ),
                array(
                    'name' => 'icmsstvalor',
                    'value' => Yii::app()->format->formatNumber($model->icmsstvalor),
                ),
            ),
        ));
        ?>
    </small>
    <small class="span2">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'ipibase',
                    'value' => Yii::app()->format->formatNumber($model->ipibase),
                ),
                array(
                    'name' => 'ipivalor',
                    'value' => Yii::app()->format->formatNumber($model->ipivalor),
                ),
                array(
                    'name' => 'ipidevolucaovalor',
                    'value' => Yii::app()->format->formatNumber($model->ipidevolucaovalor),
                ),
            ),
        ));
        ?>
    </small>
</div>
<br>
<h2>
    Produtos
    <small>
        <?php echo CHtml::link("<i class=\"icon-plus\"></i> Novo", array("notaFiscalProdutoBarra/create", "codnotafiscal" => $model->codnotafiscal)); ?>
    </small>
</h2>

<div class="row-fluid">
    <div class="span12" style="overflow-x: scroll">
        <table class="table table-hover table-condensed table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="4">Produto</th>
                    <th colspan="5">Valores</th>
                    <th rowspan="2">CFOP</th>
                    <th colspan="2">ICMS</th>
                    <th colspan="1">ST</th>
                    <th colspan="2">IPI</th>
                    <th colspan="2">PIS</th>
                    <th colspan="2">Cofins</th>
                    <th colspan="1">CSLL</th>
                    <th colspan="1">IRPJ</th>
                    <th rowspan="2">Negócio</th>
                    <th rowspan="2"></th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>Barras</th>
                    <th>Descrição</th>
                    <th>NCM</th>
                    <th>Qtd</th>
                    <th>UM</th>
                    <th>Preço</th>
                    <th>Total</th>
                    <th>Desc</th>
                    <th>CST</th>
                    <th>Valor</th>
                    <th>Valor</th>
                    <th>CST</th>
                    <th>Valor</th>
                    <th>CST</th>
                    <th>Valor</th>
                    <th>CST</th>
                    <th>Valor</th>
                    <th>Valor</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>

                <?php
                foreach ($model->NotaFiscalProdutoBarras as $prod) {
                    $linhas = 1;
                    $rural = $prod->isOperacaoRural();
                    if ($rural) {
                        $linhas++;
                    }
                    if (!empty($prod->observacoes)) {
                        $linhas = 3;
                    }
                ?>
                    <tr>
                        <td rowspan="<?php echo $linhas; ?>">
                            <small class="muted pull-right">
                                <?php echo CHtml::encode($prod->ordem, 6); ?>
                            </small>
                        </td>
                        <td rowspan="<?php echo $linhas; ?>">
                            <small class="muted">
                                <?php echo CHtml::encode($prod->ProdutoBarra->barras, 6); ?>
                            </small>
                        </td>
                        <td rowspan="<?php echo $linhas; ?>">
                            <b><?php echo CHtml::link(CHtml::encode($prod->ProdutoBarra->descricao), array("produto/view", "id" => $prod->ProdutoBarra->codproduto)); ?></b>
                            <?php if (!empty($prod->descricaoalternativa)) : ?>
                                <br>
                                <b class="text-success">
                                    <?php echo CHtml::encode($prod->descricaoalternativa); ?>
                                </b>
                            <?php endif; ?>
                            <?php if (!empty($prod->pedido) || !empty($prod->pedidoitem)) : ?>
                                <br>
                                <b class="text-warning">
                                    Pedido:
                                    <?php echo CHtml::encode($prod->pedido); ?> -
                                    Item:
                                    <?php echo CHtml::encode($prod->pedidoitem); ?>
                                </b>
                            <?php endif; ?>
                        </td>
                        <td rowspan="<?php echo $linhas; ?>">
                            <small class='muted'>
                                <?php echo CHtml::encode(Yii::app()->format->formataNcm($prod->ProdutoBarra->Produto->Ncm->ncm)); ?>
                            </small>
                        </td>
                        <td>
                            <div class="text-right">
                                <b><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->quantidade)); ?></b>
                            </div>
                        </td>
                        <td>
                            <small class='muted'>
                                <?php echo CHtml::encode($prod->ProdutoBarra->UnidadeMedida->sigla); ?>
                            </small>
                        </td>
                        <td>
                            <div class="text-right">
                                <small>
                                    <?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->valorunitario, 10)); ?>
                                </small>
                            </div>
                        </td>
                        <td>
                            <div class="text-right">
                                <b><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->valortotal)); ?></b>
                            </div>
                        </td>
                        <td>
                            <div class="text-right">
                                <small><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->valordesconto)); ?></small>
                            </div>
                        </td>
                        <td>
                            <small class='muted'>
                                <?php echo CHtml::link(CHtml::encode($prod->codcfop), array("cfop/view", "id" => $prod->codcfop)); ?>
                            </small>
                        </td>
                        <td>
                            <small class='muted'>
                                <?php echo CHtml::encode(trim($prod->csosn . ' ' . $prod->icmscst)); ?>
                            </small>
                        </td>
                        <td>
                            <small class='muted'>
                                <div class="text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->icmsvalor)); ?></div>
                            </small>
                        </td>
                        <td>
                            <small class='muted'>
                                <div class="text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->icmsstvalor)); ?></div>
                            </small>
                        </td>
                        <td>
                            <small class='muted'>
                                <?php echo CHtml::encode($prod->ipicst); ?>
                            </small>
                        </td>
                        <td>
                            <small class='muted'>
                                <div class="text-right">
                                    <?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->ipivalor)); ?>
                                    <?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->ipidevolucaovalor)); ?>
                                </div>
                            </small>
                        </td>
                        <td>
                            <small class='muted'>
                                <?php echo CHtml::encode($prod->piscst); ?>
                            </small>
                        </td>
                        <td>
                            <small class='muted'>
                                <div class="text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->pisvalor)); ?></div>
                            </small>
                        </td>
                        <td>
                            <small class='muted'>
                                <?php echo CHtml::encode($prod->cofinscst); ?>
                            </small>
                        </td>
                        <td>
                            <small class='muted'>
                                <div class="text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->cofinsvalor)); ?></div>
                            </small>
                        </td>
                        <td>
                            <small class='muted'>
                                <div class="text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->csllvalor)); ?></div>
                            </small>
                        </td>
                        <td>
                            <small class='muted'>
                                <div class="text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->irpjvalor)); ?></div>
                            </small>
                        </td>
                        <td rowspan="<?php echo $linhas; ?>">
                            <small class='muted'>
                                <?php
                                if (isset($prod->NegocioProdutoBarra))
                                    echo CHtml::link(
                                        CHtml::encode(Yii::app()->format->formataCodigo($prod->NegocioProdutoBarra->codnegocio)),
                                        array("negocio/view", "id" => $prod->NegocioProdutoBarra->codnegocio)
                                    );
                                ?>
                            </small>
                        </td>
                        <td style="max-width: 50px" rowspan="<?php echo $linhas; ?>">
                            <a href="<?php echo Yii::app()->createUrl('notaFiscalProdutoBarra/view', array('id' => $prod->codnotafiscalprodutobarra)); ?>"><i class="icon-eye-open"></i></a>
                            <a href="<?php echo Yii::app()->createUrl('notaFiscalProdutoBarra/update', array('id' => $prod->codnotafiscalprodutobarra)); ?>"><i class="icon-pencil"></i></a>
                            <a class="delete" href="<?php echo Yii::app()->createUrl('notaFiscalProdutoBarra/delete', array('id' => $prod->codnotafiscalprodutobarra, 'ajax' => 'ajax')); ?>"><i class="icon-trash"></i></a>
                        </td>
                    </tr>

                    <?php
                    if ($rural) {
                    ?>

                        <tr>

                            <td colspan="4">
                                <small class='muted'>
                                    <div>
                                        <?php
                                        echo ($prod->certidaosefazmt) ? 'Destaca Certidão Sefaz/MT' : ''
                                        ?>
                                    </div>
                                </small>
                            </td>

                            <td colspan="3">
                                <small class="muted">
                                    Fethab:
                                </small>
                                <div class="pull-right">
                                    <small class="muted">
                                        <?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->fethabvalor)); ?>
                                    </small>
                                </div>
                            </td>

                            <td colspan="3">
                                <small class="muted">
                                    Iagro:
                                </small>
                                <div class="pull-right">
                                    <small class="muted">
                                        <?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->iagrovalor)); ?>
                                    </small>
                                </div>
                            </td>

                            <td colspan="3">
                                <small class="muted">
                                    Funrural:
                                </small>
                                <div class="pull-right">
                                    <small class="muted">
                                        <?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->funruralvalor)); ?>
                                    </small>
                                </div>
                            </td>

                            <td colspan="3">
                                <small class="muted">
                                    Senar:
                                </small>
                                <div class="pull-right">
                                    <small class="muted">
                                        <?php echo CHtml::encode(Yii::app()->format->formatNumber($prod->senarvalor)); ?>
                                    </small>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>

                    <?php
                    if (!empty($prod->observacoes)) {
                    ?>
                        <tr>
                            <td colspan="16">
                                <small class='muted'>
                                    <?php echo nl2br(CHtml::encode($prod->observacoes)); ?>
                                </small>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>


                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<br>
<h2>
    Pagamentos
    <small>
        <?php echo CHtml::link("<i class=\"icon-plus\"></i> Novo", array("notaFiscalPagamento/create", "codnotafiscal" => $model->codnotafiscal)); ?>
    </small>
</h2>
<?php
$total = 0;
$ultima = 0;
foreach ($model->NotaFiscalPagamentos as $nfp) {

?>
    <div class="row-fluid">
        <small class="span4 text-center">

            <div class="row-fluid">
                <div class="span4 text-center">

                    <!-- VISTA -->
                    <?php if ($nfp->avista): ?>
                        À Vista
                    <?php else: ?>
                        À Prazo
                    <?php endif; ?>
                    <br>

                    <!-- INTEGRADO -->
                    <?php if ($nfp->integracao): ?>
                        Integrado
                    <?php else: ?>
                        Manual
                    <?php endif; ?>

                </div>

                <div class="span4 text-center">

                    <!-- TIPO/BANDEIRA -->
                    <?php echo CHtml::encode(NotaFiscalPagamento::TIPO[$nfp->tipo]); ?>
                    <?php if ($nfp->bandeira): ?>
                        <?php echo CHtml::encode(NotaFiscalPagamento::BANDEIRA[$nfp->bandeira]); ?>
                    <?php endif; ?>

                    <!-- PESSOA INTEGRADOR -->
                    <?php if ($nfp->codpessoa): ?>
                        <br>
                        <?php echo CHtml::encode($nfp->Pessoa->fantasia); ?>
                    <?php endif; ?>


                    <!-- AUTORIZACAO -->
                    <?php if ($nfp->autorizacao): ?>
                        <br>
                        Autorização
                        <?php echo CHtml::encode($nfp->autorizacao); ?>
                    <?php endif; ?>

                </div>

                <div class="span2 text-center">

                    <!-- VALOR -->
                    <b>
                        <?php echo CHtml::encode(Yii::app()->format->formatNumber($nfp->valorpagamento)); ?>
                    </b>

                    <!--  TROCO -->
                    <?php if ($nfp->troco): ?>
                        <br>
                        Troco
                        <?php echo CHtml::encode(Yii::app()->format->formatNumber($nfp->troco)); ?>
                    <?php endif; ?>

                </div>

                <div class="span2">
                    <!-- BOTOES DE ACAO -->
                    <a href="<?php echo Yii::app()->createUrl('notaFiscalPagamento/update', array('id' => $nfp->codnotafiscalpagamento)); ?>"><i class="icon-pencil"></i></a>
                    <a class="delete" href="<?php echo Yii::app()->createUrl('notaFiscalPagamento/delete', array('id' => $nfp->codnotafiscalpagamento)); ?>"><i class="icon-trash"></i></a>
                </div>

            </div>
            <br>

        </small>
    </div>
<?php
}
?>
<br>
<h2>
    Duplicatas
    <small>
        <?php echo CHtml::link("<i class=\"icon-plus\"></i> Novo", array("notaFiscalDuplicatas/create", "codnotafiscal" => $model->codnotafiscal)); ?>
    </small>
</h2>
<div class="row-fluid">
    <?php
    $total = 0;
    $ultima = 0;
    foreach ($model->NotaFiscalDuplicatass as $dup) {
        $total += $dup->valor;
        $ultima = $dup->valor;
    ?>
        <small class="span2 text-center">
            <?php echo CHtml::encode($dup->fatura); ?><br>
            <b><?php echo CHtml::encode($dup->vencimento); ?></b><br>
            <b><?php echo CHtml::encode(Yii::app()->format->formatNumber($dup->valor)); ?></b>
            <div class="pull-right">
                <a href="<?php echo Yii::app()->createUrl('notaFiscalDuplicatas/update', array('id' => $dup->codnotafiscalduplicatas)); ?>"><i class="icon-pencil"></i></a>
                <a class="delete" href="<?php echo Yii::app()->createUrl('notaFiscalDuplicatas/delete', array('id' => $dup->codnotafiscalduplicatas)); ?>"><i class="icon-trash"></i></a>
            </div>
        </small>
    <?php
    }

    if ($total != $ultima) {
    ?>
        <small class="span2 text-center">
            <b>Total <br> Duplicatas </b><br>
            <b><?php echo CHtml::encode(Yii::app()->format->formatNumber($total)); ?></b>
        </small>
    <?php
    }
    ?>
</div>
<br>
<h2>
    Notas Fiscais Referenciadas
    <small>
        <?php echo CHtml::link("<i class=\"icon-plus\"></i> Novo", array("notaFiscalReferenciada/create", "codnotafiscal" => $model->codnotafiscal)); ?>
    </small>
</h2>
<?php
$total = 0;
$ultima = 0;
foreach ($model->NotaFiscalReferenciadas as $nfr) {

?>
    <div class="row-fluid">
        <small class="span4 text-center">
            <b><?php echo CHtml::encode(Yii::app()->format->formataChaveNfe($nfr->nfechave)); ?></b>
            <div class="pull-right">
                <a href="<?php echo Yii::app()->createUrl('notaFiscalReferenciada/update', array('id' => $nfr->codnotafiscalreferenciada)); ?>"><i class="icon-pencil"></i></a>
                <a class="delete" href="<?php echo Yii::app()->createUrl('notaFiscalReferenciada/delete', array('id' => $nfr->codnotafiscalreferenciada)); ?>"><i class="icon-trash"></i></a>
            </div>
        </small>
    </div>
<?php
}
?>
<br>
<h2>Observações</h2>
<?php echo nl2br(CHtml::encode($model->observacoes)); ?>
<br>
<h2>
    Cartas de Correção
    <small>
        <a href="#modalCartaCorrecao" role="button" class="" data-toggle="modal"><i class="icon-plus"></i> Nova</a>
    </small>
</h2>

<!-- Modal -->
<div id="modalCartaCorrecao" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Digite o texto da Carta de Correção</h3>
    </div>
    <div class="modal-body">
        <textarea id="txtCartaCorrecao" style="width: 97%; height: 200px"></textarea>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <button class="btn btn-primary" data-dismiss="modal" id="btnSalvarCartaCorrecao">Salvar</button>
    </div>
</div>

<?php
foreach ($model->NotaFiscalCartaCorrecaos as $cc) {
?>
    <div class="registro">
        <small class="row-fluid">
            <b class="span2">
                <?php echo CHtml::encode($cc->protocolodata); ?>
            </b>
            <div class="span2 muted">
                <?php echo CHtml::encode($cc->protocolo); ?>
            </div>
            <div class="span1 muted text-center">
                <?php echo CHtml::encode($cc->sequencia); ?> /
                <?php echo CHtml::encode($cc->lote); ?>
            </div>
            <span class="span7">
                <?php echo nl2br(CHtml::encode($cc->texto)); ?>
            </span>
        </small>
    </div>
<?php
}
?>

<br>
<?php $this->widget('UsuarioCriacao', array('model' => $model)); ?>
