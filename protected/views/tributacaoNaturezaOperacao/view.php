<?php

$titulo = $model->Tributacao->tributacao
		. ' / '
		. $model->NaturezaOperacao->naturezaoperacao
		. ' / '
		. $model->TipoProduto->tipoproduto
		. ' / ' ;

if (empty($model->codestado))
	$titulo .= 'Demais Estados';
else
	$titulo .= $model->Estado->sigla;

$titulo .= ' / ';

if (empty($model->ncm))
	$titulo .= 'Demais NCM\'s';
else
	$titulo .= $model->ncm;

$this->pagetitle = Yii::app()->name . ' - Detalhes Tributação Natureza Operação';
$this->breadcrumbs=array(
	'Natureza Operação'=>array('naturezaOperacao/index'),
	$model->NaturezaOperacao->naturezaoperacao=>array('naturezaOperacao/view', "id"=>$model->codnaturezaoperacao),
	$titulo
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('naturezaOperacao/view', 'id'=>$model->codnaturezaoperacao)),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create', 'codnaturezaoperacao'=>$model->codnaturezaoperacao)),
	array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codtributacaonaturezaoperacao)),
	array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
	array('label'=>'Duplicar', 'icon'=>'icon-retweet', 'url'=>array('create','duplicar'=>$model->codtributacaonaturezaoperacao)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('tributacaoNaturezaOperacao/delete', array('id' => $model->codtributacaonaturezaoperacao))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $titulo ?></h1>

<div class="row-fluid">
	<div class="span6">
		<h3>Chave</h3>
			<?php
			$this->widget('bootstrap.widgets.TbDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'codtributacaonaturezaoperacao',
					array(
						'name'=>'codtributacaonaturezaoperacao',
						'value'=>Yii::app()->format->formataCodigo($model->codtributacaonaturezaoperacao),
						),
					//'codtributacao',
					array(
								'name'=>'codtributacao',
								'value'=>(isset($model->Tributacao))?CHtml::link(CHtml::encode($model->Tributacao->tributacao),array('tributacao/view','id'=>$model->codtributacao)):null,
								'type'=>'raw',
								),
					//'codnaturezaoperacao',
					array(
								'name'=>'codnaturezaoperacao',
								'value'=>(isset($model->NaturezaOperacao))?CHtml::link(CHtml::encode($model->NaturezaOperacao->naturezaoperacao),array('naturezaOperacao/view','id'=>$model->codnaturezaoperacao)):null,
								'type'=>'raw',
								),
					//'codtipoproduto',
					array(
								'name'=>'codtipoproduto',
								'value'=>(isset($model->TipoProduto))?CHtml::link(CHtml::encode($model->TipoProduto->tipoproduto),array('tipoProduto/view','id'=>$model->codtipoproduto)):null,
								'type'=>'raw',
								),
					//'codestado',
					array(
								'name'=>'codestado',
								'value'=>(isset($model->Estado))?CHtml::link(CHtml::encode($model->Estado->estado),array('estado/view','id'=>$model->codestado)):null,
								'type'=>'raw',
								),
					'ncm',
					//'codcfop',
					array(
								'name'=>'codcfop',
								'value'=>(isset($model->Cfop))?CHtml::link(CHtml::encode($model->codcfop . " - " .  $model->Cfop->cfop),array('cfop/view','id'=>$model->codcfop)):null,
								'type'=>'raw',
								),
					),
				));
		?>
	</div>
	<div class="span6">
		<h3>Contábil</h3>
			<?php
			$this->widget('bootstrap.widgets.TbDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'acumuladordominiovista',
					'acumuladordominioprazo',
					'historicodominio',
					//'movimentacaofisica',
					array(
						'name'=>'movimentacaofisica',
						'value'=>($model->movimentacaofisica)?'Sim':'Não',
						),
					//'movimentacaocontabil',
					array(
						'name'=>'movimentacaocontabil',
						'value'=>($model->movimentacaocontabil)?'Sim':'Não',
						),
					),
				));
			?>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<h3>Lucro Presumido</h3>
		<div class="row-fluid">
			<div class="span3">
				<?php
				$this->widget('bootstrap.widgets.TbDetailView',array(
					'data'=>$model,
					'attributes'=>array(
						'icmscst',
							array(
								'name'=>'icmslpbase',
								'value'=>Yii::app()->format->formatNumber($model->icmslpbase, 2),
							),
							array(
								'name'=>'icmslppercentual',
								'value'=>Yii::app()->format->formatNumber($model->icmslppercentual, 2),
							),
						),
					));
				?>
			</div>
			<div class="span3">
				<?php
					$this->widget('bootstrap.widgets.TbDetailView',array(
						'data'=>$model,
						'attributes'=>array(
							'piscst',
							array(
								'name'=>'pispercentual',
								'value'=>Yii::app()->format->formatNumber($model->pispercentual, 2),
							),
						),
					));
				?>
			</div>
			<div class="span3">
				<?php
					$this->widget('bootstrap.widgets.TbDetailView',array(
						'data'=>$model,
						'attributes'=>array(
							'cofinscst',
							array(
								'name'=>'cofinspercentual',
								'value'=>Yii::app()->format->formatNumber($model->cofinspercentual, 2),
							),
						),
					));
				?>
			</div>
			<div class="span3">
				<?php
					$this->widget('bootstrap.widgets.TbDetailView',array(
						'data'=>$model,
						'attributes'=>array(
							'ipicst',
							array(
								'name'=>'csllpercentual',
								'value'=>Yii::app()->format->formatNumber($model->csllpercentual, 2),
							),
							array(
								'name'=>'irpjpercentual',
								'value'=>Yii::app()->format->formatNumber($model->irpjpercentual, 2),
							),
						),
					));
				?>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span3">
			<h3>Simples</h3>
			<?php
			$this->widget('bootstrap.widgets.TbDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'csosn',
					array(
						'name'=>'icmsbase',
						'value'=>Yii::app()->format->formatNumber($model->icmsbase, 2),
					),
					array(
						'name'=>'icmspercentual',
						'value'=>Yii::app()->format->formatNumber($model->icmspercentual, 2),
					),
				),
			));
			?>
		</div>
		<div class="span3">
			<h3>Produtor Rural</h3>
			<?php
			$this->widget('bootstrap.widgets.TbDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					array(
						'name'=>'certidaosefazmt',
						'value'=>($model->certidaosefazmt)?'Sim':'Não',
					),
					array(
						'name'=>'fethabkg',
						'value'=>Yii::app()->format->formatNumber($model->fethabkg, 6),
					),
					array(
						'name'=>'iagrokg',
						'value'=>Yii::app()->format->formatNumber($model->iagrokg, 6),
					),
					array(
						'name'=>'funruralpercentual',
						'value'=>Yii::app()->format->formatNumber($model->funruralpercentual, 5),
					),
					array(
						'name'=>'senarpercentual',
						'value'=>Yii::app()->format->formatNumber($model->senarpercentual, 5),
					),
				),
			));
			?>
		</div>
</div>

<?php
$this->widget('UsuarioCriacao', array('model'=>$model));
?>
