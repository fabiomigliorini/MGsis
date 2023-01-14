<?php

/**
 * @var NfeTerceiro $model
 */


$this->pagetitle = Yii::app()->name . ' - Detalhes da NFe de Terceiro';
$this->breadcrumbs=array(
    'NFe de Terceiros'=>array('index'),
    $model->nfechave,
);

$interestadual = false;
if ($model->codpessoa && $model->codfilial) {
    if ($model->Pessoa->Cidade->codestado != $model->Filial->Pessoa->Cidade->codestado) {
        $interestadual = true;
    }
}

$this->menu=array(
    array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
    //array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
    array('label'=>'Download Nfe', 'icon'=>'icon-download-alt', 'url'=>'#', 'linkOptions'=>  array('id'=>'btnDownloadNfe'), 'visible'=>empty($model->codnotafiscal) ),
    array('label'=>'Informar Detalhes', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnfeterceiro), 'visible'=>$model->podeEditar()),
    array('label'=>'Importar', 'icon'=>'icon-thumbs-up', 'url'=>'#', 'visible'=>$model->podeEditar(), 'linkOptions'=>  array('id'=>'btnImportar')),
    array('label'=>'XML (Antigo)', 'icon'=>' icon-file', 'url'=>array('NFePHPNovo/visualizaXml','codnfeterceiro'=>$model->codnfeterceiro), 'linkOptions'=>  array('id'=>'btnArquivoXml')),
    array('label'=>'XML (Novo)', 'icon'=>' icon-file', 'url'=>MGSPA_API_URL . 'nfe-terceiro/' . $model->codnfeterceiro . '/xml', 'linkOptions'=>  array('target'=>'_blank')),
    array('label'=>'Danfe', 'icon'=>' icon-file', 'url'=>MGSPA_API_URL . 'nfe-terceiro/' . $model->codnfeterceiro . '/danfe', 'linkOptions'=>  array('target'=>'_blank')),
    array('label'=>'ICMS ST', 'icon'=>'icon-thumbs-down', 'url'=>array('icmsst','id'=>$model->codnfeterceiro), 'visible'=>$interestadual),
    //array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>  array('id'=>'btnExcluir')),
    //array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

?>
<script type="text/javascript">
/*<![CDATA[*/

function formataMensagem(data)
{
  var mensagem = '';

  if (data.retorno)
    classe = 'alert alert-success';
  else
    classe = 'alert alert-error';

  if (data.xMotivo == null)
    data.xMotivo = 'Erro';

  mensagem += '<h3 class="' + classe + '">';

  if (data.cStat != null)
    mensagem += data.cStat + ' - ';

  mensagem += data.xMotivo + '</h3>';

  if (data.ex != null)
    mensagem += '<pre>' + data.ex + '</pre>';

  if (!$.isEmptyObject(data.aResposta))
    mensagem +=
      '<div class="accordion" id="accordion2"> ' +
      '  <div class="accordion-group"> ' +
      '  <div class="accordion-heading"> ' +
      '    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne"> ' +
      '    Mostrar mais detalhes... ' +
      '    </a> ' +
      '  </div> ' +
      '  <div id="collapseOne" class="accordion-body collapse"> ' +
      '    <div class="accordion-inner"> ' +
      '    <pre>' + JSON.stringify(data.aResposta, null, '\t') + '</pre>' +
      '    </div> ' +
      '  </div> ' +
      ' </div> ' +
      '</div> ';

  return mensagem;
}


