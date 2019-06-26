<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'tributacao-natureza-operacao-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<div class="row-fluid">
		<div class="span6">
			<?php
				$box = $this->beginWidget(
					'bootstrap.widgets.TbBox',
					array(
						'title' => 'Chave',
						'headerIcon' => 'icon-th-list',
						//'htmlOptions' => array('class' => ' pull-left')
					)
				);

				//echo $form->textFieldRow($model,'codtributacao',array('class'=>'span5'));
				echo $form->select2Row($model, 'codtributacao', Tributacao::getListaCombo(), array('prompt' => '', 'class' => 'input-large'));
				echo $form->select2Row($model, 'codnaturezaoperacao', NaturezaOperacao::getListaCombo(), array('prompt' => '', 'class' => 'input-xlarge'));
				echo $form->select2Row($model, 'codtipoproduto', TipoProduto::getListaCombo(), array('prompt' => '', 'class' => 'input-xlarge'));
				echo $form->select2Row($model, 'codestado', Estado::getListaCombo(), array('prompt' => '', 'class' => 'input-medium'));
				echo $form->textFieldRow($model,'ncm',array('class'=>'input-small','maxlength'=>10));
				echo '<hr>';
				echo $form->select2Row($model, 'codcfop', Cfop::getListaCombo(), array('prompt' => '', 'class' => 'span12'));

				$this->endWidget();
			?>
		</div>
		<div class="span6">
			<?php

				$box = $this->beginWidget(
					'bootstrap.widgets.TbBox',
					array(
						'title' => 'Contábil',
						'headerIcon' => 'icon-th-list',
						//'htmlOptions' => array('class' => ' pull-left')
					)
				);

				echo $form->textFieldRow($model,'acumuladordominiovista',array('class'=>'input-mini text-right'));
				echo $form->textFieldRow($model,'acumuladordominioprazo',array('class'=>'input-mini text-right'));
				echo $form->textAreaRow($model,'historicodominio',array('class'=>'input-span12', 'rows'=>4, 'maxlength'=>512));
				//echo $form->checkBoxRow($model,'movimentacaofisica');
				//echo $form->checkBoxRow($model,'movimentacaocontabil');
				echo $form->toggleButtonRow($model,'movimentacaofisica', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
				echo $form->toggleButtonRow($model,'movimentacaocontabil', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));

				$this->endWidget();

			?>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span12">
			<?php
				$box = $this->beginWidget(
					'bootstrap.widgets.TbBox',
					array(
						'title' => 'Lucro Presumido',
						'headerIcon' => 'icon-th-list',
						//'htmlOptions' => array('class' => ' pull-left')
					)
				);

			?>
				<div class="row-fluid">
					<div class="span3">
						<?php
							echo $form->textFieldRow($model,'icmscst',array('class'=>'input-mini text-right','maxlength'=>14));
							echo $form->textFieldRow($model,'icmslpbase',array('class'=>'input-mini text-right','maxlength'=>14));
							echo $form->textFieldRow($model,'icmslppercentual',array('class'=>'input-mini text-right','maxlength'=>14));
						?>
					</div>
					<div class="span3">
						<?php
							echo $form->textFieldRow($model,'piscst',array('class'=>'input-mini text-right','maxlength'=>14));
							echo $form->textFieldRow($model,'pispercentual',array('class'=>'input-mini text-right','maxlength'=>14));
						?>
					</div>
					<div class="span3">
						<?php
							echo $form->textFieldRow($model,'cofinscst',array('class'=>'input-mini text-right','maxlength'=>14));
							echo $form->textFieldRow($model,'cofinspercentual',array('class'=>'input-mini text-right','maxlength'=>14));
						?>
					</div>
					<div class="span3">
						<?php
							echo $form->textFieldRow($model,'ipicst',array('class'=>'input-mini text-right','maxlength'=>14));
							echo $form->textFieldRow($model,'csllpercentual',array('class'=>'input-mini text-right','maxlength'=>14));
							echo $form->textFieldRow($model,'irpjpercentual',array('class'=>'input-mini text-right','maxlength'=>14));
						?>
					</div>
				</div>
			<?php
				$this->endWidget();
			?>

		</div>

	</div>

	<div class="row-fluid">
		<div class="span6">
			<?php
				$box = $this->beginWidget(
					'bootstrap.widgets.TbBox',
					array(
						'title' => 'Simples',
						'headerIcon' => 'icon-th-list',
						//'htmlOptions' => array('class' => ' pull-left')
					)
				);

				//echo $form->textFieldRow($model,'codnaturezaoperacao',array('class'=>'span5'));
				//echo $form->select2Row($model, 'codnaturezaoperacao', NaturezaOperacao::getListaCombo(), array('prompt' => '', 'class' => 'input-large'));
				//echo $form->textFieldRow($model,'codcfop',array('class'=>'span5'));
				echo $form->textFieldRow($model,'csosn',array('class'=>'input-mini text-right','maxlength'=>4));
				echo $form->textFieldRow($model,'icmsbase',array('class'=>'input-mini text-right','maxlength'=>14));
				echo $form->textFieldRow($model,'icmspercentual',array('class'=>'input-mini text-right','maxlength'=>14));
				//echo $form->textFieldRow($model,'codestado',array('class'=>'span5'));
				//echo $form->textFieldRow($model,'codtipoproduto',array('class'=>'span5'));

				$this->endWidget();
			?>

		</div>

		<div class="span6">
			<?php
				$box = $this->beginWidget(
					'bootstrap.widgets.TbBox',
					array(
						'title' => 'Produtor Rural',
						'headerIcon' => 'icon-th-list',
						//'htmlOptions' => array('class' => ' pull-left')
					)
				);
				echo $form->toggleButtonRow($model,'certidaosefazmt', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
				echo $form->textFieldRow($model,'fethabkg',array('class'=>'input-small text-right','maxlength'=>14));
				echo $form->textFieldRow($model,'iagrokg',array('class'=>'input-small text-right','maxlength'=>14));
				echo $form->textFieldRow($model,'funruralpercentual',array('class'=>'input-small text-right','maxlength'=>14));
				echo $form->textFieldRow($model,'senarpercentual',array('class'=>'input-small text-right','maxlength'=>14));
				$this->endWidget();
			?>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span12">
			<?php
				$box = $this->beginWidget(
					'bootstrap.widgets.TbBox',
					array(
						'title' => 'Observações',
						'headerIcon' => 'icon-th-list',
						//'htmlOptions' => array('class' => ' pull-left')
					)
				);
				echo $form->textAreaRow($model,'observacoesnf',array('class'=>'span12', 'rows'=>'5','maxlength'=>1500));
				$this->endWidget();
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

	//$("#Pessoa_fantasia").Setcase();
	//$('#TributacaoNaturezaOperacao_codtributacao').select2('focus');
	$('#TributacaoNaturezaOperacao_icmsbase').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#TributacaoNaturezaOperacao_icmspercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#TributacaoNaturezaOperacao_icmslpbase').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#TributacaoNaturezaOperacao_icmslppercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#TributacaoNaturezaOperacao_pispercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#TributacaoNaturezaOperacao_cofinspercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#TributacaoNaturezaOperacao_csllpercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#TributacaoNaturezaOperacao_irpjpercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#TributacaoNaturezaOperacao_fethabkg').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', mDec:6 });
	$('#TributacaoNaturezaOperacao_iagrokg').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', mDec:6 });
	$('#TributacaoNaturezaOperacao_funruralpercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', mDec:5 });
	$('#TributacaoNaturezaOperacao_senarpercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', mDec:5 });

	$('#tributacao-natureza-operacao-form').submit(function(e) {
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

<?php

Yii::app()->clientScript->registerScript('script', <<<JS
		$('#TributacaoNaturezaOperacao_codtributacao').select2('focus');
JS
	, CClientScript::POS_READY);

?>
