<?php

Yii::setPathOfAlias('OpenBoleto',Yii::getPathOfAlias('application.vendors.openboleto.src.OpenBoleto'));

use OpenBoleto\Banco\Bradesco;
use OpenBoleto\Agente;

class MGBoleto
{
	
	public $boleto;
	
	public function __construct($model)
	{
		
		//Filial
		$cedente = new Agente(
			$model->Filial->Pessoa->pessoa, 
			Yii::app()->format->formataCnpjCpf($model->Filial->Pessoa->cnpj, $model->Filial->Pessoa->fisica), 
			$model->Filial->Pessoa->endereco . 
				((!empty($model->Filial->Pessoa->numero))?", " . $model->Filial->Pessoa->numero:"") . 
				((!empty($model->Filial->Pessoa->complemento))?" - " . $model->Filial->Pessoa->complemento:""),
			Yii::app()->format->formataCep($model->Filial->Pessoa->cep), 
			$model->Filial->Pessoa->Cidade->cidade, 
			$model->Filial->Pessoa->Cidade->Estado->sigla 
			);
		
		//Cliente
		$sacado = new Agente(
			Yii::app()->format->formataCodigo($model->Pessoa->codpessoa) . ' - ' . $model->Pessoa->pessoa, 
			Yii::app()->format->formataCnpjCpf($model->Pessoa->cnpj, $model->Pessoa->fisica), 
			$model->Pessoa->enderecocobranca . 
				((!empty($model->Pessoa->numerocobranca))?", " . $model->Pessoa->numerocobranca:"") . 
				((!empty($model->Pessoa->complementocobranca))?" - " . $model->Pessoa->complementocobranca:"") . 
				((!empty($model->Pessoa->bairrocobranca))?" - " . $model->Pessoa->bairrocobranca:"")  
				,
			Yii::app()->format->formataCep($model->Pessoa->cepcobranca), 
			$model->Pessoa->CidadeCobranca->cidade, 
			$model->Pessoa->CidadeCobranca->Estado->sigla 
			);

		//Boleto
		$this->boleto = new Bradesco(array(
			// Parâmetros obrigatórios
			'dataVencimento' => DateTime::createFromFormat("d/m/Y",$model->vencimento),
			'valor' => $model->debito,
			'sequencial' => $model->nossonumero, // Até 11 dígitos
			'sacado' => $sacado,
			'cedente' => $cedente,
			'agencia' => $model->Portador->agencia, // Até 4 dígitos
			'carteira' => $model->Portador->carteira, // 3, 6 ou 9
			'conta' => $model->Portador->conta, // Até 7 dígitos

			// Parâmetros recomendáveis
			//'logoPath' => 'http://empresa.com.br/logo.jpg', // Logo da sua empresa
			'contaDv' => $model->Portador->contadigito,
			'agenciaDv' => $model->Portador->agenciadigito,
			'descricaoDemonstrativo' => array( // Até 5
				'Fatura ' . $model->fatura,
				'Título ' . $model->numero,
				'# ' . $model->codtitulo,
			),
			'instrucoes' => array( // Até 8
				'Não Dispensar juros de mora por atraso.',
				'Após o vencimento acrescentar multa de R$ ' . 
					Yii::app()->format->formatNumber(round($model->debito * 2/100, 2)) . 
					' mais R$ ' .
					Yii::app()->format->formatNumber(round($model->debito * 4/100/30, 2)) .
					' de juros ao dia.'
					,
				'',
				'Protesto automático após 5 dias do vencimento.',
				'',
				'',
				'Após o vencimento pagável em toda rede Bradesco.',
			),

			// Parâmetros opcionais
			//'resourcePath' => '../resources',
			//'cip' => '000', // Apenas para o Bradesco
			//'moeda' => Bradesco::MOEDA_REAL,
			'dataDocumento' => DateTime::createFromFormat("d/m/Y",$model->emissao),
			'dataProcessamento' => DateTime::createFromFormat("d/m/Y",$model->emissao),
			//'contraApresentacao' => true,
			//'pagamentoMinimo' => 23.00,
			'aceite' => 'S',
			//'especieDoc' => 'ABC',
			'numeroDocumento' => $model->numero,
			//'usoBanco' => 'Uso banco',
			//'layout' => 'layout.phtml',
			//'logoPath' => 'http://boletophp.com.br/img/opensource-55x48-t.png',
			//'sacadorAvalista' => new Agente('Antônio da Silva', '02.123.123/0001-11'),
			//'descontosAbatimentos' => 123.12,
			//'moraMulta' => 123.12,
			//'outrasDeducoes' => 123.12,
			//'outrosAcrescimos' => 123.12,
			//'valorCobrado' => 123.12,
			//'valorUnitario' => 123.12,
			//'quantidade' => 1,
		));

	}

	public function getOutput()
	{
		return $this->boleto->getOutput();
	}
	
}