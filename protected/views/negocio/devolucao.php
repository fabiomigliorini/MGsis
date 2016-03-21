<?php
/* @var $model Negocio */
/* @var $this NegocioController */

$this->pagetitle = Yii::app()->name . ' - Devolução';
$this->breadcrumbs=array(
	'Negócios'=>array('index'),
	$model->codnegocio=>array('view','id'=>$model->codnegocio),
	'Devolução',
);

$this->menu=array(
	array('label'=>'Listagem (F1)', 'icon'=>'icon-list-alt', 'url'=>array('index'), 'linkOptions'=> array('id'=>'btnListagem')),
	array('label'=>'Novo (F2)', 'icon'=>'icon-plus', 'url'=>array('create'), 'linkOptions'=> array('id'=>'btnNovo')),
	array('label'=>'Detalhes (F4)', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnegocio), 'linkOptions'=> array('id'=>'btnDetalhes')),
	//array('label'=>'Cancelar', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnCancelar')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

$this->renderPartial("_hotkeys");

?>

<h1>Selecione os produtos para Devolução!</h1>
<br>

<script type="text/javascript">
/*<![CDATA[*/

	function marcaTodos()
	{
		$.each($('.quantidadedevolucao'),function(){
			var codnegocioprodutobarra = $(this).data("codnegocioprodutobarra");
			$('#quantidadedevolucao\\[' + codnegocioprodutobarra + '\\]').autoNumeric('set', $('#maximodevolucao\\[' + codnegocioprodutobarra + '\\]').val());
		});
		calculaTotais();
	}

	function calculaTotais()
	{
		var valorprodutosdevolucao = 0;
		var percentualdesconto = <?php echo $model->valordesconto / $model->valorprodutos; ?>;
	
		$.each($('.quantidadedevolucao'),function(){
			
			var codnegocioprodutobarra = $(this).data("codnegocioprodutobarra");
			var quantidadedevolucao = parseFloat($('#quantidadedevolucao\\[' + codnegocioprodutobarra + '\\]').autoNumeric('get'));
			var maximodevolucao = parseFloat($('#maximodevolucao\\[' + codnegocioprodutobarra + '\\]').val());
            
            //console.log(maximodevolucao);
			
			if (quantidadedevolucao > maximodevolucao)
			{
				bootbox.alert('Quantidade máxima para este item é <b class="text-error">' + maximodevolucao + '</b>!', function() {
					$('#quantidadedevolucao\\[' + codnegocioprodutobarra + '\\]').focus();
				});
				quantidadedevolucao = '';
				$('#quantidadedevolucao\\[' + codnegocioprodutobarra + '\\]').autoNumeric('set', quantidadedevolucao);
			}
			
			var valorunitario = $('#valorunitario\\[' + codnegocioprodutobarra + '\\]').val();
			var totaldevolucao = quantidadedevolucao * valorunitario;
			valorprodutosdevolucao += totaldevolucao;
			$('#totaldevolucao\\[' + codnegocioprodutobarra + '\\]').autoNumeric('set', totaldevolucao);
		});
		$('#valorprodutosdevolucao').autoNumeric('set', valorprodutosdevolucao);
		var valordescontodevolucao = percentualdesconto * valorprodutosdevolucao;
		$('#valordescontodevolucao').autoNumeric('set', valordescontodevolucao);
		var valortotaldevolucao = valorprodutosdevolucao - valordescontodevolucao;
		$('#valortotaldevolucao').autoNumeric('set', valortotaldevolucao);
		
	}
	
	$(document).ready(function(){
		
		$('.quantidadedevolucao').on('change', function() { calculaTotais(); });
		$('#marcarTodos').on('click', function(e) { e.preventDefault(); marcaTodos(); });
		
		$('.quantidadedevolucao').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
		$('.totaldevolucao').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
		$('#valorprodutosdevolucao').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
		$('#valordescontodevolucao').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
		$('#valortotaldevolucao').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
		$('.quantidadedevolucao:visible:first').focus();
		
		calculaTotais();
		
		$('#devolucao-form').submit(function(e) {
			var currentForm = this;
			e.preventDefault();
			bootbox.confirm("Tem certeza que deseja confirmar a <b>devolução</b> dos itens selecionados?", function(result) {
				if (result) {
					currentForm.submit();
				}
			});
		});

	});
/*]]>*/
</script>
<?php 
$form = 
	$this->beginWidget(
		'bootstrap.widgets.TbActiveForm', 
		array(
			'id'=>'devolucao-form',
			'enableClientValidation' => false,
		)
	); 
