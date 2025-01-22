<?php
$this->pagetitle = Yii::app()->name . ' - Nova NFe de Terceiro';
$this->breadcrumbs = array(
    'NFe de Terceiros' => array('index'),
    'Nova',
);

$this->menu = array(
    array('label' => 'Listagem', 'icon' => 'icon-list-alt', 'url' => array('index')),
);
?>

<h1>Nova NFe de Terceiro</h1>

<?php
$form = $this->beginWidget('MGActiveForm', array(
    'id' => 'nfe-terceiro-form',
));
?>

<?php
echo $form->errorSummary($model);
?>


<fieldset>
    <div class="row">
        <div class="span6">
            <?php
            // echo $form->textFieldRow($model,'emitente',array('class'=>'span5','maxlength'=>100));
            echo $form->select2Row($model, 'codfilial', Filial::getListaCombo(), array('class'=>'input-medium'));
            echo $form->textFieldRow(
                $model,
                'nfechave',
                [
                    'class' => 'span5',
                    'maxlength' => 100
                ]
            );
            echo $form->textAreaRow($model, 'observacoes', array('class'=>'span6', 'rows'=>'6','maxlength'=>500, 'tabindex'=>-1));

            ?>
        </div>
    </div>
</fieldset>
<div class="form-actions">
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => 'Salvar',
            'icon' => 'icon-ok',
        )
    );
    ?>
</div>

<?php $this->endWidget(); ?>


<script type='text/javascript'>
    $(document).ready(function() {

        $('#NfeTerceiro_nfechave').change(function(e) {
            $(this).val($(this).val().replace(/\D/g, ''));
        });

        $('#nfe-terceiro-form').submit(function(e) {
            var currentForm = this;
            e.preventDefault();
            bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
                if (result) {
                    currentForm.submit();
                }
            });
        });

    });
</script>