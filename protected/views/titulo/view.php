<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Titulo';
$this->breadcrumbs=array(
	'Titulo'=>array('index'),
	$model->numero,
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codtitulo)),
	array(
		'label'=>'Imprimir Vale', 
		'icon'=>'icon-print', 
		'url'=>array('imprimevale','id'=>$model->codtitulo), 
		'linkOptions'=>array('id'=>'btnMostrarVale'),
		'visible'=>$model->saldo < 0
	),
	array(
		'label'=>'Imprimir Boleto', 
		'icon'=>'icon-barcode', 
		'url'=>array('imprimeboleto', 'id'=>$model->codtitulo), 
		'linkOptions'=>array('id'=>'btnMostrarBoleto'),
		'visible'=>($model->boleto && ($model->saldo>0))
	),
	array(
		'label'=>'Estornar', 
		'icon'=>'icon-thumbs-down', 
		'url'=>'#', 
		'linkOptions'=>array('id'=>'btnEstornar'),
		'visible'=>(empty($model->codtituloagrupamento) && ($model->saldo <> 0))
		),
	array('label'=>'Duplicar', 'icon'=>'icon-retweet', 'url'=>array('create','duplicar'=>$model->codtitulo)),
	//array('label'=>'Agrupar', 'icon'=>'icon-tasks', 'url'=>array('agrupar','id'=>$model->codtitulo)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

if ($model->saldo == 0) 
	$css_vencimento = "muted";
else
	if ($model->Juros->diasAtraso > 0)
	{
		if ($model->Juros->diasAtraso <= $model->Juros->diasTolerancia) 
		{
			$css_vencimento = "text-warning";
		}
		else 
		{
			$css_vencimento = "text-error";
		}
	}
	else
	{
		$css_vencimento = "text-success";
	}

if ($model->gerencial)
	$css_filial = "text-warning";
else
	$css_filial = "text-success";

?>

<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
	
	//abre janela boleto
	var frameSrcBoleto = $('#btnMostrarBoleto').attr('href');
	$('#btnMostrarBoleto').click(function(event){
		event.preventDefault();
		$('#modalBoleto').on('show', function () {
			$('#frameBoleto').attr("src",frameSrcBoleto);
		});
		$('#modalBoleto').modal({show:true})
		$('#modalBoleto').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
	});	

	//abre janela vale
	var frameSrcVale = $('#btnMostrarVale').attr('href');
	$('#btnMostrarVale').click(function(event){
		event.preventDefault();
		$('#modalVale').on('show', function () {
			$('#frameVale').attr("src",frameSrcVale);
		});
		$('#modalVale').modal({show:true})
		$('#modalVale').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
	});	
		
	//imprimir Boleto
	$('#btnImprimirBoleto').click(function(event){
		window.frames["frameBoleto"].focus();
		window.frames["frameBoleto"].print();
	});
	
	//imprimir Vale
	$('#btnImprimirVale').click(function(event){
		window.frames["frameVale"].focus();
		window.frames["frameVale"].print();
	});
	
	//imprimir Vale Matricial
	$('#btnImprimirValeMatricial').click(function(event){
		$('#frameVale').attr("src",frameSrcVale + "&imprimir=true");
	});
	
	//botao excluir
	jQuery('body').on('click','#btnEstornar',function() {
		bootbox.confirm("Estornar este título?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('titulo/estorna', array('id' => $model->codtitulo))?>",{});
		});
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


<div id="modalVale" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<div class="pull-right">
                        <button class="btn btn-primary" id="btnImprimirValeMatricial"><i class="icon-print icon-white"></i>&nbsp;Matricial</button>
                        <button class="btn btn-primary" id="btnImprimirVale"><i class="icon-print icon-white"></i>&nbsp;Laser</button>

			<button class="btn" data-dismiss="modal">Fechar</button>
		</div>
		<h3>Vale</h3>  
	</div>
	<div class="modal-body">
      <iframe src="" id="frameVale" name="frameVale" width="99.6%" height="400" frameborder="0"></iframe>
	</div>
</div>


<h1><?php echo $model->numero; ?> - <?php echo CHtml::link(CHtml::encode($model->Pessoa->fantasia),array('pessoa/view','id'=>$model->codpessoa)); ?></h1>

