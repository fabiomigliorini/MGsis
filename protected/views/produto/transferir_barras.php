<?php

$this->pagetitle = Yii::app()->name . ' - Transferir Código de Barras';
$this->breadcrumbs=array(
	'Produtos'=>array('index'),
	$model->produto=>array('view','id'=>$model->codproduto),
	'Transferir Código de Barras',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codproduto)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);


Yii::app()->clientScript->registerCoreScript('yii');

?>

<h1><?php echo $model->produto; ?></h1>

<?php if (!empty($model->inativo)): ?>
	<div class="alert alert-danger">
		<b>Inativado em <?php echo CHtml::encode($model->inativo); ?> </b>
	</div>
<?php endif; ?>


<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'produto-form',
)); ?>

<?php 

$cods = array(null=>null);

foreach ($model->ProdutoBarras as $pb)
{
	
	if (isset($pb->ProdutoEmbalagem))
		$descr = $pb->ProdutoEmbalagem->UnidadeMedida->sigla . ' C/' . Yii::app()->format->formatNumber($pb->ProdutoEmbalagem->quantidade, 0);
	else
		$descr = $pb->UnidadeMedida->sigla;
	
	$descr .= ' - ' . $pb->barras;
	
	$cods[$pb->codprodutobarra] = $descr;
}

?>

<?php echo $form->errorSummary($model); ?>

<fieldset>

	<div class="control-group ">
		<label class="control-label required" for="codprodutobarra">
			Barras <span class="required">*</span>
		</label>
		<div class="controls">
			<?php
				echo CHtml::dropDownList(
					'Produto[codprodutobarra]', 
					isset($_POST['Produto']['codprodutobarra'])?$_POST['Produto']['codprodutobarra']:null, 
					$cods,
					array('class' => 'input-xlarge')
				);
			?>
		</div>
	</div>

	<div class="control-group ">
		<label class="control-label required" for="codprodutobarra">
			Novo código <span class="required">*</span>
		</label>
		<div class="controls">
			<?php
				$this->widget('MGSelect2ProdutoBarra', 
					array(
						'name' => 'Produto[codprodutobarranovo]', 
						'htmlOptions' => array(
							//'class' => 'span12', 
							//'placeholder' => 'Pesquisa de Produtos ($ ordena por preço)'
							),
						)
					); 
			?>
		</div>
	</div>
	
</fieldset>

<div class="form-actions">
    
    <?php 

        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Transferir',
                'icon' => 'icon-ok',
                )
            ); 
	?>
    
</div>


<script type='text/javascript'>
	
$(document).ready(function() {

	$('#produto-form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm('Tem certeza que deseja transferir o código de barra selecionado? <br><br> <b class="text-error">Não será possível desfazer esta ação!</b>', function(result) {
            if (result) {
                currentForm.submit();
            }
        });
    });
	
});

</script>
	
<?php	
/*
$this->widget(
    'bootstrap.widgets.TbRadioButtons',
    array(
        //'asDropDownList' => false,
        'name' => 'clevertech',
        'options' => array(
            //'tags' => array('clever', 'is', 'better', 'clevertech'),
            'placeholder' => 'type clever, or is, or just type!',
            //'width' => '40%',
            'rows' => '4',
            'tokenSeparators' => array(',', ' ')
        )
    )
);
*/

/*
echo $form->dropDownListRow(
	$model,
	'multiDropdown',
	array('1', '2', '3', '4', '5'),
	array('multiple' => true)
);
 * 
 */ 

?>

<?php $this->endWidget(); ?>