function enviarEventoManifestacao(indManifestacao, justificativa)
{
  var codnfeterceiro = '<?php echo $model->codnfeterceiro ?>';
  var url = "<?php echo MGSPA_API_URL; ?>nfe-terceiro/" + codnfeterceiro + "/manifestacao";
  var data = {
    indmanifestacao: indManifestacao,
  };
  if (justificativa != null) {
    data.justificativa = justificativa;
  }
  console.log(data);
  $.ajax({
    type: 'POST',
    url: url,
    data: data,
    headers: {
      "X-Requested-With":"XMLHttpRequest"
    },
  }).done(function(resp) {
    if (resp.xMotivo != undefined) {
      bootbox.alert(resp.cStat + ' - ' + resp.xMotivo, function() {
        location.reload();
      });
      return;
    }
    bootbox.alert("NFe Manifestada!", function() {
      location.reload();
    });
  }).fail(function( jqxhr, textStatus, error ) {
    var mensagem = 'Falha ao Manifestar NFe!';
    var resp = jQuery.parseJSON(jqxhr.responseText);
    if (resp.message != undefined) {
      mensagem += '<br>' + resp.message;
    }
    if (resp.errors != undefined) {
      for (var field in resp.errors) {
        resp.errors[field].forEach((error, i) => {
          mensagem += '<BR>' + error;
        });
      }
    }
    bootbox.alert(mensagem, function() {
      location.reload();
    });
  });
}

function downloadNfe ()
{

  $.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/download')?>", {
    codnfeterceiro: <?php echo $model->codnfeterceiro; ?>
  })
    .done(function(data) {
      var mensagem = formataMensagem(data);
      bootbox.alert(mensagem, function() {
        location.reload();
      });
    })
    .fail(function( jqxhr, textStatus, error ) {
      bootbox.alert(error, function() {
        location.reload();
      });
    });

}

