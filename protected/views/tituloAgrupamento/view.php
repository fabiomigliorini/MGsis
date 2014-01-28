<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Agrupamento de Títulos';
$this->breadcrumbs=array(
	'Agrupamento de Títulos'=>array('index'),
	Yii::app()->format->formataCodigo($model->codtituloagrupamento),
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array(
		'label'=>'Imprimir Boletos', 
		'icon'=>'icon-barcode', 
		'url'=>array('titulo/imprimeboleto', 'codtituloagrupamento'=>$model->codtituloagrupamento), 
		'linkOptions'=>array('id'=>'btnMostrarBoleto'),
		'visible'=>(empty($model->cancelamento))
	),
	//array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codtituloagrupamento)),
	//array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	array(
		'label'=>'Estornar', 
		'icon'=>'icon-thumbs-down', 
		'url'=>'#', 
		'linkOptions'=>array('id'=>'btnExcluir'),
		'visible'=>(empty($model->cancelamento))
		),
	array(
		'label'=>'Relatório', 
		'icon'=>'icon-print', 
		'url'=>array('relatorio', 'id'=>$model->codtituloagrupamento), 
		'linkOptions'=>array('id'=>'btnMostrarRelatorio'),
		'visible'=>(empty($model->cancelamento))
	),
);

Yii::app()->clientScript->registerCoreScript('yii');

?>
<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){


	var frameSrcBoleto = $('#btnMostrarBoleto').attr('href');
	$('#btnMostrarBoleto').click(function(event){
		event.preventDefault();
		$('#modalBoleto').on('show', function () {
			$('#frameBoleto').attr("src",frameSrcBoleto);
		});
		$('#modalBoleto').modal({show:true})
		$('#modalBoleto').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
	});	
	
	//abre janela boleto
	var frameSrcRelatorio = $('#btnMostrarRelatorio').attr('href');
	$('#btnMostrarRelatorio').click(function(event){
		event.preventDefault();
		$('#modalRelatorio').on('show', function () {
			$('#frameRelatorio').attr("src",frameSrcRelatorio);
		});
		$('#modalRelatorio').modal({show:true})
		$('#modalRelatorio').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
	});	
	

	//imprimir Boleto
	$('#btnImprimirBoleto').click(function(event){
		window.frames["frameBoleto"].focus();
		window.frames["frameBoleto"].print();
	});

	jQuery('body').on('click','#btnExcluir',function() {
		bootbox.confirm("Estornar este Agrupamento?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('tituloAgrupamento/estorna', array('id' => $model->codtituloagrupamento))?>",{});
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
      <iframe src="" id="frameBoleto" width="99.6%" height="400" frameborder="0"></iframe>
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
      <iframe src="" id="frameRelatorio" width="99.6%" height="400" frameborder="0"></iframe>
	</div>
</div>


<h1>Agrupamento de Títulos <?php echo Yii::app()->format->formataCodigo($model->codtituloagrupamento); ?></h1>

<?php if (!empty($model->cancelamento)): ?>
	<div class="alert alert-danger">
		<b>Estornado em <?php echo CHtml::encode($model->cancelamento); ?> </b>
	</div>
<?php endif; ?>

<?php 

$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'label'=>'Pessoa',
			'value'=>CHtml::link(CHtml::encode($model->Pessoa->fantasia),array('pessoa/view','id'=>$model->codpessoa)),
			'type'=>'raw'
		),
		'emissao',
		array(
			'label'=>'Total',
			'value'=>Yii::app()->format->formatNumber($model->valor) . " " . $model->operacao,
		),
		'observacao',
	),
)); 

$this->widget('UsuarioCriacao', array('model'=>$model));
?>

<h2>Títulos Gerados</h2>

<?php

foreach ($model->Titulos as $titulo)
{
	$css_valor = ($titulo->operacao == "DB")?"text-success":"text-warning";	
	?>
	<div class="registro">
		<small class="row-fluid">
			<span class="span1 <?php echo ($titulo->gerencial)?"text-warning":"text-success"; ?>">
				<?php echo CHtml::encode($titulo->Filial->filial); ?> 
			</span>
			<span class="span2 muted">
				<?php echo CHtml::link(CHtml::encode($titulo->numero),array('titulo/view','id'=>$titulo->codtitulo)); ?> 
			</span>
			<b class="span2 text-right <?php echo $css_valor; ?>">
				<?php echo Yii::app()->format->formatNumber($titulo->valor); ?>
				<?php echo $titulo->operacao; ?>
			</b>
			<b class="span1">
				<?php echo $titulo->vencimento; ?>
			</b>
			<span class="span3 muted">
				<?php echo CHtml::link($titulo->Pessoa->fantasia,array('pessoa/view','id'=>$titulo->codpessoa)); ?> 
			</span>
			<span class="span1">
				<?php echo (isset($titulo->Portador))?CHtml::encode($titulo->Portador->portador):""; ?>
			</span>
			<span class="span2">
				<?php echo ($titulo->boleto)?"Boleto " . CHtml::encode($titulo->nossonumero):""; ?>
			</span>
		</small>
	</div>
	<?
}

unset($titulo)
?>

<h2>Títulos Baixados</h2>

<?php

foreach ($model->MovimentoTitulos as $mov)
{
	if ($mov->Titulo->codtituloagrupamento == $model->codtituloagrupamento)
		continue;
	
	if ($mov->TipoMovimentoTitulo->estorno)
		continue;
	
	$operacao = ($mov->credito > $mov->debito)?"CR":"DB";
	$css_valor = ($operacao == "DB")?"text-success":"text-warning";	
	?>
	<div class="registro">
		<small class="row-fluid">
			<span class="span1 <?php echo ($mov->Titulo->gerencial)?"text-warning":"text-success"; ?>">
				<?php echo CHtml::encode($mov->Titulo->Filial->filial); ?> 
			</span>
			<span class="span2 muted">
				<?php echo CHtml::link(CHtml::encode($mov->Titulo->numero),array('titulo/view','id'=>$mov->Titulo->codtitulo)); ?> 
			</span>
			<small class="span1 muted text-right">
				<?php echo CHtml::encode($mov->TipoMovimentoTitulo->tipomovimentotitulo); ?> 
			</small>
			<b class="span1 text-right <?php echo $css_valor; ?>">
				<?php echo Yii::app()->format->formatNumber(abs($mov->debito-$mov->credito)); ?>
				<?php echo $operacao; ?>
			</b>
			<b class="span1">
				<?php echo $mov->Titulo->vencimento; ?>
			</b>
			<span class="span3 muted">
				<?php echo CHtml::link(CHtml::encode($mov->Titulo->Pessoa->fantasia),array('pessoa/view','id'=>$mov->Titulo->codpessoa)); ?> 
			</span>
			<span class="span1">
				<?php echo (isset($mov->Titulo->Portador))?CHtml::encode($mov->Titulo->Portador->portador):""; ?>
			</span>
			<span class="span2">
				<?php echo ($mov->Titulo->boleto)?"Boleto " . CHtml::encode($mov->Titulo->nossonumero):""; ?>
			</span>
		</small>
	</div>
	<?
}

?>
