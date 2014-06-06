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
	array(
		'label'=>'Imprimir Romaneio', 
		'icon'=>'icon-print', 
		'url'=>array('imprimeromaneio','id'=>$model->codnegocio), 
		'linkOptions'=>array('id'=>'btnMostrarRomaneio'),
		'visible'=>($model->codnegociostatus == 2)
	),
	array('label'=>'Cancelar', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

$this->renderPartial("_hotkeys");

?>

<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
	
	//abre janela vale
	var frameSrcRomaneio = $('#btnMostrarRomaneio').attr('href');
	$('#btnMostrarRomaneio').click(function(event){
		event.preventDefault();
		$('#modalRomaneio').on('show', function () {
			$('#frameRomaneio').attr("src",frameSrcRomaneio);
		});
		$('#modalRomaneio').modal({show:true})
		$('#modalRomaneio').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
	});	
		
	//imprimir Romaneio
	$('#btnImprimirRomaneio').click(function(event){
		window.frames["frameRomaneio"].focus();
		window.frames["frameRomaneio"].print();
	});
	
	//imprimir Romaneio Matricial
	$('#btnImprimirRomaneioMatricial').click(function(event){
		$('#frameRomaneio').attr("src",frameSrcRomaneio + "&imprimir=true");
	});
	
	$('body').on('click','#btnExcluir',function() {
		bootbox.confirm("Excluir este registro?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('negocio/delete', array('id' => $model->codnegocio))?>",{});
		});
	});
});
/*]]>*/
</script>

<div id="modalRomaneio" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<div class="pull-right">
			<div class="btn-group">
                <button class="btn dropdown-toggle btn-primary" data-toggle="dropdown">Imprimir <span class="caret"></span></button>
                <ul class="dropdown-menu">
					<li ><a id="btnImprimirRomaneio" href="#">Na Impressora Laser</a></button>
					<li ><a id="btnImprimirRomaneioMatricial" href="#">Na Impressora Matricial</a></button>
                </ul>
              </div>			
			<button class="btn" data-dismiss="modal">Fechar</button>
		</div>
		<h3>Romaneio</h3>  
	</div>
	<div class="modal-body">
      <iframe src="" id="frameRomaneio" name="frameRomaneio" width="99.6%" height="400" frameborder="0"></iframe>
	</div>
</div>


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