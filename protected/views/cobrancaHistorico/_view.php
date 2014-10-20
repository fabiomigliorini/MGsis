<div class="registro row-fluid">
	<small class="span1">
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codcobrancahistorico)),array('cobrancaHistorico/view','id'=>$data->codcobrancahistorico)); ?>
	</small>

	<small class="span2 muted">
		<?php echo CHtml::encode($data->alteracao); ?>
		&nbsp;&nbsp;
		<?php echo CHtml::encode($data->UsuarioAlteracao->usuario); ?>
	</small>
	
	<div class="span8">
		<?php echo nl2br(CHtml::encode($data->historico)); ?>
	</div>


</div>

<pre>
	<?php
	echo print_r($data);
	?>
</pre>