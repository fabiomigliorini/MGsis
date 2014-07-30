<?php

$imgs = $model->getImagens();

if (sizeof($imgs) > 0)
{
	?>
		<div id="myCarousel" class="carousel slide">
			<ol class="carousel-indicators alert alert-info">
				<?php
				for ($i = 0; $i<sizeof($imgs); $i++)
				{
					?>
					<li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i==0)?"active":""; ?>"></li>
					<?
				}
				?>
			</ol>
			<!-- Carousel items -->
			<div class="carousel-inner">
				<?php
				$i=0;
				foreach ($imgs as $img)
				{
					?>
					<div class="<?php echo ($i==0)?"active":""; ?> item">
						<center>
							
								<?php //echo CHtml::image( Yii::app()->baseUrl . $img, '', array('style' => 'min-height: 60%')); ?>
								<?php echo CHtml::image( Yii::app()->baseUrl . $img, '', array('style' => 'max-height: 60%')); ?>
							
						</center>
					</div>
					<?
					$i++;
				}
				?>

			</div>
			
			<!-- Carousel nav -->
			<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
			<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
		</div>
	<?php
}
?>
<script type='text/javascript'>
	
$(document).ready(function() {
	$('.carousel').carousel({
		interval: 3000
	});
});

</script>