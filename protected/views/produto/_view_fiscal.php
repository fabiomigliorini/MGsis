
<?php 

$attributes = array(
	array(
		'name'=>'codncm',
		'value'=>(isset($model->Ncm))?'<b>' . CHtml::link(CHtml::encode(Yii::app()->format->formataNcm($model->Ncm->ncm)),array('ncm/view','id'=>$model->codncm)) . '</b> - ' . $model->Ncm->descricao:null,
		'type'=>'raw',
	),
	array(
		'name'=>'codcest',
		'value'=>(isset($model->Cest))?'<b>' . Yii::app()->format->formataNcm($model->Cest->ncm) . '/' . Yii::app()->format->formataCest($model->Cest->cest) . '</b> - ' . $model->Cest->descricao:null,
		'type'=>'raw',
	),
);
if (isset($model->Ncm))
{
	foreach ($model->Ncm->Ibptaxs as $ibpt)
	{
		$attributes[] = array(
			'label'=>'IBPT',
			'value'=>
				'<b>' . $ibpt->descricao . '</b><br>' .
				'Federal Nacional: ' . Yii::app()->format->formatNumber($ibpt->nacionalfederal) . '%<br>' .
				'Federal Importado: ' . Yii::app()->format->formatNumber($ibpt->nacionalfederal) . '%<br>' .
				'Estadual: ' . Yii::app()->format->formatNumber($ibpt->estadual) . '%<br>' .
				'Municipal: ' . Yii::app()->format->formatNumber($ibpt->municipal) . '%<br>',
			'type'=>'raw',		
		);
	}

	$regs = $model->Ncm->regulamentoIcmsStMtsDisponiveis();

	$value = '';
	foreach ($regs as $reg)
	{
		$value .= '<b>' . Yii::app()->format->formataNcm($reg->ncm) . '/' . $reg->subitem . '</b> - ' . $reg->descricao . '<br>' .
				((!empty($reg->ncmexceto))?'Exceto NCM: ' . $reg->ncmexceto . '<br>':'');
	}
	$attributes[] = array(
		'label'=>'Regulamento ICMS ST/MT',
		'value'=>$value,
		'type'=>'raw',
	);
}

/* monta link com tooltip da descricao do ncm */
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>$attributes
	)
);
?>
