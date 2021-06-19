<div id="modalBoletoBB" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<div class="pull-right">
			<button class="btn btn-primary" id="btnImprimirBoletoBB">Imprimir</button>
			<button class="btn" data-dismiss="modal">Fechar</button>
		</div>
		<h3>
			Boleto
		</h3>
	</div>
	<div class="modal-body">
		<iframe src="" id="frameBoletoBB" name="frameBoletoBB" width="99.6%" height="400" frameborder="0"></iframe>
	</div>
</div>
<?php
	$arrEstados = [
		1 => 'NORMAL',
		2 => 'MOVIMENTO CARTORIO',
		3 => 'EM CARTORIO',
		4 => 'TITULO COM OCORRENCIA DE CARTORIO',
		5 => 'PROTESTADO ELETRONICO',
		6 => 'LIQUIDADO',
		7 => 'BAIXADO',
		8 => 'TITULO COM PENDENCIA DE CARTORIO',
		9 => 'TITULO PROTESTADO MANUAL',
		10 => 'TITULO BAIXADO/PAGO EM CARTORIO',
		11 => 'TITULO LIQUIDADO/PROTESTADO',
		12 => 'TITULO LIQUID/PGCRTO',
		13 => 'TITULO PROTESTADO AGUARDANDO BAIXA',
		14 => 'TITULO EM LIQUIDACAO',
		15 => 'TITULO AGENDADO',
		16 => 'TITULO CREDITADO',
		17 => 'PAGO EM CHEQUE AGUARD.LIQUIDACAO',
		18 => 'PAGO PARCIALMENTE',
		19 => 'PAGO PARCIALMENTE CREDITADO',
		21 => 'TITULO AGENDADO COMPE',
		80 => 'EM PROCESSAMENTO (ESTADO TRANSITÓRIO)',
	];

	foreach ($model->TituloBoletos As $tb) {
		if (!isset($arrEstados[$tb->estadotitulocobranca])) {
			$estado = $tb->estadotitulocobranca;
		} else {
			$estado = $arrEstados[$tb->estadotitulocobranca];
		}
		?>
		<small class="">
			<div class="row-fluid">
				<div class="span5">
					<?php
						$this->widget('bootstrap.widgets.TbDetailView',array(
							'data'=>$tb,
							'attributes'=>array(
								array(
									'name'=>'estadotitulocobranca',
									'value'=>$estado,
									'cssClass' => $css_vencimento
								),
								'nossonumero',
								array(
									'label'=>'',
									'value'=>
										'<button class="btn btn-primary btn-small" id="btnMostrarBoletoBB" onClick="abrirBoletoBB(' . $tb->codtituloboleto . ')"><i class="icon-barcode"></i> &nbsp Abrir Boleto</button> ' .
										'<button class="btn btn-danger btn-small" id="btnBaixarBoletoBB" onClick="baixarBoletoBB(' . $tb->codtituloboleto . ')">Baixar</button> ' .
										'<button class="btn btn-info btn-small" id="btnConsultarBoletoBB" onClick="consultarBoletoBB(' . $tb->codtituloboleto . ')">Consultar</button>'
									,
									'type'=>'raw'
								),
								array(
									'name'=>'codportador',
									'value'=>$tb->Portador->portador,
								),
								array(
									'name'=>'valororiginal',
									'value'=>Yii::app()->format->formatNumber($tb->valororiginal),
									'cssClass' => $css_vencimento,
								),
								array(
									'name'=>'valoratual',
									'value'=>Yii::app()->format->formatNumber($tb->valoratual),
								),
								array(
									'name'=>'valorpagamentoparcial',
									'value'=>Yii::app()->format->formatNumber($tb->valorpagamentoparcial),
								),
								)
							)
						);
					?>
				</div>
				<div class="span3">
					<?php
					$this->widget('bootstrap.widgets.TbDetailView',array(
						'data'=>$tb,
						'attributes'=>array(
							array(
								'name'=>'vencimento',
								'cssClass' => $css_vencimento
							),
							'datarecebimento',
							'datacredito',
							'databaixaautomatica',
							'dataregistro',
						)
					));
					?>
				</div>
				<div class="span4">
					<?php
					$this->widget('bootstrap.widgets.TbDetailView',array(
						'data'=>$tb,
						'attributes'=>array(
							array(
								'name'=>'valororiginal',
								'value'=>Yii::app()->format->formatNumber($tb->valororiginal),
								'cssClass' => $css_vencimento,
							),
							array(
								'name'=>'valorabatimento',
								'value'=>Yii::app()->format->formatNumber($tb->valorabatimento),
							),
							array(
								'name'=>'valorjuromora',
								'value'=>Yii::app()->format->formatNumber($tb->valorjuromora),
							),
							array(
								'name'=>'valormulta',
								'value'=>Yii::app()->format->formatNumber($tb->valormulta),
							),
							array(
								'name'=>'valordesconto',
								'value'=>Yii::app()->format->formatNumber($tb->valordesconto),
							),
							array(
								'name'=>'valorreajuste',
								'value'=>Yii::app()->format->formatNumber($tb->valorreajuste),
							),
							array(
								'name'=>'valoroutro',
								'value'=>Yii::app()->format->formatNumber($tb->valoroutro),
							),
							array(
								'name'=>'valorpago',
								'value'=>Yii::app()->format->formatNumber($tb->valorpago),
							),
							array(
								'name'=>'valorliquido',
								'value'=>Yii::app()->format->formatNumber($tb->valorliquido),
							),
							)
						)
					);
					?>
				</div>
			</div>
		</small>
		<?php
	}
