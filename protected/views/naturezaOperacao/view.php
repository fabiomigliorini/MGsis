<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Natureza de Operação';
$this->breadcrumbs=array(
	'Naturezas de Operação'=>array('index'),
	$model->naturezaoperacao,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnaturezaoperacao)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('naturezaOperacao/delete', array('id' => $model->codnaturezaoperacao))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->naturezaoperacao; ?></h1>

<div class="row-fluid">
	<div class="span6">
		<?php
		$this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				//'codnaturezaoperacao',
				array(
					'name'=>'codnaturezaoperacao',
					'value'=>Yii::app()->format->formataCodigo($model->codnaturezaoperacao),
					),
				'naturezaoperacao',
				//'codoperacao',
				array(
					'name'=>'codoperacao',
					'value'=>($model->codoperacao)?'Entrada':'Saída',
					),
				//'emitida',
				array(
					'name'=>'emitida',
					'value'=>($model->emitida)?'Sim':'Não',
					),
				//'observacoesnf',
				array(
					'name'=>'observacoesnf',
					'value'=>nl2br(CHtml::encode($model->observacoesnf)),
					'type'=>'raw',
					),
				array(
					'name'=>'mensagemprocom',
					'value'=>nl2br(CHtml::encode($model->mensagemprocom)),
					'type'=>'raw',
					),
				array(
					'name'=>'codnaturezaoperacaodevolucao',
					'value'=>(isset($model->NaturezaOperacaoDevolucao))?CHtml::link(CHtml::encode($model->NaturezaOperacaoDevolucao->naturezaoperacao),array('naturezaOperacao/view','id'=>$model->codnaturezaoperacaodevolucao)):null,
					'type'=>'raw',
					),
				array(
					'name'=>'codtipotitulo',
					'value'=>(isset($model->TipoTitulo))?CHtml::link(CHtml::encode($model->TipoTitulo->tipotitulo),array('tipoTitulo/view','id'=>$model->codtipotitulo)):null,
					'type'=>'raw',
					),
				array(
					'name'=>'codcontacontabil',
					'value'=>(isset($model->ContaContabil))?CHtml::link(CHtml::encode($model->ContaContabil->contacontabil),array('contaContabil/view','id'=>$model->codcontacontabil)):null,
					'type'=>'raw',
					),
				array(
						'name'=>'codestoquemovimentotipo',
						'value'=>(isset($model->EstoqueMovimentoTipo))?CHtml::link(CHtml::encode($model->EstoqueMovimentoTipo->descricao),array('estoqueMovimentoTipo/view','id'=>$model->codestoquemovimentotipo)):null,
						'type'=>'raw',
						),
				),
			));
		?>
	</div>

	<div class="span6">
		<?php
		$this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				'finnfe',
				array(
					'name'=>'ibpt',
					'value'=>($model->ibpt)?'Sim':'Não',
					),
				array(
					'name'=>'estoque',
					'value'=>($model->estoque)?'Sim':'Não',
					),
				array(
					'name'=>'finaceiro',
					'value'=>($model->financeiro)?'Sim':'Não',
					),
				array(
					'name'=>'compra',
					'value'=>($model->compra)?'Sim':'Não',
					),
				array(
					'name'=>'venda',
					'value'=>($model->venda)?'Sim':'Não',
					),
				array(
					'name'=>'vendadevolucao',
					'value'=>($model->vendadevolucao)?'Sim':'Não',
					),

				),
			));
		?>
	</div>
</div>

<?php
	$this->widget('UsuarioCriacao', array('model'=>$model));

	$tributacaonaturezaoperacao=new TributacaoNaturezaOperacao('search');

	$tributacaonaturezaoperacao->unsetAttributes();  // clear any default values

	if(isset($_GET['TributacaoNaturezaOperacao']))
		Yii::app()->session['FiltroTributacaoNaturezaOperacaoIndex'] = $_GET['TributacaoNaturezaOperacao'];

	if (isset(Yii::app()->session['FiltroTributacaoNaturezaOperacaoIndex']))
		$tributacaonaturezaoperacao->attributes=Yii::app()->session['FiltroTributacaoNaturezaOperacaoIndex'];

	$tributacaonaturezaoperacao->codnaturezaoperacao = $model->codnaturezaoperacao;

	$this->renderPartial('/tributacaoNaturezaOperacao/index',array(
	'dataProvider'=>$tributacaonaturezaoperacao->search(),
	'model'=>$tributacaonaturezaoperacao,
	));
?>
