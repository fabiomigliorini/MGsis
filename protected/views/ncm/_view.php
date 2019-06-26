<div class="registro row-fluid">
	<small class="span1 muted">
		<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codncm)); ?>
	</small>
	
		<b class="span1">
            <?php echo CHtml::link(CHtml::encode($data->ncm),array('view','id'=>$data->codncm)); ?>
        </b>

		
		<small class="span6"><?php echo nl2br(CHtml::encode($data->descricao)); ?></small>

</div>