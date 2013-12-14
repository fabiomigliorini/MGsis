<div class="registro">
	<div class="row-fluid">
	<div class="span2 codigo">
		<?php echo CHtml::encode($data->getAttributeLabel('codportador')); ?>:
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codportador)),array('view','id'=>$data->codportador)); ?>
	</div>
	
		<div class="span2 detalhes"><?php echo CHtml::encode($data->portador); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->codbanco); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->agencia); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->agenciadigito); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->conta); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->contadigito); ?></div>

		<?php /*
		<div class="span2 detalhes"><?php echo CHtml::encode($data->emiteboleto); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->codfilial); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->convenio); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->diretorioremessa); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->diretorioretorno); ?></div>

		<div class="span2 detalhes"><?php echo CHtml::encode($data->carteira); ?></div>

		*/ ?>
	</div>
</div>