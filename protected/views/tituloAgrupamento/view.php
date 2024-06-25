<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Agrupamento de Títulos';
$this->breadcrumbs = array(
    'Agrupamento de Títulos' => array('index'),
    Yii::app()->format->formataCodigo($model->codtituloagrupamento),
);

$this->menu = array(
    array('label' => 'Listagem', 'icon' => 'icon-list-alt', 'url' => array('index')),
    array('label' => 'Novo', 'icon' => 'icon-plus', 'url' => array('create')),
    // array(
    // 	'label'=>'Imprimir Boletos',
    // 	'icon'=>'icon-barcode',
    // 	'url'=>array('titulo/imprimeboleto', 'codtituloagrupamento'=>$model->codtituloagrupamento),
    // 	'linkOptions'=>array('id'=>'btnMostrarBoleto'),
    // 	'visible'=>(empty($model->cancelamento))
    // ),
    //array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codtituloagrupamento)),
    //array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
    //array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
    array(
        'label' => 'Gerar Nota Fiscal',
        'icon' => 'icon-globe',
        'url' => '#',
        'linkOptions' => array('id' => 'btnGerarNotaFiscal'),
        //'visible'=>($model->codnegociostatus == NegocioStatus::FECHADO)
    ),
    array(
        'label' => 'Relatório',
        'icon' => 'icon-print',
        'url' => array('relatorio', 'id' => $model->codtituloagrupamento),
        'linkOptions' => array('id' => 'btnMostrarRelatorio'),
        'visible' => (empty($model->cancelamento))
    ),
    array(
        'label' => 'Estornar',
        'icon' => 'icon-thumbs-down',
        'url' => '#',
        'linkOptions' => array('id' => 'btnExcluir'),
        'visible' => (empty($model->cancelamento))
    ),
    array(
        'label' => 'Email',
        'icon' => 'icon-envelope',
        'url' => '#',
        'linkOptions' => array('id' => 'btnEmail'),
        'visible' => (empty($model->cancelamento))
    ),
);

Yii::app()->clientScript->registerCoreScript('yii');

$emails = [];
foreach ($model->Pessoa->PessoaEmails as $pe) {
    if (!$pe->cobranca) {
        continue;
    }
    $emails[] = $pe->email;
}
$email = implode(',', $emails);

