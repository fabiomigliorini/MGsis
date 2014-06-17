<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Liquidação de Títulos';
$this->breadcrumbs=array(
	'Liquidação de Títulos'=>array('index'),
	$model->codliquidacaotitulo,
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codliquidacaotitulo)),
	//array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	array(
		'label'=>'Imprimir Recibo', 
		'icon'=>'icon-print', 
		'url'=>array('imprimerecibo','id'=>$model->codliquidacaotitulo), 
		'linkOptions'=>array('id'=>'btnMostrarRecibo'),
		'visible'=>(empty($model->estornado))
	),
	array(
		'label'=>'Estornar', 
		'icon'=>'icon-thumbs-down', 
		'url'=>'#', 
		'linkOptions'=>array('id'=>'btnExcluir'),
		'visible'=>(empty($model->estornado))
		),
	
);

Yii::app()->clientScript->registerCoreScript('yii');

?>
<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){

	//abre janela vale
	var frameSrcRecibo = $('#btnMostrarRecibo').attr('href');
	$('#btnMostrarRecibo').click(function(event){
		event.preventDefault();
		$('#modalRecibo').on('show', function () {
			$('#frameRecibo').attr("src",frameSrcRecibo);
		});
		$('#modalRecibo').modal({show:true})
		$('#modalRecibo').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
	});	
		
	//imprimir Recibo
	$('#btnImprimirRecibo').click(function(event){
		window.frames["frameRecibo"].focus();
		window.frames["frameRecibo"].print();
	});
	
	//imprimir Recibo Matricial
	$('#btnImprimirReciboMatricial').click(function(event){
		$('#frameRecibo').attr("src",frameSrcRecibo + "&imprimir=true");
	});
	
	jQuery('body').on('click','#btnExcluir',function() {
		bootbox.confirm("Estornar esta Liquidação?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('liquidacaoTitulo/estorna', array('id' => $model->codliquidacaotitulo))?>",{});
		});
	});
});
/*]]>*/
</script>

<div id="modalRecibo" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<div class="pull-right">
			<div class="btn-group">
                <button class="btn dropdown-toggle btn-primary" data-toggle="dropdown">Imprimir <span class="caret"></span></button>
                <ul class="dropdown-menu">
					<li ><a id="btnImprimirRecibo" href="#">Na Impressora Laser</a></button>
					<li ><a id="btnImprimirReciboMatricial" href="#">Na Impressora Matricial</a></button>
                </ul>
              </div>			
			<button class="btn" data-dismiss="modal">Fechar</button>
		</div>
		<h3>Recibo</h3>  
	</div>
	<div class="modal-body">
      <iframe src="" id="frameRecibo" name="frameRecibo" width="99.6%" height="400" frameborder="0"></iframe>
	</div>
</div>


<h1>Liquidação de Títulos <?php echo Yii::app()->format->formataCodigo($model->codliquidacaotitulo); ?></h1>

<?php if (!empty($model->estornado)): ?>
	<div class="alert alert-danger">
		<b>Estornado em <?php echo CHtml::encode($model->estornado); ?> </b>
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
		'transacao',
		array(
			'label'=>'Pessoa',
			'value'=>CHtml::encode($model->Portador->portador),
			'type'=>'raw'
		),
		array(
			'label'=>'Total',
			'value'=>Yii::app()->format->formatNumber($model->valor) . " " . $model->operacao,
		),
		'observacao',
	),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>

<h2>Títulos Baixados</h2>

<?php

foreach ($model->MovimentoTitulos as $mov)
{
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
