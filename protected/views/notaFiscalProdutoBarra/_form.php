<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'nota-fiscal-produto-barra-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		//echo $form->textFieldRow($model,'codnotafiscal',array('class'=>'span5'));
		//echo $form->textFieldRow($model,'codprodutobarra',array('class'=>'span5'));
		echo $form->select2ProdutoBarraRow($model,'codprodutobarra',array('class'=>'input-xxlarge'));
	?>
	<div class="row-fluid">
		<div class="span3">
			<?php
				echo $form->textFieldRow($model,'quantidade',array('class'=>'input-small text-right','maxlength'=>14));
				echo $form->textFieldRow($model,'valorunitario',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				echo $form->textFieldRow($model,'valortotal',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
			?>
		</div>
		<div class="span9">
			<div class="span3">
				<?php
					echo $form->textFieldRow($model,'icmsbase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
					echo $form->textFieldRow($model,'icmspercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
					echo $form->textFieldRow($model,'icmsvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				?>
			</div>
			<div class="span3">
				<?php
					echo $form->textFieldRow($model,'icmsstbase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
					echo $form->textFieldRow($model,'icmsstpercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
					echo $form->textFieldRow($model,'icmsstvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				?>
			</div>
			<div class="span3">
				<?php
					echo $form->textFieldRow($model,'ipibase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
					echo $form->textFieldRow($model,'ipipercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
					echo $form->textFieldRow($model,'ipivalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				?>
			</div>
		</div>
	</div>		
	<?php
		echo $form->textFieldRow($model,'codcfop',array('class'=>'input-mini text-center'));
		echo $form->textFieldRow($model,'csosn',array('class'=>'input-mini text-center','maxlength'=>4));
		echo $form->textFieldRow($model,'descricaoalternativa',array('class'=>'span5','maxlength'=>100));
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

function atualizaBaseImpostos ()
{
	
	var totalAntigo = $("#NotaFiscalProdutoBarra_valortotal").data("previous-value");
	var totalNovo   = $("#NotaFiscalProdutoBarra_valortotal").autoNumeric('get');

	if ($('#NotaFiscalProdutoBarra_icmsbase').autoNumeric('get') == totalAntigo
		&& $('#NotaFiscalProdutoBarra_icmspercentual').autoNumeric('get') > 0)
	{
		$('#NotaFiscalProdutoBarra_icmsbase').autoNumeric('set', totalNovo);
		atualizaIcmsValor();
	}
	
	if ($('#NotaFiscalProdutoBarra_icmsstbase').autoNumeric('get') == totalAntigo
		&& $('#NotaFiscalProdutoBarra_icmsstpercentual').autoNumeric('get') > 0)
	{
		$('#NotaFiscalProdutoBarra_icmsstbase').autoNumeric('set', totalNovo);
		atualizaIcmsStValor();
	}
	
	if ($('#NotaFiscalProdutoBarra_ipibase').autoNumeric('get') == totalAntigo
		&& $('#NotaFiscalProdutoBarra_ipipercentual').autoNumeric('get') > 0)
	{
		$('#NotaFiscalProdutoBarra_ipibase').autoNumeric('set', totalNovo);
		atualizaIpiValor();
	}
	
}

function atualizaTotal ()
{
	$("#NotaFiscalProdutoBarra_valortotal").data("previous-value", 
		$("#NotaFiscalProdutoBarra_valortotal").autoNumeric('get')
	);

	$('#NotaFiscalProdutoBarra_valortotal').autoNumeric('set', 
		$('#NotaFiscalProdutoBarra_quantidade').autoNumeric('get') * 
		$('#NotaFiscalProdutoBarra_valorunitario').autoNumeric('get')
	);

	atualizaBaseImpostos ();
}

function atualizaUnitario ()
{
	if ($('#NotaFiscalProdutoBarra_quantidade').autoNumeric('get') < 0.01)
		$('#NotaFiscalProdutoBarra_quantidade').autoNumeric('set', 1);
	
	$('#NotaFiscalProdutoBarra_valorunitario').autoNumeric('set',
		$('#NotaFiscalProdutoBarra_valortotal').autoNumeric('get') /
		$('#NotaFiscalProdutoBarra_quantidade').autoNumeric('get')  
	);
}
	
function atualizaIcmsValor ()
{
	if ($('#NotaFiscalProdutoBarra_icmsbase').autoNumeric('get') == 0)
		$('#NotaFiscalProdutoBarra_icmsbase').autoNumeric('set', 
			$('#NotaFiscalProdutoBarra_valortotal').autoNumeric('get')
		);
	
	$('#NotaFiscalProdutoBarra_icmsvalor').autoNumeric('set',
		$('#NotaFiscalProdutoBarra_icmsbase').autoNumeric('get') * 
		$('#NotaFiscalProdutoBarra_icmspercentual').autoNumeric('get') /100
	);
}

function atualizaIcmsPercentual ()
{
	if ($('#NotaFiscalProdutoBarra_icmsvalor').autoNumeric('get') == 0)
		return;
	
	if ($('#NotaFiscalProdutoBarra_icmsbase').autoNumeric('get') < 0.01)
		$('#NotaFiscalProdutoBarra_icmsbase').autoNumeric('set', $('#NotaFiscalProdutoBarra_valortotal').autoNumeric('get'));
	
	if ($('#NotaFiscalProdutoBarra_icmsbase').autoNumeric('get') < 0.01)
		$('#NotaFiscalProdutoBarra_icmsbase').autoNumeric('set', 1);
	
	$('#NotaFiscalProdutoBarra_icmspercentual').autoNumeric('set',
		$('#NotaFiscalProdutoBarra_icmsvalor').autoNumeric('get') * 100 /
		$('#NotaFiscalProdutoBarra_icmsbase').autoNumeric('get')  
	);
}

function atualizaIcmsStValor ()
{
	if ($('#NotaFiscalProdutoBarra_icmsstbase').autoNumeric('get') == 0)
		$('#NotaFiscalProdutoBarra_icmsstbase').autoNumeric('set', 
			$('#NotaFiscalProdutoBarra_valortotal').autoNumeric('get')
		);
	
	$('#NotaFiscalProdutoBarra_icmsstvalor').autoNumeric('set',
		$('#NotaFiscalProdutoBarra_icmsstbase').autoNumeric('get') * 
		$('#NotaFiscalProdutoBarra_icmsstpercentual').autoNumeric('get') /100
	);
}

function atualizaIcmsStPercentual ()
{
	if ($('#NotaFiscalProdutoBarra_icmsstvalor').autoNumeric('get') == 0)
		return;
	
	if ($('#NotaFiscalProdutoBarra_icmsstbase').autoNumeric('get') < 0.01)
		$('#NotaFiscalProdutoBarra_icmsstbase').autoNumeric('set', $('#NotaFiscalProdutoBarra_valortotal').autoNumeric('get'));
	
	if ($('#NotaFiscalProdutoBarra_icmsstbase').autoNumeric('get') < 0.01)
		$('#NotaFiscalProdutoBarra_icmsstbase').autoNumeric('set', 1);
	
	$('#NotaFiscalProdutoBarra_icmsstpercentual').autoNumeric('set',
		$('#NotaFiscalProdutoBarra_icmsstvalor').autoNumeric('get') * 100 /
		$('#NotaFiscalProdutoBarra_icmsstbase').autoNumeric('get')  
	);
}

function atualizaIpiValor ()
{
	if ($('#NotaFiscalProdutoBarra_ipibase').autoNumeric('get') == 0)
		$('#NotaFiscalProdutoBarra_ipibase').autoNumeric('set', 
			$('#NotaFiscalProdutoBarra_valortotal').autoNumeric('get')
		);
	
	$('#NotaFiscalProdutoBarra_ipivalor').autoNumeric('set',
		$('#NotaFiscalProdutoBarra_ipibase').autoNumeric('get') * 
		$('#NotaFiscalProdutoBarra_ipipercentual').autoNumeric('get') /100
	);
}

function atualizaIpiPercentual ()
{
	if ($('#NotaFiscalProdutoBarra_ipivalor').autoNumeric('get') == 0)
		return;
	
	if ($('#NotaFiscalProdutoBarra_ipibase').autoNumeric('get') < 0.01)
		$('#NotaFiscalProdutoBarra_ipibase').autoNumeric('set', $('#NotaFiscalProdutoBarra_valortotal').autoNumeric('get'));
	
	if ($('#NotaFiscalProdutoBarra_ipibase').autoNumeric('get') < 0.01)
		$('#NotaFiscalProdutoBarra_ipibase').autoNumeric('set', 1);
	
	$('#NotaFiscalProdutoBarra_ipipercentual').autoNumeric('set',
		$('#NotaFiscalProdutoBarra_ipivalor').autoNumeric('get') * 100 /
		$('#NotaFiscalProdutoBarra_ipibase').autoNumeric('get')  
	);
}
	

	
$(document).ready(function() {

	$("#NotaFiscalProdutoBarra_valortotal").focus(function () {
		$(this).data("previous-value", $(this).autoNumeric('get'));
	});	
	$("#NotaFiscalProdutoBarra_valortotal").blur(function () {
		atualizaBaseImpostos();
	});	
	


	//$("#Pessoa_fantasia").Setcase();
	$('#NotaFiscalProdutoBarra_quantidade').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_valorunitario').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_valortotal').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_icmsbase').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_icmspercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_icmsvalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_ipibase').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_ipipercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_ipivalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_icmsstbase').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_icmsstpercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_icmsstvalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	
	$('#NotaFiscalProdutoBarra_quantidade').change(function() { atualizaTotal(); });
	$('#NotaFiscalProdutoBarra_valorunitario').change(function() { atualizaTotal(); });
	$('#NotaFiscalProdutoBarra_valortotal').change(function() { atualizaUnitario(); });

	$('#NotaFiscalProdutoBarra_icmsbase').change(function() { atualizaIcmsValor(); });
	$('#NotaFiscalProdutoBarra_icmspercentual').change(function() { atualizaIcmsValor(); });
	$('#NotaFiscalProdutoBarra_icmsvalor').change(function() { atualizaIcmsPercentual(); });
	
	$('#NotaFiscalProdutoBarra_icmsstbase').change(function() { atualizaIcmsStValor(); });
	$('#NotaFiscalProdutoBarra_icmsstpercentual').change(function() { atualizaIcmsStValor(); });
	$('#NotaFiscalProdutoBarra_icmsstvalor').change(function() { atualizaIcmsStPercentual(); });
	
	$('#NotaFiscalProdutoBarra_ipibase').change(function() { atualizaIpiValor(); });
	$('#NotaFiscalProdutoBarra_ipipercentual').change(function() { atualizaIpiValor(); });
	$('#NotaFiscalProdutoBarra_ipivalor').change(function() { atualizaIpiPercentual(); });
	
	$('#NotaFiscalProdutoBarra_codprodutobarra').change(function(e) { 
		if ($("#NotaFiscalProdutoBarra_codprodutobarra").select2('data') != null)
		{
			console.log($("#NotaFiscalProdutoBarra_codprodutobarra").select2('data').preco);
			$("#NotaFiscalProdutoBarra_valorunitario").val(
				$("#NotaFiscalProdutoBarra_codprodutobarra").select2('data').preco
			);
			atualizaTotal ();
		}
	});
	
	$('#nota-fiscal-produto-barra-form').submit(function(e) {
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