function mensagem($pais, $ddd, $telefone, $email)
{
    $texto = urlencode("Olá!

Aqui é do departamento de Cobrança da MG Papelaria!

Acabamos de enviar os documentos do fechamento de(s) sua(s) compra(s) no endereço de e-mail abaixo:

{$email}

Por favor, poderia confirmar se você recebeu?");
    return "https://wa.me/{$pais}{$ddd}{$telefone}?text={$texto}";
}


?>
<script type="text/javascript">
    /*<![CDATA[*/

    function gerarNotaFiscal(modelo) {

        $.getJSON("<?php echo Yii::app()->createUrl('tituloAgrupamento/gerarNotaFiscal') ?>", {
                id: <?php echo $model->codtituloagrupamento ?>,
                modelo: modelo,
            })
            .done(function(data) {

                if (data.Retorno != 1) {
                    bootbox.alert(data.Mensagem);
                    return false;
                }

                location.reload();

            })
            .fail(function(jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                bootbox.alert(err);
            });
    }


    function emailEnviar(destinatario) {
        $.ajax({
            type: 'POST',
            url: "<?php echo MGSPA_API_URL; ?>titulo/agrupamento/<?php echo $model->codtituloagrupamento; ?>/mail",
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            },
            data: {
                destinatario: destinatario
            }
        }).done(function(resp) {
            if (resp.sucesso) {
                var css = "text-success";
            } else {
                var css = "text-error"
            }
            mensagem = resp.mensagem;
            bootbox.alert(mensagem);
        }).fail(function(jqxhr, textStatus, error) {
            console.log(textStatus);
            console.log(error);
            console.log(jqxhr);
            var resp = jQuery.parseJSON(jqxhr.responseText);
            bootbox.alert(resp.message);
        });
    }



    function emailPerguntar() {
        bootbox.prompt("Digite o endereço de e-mail:", "Cancelar", "OK", function(result) {
            if (result) {
                emailEnviar(result);
            }
        }, '<?php echo $email; ?>');
    }

    $(document).ready(function() {

        //abre janela boleto
        var frameSrcBoleto = $('#btnMostrarBoleto').attr('href');
        $('#btnMostrarBoleto').click(function(event) {
            event.preventDefault();
            $('#modalBoleto').on('show', function() {
                $('#frameBoleto').attr("src", frameSrcBoleto);
            });
            $('#modalBoleto').modal({
                show: true
            })
            $('#modalBoleto').css({
                'width': '80%',
                'margin-left': 'auto',
                'margin-right': 'auto',
                'left': '10%'
            });
        });

        //imprimir Boleto
        $('#btnImprimirBoleto').click(function(event) {
            window.frames["frameBoleto"].focus();
            window.frames["frameBoleto"].print();
        });

        //abre janela relatorio
        var frameSrcRelatorio = $('#btnMostrarRelatorio').attr('href');
        $('#btnMostrarRelatorio').click(function(event) {
            event.preventDefault();
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
        });

        jQuery('body').on('click', '#btnExcluir', function() {
            bootbox.confirm("Estornar este Agrupamento?", function(result) {
                if (result)
                    jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('tituloAgrupamento/estorna', array('id' => $model->codtituloagrupamento)) ?>", {});
            });
        });

        $('#btnGerarNotaFiscal').click(function(event) {
            event.preventDefault();
            $('#modalModeloNotaFiscal').modal({
                show: true,
                keyboard: true
            })
        });

        $('#btnGerarNfce').click(function(event) {
            event.preventDefault();
            gerarNotaFiscal(<?php echo NotaFiscal::MODELO_NFCE; ?>);
        });

        $('#btnGerarNfe').click(function(event) {
            event.preventDefault();
            gerarNotaFiscal(<?php echo NotaFiscal::MODELO_NFE; ?>);
        });


        $('#btnEmail').click(function(event) {
            event.preventDefault();
            emailPerguntar();
        });

    });
    /*]]>*/
</script>

<div id="modalBoleto" class="modal hide fade" tabindex="-1" role="dialog">
    <div class="modal-header">
        <div class="pull-right">
            <button class="btn btn-primary" id="btnImprimirBoleto">Imprimir</button>
            <button class="btn" data-dismiss="modal">Fechar</button>
        </div>
        <h3>Boleto</h3>
    </div>
    <div class="modal-body">
        <iframe src="" id="frameBoleto" name="frameBoleto" width="99.6%" height="400" frameborder="0"></iframe>
    </div>
</div>

<div id="modalModeloNotaFiscal" class="modal hide fade" tabindex="-1" role="dialog">
    <div class="modal-header">
        <h3>Gerar qual modelo de nota Fiscal?</h3>
    </div>
    <div class="modal-body">
        <div class="pull-right">
            <button class="btn" data-dismiss="modal" id="btnGerarNfce">NFC-e (Cupom)</button>
            <button class="btn btn-primary" data-dismiss="modal" id="btnGerarNfe">NF-e (Nota)</button>
            <button class="btn" data-dismiss="modal" id="">Cancelar</button>
        </div>
    </div>
</div>


<div id="modalRelatorio" class="modal hide fade" tabindex="-1" role="dialog">
    <div class="modal-header">
        <div class="pull-right">
            <button class="btn" data-dismiss="modal">Fechar</button>
        </div>
        <h3>Relatório de Fechamento</h3>
    </div>
    <div class="modal-body">
        <iframe src="" id="frameRelatorio" name="frameRelatorio" width="99.6%" height="400" frameborder="0"></iframe>
    </div>
</div>


<h1>Agrupamento de Títulos <?php echo Yii::app()->format->formataCodigo($model->codtituloagrupamento); ?></h1>

<?php if (!empty($model->cancelamento)) : ?>
    <div class="alert alert-danger">
        <b>Estornado em <?php echo CHtml::encode($model->cancelamento); ?> </b>
    </div>
<?php endif; ?>

