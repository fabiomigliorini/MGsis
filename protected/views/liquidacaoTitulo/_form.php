<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'liquidacao-titulo-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>


<?php
	$this->widget(
		'bootstrap.widgets.TbWizard', 
		array(
			'type' => 'tabs',
			'tabs' => array(
					array('label' => 'Títulos', 'content' => $this->renderPartial('_form_titulos', array('model'=>$model, 'form'=>$form), true), 'active' => false),
					array('label' => 'Finalizar', 'content' => $this->renderPartial('_form_finalizar', array('model'=>$model, 'form'=>$form), true), 'active' => false),
			),
			'pagerContent' => '<ul class="pager wizard">
									<li class="previous first" style="display:none;"><a href="#">Primeiro</a></li>
									<li class="previous"><a href="#">Anterior</a></li>
									<li class="next last" style="display:none;"><a href="#">Último</a></li>
									<li class="next"><a href="#">Próximo</a></li>
								</ul>',
			'placement' => 'top',
		)
	);
?>

	
</fieldset>

<?php $this->endWidget(); ?>

<script type='text/javascript'>
	
$(document).ready(function() {

	//$("#Pessoa_fantasia").Setcase();

	$('#liquidacao-titulo-form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
            if (result) {
                currentForm.submit();
            }
        });
    });
	
	$('#LiquidacaoTitulo_codpessoa').on("change", function(e) { 
		buscaTitulos();
	});
	
	
});

</script>