function btnRevisaoClick(revisada) {
  bootbox.confirm("Tem Certeza?", function(result) {
    if (!result) {
      return;
    }
    $.ajax({
      url: "<?php echo Yii::app()->createUrl('nfeTerceiro/revisao')?>",
      data: {
        id: <?php echo $model->codnfeterceiro ?>,
        revisada: revisada
      },
    }).done(function(resp) {
      location.reload();
    }).fail(function( jqxhr, textStatus, error ) {
      $.notify("Erro ao marcar revisão da NFe!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
    });
  });
}

function btnConferenciaClick(conferencia) {
  bootbox.confirm("Tem Certeza?", function(result) {
    if (!result) {
      return;
    }
    $.ajax({
      url: "<?php echo Yii::app()->createUrl('nfeTerceiro/conferencia')?>",
      data: {
        id: <?php echo $model->codnfeterceiro ?>,
        conferencia: conferencia
      },
    }).done(function(resp) {
      location.reload();
    }).fail(function( jqxhr, textStatus, error ) {
      $.notify("Erro ao marcar NFe como conferida!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
    });
  });
}

$(document).ready(function(){

  $('#btnManifestacaoCiencia').click(function(e) {
    e.preventDefault();
    bootbox.confirm("Enviar à Sefaz a <b class='lead text-warning'>Ciência da Operação</b>?<br><br>Tenha cuidado ao confirmar, pois esta ação <b>não poderá ser desfeita</b>!", function(result) {
      if (result)
        enviarEventoManifestacao (<?php echo NfeTerceiro::INDMANIFESTACAO_CIENCIA; ?>, null);
    });
  });

  $('#btnManifestacaoRealizada').click(function(e) {
    e.preventDefault();
    bootbox.confirm("Enviar à Sefaz a <b class='lead text-success'>Confirmação da Operação</b>?<br><br>Tenha cuidado ao confirmar, pois esta ação <b>não poderá ser desfeita</b>!", function(result) {
      if (result)
        enviarEventoManifestacao (<?php echo NfeTerceiro::INDMANIFESTACAO_REALIZADA; ?>, null);
    });
  });

  $('#btnManifestacaoDesconhecida').click(function(e) {
    e.preventDefault();
    bootbox.confirm("Enviar à Sefaz o comunidado de <b class='lead text-error'>Desconhecimento da Operação</b>?<br><br>Tenha cuidado ao confirmar, pois esta ação <b>não poderá ser desfeita</b>!", function(result) {
      if (result)
        enviarEventoManifestacao (<?php echo NfeTerceiro::INDMANIFESTACAO_DESCONHECIDA; ?>, null);
    });
  });

  $('#btnManifestacaoNaoRealizada').click(function(e) {
    e.preventDefault();
    bootbox.confirm("Enviar à Sefaz o comunidado de <b class='lead text-error'>Operação não Realizada</b>?<br><br>Tenha cuidado ao confirmar, pois esta ação <b>não poderá ser desfeita</b>!", function(result) {
      if (result)
      {
        bootbox.prompt("Digite a justificativa:", "Cancelar", "OK", function(result)
        {
          if (result === null)
            return;
          enviarEventoManifestacao (<?php echo NfeTerceiro::INDMANIFESTACAO_NAOREALIZADA; ?>, result);
        });
        //console.log('btnManifestacaoNaoRealizada');
      }
    });
  });

  jQuery('body').on('click','#btnExcluir',function(e) {
    e.preventDefault();
    bootbox.confirm("Excluir este registro?", function(result) {
      if (result)
        jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('nfeTerceiro/delete', array('id' => $model->codnfeterceiro))?>",{});
    });
  });

  jQuery('body').on('click','#btnImportar',function(e) {
    e.preventDefault();
    bootbox.confirm("Importar essa NFe de Terceiro?", function(result) {
      if (result)
        jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('nfeTerceiro/importar', array('id'=>$model->codnfeterceiro))?>",{});
    });
  });

  jQuery('body').on('click','#btnDownloadNfe',function(e) {
    e.preventDefault();
    bootbox.confirm("Efetuar o Download da NFe?", function(result) {
      if (result)
        downloadNfe();
    });
  });
});
/*]]>*/
</script>

<?php
    $manifestacao = $model->getIndManifestacaoDescricao();
    if (empty($manifestacao)) {
      $manifestacao = 'Sem Manifestação';
    }
    $cssmanif = '';
    switch ($model->indmanifestacao) {
        case NfeTerceiro::INDMANIFESTACAO_CIENCIA:
            $cssmanif = 'btn-warning';
            break;
        case NfeTerceiro::INDMANIFESTACAO_REALIZADA:
            $cssmanif = 'btn-success';
            break;
        case NfeTerceiro::INDMANIFESTACAO_DESCONHECIDA:
        case NfeTerceiro::INDMANIFESTACAO_NAOREALIZADA:
            $cssmanif = 'btn-danger';
            break;
    }

?>

<h1>
  <?php echo Yii::app()->format->formataChaveNfe($model->nfechave); ?>
</h1>
<div style="margin-bottom: 15px">
  <div class="btn-group">
    <a class="btn dropdown-toggle <?php echo $cssmanif; ?>" data-toggle="dropdown" href="#">
      <?php echo $manifestacao; ?>
      &nbsp
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
      <?php if ($model->indmanifestacao != NfeTerceiro::INDMANIFESTACAO_CIENCIA): ?>
        <li>
          <a href='#' class='' id="btnManifestacaoCiencia">
            <span class='badge badge-warning'>C</span>
            Ciência da Operação
          </a>
        </li>
      <?php endif; ?>
      <?php if ($model->indmanifestacao != NfeTerceiro::INDMANIFESTACAO_REALIZADA): ?>
        <li>
          <a href='#' class='' id="btnManifestacaoRealizada">
            <span class='badge badge-success'>R</span>
            Operação Realizada
          </a>
        </li>
      <?php endif; ?>
      <?php if ($model->indmanifestacao != NfeTerceiro::INDMANIFESTACAO_DESCONHECIDA): ?>
        <li>
          <a class='' href='#' id="btnManifestacaoDesconhecida">
            <span class='badge badge-important'>D</span>
            Desconhecida
          </a>
        </li>
      <?php endif; ?>
      <?php if ($model->indmanifestacao != NfeTerceiro::INDMANIFESTACAO_NAOREALIZADA): ?>
        <li>
          <a class='' href='#' id="btnManifestacaoNaoRealizada">
            <span class='badge badge-important'>N</span>
            Não Realizada
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
  <div class="btn-group">
    <a class="btn dropdown-toggle <?php echo (empty($model->revisao)?'btn-warning':'btn-success') ?>" data-toggle="dropdown" href="#">
      <?php echo (empty($model->revisao)?'Não Revisada':'Revisada'); ?>
      <?php if (!empty($model->codusuariorevisao)): ?>
        por <?php echo $model->UsuarioRevisao->usuario; ?>
      <?php endif; ?>
      <?php if (!empty($model->revisao)): ?>
        em <?php echo $model->revisao; ?>
      <?php endif; ?>
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
      <?php if (empty($model->revisao)): ?>
        <li>
          <a href='#' class='' id="btnRevisaoTrue" onclick="btnRevisaoClick(true)">
            <span class='badge badge-success'>&#10004;</span>
            Marcar como revisada
          </a>
        </li>
      <?php else: ?>
        <li>
          <a href='#' class='' id="btnRevisaoFalse" onclick="btnRevisaoClick(false)">
            <span class='badge badge-warning'>?</span>
            Marcar como não revisada
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
  <div class="btn-group">
    <a class="btn dropdown-toggle <?php echo (empty($model->conferencia)?'btn-warning':'btn-success') ?>" data-toggle="dropdown" href="#">
      <?php echo (empty($model->conferencia)?'Não Conferida':'Conferida'); ?>
      <?php if (!empty($model->codusuarioconferencia)): ?>
        por <?php echo $model->UsuarioConferencia->usuario; ?>
      <?php endif; ?>
      <?php if (!empty($model->conferencia)): ?>
        em <?php echo $model->conferencia; ?>
      <?php endif; ?>
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
      <?php if (empty($model->conferencia)): ?>
        <li>
          <a href='#' class='' id="btnConferenciaTrue" onclick="btnConferenciaClick(true)">
            <span class='badge badge-success'>&#10004;</span>
            Marcar como Conferida
          </a>
        </li>
      <?php else: ?>
        <li>
          <a href='#' class='' id="btnConferenciaFalse" onclick="btnConferenciaClick(false)">
            <span class='badge badge-warning'>?</span>
            Marcar como não conferida
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</div>


<div class="row-fluid">
  <div class="span3">
    <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                'serie',
                'numero',
            ),
        ));

        ?>
  </div>
  <div class="span6">
    <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                array(
                    'name'=>'codfilial',
                    'value'=>isset($model->Filial) ? CHtml::link(CHtml::encode($model->Filial->filial), array("filial/view", "id"=>$model->codfilial)) : null,
                    'type'=>"raw",
                ),
                array(
                    'name'=>'codpessoa',
                    'value'=>isset($model->Pessoa) ? CHtml::link(CHtml::encode($model->Pessoa->fantasia), array("pessoa/view", "id"=>$model->codpessoa)) : null,
                    'type'=>"raw",
                ),
            ),
        ));

        ?>
  </div>
  <div class="span3">
    <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                'emissao',
                array(
                    'name'=>'valortotal',
                    'value'=>Yii::app()->format->formatNumber($model->valortotal),
                ),
            ),
        ));

        ?>
  </div>
