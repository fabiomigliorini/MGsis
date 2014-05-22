<div class="row-fluid">
	<?php
	if ($model->codnegociostatus == NegocioStatus::FECHADO)
	{
		?>
		<a href="#">Gerar Nova Nota</a>
		<hr>
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
