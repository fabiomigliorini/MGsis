<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Titulo';
$this->breadcrumbs=array(
	'Titulo'=>array('index'),
	$model->numero,
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
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
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codtitulo)),
	array('label'=>'Estornar', 'icon'=>'icon-thumbs-down', 'url'=>'#', 'linkOptions'=>array('id'=>'btnExcluir')),
	array('label'=>'Duplicar', 'icon'=>'icon-retweet', 'url'=>array('create','duplicar'=>$model->codtitulo)),
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
	jQuery('body').on('click','#btnExcluir',function() {
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
      <iframe src="" id="frameBoleto" width="99.6%" height="400" frameborder="0"></iframe>
	</div>
</div>

<div id="modalVale" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<div class="pull-right">
			<div class="btn-group">
                <button class="btn dropdown-toggle btn-primary" data-toggle="dropdown">Imprimir <span class="caret"></span></button>
                <ul class="dropdown-menu">
					<li ><a id="btnImprimirVale" href="#">Na Impressora Laser</a></button>
					<li ><a id="btnImprimirValeMatricial" href="#">Na Impressora Matricial</a></button>
                </ul>
              </div>			
			<button class="btn" data-dismiss="modal">Fechar</button>
		</div>
		<h3>Vale</h3>  
	</div>
	<div class="modal-body">
      <iframe src="" id="frameVale" width="99.6%" height="400" frameborder="0"></iframe>
	</div>
</div>

<h2><?php echo $model->numero; ?> - <?php echo CHtml::link(CHtml::encode($model->Pessoa->fantasia),array('pessoa/view','id'=>$model->codpessoa)); ?></h2>

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
			array(
				'name'=>'codfilial',
				'value'=>(isset($model->Filial))?$model->Filial->filial:null,
				'cssClass'=>$css_filial
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
				'value'=>(!empty($model->observacao))?nl2br($model->observacao):null,
				),
			array(
				'label'=>'Negócio',
				'value'=>(isset($model->NegocioFormaPagamento))?Yii::app()->format->formataCodigo($model->NegocioFormaPagamento->codnegocio):"Não",
				),
			array(
				'label'=>'Agrupamento',
				'value'=>(!empty($model->codtituloagrupamento))?"Sim":"Não",
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
			'emissao',
			'transacao',
			array(
				'name'=>'valor',
				'value'=>Yii::app()->format->formatNumber($model->valor) . " " . $model->operacao,
				),
			array(
				'name'=>'codportador',
				'value'=>(isset($model->Portador))?$model->Portador->portador:null,
				),
			array(
				'name'=>'boleto',
				'value'=>($model->boleto)?$model->nossonumero:"Sem Boleto",
				),
			'remessa',
			'transacaoliquidacao',
			'estornado',
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
	<br>
	<?php
	$box = $this->beginWidget('bootstrap.widgets.TbBox',
			array(
				'title' => 'Movimento',
				/*'headerIcon' => 'icon-th-list',*/
				'htmlOptions' => array('class' => 'bootstrap-widget-table')
				)
			);
	
	$criteria=new CDbCriteria;
	$criteria->compare('codtitulo', $model->codtitulo, false);
	$criteria->order = 'criacao ASC, sistema ASC, debito ASC, credito ASC';
	$criteria->limit = 50;
	
    $dataProvider = new CActiveDataProvider(
		MovimentoTitulo::model(), 
		array(
			'criteria' => $criteria,
			'pagination' => false,
			)
		);

	?>
	<ul id="yw3" class="nav nav-list">
	<?php
	$this->widget(
		'zii.widgets.CListView', 
		array(
			'id' => 'Listagem',
			'dataProvider' => $dataProvider,
			'itemView' => '_view_movimento',
			'template' => '{items}',
		)
	);
	?>
	</ul>
	<?php
	
	$this->endWidget();
	
	$box = $this->beginWidget('bootstrap.widgets.TbBox',
			array(
				'title' => 'Retorno Boleto',
				/*'headerIcon' => 'icon-th-list',*/
				'htmlOptions' => array('class' => 'bootstrap-widget-table')
				)
			);
	
	$criteria=new CDbCriteria;
	$criteria->compare('codtitulo', $model->codtitulo, false);
	$criteria->order = 'codboletoretorno ASC';
	$criteria->limit = 50;
	
    $dataProvider = new CActiveDataProvider(
		BoletoRetorno::model(), 
		array(
			'criteria' => $criteria,
			'pagination' => false,
			)
		);

	?>
	<ul id="yw3" class="nav nav-list">
	<?php
	$this->widget(
		'zii.widgets.CListView', 
		array(
			'id' => 'Listagem',
			'dataProvider' => $dataProvider,
			'itemView' => '_view_boleto_retorno',
			'template' => '{items}',
		)
	);
	?>
	</ul>
	<?php
	
	$this->endWidget();
?>
