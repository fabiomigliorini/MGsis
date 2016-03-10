<?php

/**
 * This is the model class for table "mgsis.tblnotafiscal".
 *
 * The followings are the available columns in table 'mgsis.tblnotafiscal':
 * @property string $codnotafiscal
 * @property string $codnaturezaoperacao
 * @property boolean $emitida
 * @property integer $serie
 * @property integer $numero
 * @property string $emissao
 * @property string $saida
 * @property string $codfilial
 * @property string $codestoquelocal
 * @property string $codpessoa
 * @property string $observacoes
 * @property integer $volumes
 * @property integer $frete
 * @property string $codoperacao
 * @property string $valorfrete
 * @property string $valorseguro
 * @property string $valordesconto
 * @property string $valoroutras
 * @property string $nfechave
 * @property integer $tpemis
 * @property boolean $nfeimpressa
 * @property string $nfereciboenvio
 * @property string $nfedataenvio
 * @property string $nfeautorizacao
 * @property string $nfedataautorizacao
 * @property string $nfecancelamento
 * @property string $nfedatacancelamento
 * @property string $nfeinutilizacao
 * @property string $nfedatainutilizacao
 * @property string $justificativa
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $valorprodutos
 * @property string $valortotal
 * @property string $icmsbase
 * @property string $icmsvalor
 * @property string $icmsstbase
 * @property string $icmsstvalor
 * @property string $ipibase
 * @property string $ipivalor
 * @property string $modelo
 *
 * The followings are the available model relations:
 * @property NotaFiscalProdutoBarra[] $NotaFiscalProdutoBarras
 * @property NfeTerceiro[] $NfeTerceiros
 * @property Operacao $Operacao
 * @property NaturezaOperacao $NaturezaOperacao
 * @property Filial $Filial
 * @property EstoqueLocal $EstoqueLocal
 * @property Pessoa $Pessoa
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property NotaFiscalCartaCorrecao[] $NotaFiscalCartaCorrecaos
 * @property NotaFiscalDuplicatas[] $NotaFiscalDuplicatass
 * @property NotaFiscalReferenciada[] $NotaFiscalReferenciadas
 */
class NotaFiscal extends MGActiveRecord
{
	
	const CODSTATUS_NOVA          = 100;
	const CODSTATUS_DIGITACAO     = 101;
	const CODSTATUS_AUTORIZADA    = 102;
	const CODSTATUS_NOSSA_EMISSAO = 201;
	const CODSTATUS_LANCADA       = 202;
	const CODSTATUS_NAOAUTORIZADA = 301;
	const CODSTATUS_INUTILIZADA   = 302;
	const CODSTATUS_CANCELADA     = 303;
	
	const FRETE_EMITENTE          = 0;
	const FRETE_DESTINATARIO      = 1;
	const FRETE_TERCEIROS         = 2;
	const FRETE_SEM               = 9;
	
	const TPEMIS_NORMAL           = 1; // Emissão normal (não em contingência);
	const TPEMIS_FS_IA            = 2; // Contingência FS-IA, com impressão do DANFE em formulário de segurança;
	const TPEMIS_SCAN             = 3; // Contingência SCAN (Sistema de Contingência do Ambiente Nacional) Desativação prevista para 30/06/2014;
	const TPEMIS_DPEC             = 4; // Contingência DPEC (Declaração Prévia da Emissão em Contingência);
	const TPEMIS_FS_DA            = 5; // Contingência FS-DA, com impressão do DANFE em formulário de segurança;
	const TPEMIS_SVC_AN           = 6; // Contingência SVC-AN (SEFAZ Virtual de Contingência do AN);
	const TPEMIS_SVC_RS           = 7; // Contingência SVC-RS (SEFAZ Virtual de Contingência do RS);
	const TPEMIS_OFFLINE          = 9; // Contingência off-line da NFC-e (as demais opções de contingência são válidas também para a NFC-e);	
	
	public $status;
	public $codstatus;
	public $emissao_de;
	public $emissao_ate;
	public $saida_de;
	public $saida_ate;
	
	private $_codnaturezaoperacao_original;
	private $_codfilial_original;
	private $_codpessoa_original;
	
