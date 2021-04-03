<?php

/**
 * @var NfeTerceiro $model
 */


$this->pagetitle = Yii::app()->name . ' - Detalhes da NFe de Terceiro';
$this->breadcrumbs=array(
    'NFe de Terceiros'=>array('index'),
    $model->nfechave,
);

$this->menu=array(
    array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
    array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnfeterceiro)),
);

Yii::app()->clientScript->registerScriptFile(Yii::app()->bootstrap->getAssetsUrl() . '/js/bootstrap-datepicker.min.js');
Yii::app()->clientScript->registerCSSFile(Yii::app()->bootstrap->getAssetsUrl() . '/css/bootstrap-datepicker.min.css');
Yii::app()->clientScript->registerCoreScript('yii');

?>

<h1>
	Cálculo ICMS ST NFe <?php echo Yii::app()->format->formataChaveNfe($model->nfechave); ?>
</h1>

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
                    'value'=>isset($model->Filial)?CHtml::link(CHtml::encode($model->Filial->filial), array("filial/view", "id"=>$model->codfilial)):null,
                    'type'=>"raw",
                ),
                array(
                    'name'=>'codpessoa',
                    'value'=>isset($model->Pessoa)?CHtml::link(CHtml::encode($model->Pessoa->fantasia), array("pessoa/view", "id"=>$model->codpessoa)):null,
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

<h3>Itens</h3>
<table class="detail-view table table-striped table-condensed">
  <tbody>
    <tr>
      <th style="text-align: center !important">
        NCM
      </th>
      <th style="text-align: center !important">
        CEST
      </th>
      <th style="text-align: left !important; min-width: 400px">
        Descrição do Produto
      </th>
      <th style="text-align: right !important">
        Ref
      </th>
      <th>
        #
      </th>
      <th>
        MVA
      </th>
      <th>
        Valor
      </th>
      <th>
        Redução BIT
      </th>
      <th>
        Icms
      </th>
      <th>
        ST Destacada
      </th>
      <th>
        ST Calculada
      </th>
      <th>
        Diferença
      </th>
    </tr>
    <?php foreach($itens as $item): ?>
      <?php
	$cestnota = intval($item['cestnota']);
	$cestproduto = intval($item['cestproduto']);
	$classCest = ($cestnota!=$cestproduto)?'error':''
      ?>
      <tr class='<?php echo $classCest; ?>'>
        <td style="text-align: center !important">
          <?php echo CHtml::encode(Yii::app()->format->formataNcm($item['ncmnota'])); ?>
          <?php if ($item['ncmnota']!=$item['ncmproduto']): ?>
            <?php echo CHtml::encode(Yii::app()->format->formataNcm($item['ncmproduto'])); ?>
          <?php endif; ?>
        </td>
        <td style="text-align: center !important">
          <?php echo CHtml::encode(Yii::app()->format->formataCest($item['cestnota'])); ?>
          <?php if ($cestnota!=$cestproduto): ?>
            <?php echo CHtml::encode(Yii::app()->format->formataCest($item['cestproduto'])); ?>
          <?php endif; ?>
        </td>
        <td>
          <?php echo CHtml::link(CHtml::encode($item['xprod']), array("nfeTerceiroItem/view", "id"=>$item['codnfeterceiroitem'])); ?>
        </td>
        <td style="text-align: right !important">
          <?php echo CHtml::encode($item['cprod']); ?>
        </td>
        <td style="text-align: right !important">
          <?php echo CHtml::encode(Yii::app()->format->formatNumber($item['nitem'], 0)); ?>
        </td>
        <td style="text-align: right !important">
          <?php if ($item['mva'] > 0): ?>
            <?php echo CHtml::encode(Yii::app()->format->formatNumber(($item['mva'] - 1) * 100, 2)); ?> %
          <?php endif; ?>
        </td>
        <td style="text-align: right !important">
          <?php echo CHtml::encode(Yii::app()->format->formatNumber($item['valor'], 2)); ?>
        </td>
        <td style="text-align: right !important">
          <?php if ($item['reducao'] != 1): ?>
            <?php echo CHtml::encode(Yii::app()->format->formatNumber($item['reducao'] * 100, 2)); ?> %
          <?php endif; ?>
        </td>
        <td style="text-align: right !important">
          <?php echo CHtml::encode(Yii::app()->format->formatNumber($item['vicms'], 2)); ?>
        </td>
        <td style="text-align: right !important">
          <?php echo CHtml::encode(Yii::app()->format->formatNumber($item['vicmsst'], 2)); ?>
        </td>
        <td style="text-align: right !important">
          <?php echo CHtml::encode(Yii::app()->format->formatNumber($item['vicmsstcalculado'], 2)); ?>
        </td>
        <td style="text-align: right !important">
          <?php echo CHtml::encode(Yii::app()->format->formatNumber($item['diferenca'], 2)); ?>
        </td>
      </tr>
    <?php endforeach; ?>
    <tr>
      <th colspan="9">
        Total
      </th>
      <th>
        <?php echo CHtml::encode(Yii::app()->format->formatNumber(array_sum(array_column($itens, 'vicmsst')), 2)); ?>
      </th>
      <th>
        <?php echo CHtml::encode(Yii::app()->format->formatNumber(array_sum(array_column($itens, 'vicmsstcalculado')), 2)); ?>
      </th>
      <th>
        <?php echo CHtml::encode(Yii::app()->format->formatNumber(array_sum(array_column($itens, 'diferenca')), 2)); ?>
      </th>
    </tr>
  </tbody>
</table>

<?php
$tituloNfeTerceiros = $model->TituloNfeTerceiros;
?>
<h3>Guias de ST</h3>
<table class="detail-view table table-striped table-condensed">
  <tbody>
    <tr>
      <th style="text-align: center !important">
       # Título
      </th>
      <th style="text-align: center !important">
        Emissão
      </th>
      <th style="text-align: center !important">
        Vencimento
      </th>
      <th style="text-align: center !important">
        Valor
      </th>
      <th style="text-align: center !important">
        Saldo
      </th>
      <th style="text-align: center !important">
        Arquivo
      </th>
    </tr>
    <?php foreach($tituloNfeTerceiros as $tituloNfeTerceiro): ?>
      <tr class=''>
        <td style="text-align: center !important">
          <?php echo CHtml::link(Yii::app()->format->formataCodigo($tituloNfeTerceiro->codtitulo), array("titulo/view", "id"=>$tituloNfeTerceiro->codtitulo)); ?>
        </td>
        <td style="text-align: center !important">
          <?php echo CHtml::encode($tituloNfeTerceiro->Titulo->emissao); ?>
        </td>
        <td style="text-align: center !important">
          <?php echo CHtml::encode($tituloNfeTerceiro->Titulo->vencimento); ?>
        </td>
        <td style="text-align: center !important">
          <?php echo CHtml::encode(Yii::app()->format->formatNumber($tituloNfeTerceiro->Titulo->valor, 2)); ?>
        </td>
        <td style="text-align: center !important">
          <?php echo CHtml::encode(Yii::app()->format->formatNumber($tituloNfeTerceiro->Titulo->saldo, 2)); ?>
        </td>
        <td style="text-align: center !important">
          <?php echo CHtml::link('Abrir Guia <i class="icon-file"></i>', array("NfeTerceiro/guiaSt", "codtitulonfeterceiro"=>$tituloNfeTerceiro->codtitulonfeterceiro)); ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="row">
  <div class="span12">
    <div class="input-prepend">
      <span class="add-on">Vencimento</span>
      <input class="span2 text-center" id="vencimentoGuiaSt" type="text" value="<?php echo date("d/m/Y", strtotime("+7 days")) ?>">
    </div>
    <div class="input-prepend input-append">
      <span class="add-on">R$</span>
      <input class="span2 text-right" id="valorGuiaSt" type="text" value="<?php echo array_sum(array_column($itens, 'diferenca')) ?>">
      <button class="btn btn-primary" id="btnGerarGuia" type="button">Gerar Guia de ST</button>
    </div>
  </div>
</div>



<script type="text/javascript">
/*<![CDATA[*/

function gerarGuiaSt () {
  var valorGuiaSt = $('#valorGuiaSt').autoNumeric('get');
  var vencimentoGuiaSt = $('#vencimentoGuiaSt').val();
  $.getJSON("<?php echo Yii::app()->createUrl('NfeTerceiro/gerarGuiaSt')?>", {
    id: <?php echo $model->codnfeterceiro ?>,
    valor: valorGuiaSt,
    vencimento: vencimentoGuiaSt,
  })
  .done(function(data) {
    bootbox.alert("Guia de ST Gerada!", function() {
      location.reload();
    });
  })
  .fail(function( jqxhr, textStatus, error ) {
    $.notify("Falha ao gerar Guia de ST!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
  });
}

$(document).ready(function(){

  $('#valorGuiaSt').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
  $('#vencimentoGuiaSt').datepicker({'format':'dd/mm/yyyy','language':'pt'});

  $('#btnGerarGuia').click(function(e) {
		e.preventDefault();
    bootbox.confirm("Deseja Gerar a Guia de ST?", function(result) {
			if (!result) {
        return
      }
      gerarGuiaSt();
		});
	});

});

/*]]>*/
</script>
