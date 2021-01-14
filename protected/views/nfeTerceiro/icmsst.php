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

Yii::app()->clientScript->registerCoreScript('yii');

?>
<script type="text/javascript">
/*<![CDATA[*/

function gerarDar()
{
  var data = {
    periodoReferencia:'12/2020',
    tipoVenda:1,
    tributo:1538,
    cnpjBeneficiario:null,
    numrDuimp:null,
    numrDocumentoDestinatario:132030470,
    txtCaminhoArquivo:'(binary)',
    isNFE1:'on',
    numrNota1:13201204402277000100550170002223641629469490,
    isNFE2:'on',
    numrNota2:null,
    isNFE3:'on',
    numrNota3:null,
    isNFE4:'on',
    numrNota4:null,
    isNFE5:'on',
    numrNota5:null,
    isNFE6:'on',
    numrNota6:null,
    isNFE7:'on',
    numrNota7:null,
    isNFE8:'on',
    numrNota8:null,
    isNFE9:'on',
    numrNota9:null,
    isNFE10:'on',
    numrNota10:null,
    numrPessoaDestinatario:611107,
    statInscricaoEstadual:'Ativo',
    notas:1,
    nfeNota1:null,
    nfeNota2:null,
    nfeNota3:null,
    nfeNota4:null,
    nfeNota5:null,
    nfeNota6:null,
    nfeNota7:null,
    nfeNota8:null,
    nfeNota9:null,
    nfeNota10:null,
    numrParcela:null,
    totalParcela:null,
    numrNai:null,
    numrTad:null,
    multaCovid:null,
    numeroNob:null,
    codgConvDesc:null,
    dataVencimento:15/01/2021,
    qtd:null,
    qtdUnMedida:null,
    valorUnitario:null,
    valorCampo:'719,00',
    valorCorrecao:null,
    diasAtraso:null,
    juros:null,
    tipoDocumento:2,
    nota1:null,
    nota2:null,
    nota3:null,
    nota4:null,
    nota5:null,
    nota6:null,
    nota7:null,
    nota8:null,
    nota9:null,
    nota10:null,
    informacaoPrevista:null,
    informacaoPrevista2:null,
    municipio:255009,
    numrContribuinte:611107,
    pagn:'emitir',
    numrDocumento:4576775000160,
    numrInscEstadual:132030470,
    tipoContribuinte:1,
    codgCnae:4751201,
    tipoTributoH:null,
    codgOrgao:null,
    valor:'719,00',
    valorPadrao:0,
    valorMulta:null,
    tributoTad:1538,
    tipoVendaX:null,
    tipoUniMedida:null,
    valorUnit:null,
    upfmtFethab:null,
  };

  $.ajax({
      type: "POST",
      crossDomaisssn: true,
      url: "https://www.sefaz.mt.gov.br/arrecadacao/darlivre/pj/gerardar",
      data: data,
      cache: false,
      success: function(response)
      {
          alert('got response');
          window.open(response);
      },
      error: function (XMLHttpRequest, textStatus, errorThrown)
      {
          alert('Error occurred while opening fax template'
                + getAjaxErrorString(textStatus, errorThrown));
      }
  });

}

$(document).ready(function(){

});

/*]]>*/
</script>

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
      $classCest = $item['cestnota']!=$item['cestproduto']?'error':''
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
          <?php if ($item['cestnota']!=$item['cestproduto']): ?>
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
$this->widget('UsuarioCriacao', array('model'=>$model));
?>
