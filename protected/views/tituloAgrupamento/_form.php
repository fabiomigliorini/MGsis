<?php

$form = $this->beginWidget('MGActiveForm', array(
    'id' => 'titulo-agrupamento-form',
));

echo $form->errorSummary($model);

?>

<fieldset>


    <?php
    $this->widget(
        'bootstrap.widgets.TbWizard',
        array(
            'type' => 'tabs',
            'tabs' => array(
                array('label' => 'Títulos', 'content' => $this->renderPartial('_form_titulos', array('model' => $model, 'form' => $form), true), 'active' => false),
                array('label' => 'Vencimentos', 'content' => $this->renderPartial('_form_vencimentos', array('model' => $model, 'form' => $form), true), 'active' => false),
                array('label' => 'Finalizar', 'content' => $this->renderPartial('_form_finalizar', array('model' => $model, 'form' => $form), true), 'active' => false),
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

        $('#titulo-agrupamento-form').submit(function(e) {
            var currentForm = this;
            e.preventDefault();
            bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
                if (result) {
                    currentForm.submit();
                }
            });
        });

        $('#Titulo_codfilial').on("change", function(e) {
            buscaTitulos();
        });
        $('#Titulo_codgrupoeconomico').on("change", function(e) {
            if ($('#Titulo_codgrupoeconomico').select2('val')) {
                $('#TituloAgrupamento_codpessoa').select2('val', null);
                buscaTitulos();
            }
        });
        $('#TituloAgrupamento_codpessoa').on("change", function(e) {
            buscaTitulos();
        });
        $('#Titulo_credito').on("change", function(e) {
            buscaTitulos();
        });
        $('#Titulo_credito').select2({
            allowClear: true
        });
        $('#Titulo_vencimento_de').on("change", function(e) {
            buscaTitulos();
        });
        $('#Titulo_vencimento_ate').on("change", function(e) {
            buscaTitulos();
        });

    });
</script>