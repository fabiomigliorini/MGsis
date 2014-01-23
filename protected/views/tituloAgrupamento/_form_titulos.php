<?php

// Pessoa
echo $form->select2PessoaRow($model, 'codpessoa');

// Grid de Títulos
$html_titulos = '<div id="listagem-titulos">';
$html_titulos .=
	$this->widget(
		'MGGridTitulos',
		array(
			'modelname'   => 'TituloAgrupamento',
			'campo'		  => 'GridTitulos',
			'GridTitulos' => $model->GridTitulos,
			'codpessoa'   => $model->codpessoa,
		),
		true
	);
$html_titulos .= '</div>';
echo $form->customRow($model, 'GridTitulos', $html_titulos);
