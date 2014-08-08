<?php
$this->pagetitle = Yii::app()->name . ' - Liquidação de Títulos';
$this->breadcrumbs=array(
	'Liquidação de Títulos',
);

$this->menu=array(
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	array(
		'label'=>'Relatório', 
		'icon'=>'icon-print', 
		'url'=>array('relatorio'), 
		'linkOptions'=>array('id'=>'btnMostrarRelatorio'),
	),
);
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
		$('#modalRelatorio').modal({show:true})
		$('#modalRelatorio').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
	});	
	
	$("#LiquidacaoTitulo_estornado").select2();
	$("#LiquidacaoTitulo_codportador").select2({allowClear: true});
	$("#LiquidacaoTitulo_codusuariocriacao").select2({allowClear: true});
	
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
		<h3>Relatório de Títulos</h3>  
	</div>  
	<div class="modal-body">
      <iframe src="" id="frameRelatorio" name="frameRelatorio" width="99.6%" height="400" frameborder="0"></iframe>
	</div>
</div>

<h1>Liquidação de Títulos</h1>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id' => 'search-form',
	'type' => 'inline',
	'method'=>'get',
)); 

?>
<div class="well well-small">
	<?php echo $form->textField($model, 'codliquidacaotitulo', array('placeholder' => '#', 'class'=>'input-mini')); ?>
	<?php echo $form->select2Pessoa($model, 'codpessoa', array('class'=>'input-xxlarge')); ?>	
	<?php echo $form->dropDownList($model, 'estornado', array('0' => 'Não Estornados', 1 => 'Estornados', 9 => 'Todos'), array('placeholder' => 'Estornado', 'class'=>'input-medium')); ?>
	<?php
		echo $form->dropDownList(
				$model,
				'codportador',
				Portador::getListaCombo(),
				array(
					'prompt'=>'', 
					'placeholder'=>'Portador',
					'class' => 'input-medium'
					)
				);	
	?>
	<?php 
		echo $form->datepickerRow(
				$model,
				'criacao_de',
				array(
					'class' => 'input-mini text-center', 
					'options' => array(
						'format' => 'dd/mm/yy'
						),
					'placeholder' => 'Criação',
					'prepend' => 'De',
					)
				); 	
	?>
	<?php 
		echo $form->datepickerRow(
				$model,
				'criacao_ate',
				array(
					'class' => 'input-mini text-center', 
					'options' => array(
						'format' => 'dd/mm/yy'
						),
					'placeholder' => 'Criação',
					'prepend' => 'Até',
					)
				); 	
	?>
	<?php
		echo $form->dropDownList(
				$model,
				'codusuariocriacao',
				Usuario::getListaCombo(),
				array('prompt'=>'', 'placeholder' => 'Usuário', "class"=>"input-medium")
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
