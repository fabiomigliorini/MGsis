<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Certidão';
$codpessoacertidao = Yii::app()->format->formataCodigo($model->codpessoacertidao);
$this->breadcrumbs=array(
	'Pessoas'=>array('pessoa/index'),
	$model->Pessoa->pessoa=>array('pessoa/view', "id"=>$model->codpessoa),
	"Certidão {$codpessoacertidao}",
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('pessoa/view', 'id'=>$model->codpessoa)),
	array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codpessoacertidao)),
	array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
);

Yii::app()->clientScript->registerCoreScript('yii');

?>
<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
	jQuery('body').on('click','#btnExcluir',function() {
		bootbox.confirm("Excluir este registro?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('pessoaCertidao/delete', array('id' => $model->codpessoacertidao))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1>Certidão <?php echo CHtml::encode($codpessoacertidao); ?></h1>
<?php if (!empty($model->inativo)): ?>
	<div class="alert alert-danger">
		<b>Inativado em <?php echo CHtml::encode($model->inativo); ?> </b>
	</div>
<?php endif; ?>

<?php
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'numero',
		'autenticacao',
		'validade',
		array(
			'name'=>'codcertidaoemissor',
			'value'=>$model->CertidaoEmissor->certidaoemissor,
		),
		array(
			'name'=>'codcertidaotipo',
			'value'=>$model->CertidaoTipo->certidaotipo,
		),
		'inativo',
		),
	));

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