	const MODELO_NFE			= 55;
	const MODELO_NFCE			= 65;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnotafiscal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codnaturezaoperacao, serie, emissao, saida, codfilial, codestoquelocal, codpessoa', 'required'),
			array('serie, tpemis, numero, volumes, frete', 'numerical', 'integerOnly'=>true),
			array('nfechave, nfereciboenvio, nfeautorizacao, nfecancelamento, nfeinutilizacao', 'length', 'max'=>100),
			//array('nfechave', 'unique'),
			array('codestoquelocal', 'validaEstoqueLocal'),
			array('nfechave', 'validaChaveNFE'),
			array('modelo', 'validaModelo'),
			array('codpessoa', 'validaPessoaPelaChaveNFE'),
			array('serie', 'validaSeriePelaChaveNFE'),
			array('numero', 'validaNumeroPelaChaveNFE'),
			array('numero', 'validaNumero'),
			array('emissao', 'validaEmissaoPelaChaveNFE'),
			array('saida', 'validaSaida'),
			array('observacoes', 'length', 'max'=>1500),
			array('valorfrete, valorseguro, valordesconto, valoroutras, valorprodutos, valortotal, icmsbase, icmsvalor, icmsstbase, icmsstvalor, ipibase, ipivalor', 'length', 'max'=>14),
			array('justificativa', 'length', 'max'=>200),
			array('emitida, nfeimpressa, codoperacao, nfedataenvio, nfedataautorizacao, nfedatacancelamento, nfedatainutilizacao, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnotafiscal, codnaturezaoperacao, emitida, nfechave, tpemis, nfeimpressa, serie, numero, emissao, modelo, saida, codfilial, codestoquelocal, codpessoa, observacoes, volumes, frete, codoperacao, nfereciboenvio, nfedataenvio, nfeautorizacao, nfedataautorizacao, valorfrete, valorseguro, valordesconto, valoroutras, nfecancelamento, nfedatacancelamento, nfeinutilizacao, nfedatainutilizacao, justificativa, alteracao, codusuarioalteracao, criacao, codusuariocriacao, valorprodutos, valortotal, icmsbase, icmsvalor, icmsstbase, icmsstvalor, ipibase, ipivalor, codstatus, emissao_de, emissao_ate, saida_de, saida_ate', 'safe', 'on'=>'search'),
		);
	}

	public function validaEstoqueLocal($attribute, $params)
	{
		if (!isset($this->EstoqueLocal))
			return;
		
		if (!isset($this->Filial))
			return;
		
		if ($this->EstoqueLocal->codfilial != $this->codfilial)
			$this->addError($attribute, 'O Local de Estoque não bate com a Filial selecionada!');
	}
	
	public function validaModelo($attribute, $params)
	{
		if (empty($this->nfechave))
		{
			if (!$this->emitida)
				return;
			
			if (empty($this->modelo))
				$this->addError($attribute, "Modelo não pode ser vazio!");
			
			if ($this->modelo != NotaFiscal::MODELO_NFCE && $this->modelo != NotaFiscal::MODELO_NFE)
				$this->addError($attribute, "Modelo incorreto!");
		}
		else
		{
			if ($this->modelo != substr($this->nfechave, 20, 2))
				$this->addError($attribute, "Modelo informado não bate com a Chave!");
		}
	}
	
	// composicao serie e numero deve ser unica para a filial ou para a pessoa
	public function validaNumero($attribute, $params)
	{
		if ((!$this->emitida) && empty($this->numero))
			$this->addError($attribute, "Preencha o número da Nota Fiscal!");
		
		if (empty($this->numero))
			return;
		
		if (empty($this->codpessoa))
			return;
		
		if (empty($this->serie))
			return;
		
		if (empty($this->codfilial))
			return;
		
		if (empty($this->modelo))
			return;

		$condicao = " serie = :serie AND numero = :numero ";
		
		$parametros = array(
			"serie" => $this->serie,
			"numero" => $this->numero
			);
		
		if (!$this->isNewRecord)
		{
			$condicao .= " AND codnotafiscal <> :codnotafiscal ";
			$parametros["codnotafiscal"] = $this->codnotafiscal;
		}
		
		if ($this->emitida)
		{
			$condicao .= " AND emitida = true AND codfilial = :codfilial AND modelo = :modelo ";
			$parametros["codfilial"] = $this->codfilial;
			$parametros["modelo"] = $this->modelo;
		}
		else
		{
			$condicao .= " AND emitida = false AND codpessoa = :codpessoa ";
			$parametros["codpessoa"] = $this->codpessoa;
		}
		
		if ($nota = NotaFiscal::model()->findAll($condicao, $parametros))
			$this->addError($attribute, "Esta Nota Fiscal já está cadastrada no sistema!");

	}
		
	// valida chave da NFE
	public function validaSaida($attribute, $params)
	{
		if (empty($this->emissao))
			return;
		
		if (empty($this->saida))
			return;
		
		$saida = DateTime::createFromFormat("d/m/Y",$this->saida);
		$emissao = DateTime::createFromFormat("d/m/Y",$this->emissao);
		$maximo = new DateTime("now");
		$maximo->add(new DateInterval("P3D"));
		
		if ($saida < $emissao)
			$this->addError($attribute, "A data de Entrada/Saída precisa ser posterior à $this->emissao!");
		
		if ($saida > $maximo)
			$this->addError($attribute, "A data de Entrada/Saída precisa ser anterior à " . $maximo->format('d/m/Y') . " !");
	}
	
	// valida chave da NFE
	public function validaChaveNFE($attribute, $params)
	{
		if (empty($this->nfechave))
			return;
		
		$digito = $this->calculaDigitoChaveNFE($this->nfechave);
		
		if ($digito == -1)
			$this->addError($attribute, "Chave da NFE Inválida!");
		
		if (substr($this->nfechave, 43, 1) <> $digito)
			$this->addError($attribute, "Dígito da Chave da NFE Inválido!");

		$condicao = "nfechave = :nfechave";
		$parametros["nfechave"] = $this->nfechave;

		if (!empty($this->codnotafiscal))
		{
			$condicao .= " AND codnotafiscal != :codnotafiscal";
			$parametros["codnotafiscal"] = $this->codnotafiscal;
		}

		if (!empty($this->codfilial))
		{
			$condicao .= " AND codfilial = :codfilial ";
			$parametros["codfilial"] = $this->codfilial;
		}

                if ($nota = NotaFiscal::model()->findAll($condicao, $parametros))
                        $this->addError($attribute, "Esta Chave já está cadastrada no sistema!");

	}
	
	// compara CNPJ da Filial ou da Pessoa com o CNPJ da Chave da NFE
	public function validaPessoaPelaChaveNFE($attribute, $params)
	{
		if (empty($this->nfechave))
			return;
		
		if (empty($this->codpessoa))
			return;
		
		if (empty($this->codfilial))
			return;
		
		$cnpj = substr(Yii::app()->format->numeroLimpo($this->nfechave), 6, 14);
		
		if (strlen($cnpj) <> 14)
			return;
		
		if ($this->emitida)
		{
			if ($cnpj != $this->Filial->Pessoa->cnpj)
				$this->addError($attribute, "A filial selecionada não bate com o CNPJ da chave da NFE!");
		}
		else
		{
			$pessoas = Pessoa::model()->findAll("cnpj = :cnpj", array(":cnpj" => $cnpj));
			$achou = false;
			foreach ($pessoas as $pessoa)
				if ($this->codpessoa == $pessoa->codpessoa)
					$achou = true;

			if (!$achou)
				$this->addError($attribute, "A pessoa selecionada não bate com o CNPJ da chave da NFE!");
		}
	}
	
	// compara Serie informada com a Serie da chave a NFE
	public function validaSeriePelaChaveNFE($attribute, $params)
	{
		if (empty($this->nfechave))
			return;
		
		if (empty($this->serie))
			return;
		
		$serie = intval(substr(Yii::app()->format->numeroLimpo($this->nfechave), 22, 3));
		
		if ($serie <> $this->serie)
			$this->addError($attribute, "A série informada não bate com a chave da NFE!");
		
	}
	
	// compara numero informada com o numero da chave a NFE
	public function validaNumeroPelaChaveNFE($attribute, $params)
	{
		if (empty($this->nfechave))
			return;
		
		if (empty($this->numero))
			return;
		
		$numero = intval(substr(Yii::app()->format->numeroLimpo($this->nfechave), 25, 9));
		
		if ($numero <> $this->numero)
			$this->addError($attribute, "O número informado não bate com a chave da NFE!");
		
	}

	// compara data de emissão informada com o mes e ano da chave a NFE
	public function validaEmissaoPelaChaveNFE($attribute, $params)
	{
		if (empty($this->nfechave))
			return;
		
		if (empty($this->emissao))
			return;
		
		$mes = substr(Yii::app()->format->numeroLimpo($this->nfechave), 4, 2);
		$ano = intval(substr(Yii::app()->format->numeroLimpo($this->nfechave), 2, 2));
		$ano += 2000;
		
		if (($mes <> substr($this->emissao, 3, 2)) || ($ano <> substr($this->emissao, 6, 4)))
			$this->addError($attribute, "A emissão informada não bate com a chave da NFE!");
		
		
	}
	
	public Static function calculaDigitoChaveNFE($chave)
	{

		//Dim i As Integer
		//Dim c As Byte

		$key = 0;
		$chave = substr(Yii::app()->format->numeroLimpo($chave), 0, 43);
		
		//echo $chave;

		If (strlen($chave) <> 43)
			return -1;

		$c = 2;

		//faz um loop por cada número o mutiplicando-o pelos valores de C
		for ($i = strlen($chave); $i >= 1; $i--)
		{
			//vericica se o valor de c for maior que nove passa o valor para 2
			If ($c > 9) 
				$c = 2;

			//soma os valores mutiplicados
			$key = $key + (intval(substr($chave, $i-1, 1)) * $c);
			
			$c++;
		}

		//obtem o Digito Verificador
		If ((($key % 11) == 0) || (($key % 11) == 1))
			return 0;
		else
			return (11 - ($key % 11));

	}	

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'NotaFiscalProdutoBarras' => array(self::HAS_MANY, 'NotaFiscalProdutoBarra', 'codnotafiscal', 'order'=>'criacao ASC NULLS LAST, codnotafiscalprodutobarra ASC'),
			'NfeTerceiros' => array(self::HAS_MANY, 'NfeTerceiro', 'codnotafiscal'),
			'Operacao' => array(self::BELONGS_TO, 'Operacao', 'codoperacao'),
			'NaturezaOperacao' => array(self::BELONGS_TO, 'NaturezaOperacao', 'codnaturezaoperacao'),
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'EstoqueLocal' => array(self::BELONGS_TO, 'EstoqueLocal', 'codestoquelocal'),
			'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),			
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'NotaFiscalCartaCorrecaos' => array(self::HAS_MANY, 'NotaFiscalCartaCorrecao', 'codnotafiscal', 'order'=>'sequencia DESC'),
			'NotaFiscalDuplicatass' => array(self::HAS_MANY, 'NotaFiscalDuplicatas', 'codnotafiscal', 'order'=>'vencimento ASC, valor ASC, codnotafiscalduplicatas ASC'),
			'NotaFiscalReferenciadas' => array(self::HAS_MANY, 'NotaFiscalReferenciada', 'codnotafiscal'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codnotafiscal' => '#',
			'codnaturezaoperacao' => 'Natureza de Operação',
			'emitida' => 'Emitida',
			'nfechave' => 'Chave',
			'tpemis' => 'Forma Emissão NFe/NFCe',
			'nfeimpressa' => 'Impressa',
			'serie' => 'Série',
			'numero' => 'Número',
			'emissao' => 'Emissão',
			'saida' => 'Saída/Entrada',
			'codfilial' => 'Filial',
			'codestoquelocal' => 'Local Estoque',
			'codpessoa' => 'Pessoa',
			'observacoes' => 'Observações',
			'volumes' => 'Volumes',
			'frete' => 'Frete por Conta',
			'codoperacao' => 'Operação',
			'nfereciboenvio' => 'Recibo do Envio',
			'nfedataenvio' => 'Data Envio',
			'nfeautorizacao' => 'Autorização',
			'nfedataautorizacao' => 'Data Autorização',
			'valorfrete' => 'Frete',
			'valorseguro' => 'Seguro',
			'valordesconto' => 'Desconto',
			'valoroutras' => 'Outras',
			'nfecancelamento' => 'Cancelamento',
			'nfedatacancelamento' => 'Data do Cancelamento',
			'nfeinutilizacao' => 'Inutilização',
			'nfedatainutilizacao' => 'Data da Inutilização',
			'justificativa' => 'Justificativa',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuário Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuário Criação',
			'valorprodutos' => 'Produtos',
			'valortotal' => 'Total',			
			'icmsbase' => 'ICMS Base',
			'icmsvalor' => 'ICMS Valor',
			'icmsstbase' => 'ICMS ST Base',
			'icmsstvalor' => 'ICMS ST Valor',
			'ipibase' => 'IPI Base',
			'ipivalor' => 'IPI Valor',
			'modelo' => 'Modelo NFE',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($comoDataProvider = true)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codnotafiscal',$this->codnotafiscal, false);
		$criteria->compare('codnaturezaoperacao',$this->codnaturezaoperacao, false);
		$criteria->compare('emitida',$this->emitida);
		$criteria->compare('nfechave',$this->nfechave, false);
		$criteria->compare('tpemis',$this->tpemis);
		$criteria->compare('nfeimpressa',$this->nfeimpressa);
		$criteria->compare('serie',$this->serie);
		$criteria->compare('numero',$this->numero);
		$criteria->compare('modelo',$this->modelo);
		$criteria->compare('emissao',$this->emissao, false);
		$criteria->compare('saida',$this->saida, false);
		$criteria->compare('codfilial',$this->codfilial, false);
		$criteria->compare('codestoquelocal',$this->codestoquelocal,false);
		$criteria->compare('codpessoa',$this->codpessoa, false);
		$criteria->compare('observacoes',$this->observacoes, false);
		$criteria->compare('volumes',$this->volumes);
		$criteria->compare('frete',$this->frete);
		$criteria->compare('codoperacao',$this->codoperacao, false);
		$criteria->compare('nfereciboenvio',$this->nfereciboenvio, false);
		$criteria->compare('nfedataenvio',$this->nfedataenvio, false);
		$criteria->compare('nfeautorizacao',$this->nfeautorizacao, false);
		$criteria->compare('nfedataautorizacao',$this->nfedataautorizacao, false);
		$criteria->compare('valorfrete',$this->valorfrete, false);
		$criteria->compare('valorseguro',$this->valorseguro, false);
		$criteria->compare('valordesconto',$this->valordesconto, false);
		$criteria->compare('valoroutras',$this->valoroutras, false);
		$criteria->compare('nfecancelamento',$this->nfecancelamento, false);
		$criteria->compare('nfedatacancelamento',$this->nfedatacancelamento, false);
		$criteria->compare('nfeinutilizacao',$this->nfeinutilizacao, false);
		$criteria->compare('nfedatainutilizacao',$this->nfedatainutilizacao, false);
		$criteria->compare('justificativa',$this->justificativa, false);
		$criteria->compare('alteracao',$this->alteracao, false);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao, false);
		$criteria->compare('criacao',$this->criacao, false);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao, false);
		$criteria->compare('valorprodutos',$this->valorprodutos, false);
		$criteria->compare('valortotal',$this->valortotal, false);
		$criteria->compare('icmsbase',$this->icmsbase, false);
		$criteria->compare('icmsvalor',$this->icmsvalor, false);
		$criteria->compare('icmsstbase',$this->icmsstbase, false);
		$criteria->compare('icmsstvalor',$this->icmsstvalor, false);
		$criteria->compare('ipibase',$this->ipibase, false);
		$criteria->compare('ipivalor',$this->ipivalor, false);
		
		if ($emissao_de = DateTime::createFromFormat("d/m/y",$this->emissao_de))
		{
			$criteria->addCondition('t.emissao >= :emissao_de');
			$criteria->params = array_merge($criteria->params, array(':emissao_de' => $emissao_de->format('Y-m-d')  . ' 00:00:00.0' ));
		}
		if ($emissao_ate = DateTime::createFromFormat("d/m/y",$this->emissao_ate))
		{
			$criteria->addCondition('t.emissao <= :emissao_ate');
			$criteria->params = array_merge($criteria->params, array(':emissao_ate' => $emissao_ate->format('Y-m-d')  . ' 23:59:59.9'));
		}
		if ($saida_de = DateTime::createFromFormat("d/m/y",$this->saida_de))
		{
			$criteria->addCondition('t.saida >= :saida_de');
			$criteria->params = array_merge($criteria->params, array(':saida_de' => $saida_de->format('Y-m-d').' 00:00:00.0'));
		}
		if ($saida_ate = DateTime::createFromFormat("d/m/y",$this->saida_ate))
		{
			$criteria->addCondition('t.saida <= :saida_ate');
			$criteria->params = array_merge($criteria->params, array(':saida_ate' => $saida_ate->format('Y-m-d').' 23:59:59.9'));
		}
		
		switch ($this->codstatus)
		{
			case self::CODSTATUS_NOVA;
				$criteria->addCondition('codnotafiscal = 0');
				break;
			
			case self::CODSTATUS_DIGITACAO;
				$criteria->addCondition('t.emitida = true and t.numero = 0');
				break;
			
			case self::CODSTATUS_AUTORIZADA;
				$criteria->addCondition('t.emitida = true and t.nfechave is not null and t.nfeautorizacao is not null and t.nfecancelamento is null and t.nfeinutilizacao is null');
				break;

			case self::CODSTATUS_LANCADA;
                $criteria->addCondition('t.emitida = false');
				break;
			
			case self::CODSTATUS_NOSSA_EMISSAO;
                $criteria->addCondition('t.emitida = true');
				break;
			
			case self::CODSTATUS_NAOAUTORIZADA;
				$criteria->addCondition('t.emitida = true and t.numero > 0 and t.nfeautorizacao is null and t.nfecancelamento is null and t.nfeinutilizacao is null');
				break;
			
			case self::CODSTATUS_INUTILIZADA;
                $criteria->addCondition('t.emitida = true and t.nfeinutilizacao is not null');
				break;
			
			case self::CODSTATUS_CANCELADA;
				$criteria->addCondition('t.emitida = true and t.nfecancelamento is not null');
				break;
		}
		

		if ($comoDataProvider)
		{
			$criteria->order = 't.saida DESC, t.codfilial ASC, t.numero DESC';
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array('pageSize'=>20)
			));
		}
		else
		{
			$criteria->order = 't.codfilial, t.codnaturezaoperacao, t.emissao, t.saida, t.modelo, t.numero';			
			return $this->findAll($criteria);
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NotaFiscal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	function calculaCodStatus()
	{

		if ($this->isNewRecord)
		{
			$this->codstatus = self::CODSTATUS_NOVA;
			return $this->codstatus;
		}
		
		if (!empty($this->nfeinutilizacao))
		{
			$this->codstatus = self::CODSTATUS_INUTILIZADA;
			return $this->codstatus;
		}
		
		if (!empty($this->nfecancelamento))
		{
			$this->codstatus = self::CODSTATUS_CANCELADA;
			return $this->codstatus;
		}
		
		if ($this->emitida)
		{
			if (empty($this->numero))
			{
				$this->codstatus = self::CODSTATUS_DIGITACAO;
				return $this->codstatus;
			}
			
			if (!empty($this->nfeautorizacao))
			{
				$this->codstatus = self::CODSTATUS_AUTORIZADA;
				return $this->codstatus;
			}

			$this->codstatus = self::CODSTATUS_NAOAUTORIZADA;
			return $this->codstatus;
		}
		
		$this->codstatus = self::CODSTATUS_LANCADA;
		return $this->codstatus;
		
	}
	
	function calculaStatus()
	{
		$codstatus = $this->calculaCodStatus();
		$opcoes = $this->getStatusListaCombo();
		$this->status = $opcoes[$codstatus];
	}

	function getTpEmisListaCombo()
	{
		return array(
			self::TPEMIS_NORMAL => "Emissão normal (não em contingência)",
			self::TPEMIS_FS_IA => "Contingência FS-IA, com impressão do DANFE em formulário de segurança",
			self::TPEMIS_SCAN => "Contingência SCAN (Sistema de Contingência do Ambiente Nacional) Desativação prevista para 30/06/2014",
			self::TPEMIS_DPEC => "Contingência DPEC (Declaração Prévia da Emissão em Contingência)",
			self::TPEMIS_FS_DA => "Contingência FS-DA, com impressão do DANFE em formulário de segurança",
			self::TPEMIS_SVC_AN => "Contingência SVC-AN (SEFAZ Virtual de Contingência do AN)",
			self::TPEMIS_SVC_RS => "Contingência SVC-RS (SEFAZ Virtual de Contingência do RS)",
			self::TPEMIS_OFFLINE => "Contingência Off-Line da NFC-e"
		);
	}
	
	
	function getStatusListaCombo()
	{
		return array(
			self::CODSTATUS_NOVA => "Nova",
			self::CODSTATUS_DIGITACAO => "Em Digitação",
			self::CODSTATUS_AUTORIZADA => "Autorizada",
			self::CODSTATUS_LANCADA => "Lançada",
			self::CODSTATUS_NOSSA_EMISSAO => "Nossa Emissão",
			self::CODSTATUS_NAOAUTORIZADA => "Não Autorizada",
			self::CODSTATUS_INUTILIZADA => "Inutilizada",
			self::CODSTATUS_CANCELADA => "Cancelada"
		);
	}
	
	function getFreteListaCombo()
	{
		return array(
			self::FRETE_EMITENTE => "Emitente",
			self::FRETE_DESTINATARIO => "Destinatario",
			self::FRETE_TERCEIROS => "Terceiros",
			self::FRETE_SEM => "Sem Frete",
		);
	}

	function getModeloListaCombo()
	{
		return array(
			self::MODELO_NFE => self::MODELO_NFE . " - NFe - Nota",
			self::MODELO_NFCE => self::MODELO_NFCE . " - NFC-e - Cupom"
		);
	}
	
	protected function afterFind()
	{
		$this->calculaStatus();
		$this->_codnaturezaoperacao_original = null;
		$this->_codnaturezaoperacao_original = $this->codnaturezaoperacao;
		$this->_codfilial_original = null;
		$this->_codfilial_original = $this->codfilial;
		$this->_codpessoa_original = null;
		$this->_codpessoa_original = $this->codpessoa;
		return parent::afterFind();
	}
	
	//preenche codoperacao
	protected function beforeValidate()
	{
		if (!empty($this->codnaturezaoperacao))
		{
			if (isset($this->NaturezaOperacao))
				$this->codoperacao = $this->NaturezaOperacao->codoperacao;
		}
		
		return parent::beforeValidate();
	}
	

	public function podeEditar()
	{
		if ($this->codstatus == NotaFiscal::CODSTATUS_AUTORIZADA
			|| $this->codstatus == NotaFiscal::CODSTATUS_INUTILIZADA
			|| $this->codstatus == NotaFiscal::CODSTATUS_CANCELADA)
			return false;
		
		if ($this->emitida && !empty($this->numero))
			return false;
		
		return true;
		
	}
	
	protected function afterSave()
	{
		// se alterou Natureza de Operacao, Filial ou Pessoa, Recalcula tributacao
		if (($this->codnaturezaoperacao != $this->_codnaturezaoperacao_original) 
			|| ($this->codfilial != $this->_codfilial_original)
			|| ($this->codpessoa != $this->_codpessoa_original)
			)
		{
			$nfpbs = NotaFiscalProdutoBarra::model()->findAll("codnotafiscal = {$this->codnotafiscal}");
			foreach ($nfpbs as $nfpb)
			{
				//Limpa Tributacao Calculada
				$nfpb->codcfop = null;
				$nfpb->csosn = null;
				
				$nfpb->icmscst = null;
				$nfpb->icmsbase = null;
				$nfpb->icmspercentual = null;
				$nfpb->icmsvalor = null;
				
				$nfpb->ipicst = null;
				$nfpb->ipibase = null;
				$nfpb->ipipercentual = null;
				$nfpb->ipivalor = null;

				$nfpb->icmsstbase = null;
				$nfpb->icmsstpercentual = null;
				$nfpb->icmsstvalor = null;
				
				$nfpb->piscst = null;
				$nfpb->pisbase = null;
				$nfpb->pispercentual = null;
				$nfpb->pisvalor = null;
				
				$nfpb->cofinscst = null;
				$nfpb->cofinsbase = null;
				$nfpb->cofinspercentual = null;
				$nfpb->cofinsvalor = null;
				
				$nfpb->csllbase = null;
				$nfpb->csllpercentual = null;
				$nfpb->csllvalor = null;
				
				$nfpb->irpjbase = null;
				$nfpb->irpjpercentual = null;
				$nfpb->irpjvalor = null;
				
				$nfpb->save();
			}
		}
		
		if (!$this->emitida && !empty($this->nfechave))
		{
			if ($nft = NfeTerceiro::model()->find('codnotafiscal is null and nfechave = :nfechave', array(':nfechave' => $this->nfechave)))
			{
				$nft->codnotafiscal = $this->codnotafiscal;
				$nft->save();
			}
		}
		
		return parent::afterSave();
	}
	
	public function scopes () 
	{
		return array(
			'pendentes'=>array(
				'condition' => '
					   t.emitida = true 
						and t.numero > 0 
						and t.nfeautorizacao is null 
						and t.nfecancelamento is null 
						and t.nfeinutilizacao is null
						and t.emissao >= \'2016-01-08\'
						and t.alteracao <= (current_timestamp - interval \'15 seconds\')
				',
				'order'=>'emissao ASC',
				),
			);
	}
	
}
