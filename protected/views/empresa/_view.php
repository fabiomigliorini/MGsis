<div class="registro row-fluid">
	<small class="span1 muted">
            <?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codempresa)); ?>
	</small>
	
        <b class="span11">
            <?php echo CHtml::link(CHtml::encode($data->empresa),array('view','id'=>$data->codempresa)); ?>
        </b>

</div>