?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<table class="table table-bordered table-condensed table-hover table-striped">
		<thead>
			<tr>
				<th colspan="2">Produto</th>
				<th colspan="2">
					Devolução
					<small>
						<a href="#" id="marcarTodos" tabindex="-1">Marcar Todos</a>
					</small>
				</th>
				<th colspan="4">Original</th>
			</tr>
			<tr>
				<th>Barras</th>
				<th>Descrição</th>
				<th>Quantidade</th>
				<th>Total</th>
				<th>Quantidade</th>
				<th>UM</th>
				<th>Preço</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php

				foreach ($model->NegocioProdutoBarras as $npb)
				{
                    $dev = $npb->devolucaoTotal;
                    $disp = $npb->quantidade - $dev;
                    $bloqueado = '';
                    if ($disp == 0)
                        $bloqueado = 'disabled=disabled';
					?>
					<tr>
						<td>
							<?php echo CHtml::encode($npb->ProdutoBarra->barras) ?> 
						</td>
						<td>
							<?php echo CHtml::link(CHtml::encode($npb->ProdutoBarra->descricao), array('produto/view', 'id'=>$npb->ProdutoBarra->codproduto), array ("tabindex"=>-1)); ?> 
						</td>
						<td>
							<div class="text-center">
								<input 
									type="hidden" 
									class="input-mini" 
									name="maximodevolucao[<?php echo $npb->codnegocioprodutobarra; ?>]" 
									id="maximodevolucao[<?php echo $npb->codnegocioprodutobarra; ?>]" 
									value="<?php echo $disp; ?>"
								>
								<input 
									type="hidden" 
									class="input-mini" 
									name="valorunitario[<?php echo $npb->codnegocioprodutobarra; ?>]" 
									id="valorunitario[<?php echo $npb->codnegocioprodutobarra; ?>]" 
									value="<?php echo $npb->valorunitario; ?>"
								>
								<input 
									type="text" 
									class="input-mini text-right quantidadedevolucao" 
									name="quantidadedevolucao[<?php echo $npb->codnegocioprodutobarra; ?>]" 
									id="quantidadedevolucao[<?php echo $npb->codnegocioprodutobarra; ?>]" 
									value="<?php echo (isset($_POST['quantidadedevolucao'][$npb->codnegocioprodutobarra]))?Yii::app()->format->unformatNumber($_POST['quantidadedevolucao'][$npb->codnegocioprodutobarra]):''; ?>"
									data-codnegocioprodutobarra="<?php echo $npb->codnegocioprodutobarra; ?>"
                                    <?php echo $bloqueado; ?>
								>
							</div>
						</td>
						<td>
							<b class="pull-right totaldevolucao" id="totaldevolucao[<?php echo $npb->codnegocioprodutobarra; ?>]"></b>
						</td>
						<td>
							<div class="pull-right">
								<?php echo Yii::app()->format->formatNumber($npb->quantidade); ?>  
                                <?php if (abs($dev) > 0): ?>
                                    <small class="muted pull-left">
                                        <?php echo Yii::app()->format->formatNumber($dev); ?>  já devolvido anteriormente! &nbsp;
                                    </small>
                                <?php endif; ?>
							</div>
						</td>
						<td>
							<div class="pull-right">
								<?php echo CHtml::encode($npb->ProdutoBarra->UnidadeMedida->sigla); ?> 
							</div>
						</td>
						<td>
							<div class="pull-right">
								<?php echo Yii::app()->format->formatNumber($npb->valorunitario); ?> 
							</div>
						</td>
						<td>
							<div class="pull-right">
								<?php echo Yii::app()->format->formatNumber($npb->valortotal); ?> 
							</div>
						</td>
					</tr>

					<?
				}
			?>
			
			
		</tbody>
		<tfoot>
			<tr>
				<th rowspan="3" colspan="2">Total</th>
				<th>
					Produtos 
				</th>
				<th>
					<div class="pull-right" id="valorprodutosdevolucao">
						0,00
					</div>					
				</th>
				<th colspan="4">
					<div class="pull-right" id="valorprodutos">
						<?php echo $model->valorprodutos; ?>
					</div>					
				</th>
			</tr>
			<tr>
				<th>
					Desconto 
				</th>
				<th>
					<div class="pull-right" id="valordescontodevolucao">
						0,00
					</div>					
				</th>
				<th colspan="4">
					<div class="pull-right" id="valordesconto">
						<?php echo $model->valordesconto; ?>
					</div>					
				</th>
			</tr>
			<tr>
				<th>
					Total 
				</th>
				<th>
					<div class="pull-right" id="valortotaldevolucao">
						0,00
					</div>					
				</th>
				<th colspan="4">
					<div class="pull-right" id="valortotal">
						<?php echo $model->valortotal; ?>
					</div>					
				</th>
			</tr>
		</tfoot>
	</table>
</fieldset>

<div class="form-actions text-center">
    <?php 
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Confirmar',
                'icon' => 'icon-ok',
                )
            ); 
	?>
</div>


<?php $this->endWidget(); ?>
