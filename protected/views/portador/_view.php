<div class="registro">
	<div class="row-fluid">
		<small class="span1 muted"><?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codportador)); ?></small>
		
		<b class="span2"><?php echo CHtml::link(CHtml::encode($data->portador),array('view','id'=>$data->codportador)); ?></b>

		<small class="span1"><?php echo CHtml::encode((isset($data->Banco)?$data->Banco->banco:"")); ?></small>
		
		<small class="span1"><?php echo CHtml::encode((isset($data->Filial)?$data->Filial->filial:"")); ?></small>

		<small class="span7"><?php echo CHtml::encode(($data->emiteboleto)?"Boleto":""); ?></small>
		
		
		<?php /*	
		<small class="span1 muted"><?php echo CHtml::encode($data->convenio); ?></small>
		
		<small class="span1 muted"><?php echo CHtml::encode($data->diretorioremessa); ?></small>
		
		<small class="span1 muted"><?php echo CHtml::encode($data->diretorioretorno); ?></small>
		
		<small class="span1 muted"><?php echo CHtml::encode($data->carteira); ?></small>
		 
		<small class="span1 text-right muted"><?php echo CHtml::encode($data->agencia); ?>-<?php echo CHtml::encode($data->agenciadigito); ?></small>
		
		<small class="span1 text-right muted"><?php echo CHtml::encode($data->conta); ?>-<?php echo CHtml::encode($data->contadigito); ?></small>

		
		*/ ?>
		
	</div>
</div>
