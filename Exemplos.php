<?php

// TIMESTAMP:
$this->widget('CMaskedTextField',array(
	'model'=>$model,
	'attribute'=>'sistema',
	'mask'=>'99/99/9999\ 99:99:99',
	'htmlOptions'=>array(
		'style'=>'width:140px;'
	),
));

// DATA
$this->widget('zii.widgets.jui.CJuiDatePicker',array(
	'model'=>$model,
	'attribute'=>'vencimento',
	'language'=>'pt-BR',
	'htmlOptions'=>array(
		'class'=>'date',
		),
));		

// VALOR
?>
<script type="text/javascript">
	$(document).ready(
		function()
			{
				$('#Titulo_debito').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

			}
		);
</script>
<?php
//FORMATAR VALORES
echo Yii::app()->format->number(1234567.89);
echo Yii::app()->format->unformatNumber('1.234.567,89');

?>