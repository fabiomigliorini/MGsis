<?php
$this->pagetitle = Yii::app()->name . ' - Negócios';
$this->breadcrumbs=array(
	'Negócios',
);

$this->menu=array(
	array('label'=>'Novo (F2)', 'icon'=>'icon-plus', 'url'=>array('create'), 'linkOptions'=> array('id'=>'btnNovo')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	array(
		'label'=>'Relatório', 
		'icon'=>'icon-print', 
		'url'=>array('relatorio'), 
		'linkOptions'=>array('id'=>'btnMostrarRelatorio'),
		),
	);

$this->renderPartial("_hotkeys");

?>

<script type='text/javascript'>

$(document).ready(function(){
	
	//abre janela Relatorio
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

	/*
	$('#search-form').change(function(){
		var ajaxRequest = $("#search-form").serialize();
		$.fn.yiiListView.update(
			// this is the id of the CListView
			'Listagem',
			{data: ajaxRequest}
		);
    });
	*/
});
</script>

<div id="modalRelatorio" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">  
		<div class="pull-right">
			<button class="btn" data-dismiss="modal">Fechar</button>
		</div>
		<h3>Relatório de Negocios</h3>  
	</div>  
	<div class="modal-body">
      <iframe src="" id="frameRelatorio" name="frameRelatorio" width="99.6%" height="400" frameborder="0"></iframe>
	</div>
</div>

<h1>Negócios</h1>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id' => 'search-form',
	'type' => 'inline',
	'method'=>'get',
)); 

?>
<div class="well well-small">
	<div class="">
		<?php echo $form->textField($model, 'codnegocio', array('placeholder' => '#', 'class'=>'input-mini')); ?>

		<?php 

			echo $form->datetimepickerRow(
				$model,
				'lancamento_de',
				array(
					'class' => 'input-medium text-center', 
					'options' => array(
						'format' => 'dd/mm/yy hh:ii',
					),
					'placeholder' => 'Data Inicial',
					'prepend' => 'De',
				)
			);

			echo $form->datetimepickerRow(
				$model,
				'lancamento_ate',
				array(
					'class' => 'input-medium text-center', 
					'options' => array(
						'format' => 'dd/mm/yy hh:ii',
					),
					'placeholder' => 'Data',
					'prepend' => 'Até',
				)
			);
		?>
		<?php echo $form->select2($model, 'codfilial', Filial::getListaCombo(), array('placeholder'=>'Filial', 'class' => 'input-medium')); ?>
		<?php echo $form->select2($model, 'codnegociostatus', NegocioStatus::getListaCombo(), array('placeholder'=>'Status', 'class' => 'input-medium')); ?>
		<?php echo $form->select2($model, 'pagamento', array("a"=> "A Vista", "p"=> "A Prazo"), array('placeholder'=>'Pagamento', 'class' => 'input-medium')); ?>
	</div>
	<div class="">
		<?php echo $form->select2($model, 'codnaturezaoperacao', NaturezaOperacao::getListaCombo(), array('placeholder'=>'Natureza', 'class' => 'input-xlarge')); ?>
		<?php echo $form->select2Pessoa($model, 'codpessoa', array('class' => 'span5', 'inativo'=>true)); ?> 
		<?php echo $form->select2($model, 'codusuario', Usuario::getListaCombo(), array('placeholder'=>'Usuario', 'class' => 'input-medium')); ?>
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
