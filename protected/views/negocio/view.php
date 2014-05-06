<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes do Negócio';
$this->breadcrumbs=array(
	'Negócios'=>array('index'),
	$model->codnegocio,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnegocio)),
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
							'label' => 'Documentos', 
							'content' => 'Ainda Vazio'
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