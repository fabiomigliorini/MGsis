<?php
$this->pagetitle = Yii::app()->name . ' - Carregar NFe de Terceiro Via Arquivo XML';
$this->breadcrumbs=array(
	'NFe de Terceiros'=>array('index'),
	'Carregar NFe de Terceiro Via Arquivo XML',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Carregar NFe de Terceiro Via Arquivo XML</h1>

<?php 
$form=$this->beginWidget('MGActiveForm',
	array(
		'id'=>'nfe-terceiro-form',
        'enableAjaxValidation' => false,
		'htmlOptions' => array('enctype' => 'multipart/form-data')
	)
); 
?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
	
		echo $form->fileFieldRow(
			$model,
			'arquivoxml'
		);
	?>
</fieldset>
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

	//$("#Pessoa_fantasia").Setcase();

	$('#nfe-terceiro-form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm("Tem certeza que deseja carregar o arquivo selecionado?", function(result) {
            if (result) {
                currentForm.submit();
            }
        });
    });
	
});

</script>