<div class="registro row-fluid">
	<b class="span1 text-right">
		<?php echo CHtml::link(CHtml::encode($data->codcfop),array('view','id'=>$data->codcfop)); ?>
	</b>
	
		<small class="span11"><?php echo nl2br(CHtml::encode($data->cfop)); ?></small>


</div>