<div class="row-fluid">
    <div class="span4">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => 'Pessoa',
                    'value' => CHtml::link(CHtml::encode($model->Pessoa->fantasia), array('pessoa/view', 'id' => $model->codpessoa)),
                    'type' => 'raw'
                ),
                'emissao',
                array(
                    'label' => 'Total',
                    'value' => Yii::app()->format->formatNumber($model->valor) . " " . $model->operacao,
                ),
                'observacao',
            ),
        ));
        $this->widget('UsuarioCriacao', array('model' => $model));
        ?>
    </div>
    <div class="span4">
        <table class="detail-view table table-striped table-condensed" id="yw0">
            <?php foreach ($model->Pessoa->PessoaTelefones as $tel) : ?>
                <tr class="odd">
                    <th>
                        <?php echo ($tel->tipo == 1) ? "Fixo" : "Celular" ?>
                    </th>
                    <td>
                        <a href="<?php echo mensagem($tel->pais, $tel->ddd, $tel->telefone, $email); ?>" target="WhatsApp">
                            +<?php echo $tel->pais ?>
                            (<?php echo $tel->ddd ?>)
                            <?php echo $tel->telefone ?>
                            <!-- <img src="https://logodownload.org/wp-content/uploads/2015/04/whatsapp-logo-png.png" style="max-height: 15px" /> -->
                            <?php echo $tel->apelido ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <small class="muted">
            Clique em um número de telefone acima para enviar a mensagem de confirmação de recebimento dos documentos por email.
        </small>
    </div>

</div>



<?php

$command = Yii::app()->db->createCommand('
	SELECT distinct nfpb.codnotafiscal
	  FROM tbltituloagrupamento ta
	 INNER JOIN tblmovimentotitulo mt ON (mt.codtituloagrupamento = ta.codtituloagrupamento)
	 INNER JOIN tbltitulo t ON (t.codtitulo = mt.codtitulo)
	 INNER JOIN tblnegocioformapagamento nfp ON (nfp.codnegocioformapagamento = t.codnegocioformapagamento)
	 INNER JOIN tblnegocioprodutobarra npb ON (npb.codnegocio = nfp.codnegocio)
	 INNER JOIN tblnotafiscalprodutobarra nfpb ON (nfpb.codnegocioprodutobarra = npb.codnegocioprodutobarra)
	 WHERE ta.codtituloagrupamento = :codtituloagrupamento
	');

$command->params = array("codtituloagrupamento" => $model->codtituloagrupamento);

$codnotas = $command->queryAll();


if (!empty($codnotas)) {
?>
    <h3>Nota Fiscal</h3>
<?php
}

foreach ($codnotas as $codnota) {
    $nota = NotaFiscal::model()->findByPk($codnota);

    $css_label = "";
    $staus = "&nbsp";
    $css = "";

    switch ($nota->codstatus) {
        case NotaFiscal::CODSTATUS_DIGITACAO;
            $css_label = "label-warning";
            $staus = "D";
            break;

        case NotaFiscal::CODSTATUS_AUTORIZADA;
            $css_label = "label-success";
            $staus = "A";
            break;

        case NotaFiscal::CODSTATUS_LANCADA;
            $css_label = "label-info";
            $staus = "L";
            break;

        case NotaFiscal::CODSTATUS_NAOAUTORIZADA;
            $css = "alert-info";
            $staus = "E";
            break;

        case NotaFiscal::CODSTATUS_INUTILIZADA;
            $css = "alert-danger";
            $css_label = "label-important";
            $staus = "I";
            break;

        case NotaFiscal::CODSTATUS_CANCELADA;
            $css = "alert-danger";
            $css_label = "label-important";
            $staus = "C";
            break;
    }
?>
    <div class="registro <?php echo $css; ?>">
        <span class="row-fluid">
            <small class="span1 muted">
                <?php echo CHtml::encode($nota->Filial->filial); ?>
            </small>
            <div class="span2">
                <?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataNumeroNota($nota->emitida, $nota->serie, $nota->numero, $nota->modelo)), array('notaFiscal/view', 'id' => $nota->codnotafiscal)); ?>
            </div>
            <div class="span1">
                <?php echo CHtml::encode(Yii::app()->format->formatNumber($nota->valortotal)); ?>
            </div>
            <small class="span2 muted">
                <?php echo CHtml::encode($nota->emissao); ?> &nbsp;&nbsp;
                <?php echo CHtml::encode($nota->NaturezaOperacao->naturezaoperacao); ?>
            </small>
            <small class="span4">
                <?php echo CHtml::link(
                    CHtml::encode($nota->Pessoa->fantasia),
                    array('pessoa/view', 'id' => $nota->codpessoa)
                );
                ?>
                <small class="label <?php echo $css_label; ?> pull-right">
                    <?php echo $nota->status; ?>
                </small>
            </small>
            <div class="span2">
                <?php $this->widget('MGNotaFiscalBotoes', array('model' => $nota)); ?>
            </div>
        </span>
    </div>
