<div class="registro row-fluid">
	<div class="span1">
            <?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codempresa)); ?>
	</div>
	
        <b class="span11">
            <?php echo CHtml::link(CHtml::encode($data->empresa),array('view','id'=>$data->codempresa)); ?>
        </b>

</div>