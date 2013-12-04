<?php
$this->pagetitle = Yii::app()->name . ' - Usuario';
$this->breadcrumbs=array(
	'Usuario',
);

$this->menu=array(
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
?>

<h1>Usuario</h1>

<br>

<?php $form=$this->beginWidget('MGActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'type' => 'search',
	'method'=>'get',
)); 

?>

<div class="controls-row well well-small">
	<div class="span11">
	<?php 
		echo $form->textField($model, 'codusuario', array('placeholder' => '#', 'class'=>'span1')); 

		echo $form->textField($model, 'usuario', array('class' => 'span2', 'placeholder' => 'usuario')); 

		echo $form->select2Pessoa(
				$model, 
				'codpessoa',
				array('class' => 'span4', 'placeholder' => '-- Pessoa --')
				);
		

		echo $form->dropDownList(
				$model,
				'codfilial',
				Filial::getListaCombo(),
				array('prompt'=>'-- Filial --', 'class' => 'span2')                    
				);	
	 

	?>
	</div>
	<div class="span1 right">
	<?

	$this->widget('bootstrap.widgets.TbButton'
		, array(
			'buttonType' => 'submit',
			'icon'=>'icon-search',
			'label'=>'',
			)
		); 
	
	?>
	</div>
		
</div>

<?php $this->endWidget(); ?>

<?


/*
echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn'));
 
Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
	$('.search-form').toggle();
		return false;
		});
	$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('usuario-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");

<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
*/

/*
$this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'itemsTagName'=>'table',
	'template'=>'{sorter} {items} {pager}',
	)); 
 * 
 * 
 */

$this->widget('zii.widgets.CListView', array(
       'id' => 'Listagem',
       'dataProvider' => $dataProvider,
       'itemView' => '_view',
       'template' => '{items} {pager}',
		/* scroll infinito */
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