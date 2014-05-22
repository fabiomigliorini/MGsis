<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes do Negócio';
$this->breadcrumbs=array(
	'Negócios'=>array('index'),
	$model->codnegocio,
);

$this->menu=array(
array('label'=>'Listagem (F1)', 'icon'=>'icon-list-alt', 'url'=>array('index'), 'linkOptions'=> array('id'=>'btnListagem')),
array('label'=>'Novo (F2)', 'icon'=>'icon-plus', 'url'=>array('create'), 'linkOptions'=> array('id'=>'btnNovo')),
array('label'=>'Fechar Negócio (F3)', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnegocio), 'visible'=>($model->codnegociostatus==1), 'linkOptions'=>	array('id'=>'btnFechar')),
array('label'=>'Cancelar', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

$this->renderPartial("_hotkeys");

?>

<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
	$('body').on('click','#btnExcluir',function() {
		bootbox.confirm("Excluir este registro?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('negocio/delete', array('id' => $model->codnegocio))?>",{});
		});
	});
});
/*]]>*/
</script>


<div class="row-fluid">

	<div class="span8">
		<?php
			$this->widget(
				'bootstrap.widgets.TbTabs',
				array(
					'type' => 'tabs', // 'tabs' or 'pills'
					'tabs' => array(
						array(
							'label' => 'Produtos',
							'content' => $this->renderPartial('_view_produtos', array('model'=>$model), true),
							'active' => true
						),
						array(
							'label' => 'Notas Fiscais',
							'content' => $this->renderPartial('_view_notas', array('model'=>$model), true),
						),
						array(
							'label' => 'Cupons Fiscais',
							'content' => $this->renderPartial('_view_cupons', array('model'=>$model), true),
						),
						array(
							'label' => 'Títulos',
							'content' => $this->renderPartial('_view_titulos', array('model'=>$model), true),
						),
					),
				)
			);	
		?>
	</div>
	
	<div class="span4">

		<?php if ($model->codnegociostatus == 3): ?>
			<div class="alert alert-danger">
				<b>Cancelado em <?php echo CHtml::encode((empty($model->alteracao)?$model->lancamento:$model->alteracao)); ?> </b>
			</div>
		<?php endif; ?>

		<div id="totais">
			<?php $this->renderPartial('_view_totais', array('model'=>$model));	?>
		</div>
		
		<?php 
		$this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array(
					'name'=>'codnegocio',
					'value'=> Yii::app()->format->formataCodigo($model->codnegocio),
					),
				array(
					'name'=>'codnaturezaoperacao',
					'value'=>
						((isset($model->Operacao))?$model->Operacao->operacao:null)
						. " - " .
						((isset($model->NaturezaOperacao))?$model->NaturezaOperacao->naturezaoperacao:null),
					),
				array(
					'name'=>'codpessoa',
					'value'=>(isset($model->Pessoa))?CHtml::link(CHtml::encode($model->Pessoa->fantasia),array('pessoa/view','id'=>$model->codpessoa)):null,
					'type'=>'raw',
					),
				array(
					'name'=>'codpessoavendedor',
					'value'=>(isset($model->PessoaVendedor))?$model->PessoaVendedor->fantasia:null,
					),
				'lancamento',
				array(
					'name'=>'codnegociostatus',
					'value'=>(isset($model->NegocioStatus))?$model->NegocioStatus->negociostatus:null,
					),
				array(
					'name'=>'codfilial',
					'value'=>(isset($model->Filial))?$model->Filial->filial:null,
					),
				array(
					'name'=>'codusuario',
					'value'=>(isset($model->Usuario))?$model->Usuario->usuario:null,
					),
				'observacoes',
				),
			)); 
		
			
			$this->widget('UsuarioCriacao', array('model'=>$model));

		?>
	</div>
</div>