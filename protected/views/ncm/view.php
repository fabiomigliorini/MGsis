<?php

/**
 * @var Ncm $model
 */

$this->pagetitle = Yii::app()->name . ' - Detalhes NCM';
$this->breadcrumbs=array(
	'NCM'=>array('index'),
	$model->ncm,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codncm)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('ncm/delete', array('id' => $model->codncm))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo Yii::app()->format->formataNcm($model->ncm); ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'codncm',
			'value'=>Yii::app()->format->formataCodigo($model->codncm),
		),
		array(
			'name'=>'ncm',
			'value'=>Yii::app()->format->formataNcm($model->ncm),
		),
		array(
			'name'=>'codncmpai',
			'value'=>(!empty($model->codncmpai))?CHtml::link(CHtml::encode(Yii::app()->format->formataNcm($model->NcmPai->ncm)),array('ncm/view','id'=>$model->codncmpai)):null,
			'type'=>'raw'
		),
		array(
			'name'=>'descricao',
			'value'=>nl2br(CHtml::encode($model->descricao)),
			'type'=>'raw',
		),
	),
)); 

$this->widget('UsuarioCriacao', array('model'=>$model));

?>
<div class="row-fluid">
	<div class="span4">

		<h3>ICMS/ST <small>Regulamento de ICMS Substituição Tributária do Estado de Mato Grosso - Anexo X</small></h3>
		<?php
		$itens = $model->regulamentoIcmsStMtsDisponiveis();
		foreach ($itens as $item)
		{
			?>
			<div class="well well-small">
			<?php
			$this->widget('bootstrap.widgets.TbDetailView',array(
				'data'=>$item,
				'attributes'=>array(
					array(
						'name'=>'codregulamentoicmsstmt',
						'value'=>Yii::app()->format->formataCodigo($item->codregulamentoicmsstmt),
					),
					'subitem',
					'descricao',
					array(
						'name'=>'ncm',
						'value'=>Yii::app()->format->formataNcm($item->ncm),
					),
					'ncmexceto',
					'icmsstsul',
					'icmsstnorte',
				),
			));
			$this->widget('UsuarioCriacao', array('model'=>$item));
			?>
			</div>
			<?php
		}

		?>
	</div>
	<div class="span4">

		<h3>CEST <small>Código Especificador da Substituição Tributária - Anexo I</small></h3>
		<?php
		$itens = $model->cestsDisponiveis();
		foreach ($itens as $item)
		{
			?>
			<div class="well well-small">
			<?php
			$this->widget('bootstrap.widgets.TbDetailView',array(
				'data'=>$item,
				'attributes'=>array(
					array(
						'name'=>'codcest',
						'value'=>Yii::app()->format->formataCodigo($item->codcest),
					),
					array(
						'name'=>'cest',
						'value'=>Yii::app()->format->formataCest($item->cest),
					),
					array(
						'name'=>'ncm',
						'value'=>Yii::app()->format->formataNcm($item->ncm),
					),
					'descricao',
				),
			));
			$this->widget('UsuarioCriacao', array('model'=>$item));
			?>
			</div>
			<?php
		}

		?>
	</div>
	<div class="span4">
		<h3>IBPT <small>Instituto Brasileiro de Planejamento e Tributação</small></h3>
		<?php
		foreach ($model->Ibptaxs as $item)
		{
			?>
			<div class="well well-small">
			<?php
			$this->widget('bootstrap.widgets.TbDetailView',array(
				'data'=>$item,
				'attributes'=>array(
					array(
						'name'=>'codibptax',
						'value'=>Yii::app()->format->formataCodigo($item->codibptax),
					),
					array(
						'name'=>'codigo',
						'value'=>Yii::app()->format->formataNcm($item->codigo),
					),
					'ex',
					'tipo',
					'descricao',
					array(
						'name'=>'nacionalfederal',
						'value'=>Yii::app()->format->formatNumber($item->nacionalfederal) . '%',
					),
					array(
						'name'=>'importadosfederal',
						'value'=>Yii::app()->format->formatNumber($item->importadosfederal) . '%',
					),
					array(
						'name'=>'estadual',
						'value'=>Yii::app()->format->formatNumber($item->estadual) . '%',
					),
					array(
						'name'=>'municipal',
						'value'=>Yii::app()->format->formatNumber($item->municipal) . '%',
					),
					'vigenciainicio',
					'vigenciafim',
					'chave',
					'versao',
					'fonte',
				),
			));
			$this->widget('UsuarioCriacao', array('model'=>$item));
			?>
			</div>
			<?php
		}

		?>
	</div>
</div>
<?php 
$itens = $model->Ncms;
if (sizeof($itens) > 0)
{
	?>
	<h3>Filhos</h3>
	<div class="row-fluid">
		<?php
		foreach ($itens as $item)
		{
			?>
			<div class="registro row-fluid">
				<div class="span1">
					<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataNcm($item->ncm)),array('ncm/view','id'=>$item->codncm)); ?>
				</div>
				<div class="span11">
					<?php echo $item->descricao; ?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}
?>