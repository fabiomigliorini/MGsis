<?php
$this->pagetitle = Yii::app()->name . ' - Cheques';
$this->breadcrumbs=array(
	'Cheques',
);

$this->menu=array(
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
?>

<script type='text/javascript'>

$(document).ready(function(){
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

<h1>Cheques	</h1>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'id' => 'search-form',
	'type' => 'inline',
	'method'=>'get',
)); 

?>
<div class="well well-small">
	<div class='row-fluid'>
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
		<div class="span6">
			<div class="row-fluid">
				<?php echo $form->textField($model, 'codcheque', array('placeholder' => '#', 'class'=>'input-mini')); ?>
				<?php echo $form->textField($model, 'emitente', array('placeholder' => 'Emitente', 'class'=>'input-large')); ?>
				<?php echo $form->textField($model, 'destino', array('placeholder' => 'Destino', 'class'=>'input-large')); ?>
			</div>
			<div class="row-fluid">
				<?php echo $form->textField($model, 'motivodevolucao', array('placeholder' => 'Motivo Devolução', 'class'=>'input-large')); ?>
				<?php echo $form->select2($model, 'codstatus', Cheque::getStatusListaCombo(), array('placeholder' => 'Status', 'class'=>'input-medium')); ?>
				&nbsp
				<?php
					echo $form->select2(
						$model, 
						'codbanco', 
						Banco::getListaCombo(), 
						array(
							'placeholder'=>'Banco',
							'class' => 'input-medium'
						)
					);
				?>
			</div>
		</div>
		<div class="span5">
			<div class="row-fluid">
				<?php 
					echo $form->datepickerRow(
							$model,
							'vencimento_de',
							array(
								'class' => 'input-mini text-center', 
								'options' => array(
									'format' => 'dd/mm/yy'
									),
								'placeholder' => 'Vencimento',
								'prepend' => 'De',
								)
							); 	
				?>
				<?php 
					echo $form->datepickerRow(
							$model,
							'vencimento_ate',
							array(
								'class' => 'input-mini text-center', 
								'options' => array(
									'format' => 'dd/mm/yy'
									),
								'placeholder' => 'Vencimento',
								'prepend' => 'Até',
								)
							); 	
				?>
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
			</div>
			<div class="row-fluid">
				<?php 
				echo $form->datepickerRow(
						$model,
						'repasse_de',
						array(
							'class' => 'input-mini text-center', 
							'options' => array(
								'format' => 'dd/mm/yy'
								),
							'placeholder' => 'Repasse',
							'prepend' => 'De',
							)
						); 	
				?>
				<?php 
					echo $form->datepickerRow(
							$model,
							'repasse_ate',
							array(
								'class' => 'input-mini text-center', 
								'options' => array(
									'format' => 'dd/mm/yy'
									),
								'placeholder' => 'Repasse',
								'prepend' => 'Até',
								)
							); 	
				?>
				<?php 
					echo $form->datepickerRow(
							$model,
							'devolucao_de',
							array(
								'class' => 'input-mini text-center', 
								'options' => array(
									'format' => 'dd/mm/yy'
									),
								'placeholder' => 'Devolução',
								'prepend' => 'De',
								)
							); 	
				?>
				<?php 
					echo $form->datepickerRow(
							$model,
							'devolucao_ate',
							array(
								'class' => 'input-mini text-center', 
								'options' => array(
									'format' => 'dd/mm/yy'
									),
								'placeholder' => 'Devolução',
								'prepend' => 'Até',
								)
							); 	
				?>
			</div>
		</div>
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
