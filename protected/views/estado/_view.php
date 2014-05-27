<div class="registro row-fluid">
		
		<small class="span1 muted"><?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codestado)); ?></small>
		
		<b class="span1"><?php echo CHtml::link(CHtml::encode($data->estado),array('view','id'=>$data->codestado)); ?></b>

		<small class="span1"><?php echo CHtml::encode($data->Pais->pais); ?></small>

		<small class="span1"><?php echo CHtml::encode($data->sigla); ?></small>

		<small class="span1"><?php echo CHtml::encode($data->codigooficial); ?></small>

</div>