</div>


<?php if (!empty($model->NfeTerceiroItems)): ?>
<h3>Itens</h3>
<div id="ListagemItens">
  <?php
    $this->renderPartial("_view_itens", array("model"=>$model))
    ?>
</div>
<br>
<?php endif; ?>
<h3>Detalhes</h3>

<small class="row-fluid">
  <div class="span5">
    <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                array(
                    'name' => 'codnfeterceiro',
                    'value' => Yii::app()->format->formataCodigo($model->codnfeterceiro),
                ),
                array(
                    'name'=>'natureza',
                    'value'=>$model->natureza,
                    // 'type'=>"raw",
                ),
                array(
                    'name'=>'codnaturezaoperacao',
                    'value'=>isset($model->NaturezaOperacao) ? CHtml::encode($model->NaturezaOperacao->naturezaoperacao) : null,
                    'type'=>"raw",
                ),
                array(
                    'name'=>'codnotafiscal',
                    'value'=>isset($model->NotaFiscal) ? CHtml::link(CHtml::encode(Yii::app()->format->formataNumeroNota($model->NotaFiscal->emitida, $model->NotaFiscal->serie, $model->NotaFiscal->numero, $model->NotaFiscal->modelo)), array("notaFiscal/view", "id"=>$model->codnotafiscal)) : null,
                    'type'=>"raw",

                ),
                array(
                    'name'=>'codnegocio',
                    'value'=>(!empty($model->codnegocio)) ? CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($model->codnegocio)), array("negocio/view", "id"=>$model->codnegocio)) . ' - ' . $model->Negocio->NegocioStatus->negociostatus : null,
                    'type'=>"raw",

                ),
                'entrada',
                'informacoes',
            ),
        ));

        ?>
  </div>
  <div class="span4">
    <?php

        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                'emitente',
                array(
                    'name' => 'cnpj',
                    'value' => Yii::app()->format->formataCnpjCpf($model->cnpj, false)
                ),
                'ie',
                'nfedataautorizacao',
                'nsu',
                array(
                    'name' => 'ignorada',
                    'value' => ($model->ignorada) ? 'Sim' : 'Não',
                ),
                array(
                    'name' => 'indsituacao',
                    'value' => $model->getIndSituacaoDescricao(),
                ),
                array(
                    'name' => 'indmanifestacao',
                    'value' => $manifestacao,
                ),
                array(
                    'name' => 'justificativa',
                    'value' => nl2br(CHtml::encode($model->justificativa)),
                    'type' => 'raw',
                ),

            ),
        ));

        ?>
  </div>
  <div class="span3 pull-right">
    <?php
        $outros = $model->totalComplemento();
        $totalgeral = $model->valortotal + $outros;
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                array(
                        'name' => 'valorprodutos',
                        'value' => Yii::app()->format->formatNumber($model->valorprodutos),
                ),
                array(
                        'name' => 'valorfrete',
                        'value' => Yii::app()->format->formatNumber($model->valorfrete),
                ),
                array(
                        'name' => 'valorseguro',
                        'value' => Yii::app()->format->formatNumber($model->valorseguro),
                ),
                array(
                        'name' => 'valordesconto',
                        'value' => Yii::app()->format->formatNumber($model->valordesconto),
                ),
                array(
                        'name' => 'valoroutras',
                        'value' => Yii::app()->format->formatNumber($model->valoroutras),
                ),
                array(
                        'name' => 'icmsbase',
                        'value' => Yii::app()->format->formatNumber($model->icmsbase),
                ),
                array(
                        'name' => 'icmsvalor',
                        'value' => Yii::app()->format->formatNumber($model->icmsvalor),
                ),
                array(
                        'name' => 'icmsstbase',
                        'value' => Yii::app()->format->formatNumber($model->icmsstbase),
                ),
                array(
                        'name' => 'icmsstvalor',
                        'value' => Yii::app()->format->formatNumber($model->icmsstvalor),
                ),
                array(
                        'name' => 'ipivalor',
                        'value' => Yii::app()->format->formatNumber($model->ipivalor),
                ),
                array(
                    'name'=>'valortotal',
                    'value'=>Yii::app()->format->formatNumber($model->valortotal),
                ),
                array(
                    'label'=>'Outros Custos',
                    'value'=>Yii::app()->format->formatNumber($outros),
                ),
                array(
                    'label'=>'Total Geral',
                    'value'=>Yii::app()->format->formatNumber($totalgeral),
                ),
            ),
        ));

        ?>
  </div>


</small>

<?php if (!empty($model->NfeTerceiroDuplicatas)): ?>
<h3>Duplicatas</h3>
<div id="ListagemDuplicatas">
  <?php
    $this->renderPartial("_view_duplicatas", array("model"=>$model))
    ?>
</div>
<br>
<?php endif; ?>

<?php

$this->widget('UsuarioCriacao', array('model'=>$model));

?>
