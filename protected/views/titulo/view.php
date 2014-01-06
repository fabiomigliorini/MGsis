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
array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

?>
<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
	jQuery('body').on('click','#btnExcluir',function() {
		bootbox.confirm("Excluir este registro?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('titulo/delete', array('id' => $model->codtitulo))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1>Título <?php echo $model->numero; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'codtitulo',
			'value'=>Yii::app()->format->formataCodigo($model->codtitulo),
			),
		array(
			'name'=>'codpessoa',
			'value'=>(isset($model->Pessoa))?CHtml::link(CHtml::encode($model->Pessoa->fantasia),array('pessoa/view','id'=>$model->codpessoa)):null,
			'type'=>'raw',			
			),
		'numero',
		'vencimento',
		array(
			'name'=>'saldo',
			'value'=>Yii::app()->format->formatNumber($model->saldo),
			),
		'emissao',
		array(
			'name'=>'debito',
			'value'=>Yii::app()->format->formatNumber($model->debito),
			),
		array(
			'name'=>'credito',
			'value'=>Yii::app()->format->formatNumber($model->credito),
			),
		
		array(
			'name'=>'codtipotitulo',
			'value'=>(isset($model->TipoTitulo))?$model->TipoTitulo->tipotitulo:null,
			),
		array(
			'name'=>'codcontacontabil',
			'value'=>(isset($model->ContaContabil))?$model->ContaContabil->contacontabil:null,
			),
		array(
			'name'=>'codfilial',
			'value'=>(isset($model->Filial))?$model->Filial->filial:null,
			),
		'fatura',
		'transacao',
		'sistema',
		'vencimentooriginal',
		array(
			'name'=>'gerencial',
			'value'=>($model->gerencial)?"Gerencial":"Fiscal",
			),
		array(
			'name'=>'observacao',
			'value'=>(!empty($model->observacao))?nl2br($model->observacao):null,
			),
		array(
			'name'=>'codportador',
			'value'=>(isset($model->Portador))?$model->Portador->portador:null,
			),
		array(
			'name'=>'boleto',
			'value'=>($model->boleto)?"Com Boleto":"Sem Boleto",
			),
		'nossonumero',
		'remessa',
		array(
			'label'=>'Negócio',
			'value'=>(isset($model->NegocioFormaPagamento))?Yii::app()->format->formataCodigo($model->NegocioFormaPagamento->codnegocio):null,
			),
		array(
			'label'=>'Agrupamento',
			'value'=>(!empty($model->codtituloagrupamento))?"Sim":"Não",
			),
		'transacaoliquidacao',
		'estornado',
		
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

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
