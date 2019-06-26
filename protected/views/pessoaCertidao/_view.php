<div class="registro row-fluid <?php echo (!empty($data->inativo))?"alert-danger":""; ?>">
	<small class="span1">
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codpessoacertidao)),array('pessoaCertidao/view','id'=>$data->codpessoacertidao)); ?>
	</small>
	<small class="span2 muted">
		<?php echo CHtml::encode($data->numero); ?>
		<?php echo CHtml::encode($data->autenticacao); ?>
		<?php if (!empty($data->inativo)): ?>
			<span class="label label-important pull-right">Inativado em <?php echo CHtml::encode($data->inativo); ?></span>
		<?php endif; ?>
	</small>
	<small class="span1">
		<?php echo CHtml::encode($data->validade); ?>
	</small>
	<small class="span2">
		<?php echo CHtml::encode($data->CertidaoEmissor->certidaoemissor); ?>
		<?php echo CHtml::encode($data->CertidaoTipo->certidaotipo); ?>
	</small>
</div>
