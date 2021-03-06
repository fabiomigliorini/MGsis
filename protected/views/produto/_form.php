<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'produto-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'produto',array('class'=>'input-xlarge','maxlength'=>100));
		echo $form->textFieldRow($model,'referencia',array('class'=>'input-medium','maxlength'=>50));
		echo $form->dropDownListRow($model, 'codunidademedida', UnidadeMedida::getListaCombo(), array('prompt' => '', 'class' => 'input-mini'));
		echo $form->select2Row(
			$model, 
			'codsubgrupoproduto', 
			SubGrupoProduto::getListaCombo(), 
			array(
				//'placeholder'=>'Tributação',
				'class' => 'input-xxlarge'
			)
		);
		echo $form->select2MarcaRow($model, 'codmarca');
		echo $form->textFieldRow($model,'preco',array('class'=>'input-small text-right','maxlength'=>14));
		
		echo $form->toggleButtonRow($model,'importado', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		
		// ncm
		echo $form->select2NcmRow($model, 'codncm');
		
		
		
//		echo $form->textFieldRow($model,'ncm',array('class'=>'input-small text-center', 'maxlength'=>8));
		/*
		if (!empty($model->ncm))
			$model->ncm = Yii::app()->format->formataNcm($model->ncm);
		echo $form->maskedTextFieldRow($model,'ncm', '99999999', array('class'=>'input-small text-center','maxlength'=>10));
		*/
		
		echo $form->dropDownListRow($model, 'codtributacao', Tributacao::getListaCombo(), array('prompt' => '', 'class' => 'input-medium'));
		echo $form->textFieldRow(
			$model, 
			'codcest',
			array(
				'class' => 'input-xxlarge'
			)
		);
		
		echo $form->dropDownListRow($model, 'codtipoproduto', TipoProduto::getListaCombo(), array('prompt' => '', 'class' => 'input-xlarge'));
		
		echo $form->toggleButtonRow($model,'site', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->textAreaRow($model,'descricaosite',array('class'=>'span5','maxlength'=>1024,'rows'=>5));
		
		echo $form->datepickerRow(
				$model,
				'inativo',
				array(
					'class' => 'input-small text-center', 
					'options' => array(
						'language' => 'pt',
						'format' => 'dd/mm/yyyy'
						),
					'prepend' => '<i class="icon-calendar"></i>',
					)
				); 
		
	?>
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

	$("#Produto_produto").Setcase();
	$('#Produto_preco').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	//mascara="999.99.99";
	//$("#Produto_ncm").mask(mascara);	


	$('#produto-form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
            if (result) {
                currentForm.submit();
            }
        });
    });
	
	$('#Produto_codcest').select2({
		minimumInputLength: 0,
		allowClear: true,
		closeOnSelect: true,
		placeholder: 'CEST',
		formatResult: function(item) {
			var markup = "";
			markup    += "<b>" + item.ncm + "</b>/";
			markup    += "<b>" + item.cest + "</b>&nbsp;";
			markup    += "<span>" + item.descricao + "</span>";
			return markup;
		},
		formatSelection: function(item) { 
			return item.ncm + "/" + item.cest + "&nbsp;" + item.descricao; 
		},
		ajax: {
			url: '/MGsis/index.php?r=cest/ajaxbuscacest&codncm=',
			dataType:'json',
			quietMillis: 500,
			data: function(term,page) { 
				return {texto: term, limite: 20, pagina: page, codncm: $('#Produto_codncm').val()}; 
			},
			results: function(data,page) {
				var more = (page * 20) < data.total;
				return {results: data.itens, more: data.mais};
			}
		},
		initSelection: function (element, callback) {
			$.ajax({
				type: "GET",
				url: "/MGsis/index.php?r=cest/ajaxinicializacest",
				data: "cod=<?php echo $model->codcest?>",
				dataType: "json",
				success: function(result) { callback(result); }
			});
		},
		width: 'resolve'
	});	
});

</script>