<?
}
?>

<h3>Títulos Gerados</h3>

<?php

foreach ($model->Titulos as $titulo) {
    $css_valor = ($titulo->operacao == "DB") ? "text-success" : "text-warning";
?>
    <div class="registro">
        <small class="row-fluid">
            <span class="span1 <?php echo ($titulo->gerencial) ? "text-warning" : "text-success"; ?>">
                <?php echo CHtml::encode($titulo->Filial->filial); ?>
            </span>
            <span class="span2 muted">
                <?php echo CHtml::link(CHtml::encode($titulo->numero), array('titulo/view', 'id' => $titulo->codtitulo)); ?>
            </span>
            <b class="span2 text-right <?php echo $css_valor; ?>">
                <?php echo Yii::app()->format->formatNumber($titulo->valor); ?>
                <?php echo $titulo->operacao; ?>
            </b>
            <b class="span1">
                <?php echo $titulo->vencimento; ?>
            </b>
            <span class="span3 muted">
                <?php echo CHtml::link($titulo->Pessoa->fantasia, array('pessoa/view', 'id' => $titulo->codpessoa)); ?>
            </span>
            <span class="span1">
                <?php echo (isset($titulo->Portador)) ? CHtml::encode($titulo->Portador->portador) : ""; ?>
            </span>
            <span class="span2">
                <?php echo ($titulo->boleto) ? "Boleto " . CHtml::encode($titulo->nossonumero) : ""; ?>
            </span>
        </small>
    </div>
<?
}

unset($titulo)
?>

<h3>Títulos Baixados</h3>

<?php

foreach ($model->MovimentoTitulos as $mov) {
    if ($mov->Titulo->codtituloagrupamento == $model->codtituloagrupamento)
        continue;

    if ($mov->TipoMovimentoTitulo->estorno)
        continue;

    $operacao = ($mov->credito > $mov->debito) ? "CR" : "DB";
    $css_valor = ($operacao == "DB") ? "text-success" : "text-warning";
?>
    <div class="registro">
        <small class="row-fluid">
            <span class="span1 <?php echo ($mov->Titulo->gerencial) ? "text-warning" : "text-success"; ?>">
                <?php echo CHtml::encode($mov->Titulo->Filial->filial); ?>
            </span>
            <span class="span2 muted">
                <?php echo CHtml::link(CHtml::encode($mov->Titulo->numero), array('titulo/view', 'id' => $mov->Titulo->codtitulo)); ?>
            </span>
            <small class="span1 muted text-right">
                <?php echo CHtml::encode($mov->TipoMovimentoTitulo->tipomovimentotitulo); ?>
            </small>
            <b class="span1 text-right <?php echo $css_valor; ?>">
                <?php echo Yii::app()->format->formatNumber(abs($mov->debito - $mov->credito)); ?>
                <?php echo $operacao; ?>
            </b>
            <b class="span1">
                <?php echo $mov->Titulo->vencimento; ?>
            </b>
            <span class="span3 muted">
                <?php echo CHtml::link(CHtml::encode($mov->Titulo->Pessoa->fantasia), array('pessoa/view', 'id' => $mov->Titulo->codpessoa)); ?>
            </span>
            <span class="span1">
                <?php echo (isset($mov->Titulo->Portador)) ? CHtml::encode($mov->Titulo->Portador->portador) : ""; ?>
            </span>
            <span class="span2">
                <?php echo ($mov->Titulo->boleto) ? "Boleto " . CHtml::encode($mov->Titulo->nossonumero) : ""; ?>
            </span>
        </small>
    </div>
<?
}

?>