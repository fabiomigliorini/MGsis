<div class="registro row-fluid">
	<small class="span1 muted">
		<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codformapagamento)); ?>
	</small>
	
		<b class="span3"><?php echo CHtml::link(CHtml::encode($data->formapagamento),array('view','id'=>$data->codformapagamento)); ?> </b>

		<small class="span1"><?php echo ($data->boleto)?"Boleto":""; ?></small>

		<small class="span1"><?php echo ($data->fechamento)?"Fechamento":""; ?></small>

		<small class="span1"><?php echo ($data->notafiscal)?"Nota Fiscal":""; ?></small>

		<small class="span1"><?php echo ($data->avista)?"Á Vista":"Á prazo"; ?></small>
		
		<small class="span1"><?php echo CHtml::encode($data->parcelas); ?></small>

		<small class="span3"><?php echo CHtml::encode($data->diasentreparcelas); ?></small>


		<?php /*
		<small class="span1 muted"><?php echo CHtml::encode($data->formapagamentoecf); ?></small>
		 
		 <small class="span1 muted"><?php echo CHtml::encode($data->entrega); ?></small>
		*/ ?>
</div>