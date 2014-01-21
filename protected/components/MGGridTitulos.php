<?php

class MGGridTitulos extends CWidget
{
	
	public $codtitulos;
	public $codpessoa;
	public $saldo;
	public $multa;
	public $juros;
	public $desconto;
	public $total;
	
	
	public function run()
	{

		
		$model=new Titulo('search');
		
		$titulos = array();
		
		if (!empty($this->codtitulos))
		{
			if (!is_array($this->codtitulos))
				$this->codtitulos = explode(',', trim($this->codtitulos, ','));
			
			foreach($this->codtitulos as $codtitulo)
			{
				$model->unsetAttributes();
				$model->attributes=array('codtitulo' => $codtitulo);
				$titulos = array_merge($titulos, $model->search(false));
			}
		}
		else
			$this->codtitulos = array();
		
		if (!empty($this->codpessoa))
		{
			$model->unsetAttributes();
			$model->attributes=array('codpessoa' => $this->codpessoa);
			foreach ($model->search(false) as $titulo)
				if (!in_array($titulo->codtitulo, $this->codtitulos))
					$titulos[] = $titulo;
		}
		
		?>
		<div class="registro">
			<b class="row-fluid">
				<div class="span2">
					<b>Totais</b>
				</div>
				<span class="span7 text-right">
					<b class="span2 text-right">
						<span class="pull-right text-right" id="total_operacao">
						</span>
					</b>
					<div class="span2 text-right numero" id="total_saldo">
					</div>
					<div class="span2 text-right numero" id="total_multa">
					</div>
					<div class="span2 text-right numero" id="total_juros">
					</div>
					<div class="span2 text-right numero" id="total_desconto">
					</div>
					<div class="span2 text-right numero" id="total_total">
					</div>
				</span>
				<small class="span3 muted">
					<div class="span1">
						<input 
							type="checkbox" 
							id="TituloAgrupamento_codtitulo_todos" 
						>
					</div>
					<div class="span3">
					</div>
					<b class="span8">
					</b>
				</small>
			</b>
		</div>

		<?
		
		// percorre resultados
		foreach ($titulos as $titulo)
			$this->controller->renderPartial(
				'application.components.views._grid_titulos', 
				array(
					'data'=>$titulo, 
					'codtitulos'=>$this->codtitulos,
					'saldo'=>$this->saldo,
					'multa'=>$this->multa,
					'juros'=>$this->juros,
					'desconto'=>$this->desconto,
					'total'=>$this->total,
				)
			);

		/*
		echo "<pre> saldo no widget:\n\n";
		print_r($this->saldo);
		echo "</pre>";
		 * 
		 */
		
	}
	
}