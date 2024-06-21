<?php
$this->pagetitle = Yii::app()->name . ' - Notas Fiscais';
$this->breadcrumbs=array(
	'Notas Fiscais',
);

$this->menu=array(
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	array(
		'label'=>'Relatório', 
		'icon'=>'icon-print', 
		'url'=>array('relatorio'), 
		'linkOptions'=>array('id'=>'btnMostrarRelatorio'),
		),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
?>

<script type='text/javascript'>

$(document).ready(function(){
	
	var frameSrcRelatorio = $('#btnMostrarRelatorio').attr('href');
	$('#btnMostrarRelatorio').click(function(event){
		event.preventDefault();
		$('#modalRelatorio').on('show', function () {
			$('#frameRelatorio').attr("src",frameSrcRelatorio);
		});
		$('#modalRelatorio').modal({show:true});
		$('#modalRelatorio').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
	});	
	
	$('#search-form').change(function(){
		var ajaxRequest = $("#search-form").serialize();
		$.fn.yiiListView.update(
			// this is the id of the CListView
			'Listagem',
			{data: ajaxRequest}
		);
    });
});

</script>

<div id="modalRelatorio" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">  
		<div class="pull-right">
			<button class="btn" data-dismiss="modal">Fechar</button>
		</div>
		<h3>Relatório de Notas Fiscais</h3>  
	</div>  
	<div class="modal-body">
      <iframe src="" id="frameRelatorio" name="frameRelatorio" width="99.6%" height="400" frameborder="0"></iframe>
	</div>
</div>

<h1>Notas Fiscais</h1>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id' => 'search-form',
	'type' => 'inline',
	'method'=>'get',
)); 

?>
<div class="well well-small">
	<?php echo $form->numberField($model, 'codnotafiscal', array('placeholder' => '#', 'class'=>'input-small text-center', 'type'=>'number', 'min'=>1, 'step'=>1)); ?>
	<?php echo $form->numberField($model, 'numero', array('placeholder' => 'Número', 'class'=>'input-small text-center', 'type'=>'number', 'min'=>0, 'step'=>1)); ?>
	<?php echo $form->select2Pessoa($model, 'codpessoa', array('placeholder' => 'Pessoa', 'class'=>'input-xxlarge')); ?>
	<?php echo $form->select2($model, 'codfilial', Filial::getListaCombo(), array('placeholder' => 'Filial', 'class'=>'input-medium')); ?>
	<?php echo $form->select2($model, 'codnaturezaoperacao', NaturezaOperacao::getListaCombo(), array('placeholder' => 'Natureza de Operação', 'class'=>'input-large')); ?>
	<?php echo $form->select2($model, 'codstatus', NotaFiscal::getStatusListaCombo(), array('placeholder' => 'Status', 'class'=>'input-medium')); ?>
	<?php echo $form->select2($model, 'modelo', NotaFiscal::getModeloListaCombo(), array('placeholder' => 'Modelo', 'class'=>'input-medium')); ?>
	<?php echo $form->select2($model, 'codoperacao', Operacao::getListaCombo(), array('placeholder' => 'Operacao', 'class'=>'input-medium')); ?>
		<?php 
			echo $form->datepickerRow(
					$model,
					'emissao_de',
					array(
						'class' => 'input-mini text-center', 
						'options' => array(
							'format' => 'dd/mm/yy'
							),
						'placeholder' => 'Emissão',
						'prepend' => 'De',
						)
					); 	
		?>
		<?php 
			echo $form->datepickerRow(
					$model,
					'emissao_ate',
					array(
						'class' => 'input-mini text-center', 
						'options' => array(
							'format' => 'dd/mm/yy'
							),
						'placeholder' => 'Emissão',
						'prepend' => 'Até',
						)
					); 	
		?>
		<?php 
			echo $form->datepickerRow(
					$model,
					'saida_de',
					array(
						'class' => 'input-mini text-center', 
						'options' => array(
							'format' => 'dd/mm/yy'
							),
						'placeholder' => 'Saída/Entrada',
						'prepend' => 'De',
						)
					); 	
		?>
		<?php 
			echo $form->datepickerRow(
					$model,
					'saida_ate',
					array(
						'class' => 'input-mini text-center', 
						'options' => array(
							'format' => 'dd/mm/yy'
							),
						'placeholder' => 'Saída/Entrada',
						'prepend' => 'Até',
						)
					); 	
		?>
	<?php
	$this->widget('bootstrap.widgets.TbButton'
		, array(
			'buttonType' => 'submit',
			'icon'=>'icon-search',
			//'label'=>'',
			'htmlOptions' => array('class'=>'pull-right btn btn-info')
			)
		); 
	?>
</div>

<?php $this->endWidget(); ?>


<?php
 
$this->widget(
	'zii.widgets.CListView', 
	array(
		'id' => 'Listagem',
		'dataProvider' => $dataProvider,
		'itemView' => '_view',
		'template' => '{items} {pager}',
		'pager' => array(
			'class' => 'ext.infiniteScroll.IasPager', 
			'rowSelector'=>'.registro', 
			'listViewId' => 'Listagem', 
			'header' => '',
			'loaderText'=>'Carregando...',
			'options' => array('history' => false, 'triggerPageTreshold' => 10, 'trigger'=>'Carregar mais registros'),
		)
	)
);
?>
