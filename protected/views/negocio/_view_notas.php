<div class="row-fluid">
	<b class="span4" style="font-size: 160%;">
		Notas Fiscais
	</b>
	<?php
	if ($model->codnegociostatus != 1)
	{
		?>
		<a href="#">Gerar Nova Nota</a>
		<?php
	}
	?>
</div>	
<div id="listagemNotas">
	<?php
	$this->renderPartial('_view_notas_listagem',
		array(
			'model'=>$model,
		));		
	?>
</div>
