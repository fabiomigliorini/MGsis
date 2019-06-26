<div class="registro">
	<div class="row-fluid">
		<small class="span1">
			<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codmarca)),array('view','id'=>$data->codmarca)); ?>
		</small>
		<span class="span1">
			<?php 
			$arq = Yii::app()->basePath . "/../images/marca/" . $data->codmarca . ".jpg";
			if (file_exists($arq))
				echo CHtml::image( Yii::app()->baseUrl . "/images/marca/" . $data->codmarca . ".jpg", '', array('style' => 'width: 70px')); 
			?>
		</span>
		<b class="span3">
			<?php echo CHtml::link(CHtml::encode($data->marca),array('view','id'=>$data->codmarca)); ?>
		</b>
		<small class="span2 muted">
			<?php 
			if (!empty($data->site))
				echo CHtml::encode("Disponível no Site"); 
			?>
		</small>
		<small class="span5 muted"><?php echo CHtml::encode($data->descricaosite); ?></small>
	</div>
</div>