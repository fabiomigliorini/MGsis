<?php

/**
 * @var NfeTerceiro $model
 */
$this->pagetitle = Yii::app()->name . ' - Pesquisar na Sefaz NFe de Terceiros';
$this->breadcrumbs=array(
	'NFe de Terceiros'=>array('index'),
	'Pesquisar na Sefaz',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	//array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnfeterceiro)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Pesquisar na Sefaz NFe de Terceiros</h1>
<br>

<?php 

	$form=$this->beginWidget('MGActiveForm',array(
		'id'=>'nfe-terceiro-form',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>false,	
	)); 

?>

<?php
	echo $form->select2Row($model,'codfilial', Filial::model()->getListaCombo() , array('class'=>'input-medium'));
	echo $form->textFieldRow($model,'nsu',array('class'=>'input-medium text-right'));
?>
<div class="form-actions">
<?php 
	$this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'buttonType' => 'submit',
			'type' => 'primary',
			'label' => 'Pesquisar',
			'icon' => 'icon-ok',
			)
		);
	
	
?>
</div>

<?php $this->endWidget(); ?>

<?php 

	//busca o ultimo nsu das filiais
	$command = Yii::app()->db->createCommand(' 
		SELECT codfilial, MAX(nsu) AS nsu FROM tblnfeterceiro GROUP BY codfilial
		');
	$nsus = $command->queryAll();
	$arrNsu = array();
	foreach ($nsus as $nsu)
		$arrNsu[$nsu["codfilial"]] = $nsu["nsu"];
	
	if (!empty($model->codfilial) && !empty($model->nsu))
		$arrNsu[$model->codfilial] = $model->nsu;

	//converte pra json para passar pro JS
	$nsu = json_encode($arrNsu);

?>

<script type='text/javascript'>
	
$(document).ready(function() {

    var arrNsu = <?php echo $nsu; ?>;
	
	$('#NfeTerceiro_codfilial').change(function () {
		var codfilial = $('#NfeTerceiro_codfilial').select2('val');
		var nsu = arrNsu[codfilial];
		$('#NfeTerceiro_nsu').val(nsu);
	});

	$('#nfe-terceiro-form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm("Tem certeza que deseja executar a consulta?", function(result) {
            if (result) {
				bootbox.alert("Fazendo consulta na Sefaz, aguarde esta operação pode <b>demorar alguns minutos</b>...");
                currentForm.submit();
            }
        });
    });
	
});

</script>
