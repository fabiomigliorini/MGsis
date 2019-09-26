<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'nfe-terceiro-item-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
	<fieldset>
		<div class="span8">
			<div class="row-fluid">
				<?php echo $form->select2ProdutoBarraRow($model,'codprodutobarra',array('class'=>'input-xxlarge')); ?>
			</div>
			<div class="row-fluid">
				<div class="span6">
					<?php
						echo $form->textFieldRow($model,'cean',array('class'=>'input-medium text-center','maxlength'=>30, 'disabled'=>true));
						if (!empty($model->ceantrib) && $model->cean != $model->ceantrib || true)
							echo $form->textFieldRow($model,'ceantrib',array('class'=>'input-medium text-center','maxlength'=>30, 'disabled'=>true));
						echo $form->textFieldRow($model,'qcom',array('class'=>'input-small text-right','maxlength'=>14,'disabled'=>true, 'append'=>$model->ucom));
						echo $form->textFieldRow($model,'vuncom',array('class'=>'input-small text-right','maxlength'=>14,'disabled'=>true));
						echo $form->textFieldRow($model,'margem',array('class'=>'input-mini text-right','maxlength'=>6, 'append'=>'%'));
						echo $form->toggleButtonRow($model,'modalidadeicmsgarantido', array('options' => array('width' => 400,  'enabledLabel' => 'Garantido (até 2019)', 'disabledLabel' => 'Apuração (partir 2020)')));
					?>
				</div>
				<div class="span6">
					<?php
						echo $form->textFieldRow($model,'cprod',array('class'=>'input-medium text-center','maxlength'=>30, 'disabled'=>true));
					?>
				</div>
			</div>

			<?php
				/*
				echo $form->textFieldRow($model,'codnfeterceiro',array('class'=>'span5'));
				echo $form->textFieldRow($model,'nitem',array('class'=>'span5'));
				echo $form->textFieldRow($model,'ncm',array('class'=>'span5','maxlength'=>10));
				echo $form->textFieldRow($model,'cfop',array('class'=>'span5'));
				echo $form->textFieldRow($model,'utrib',array('class'=>'span5','maxlength'=>14));
				echo $form->textFieldRow($model,'qtrib',array('class'=>'span5','maxlength'=>14));
				echo $form->textFieldRow($model,'vuntrib',array('class'=>'span5','maxlength'=>14));
				echo $form->textFieldRow($model,'cst',array('class'=>'span5','maxlength'=>10));
				echo $form->textFieldRow($model,'csosn',array('class'=>'span5','maxlength'=>10));
				echo $form->textFieldRow($model,'vbc',array('class'=>'span5','maxlength'=>14));
				echo $form->textFieldRow($model,'picms',array('class'=>'span5','maxlength'=>14));
				echo $form->textFieldRow($model,'vicms',array('class'=>'span5','maxlength'=>14));
				echo $form->textFieldRow($model,'vbcst',array('class'=>'span5','maxlength'=>14));
				echo $form->textFieldRow($model,'picmsst',array('class'=>'span5','maxlength'=>14));
				echo $form->textFieldRow($model,'vicmsst',array('class'=>'span5','maxlength'=>14));
				echo $form->textFieldRow($model,'ipivbc',array('class'=>'span5','maxlength'=>14));
				echo $form->textFieldRow($model,'ipipipi',array('class'=>'span5','maxlength'=>14));
				echo $form->textFieldRow($model,'ipivipi',array('class'=>'span5','maxlength'=>14));
				 *
				 */
			?>
		</div>
		<div class="span3">
			<?php
				echo $form->textFieldRow($model,'vprod',array('class'=>'input-small text-right','maxlength'=>14,'disabled'=>true));
				echo $form->textFieldRow($model,'ipivipi',array('class'=>'input-small text-right','maxlength'=>14,'disabled'=>true));
				echo $form->textFieldRow($model,'vicmsst',array('class'=>'input-small text-right','maxlength'=>14,'disabled'=>true));
				// echo $form->textFieldRow($model,'vicmsgarantido',array('class'=>'input-small text-right','maxlength'=>14,'disabled'=>true));
				echo $form->textFieldRow($model,'complemento',array('class'=>'input-small text-right','maxlength'=>14));
				echo $form->textFieldRow($model,'vcusto',array('class'=>'input-small text-right','maxlength'=>14,'disabled'=>true));
			?>
		</div>
	</fieldset>
</div>
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

function calculaCusto()
{
	var vprod = parseFloat($('#NfeTerceiroItem_vprod').autoNumeric('get'));
	if (isNaN(vprod))
		vprod = 0;

	var vipi = parseFloat($('#NfeTerceiroItem_ipivipi').autoNumeric('get'));
	if (isNaN(vipi))
		vipi = 0;

	var vst = parseFloat($('#NfeTerceiroItem_vicmsst').autoNumeric('get'));
	if (isNaN(vst))
		vst = 0;

	// var vicms = parseFloat($('#NfeTerceiroItem_vicmsgarantido').autoNumeric('get'));
	// if (isNaN(vicms))
	// 	vicms = 0;

	var vcomp = parseFloat($('#NfeTerceiroItem_complemento').autoNumeric('get'));
	if (isNaN(vcomp))
		vcomp = 0;

	// var custo = vprod + vipi + vst + vicms + vcomp;
	var custo = vprod + vipi + vst + vcomp;

	$('#NfeTerceiroItem_vcusto').autoNumeric('set', custo);

}
$(document).ready(function() {

	//$("#Pessoa_fantasia").Setcase();
	$('#NfeTerceiroItem_qcom').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NfeTerceiroItem_vuncom').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NfeTerceiroItem_vprod').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NfeTerceiroItem_ipivipi').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NfeTerceiroItem_vicmsst').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	// $('#NfeTerceiroItem_vicmsgarantido').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NfeTerceiroItem_complemento').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NfeTerceiroItem_vcusto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NfeTerceiroItem_margem').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NfeTerceiroItem_complemento').change(function (e){
		calculaCusto();
	});

	calculaCusto();

	$('#nfe-terceiro-item-form').submit(function(e) {
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