<?php if (!empty($model->estornado)): ?>
	<div class="alert alert-danger">
		<b>Estornado em <?php echo CHtml::encode($model->estornado); ?> </b>
	</div>
<?php endif; ?>

<div class="row-fluid">
	<div class="span4">
	<?php 
	$this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'codtitulo',
				'value'=>Yii::app()->format->formataCodigo($model->codtitulo),
				),
			'fatura',
			array(
				'name'=>'codtipotitulo',
				'value'=>(isset($model->TipoTitulo))?$model->TipoTitulo->tipotitulo:null,
				),
			array(
				'name'=>'codcontacontabil',
				'value'=>(isset($model->ContaContabil))?$model->ContaContabil->contacontabil:null,
				),
			array(
				'name'=>'observacao',
				'value'=>(!empty($model->observacao))?nl2br(CHtml::encode($model->observacao)):null,
				'type'=>'raw'
				),
			array(
				'label'=>'Negócio',
//				'value'=>(isset($model->NegocioFormaPagamento))?Yii::app()->format->formataCodigo($model->NegocioFormaPagamento->codnegocio):"Não",
				'value'=>(!empty($model->codnegocioformapagamento))?CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($model->NegocioFormaPagamento->codnegocio)),array('negocio/view','id'=>$model->NegocioFormaPagamento->codnegocio)):null,
				'type'=>'raw'
				),
			array(
				'label'=>'Agrupamento',
				'value'=>(!empty($model->codtituloagrupamento))?CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($model->codtituloagrupamento)),array('tituloAgrupamento/view','id'=>$model->codtituloagrupamento)):null,
				'type'=>'raw'
				),
			),
	)); 
	?>
	</div>
	<div class="span4">
	<?php 
	$this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'codfilial',
				'value'=>(isset($model->Filial))?$model->Filial->filial:null,
				'cssClass'=>$css_filial
				),
			'emissao',
			'transacao',
			array(
				'name'=>'codportador',
				'value'=>(isset($model->Portador))?$model->Portador->portador:null,
				),
			array(
				'name'=>'boleto',
				'value'=>($model->boleto)?(!empty($model->nossonumero)?$model->nossonumero:"Sim"):"Sem Boleto",
				),
			'remessa',
			'transacaoliquidacao',
		),
	)); 
	?>		
	</div>
	<div class="span4">
	<?php
	$this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'valor',
				'value'=>Yii::app()->format->formatNumber($model->valor) . " " . $model->operacao,
				),
			array(
				'name'=>'vencimento',
				'cssClass' => $css_vencimento 
			),
			array(
				'name'=>'vencimentooriginal',
				'cssClass' => $css_vencimento
			),
			array(
				'name'=>'saldo',
				'value'=>Yii::app()->format->formatNumber(abs($model->saldo)) . " " . $model->operacao,
				'cssClass' => $css_vencimento,
				),
			array(
				'label'=>'Juros',
				'value'=>Yii::app()->format->formatNumber(abs($model->Juros->valorJuros)) . " " . $model->operacao,
				'cssClass' => $css_vencimento
				),
			array(
				'label'=>'Multa',
				'value'=>Yii::app()->format->formatNumber(abs($model->Juros->valorMulta)) . " " . $model->operacao,
				'cssClass' => $css_vencimento
				),
			array(
				'label'=>'Total',
				'value'=>Yii::app()->format->formatNumber(abs($model->Juros->valorTotal)) . " " . $model->operacao,
				'cssClass' => $css_vencimento
				),
			)
		)
	);
	?>
	</div>
</div>
<?php
$this->widget('UsuarioCriacao', array('model'=>$model));
?>
<br>
<h2>Movimentos do Título</h2>
<?php

