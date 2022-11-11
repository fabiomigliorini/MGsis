<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Item NFe de Terceiros';
$this->breadcrumbs=array(
	'NFe de Terceiros'=>array('nfeTerceiro/index'),
	$model->NfeTerceiro->nfechave=>array('nfeTerceiro/view', 'id' => $model->codnfeterceiro),
	$model->xprod=>array('nfeTerceiroItem/view', 'id' => $model->codnfeterceiroitem),
	'Alterar'
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('nfeTerceiro/view', 'id'=>$model->codnfeterceiro)),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnfeterceiroitem)),
);
?>

<h1>
	Abrir Kit Item <?php echo $model->xprod; ?>
</h1>
<br>

<?php


$form=$this->beginWidget('MGActiveForm', array(
	'action'=> array('dividirSalvar', 'id'=>$model->codnfeterceiroitem),
	'id'=>'nfe-terceiro-item-dividir',
));


?>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
	<fieldset>
		<div class="span8">
			<div class="row-fluid">
				<div class="span6">
					<div class="control-group ">
						<label class="control-label" for="NfeTerceiroItem_margem">
							Produto
						</label>
						<div class="controls">
							<?php echo $model->xprod; ?>  <br />
							<?php echo $model->cprod; ?> <br />
							<?php echo $model->cean; ?> <br />
							<?php echo $model->ceantrib; ?> <br />
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label" for="NfeTerceiroItem_margem">
							Quantidade de Tamanhos
						</label>
						<div class="controls">
							<select name="NfeTerceiroItem_parcelas">
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
								<option>6</option>
								<option>10</option>
							</select>
						</div>
					</div>
				</div>
			</div>

		</div>
	</fieldset>
</div>
<div class="form-actions">


    <?php


        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Salvar',
                'icon' => 'icon-ok',
                )
            );
	?>

</div>

<?php $this->endWidget(); ?>

<script type='text/javascript'>

$(document).ready(function() {

	// $("#NfeTerceiroItem_parcelas").select2();

	$('#nfe-terceiro-item-dividir').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
            if (result) {
                currentForm.submit();
            }
        });
    });

});

</script>

<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>