foreach ($model->MovimentoTitulos as $mov)
{
	$css_valor = ($mov->operacao == "CR")?"text-warning":"text-success";
	?>
	<div class="registro">
		<small class="row-fluid">
			<span class="span1">
				<?php echo $mov->transacao; ?>
			</span>
			<b class="span2 text-right <?php echo $css_valor; ?>">
				<?php echo Yii::app()->format->formatNumber($mov->valor); ?> <?php echo $mov->operacao; ?>
			</b>
			<span class="span6 muted">
				<span class="span4">
					<?php echo (isset($mov->TipoMovimentoTitulo))?$mov->TipoMovimentoTitulo->tipomovimentotitulo:null; ?>
				</span>
				<span class="span4">
					<?php echo (isset($mov->Portador))?$mov->Portador->portador:null; ?>
				</span>
				<span class="span4">
					<?php echo (!empty($mov->codboletoretorno)) ? "Retorno Boleto" :""?>
					<?php echo (!empty($mov->codcobranca)) ? "Cobranca" :""?>
					<?php echo (!empty($mov->codliquidacaotitulo)) ? "Liquidação "  . CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($mov->codliquidacaotitulo)),array('liquidacaoTitulo/view','id'=>$mov->codliquidacaotitulo)):""?>
					<?php echo (!empty($mov->codtituloagrupamento)) ? "Agrupamento " . CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($mov->codtituloagrupamento)),array('tituloAgrupamento/view','id'=>$mov->codtituloagrupamento)) :""?>
				</span>
			</span>
			<div class="span3 pull-right">
				<?php
					$this->widget('UsuarioCriacao', array('model'=>$mov));
				?>
			</div>
		</small>
	</div>	
	<?php
}

//Retornos do Boleto
if (!empty($model->BoletoRetornos))
{
	?>
	<br>
	<h2>Retornos do Boleto</h2>
	<?php
}

foreach ($model->BoletoRetornos as $ret)
{
	if (!empty($ret->pagamento))
		$css_valor = "text-success";
	elseif (!empty($ret->protesto))
		$css_valor = "text-error";
	else
		$css_valor = "text-warning";
	?>


	<div class="registro">
		<small class="row-fluid">
			<span class="span1">
				<?php echo $ret->dataretorno; ?>
			</span>
			<b class="span8 <?php echo $css_valor; ?>">
				<?php echo (!empty($ret->valor))?"Valor: " . Yii::app()->format->formatNumber($ret->valor):""; ?>
				<?php echo (!empty($ret->pagamento))?"Pagamento: " . Yii::app()->format->formatNumber($ret->pagamento):""; ?>
				<?php echo (!empty($ret->despesas))?"Despesas: " . Yii::app()->format->formatNumber($ret->despesas):""; ?>
				<?php echo (!empty($ret->outrasdespesas))?"Outras Despesas: " . Yii::app()->format->formatNumber($ret->outrasdespesas):""; ?>
				<?php echo (!empty($ret->jurosatraso))?"Juros Atraso: " . Yii::app()->format->formatNumber($ret->jurosatraso):""; ?>
				<?php echo (!empty($ret->jurosmora))?"Juros Mora: " . Yii::app()->format->formatNumber($ret->jurosmora):""; ?>
				<?php echo (!empty($ret->desconto))?"Desconto: " . Yii::app()->format->formatNumber($ret->desconto):""; ?>
				<?php echo (!empty($ret->abatimento))?"Abatimento: " . Yii::app()->format->formatNumber($ret->abatimento):""; ?>
				<?php echo (!empty($ret->protesto))?"Protesto: " . $ret->protesto:""; ?>
			</b>
			<div class="span3 pull-right">
				<?php
					$this->widget('UsuarioCriacao', array('model'=>$ret));
				?>
			</div>		
		</small>
		<small class="row-fluid">
			<small class="span4 muted">
				<?php echo (isset($ret->BoletoMotivoOcorrencia->BoletoTipoOcorrencia))?$ret->BoletoMotivoOcorrencia->BoletoTipoOcorrencia->ocorrencia:null; ?>
				>
				<?php echo (isset($ret->BoletoMotivoOcorrencia))?$ret->BoletoMotivoOcorrencia->motivo:null; ?>
			</small>

			<small class="span1 muted">
				<?php echo (isset($ret->Portador))?$ret->Portador->portador:null; ?>
			</small>
			<small class="span1 muted">
				<?php echo $ret->nossonumero; ?>
			</small>
			<small class="span2 muted">
				<?php echo $ret->arquivo; ?>:L<?php echo $ret->linha; ?>
			</small>
			<small class="span2 muted">
				<?php echo $ret->numero; ?>
			</small>
			<small class="span2 muted">
				Bco <?php echo $ret->codbancocobrador; ?>
				Ag <?php echo $ret->agenciacobradora; ?>
			</small>
		</small>
	</div>
	<?php
}
