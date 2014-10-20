<?php

/**
 * This is the model class for table "mgsis.tblpessoa".
 *
 * The followings are the available columns in table 'mgsis.tblpessoa':
 * @property string $codpessoa
 * @property string $pessoa
 * @property string $fantasia
 * @property string $inativo
 * @property boolean $cliente
 * @property boolean $fornecedor
 * @property boolean $fisica
 * @property string $codsexo
 * @property string $cnpj
 * @property string $ie
 * @property boolean $consumidor
 * @property string $contato
 * @property string $codestadocivil
 * @property string $conjuge
 * @property string $endereco
 * @property string $numero
 * @property string $complemento
 * @property string $codcidade
 * @property string $bairro
 * @property string $cep
 * @property string $enderecocobranca
 * @property string $numerocobranca
 * @property string $complementocobranca
 * @property string $codcidadecobranca
 * @property string $bairrocobranca
 * @property string $cepcobranca
 * @property string $telefone1
 * @property string $telefone2
 * @property string $telefone3
 * @property string $email
 * @property string $emailnfe
 * @property string $emailcobranca
 * @property string $codformapagamento
 * @property string $credito
 * @property boolean $creditobloqueado
 * @property string $observacoes
 * @property string $mensagemvenda
 * @property boolean $vendedor
 * @property string $rg
 * @property string $desconto
 * @property integer $notafiscal
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property integer $toleranciaatraso
 * @property string $codgrupocliente
 *
 * The followings are the available model relations:
 * @property Titulo[] $Titulos
 * @property RegistroSpc[] $RegistroSpcs
 * @property TituloAgrupamento[] $TituloAgrupamentos
 * @property Filial[] $Filials
 * @property Usuario[] $Usuarios
 * @property Cidade $Cidade
 * @property Cidade $CidadeCobranca
 * @property EstadoCivil $EstadoCivil
 * @property FormaPagamento $FormaPagamento
 * @property Sexo $Sexo
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property GrupoCliente $GrupoCliente
 * @property CupomFiscal[] $CupomFiscals
 * @property CobrancaHistorico[] $CobrancaHistoricos
 * @property Negocio[] $Negocios
 * @property Negocio[] $NegocioVendedors
 */
class Pessoa extends MGActiveRecord
{
	/* @property boolean $cobrancanomesmoendereco */
 	public $cobrancanomesmoendereco;
	
	const NOTAFISCAL_TRATAMENTOPADRAO = 0;
	const NOTAFISCAL_SEMPRE = 1;
	const NOTAFISCAL_SOMENTE_FECHAMENTO = 2;
	const NOTAFISCAL_NUNCA = 9;
	
	const CONSUMIDOR = 1;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblpessoa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
			array('cnpj', 'ext.validators.CnpjCpfValidator'),
			array('ie', 'ext.validators.InscricaoEstadualValidator'),
			array('ie', 'validaCnpjDuplicado'),
			array('codgrupocliente', 'validaGrupoCliente'),
			array('ie, cep, cepcobranca','filter','filter'=>array($this, 'numeroLimpo')),
			array('toleranciaatraso, numero, email, codcidade, endereco, bairro, cep, codcidadecobranca, enderecocobranca, numerocobranca, bairrocobranca, cepcobranca, pessoa, fantasia, notafiscal, telefone1', 'required'),
			array('fantasia', 'unique', 'caseSensitive' => false),
			array('fantasia, pessoa', 'length', 'min' => 5),
			array('pessoa, contato, conjuge, endereco, enderecocobranca, email, emailnfe, emailcobranca', 'length', 'max'=>100),
			array('email, emailnfe, emailcobranca', 'email'),
			array('fantasia, complemento, bairro, complementocobranca, bairrocobranca, telefone1, telefone2, telefone3', 'length', 'max'=>50),
			array('notafiscal, toleranciaatraso', 'numerical', 'integerOnly'=>true),
			array('credito', 'length', 'max'=>14),
			array('telefone1, telefone2, telefone3', 'validaTelefone'),
			array('ie', 'length', 'max'=>20),
			array('numero, numerocobranca', 'length', 'max'=>10),
			array('cep, cepcobranca', 'length', 'max'=>10),
			array('observacoes', 'length', 'max'=>255),
			array('mensagemvenda', 'length', 'max'=>500),
			array('rg', 'length', 'max'=>30),
			array('desconto', 'numerical', 'max'=>50),
			array('notafiscal', 'in', 'range' => self::getNotaFiscalRange()),
			array('inativo, cliente, cobrancanomesmoendereco, fornecedor, fisica, codsexo, consumidor, codestadocivil, codcidade, codcidadecobranca, codformapagamento, creditobloqueado, vendedor, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			array('codpessoa, pessoa, fantasia, inativo, cnpj, codcidade, email, telefone1', 'safe', 'on'=>'search'),
		);
	}

	//retorna numero limpo
	//necessario para o filtro de ie/cep/cobranca
	public function numeroLimpo($str)
	{
		return MGFormatter::numeroLimpo($str);
	}	

	//verifica se o numero tem pelo menos 10 digitos
	public function validaTelefone($attribute,$params)
	{
		if (!empty($this->$attribute))
			if (strlen(MGFormatter::numeroLimpo($this->$attribute)) < 10)
				$this->addError($attribute,'Telefone inválido, não esqueça do DDD.');
	}
	
	//verifica se o grupo do cliente está preenchido
	public function validaGrupoCliente($attribute,$params)
	{
		if ($this->cliente && empty($this->codgrupocliente))
			$this->addError($attribute,'Grupo do Cliente obrigatório.');
	}

	//verifica se a combinacao de CNPJ e IE já não estão cadastrados
	public function validaCnpjDuplicado($attribute,$params)
	{
		
		if ($this->codpessoa == self::CONSUMIDOR)
			return true;
		
		if (!empty($this->cnpj))
		{
			$validar = true;
			
			if (!$this->isNewRecord)
			{
				$pessoa = Pessoa::model()->findByPk($this->codpessoa);
				if ($this->cnpj == $pessoa->cnpj && (int) MGFormatter::numeroLimpo($this->ie) == (int) MGFormatter::numeroLimpo($pessoa->ie))
				{
					$validar = false;
				}
			}
			
			if ($validar)
			{
				$pessoas = Pessoa::model()->findAll(
					array(
						'select' => 'codpessoa, fantasia, ie, cnpj', 
						'condition' => 'cnpj = :cnpj', 
						'params' => 
							array(
								'cnpj' => $this->cnpj,
							)
					)
				);

				foreach($pessoas as $pessoa)
				{
					if ($pessoa->codpessoa == $this->codpessoa)
						continue;

					if ((int) MGFormatter::numeroLimpo($this->ie) == (int) MGFormatter::numeroLimpo($pessoa->ie))
					{
						$erro = sprintf(
							'CNPJ/CPF e Inscrição Estadual já cadastrados para "%s" (%s).', 
							$pessoa->fantasia,
							CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($pessoa->codpessoa)),array('view','id'=>$pessoa->codpessoa))
							);
						$this->addError($attribute, $erro);
						break;
					}
				}
			}
		}
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'Titulos' => array(self::HAS_MANY, 'Titulo', 'codpessoa'),
			'RegistroSpcs' => array(self::HAS_MANY, 'RegistroSpc', 'codpessoa'),
			'TituloAgrupamentos' => array(self::HAS_MANY, 'TituloAgrupamento', 'codpessoa'),
			'Filials' => array(self::HAS_MANY, 'Filial', 'codpessoa'),
			'Usuarios' => array(self::HAS_MANY, 'Usuario', 'codpessoa'),
			'Cidade' => array(self::BELONGS_TO, 'Cidade', 'codcidade'),
			'CidadeCobranca' => array(self::BELONGS_TO, 'Cidade', 'codcidadecobranca'),
			'EstadoCivil' => array(self::BELONGS_TO, 'EstadoCivil', 'codestadocivil'),
			'FormaPagamento' => array(self::BELONGS_TO, 'FormaPagamento', 'codformapagamento'),
			'Sexo' => array(self::BELONGS_TO, 'Sexo', 'codsexo'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'CupomFiscals' => array(self::HAS_MANY, 'Cupomfiscal', 'codpessoa'),
			'CobrancaHistoricos' => array(self::HAS_MANY, 'CobrancaHistorico', 'codpessoa'),
			'Negocios' => array(self::HAS_MANY, 'Negocio', 'codpessoa'),
			'NegociosVendedors' => array(self::HAS_MANY, 'Negocio', 'codpessoavendedor'),
			'GrupoCliente' => array(self::BELONGS_TO, 'GrupoCliente', 'codgrupocliente'),
            'inclusaoSpc'=>array(
				self::STAT, 
				'RegistroSpc', 
				'codpessoa',
				'select'=>'to_char(min(inclusao), \'DD/MM/YYYY\')',
				'condition'=>'baixa is null'
				),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codpessoa' => '#',
			'pessoa' => 'Razão Social',
			'fantasia' => 'Nome Fantasia',
			'inativo' => 'Inativo desde',
			'cliente' => 'Cliente',
			'codgrupocliente' => 'Grupo de Cliente',
			'fornecedor' => 'Fornecedor',
			'fisica' => 'Pessoa Física',
			'codsexo' => 'Sexo',
			'cnpj' => 'CNPJ/CPF',
			'ie' => 'Inscrição Estadual',
			'consumidor' => 'Consumidor Final',
			'contato' => 'Contato',
			'codestadocivil' => 'Estado Civil',
			'conjuge' => 'Conjuge',
			'endereco' => 'Endereço',
			'numero' => 'Número',
			'complemento' => 'Complemento',
			'codcidade' => 'Cidade',
			'bairro' => 'Bairro',
			'cep' => 'CEP',
			'enderecocobranca' => 'Endereço',
			'numerocobranca' => 'Número',
			'complementocobranca' => 'Complemento',
			'codcidadecobranca' => 'Cidade',
			'bairrocobranca' => 'Bairro',
			'cepcobranca' => 'Cep',
			'telefone1' => 'Telefone',
			'telefone2' => 'Telefone 2',
			'telefone3' => 'Telefone 3',
			'email' => 'Email',
			'emailnfe' => 'Email para NFe',
			'emailcobranca' => 'Email para Cobranca',
			'codformapagamento' => 'Forma de Pagamento',
			'credito' => 'Limite de Credito',
			'creditobloqueado' => 'Credito Bloqueado',
			'toleranciaatraso' => 'Tolerância de Atraso',
			'observacoes' => 'Observações',
			'mensagemvenda' => 'Mensagem de Venda',
			'vendedor' => 'Vendedor',
			'rg' => 'RG',
			'desconto' => 'Desconto',
			'notafiscal' => 'Nota Fiscal',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuario Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuario Criação',
			'cobrancanomesmoendereco' => 'Cobrança no Mesmo Endereço.',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('codpessoa',$this->codpessoa,false);
		$criteria->compare('codpessoa',Yii::app()->format->numeroLimpo($this->codpessoa),false);
		$criteria->compare('codgrupocliente',$this->codgrupocliente,false);
		
		if (!empty($this->fantasia))
		{
			$texto  = str_replace(' ', '%', trim($this->fantasia));
			$criteria->addCondition('t.fantasia ILIKE :fantasia OR t.pessoa ILIKE :fantasia');
			$criteria->params = array_merge($criteria->params, array(':fantasia' => '%'.$texto.'%'));
		}
		
		if (!empty($this->cnpj))
		{
			$criteria->addCondition('cast(t.Cnpj as char(20)) ILIKE :cnpj');
			$criteria->params = array_merge($criteria->params, array(':cnpj' => (int)MGFormatter::numeroLimpo($this->cnpj) .'%'));
		}

		switch ($this->inativo)
		{
			case 9:
				break;
			
			case 1:
				$criteria->addCondition('t.inativo is not null');
				break;
			
			default:
				$criteria->addCondition('t.inativo is null');
				break;
		}
		
		if (!empty($this->email))
		{
			$criteria->addCondition('t.email ILIKE :email OR t.emailnfe ILIKE :email OR t.emailcobranca ILIKE :email');
			$criteria->params = array_merge($criteria->params, array(':email' => '%'.$this->email.'%'));
		}

		if (!empty($this->telefone1))
		{
			$criteria->addCondition('t.telefone1 ILIKE :telefone OR t.telefone2 ILIKE :telefone OR t.telefone3 ILIKE :telefone');
			$criteria->params = array_merge($criteria->params, array(':telefone' => '%'.$this->telefone1.'%'));
		}

		if (!empty($this->codcidade))
		{
			$criteria->addCondition('t.codcidade = :codcidade OR t.codcidadecobranca = :codcidade');
			$criteria->params = array_merge($criteria->params, array(':codcidade' => $this->codcidade));
		}
		
		
		return new CActiveDataProvider($this, 
				array(
					'criteria'=>$criteria,
					'sort'=>array('defaultOrder'=>'fantasia ASC'),
				)
			);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pessoa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function afterFind()
	{
		if (
			($this->enderecocobranca    <>  $this->endereco   ) or 
			($this->numerocobranca      <>  $this->numero     ) or 
			($this->complementocobranca <>  $this->complemento) or 
			($this->bairrocobranca      <>  $this->bairro     ) or 
			($this->codcidadecobranca   <>  $this->codcidade  ) or 
			($this->cepcobranca         <>  $this->cep        ) 
		   )
			$this->cobrancanomesmoendereco = false;
		else
			$this->cobrancanomesmoendereco = true;
		
		return parent::afterFind();
	}
	
	public function getNotaFiscalOpcoes()
	{
		return array(
			self::NOTAFISCAL_TRATAMENTOPADRAO => "Tratamento Padrão",
			self::NOTAFISCAL_SEMPRE => "Sempre",
			self::NOTAFISCAL_SOMENTE_FECHAMENTO => "Somente no Fechamento",
			self::NOTAFISCAL_NUNCA => "Nunca Emitir",
		);
	}

	public function getNotaFiscalRange()
	{
		return array(
			self::NOTAFISCAL_TRATAMENTOPADRAO,
			self::NOTAFISCAL_SEMPRE,
			self::NOTAFISCAL_SOMENTE_FECHAMENTO,
			self::NOTAFISCAL_NUNCA,
		);
	}
	
	public function getNotaFiscalDescricao()
	{
		$opcoes=$this->getNotaFiscalOpcoes();
		if (!isset($this->notafiscal))
			return null;
		return isset($opcoes[$this->notafiscal]) ? $opcoes[$this->notafiscal] : "Tipo Desconhecido ({$this->notafiscal})";
	}
	
	protected function beforeValidate()
	{
	
		if ($this->cobrancanomesmoendereco == true)
		{
			$this->enderecocobranca    = $this->endereco;
			$this->numerocobranca      = $this->numero;
			$this->complementocobranca = $this->complemento;
			$this->bairrocobranca      = $this->bairro;
			$this->codcidadecobranca   = $this->codcidade;
			$this->cepcobranca         = $this->cep;
		}
		
		if (empty($this->notafiscal))
			$this->notafiscal = self::NOTAFISCAL_TRATAMENTOPADRAO;
		
		return parent::beforeValidate();
	}
	
	public function totalTitulos()
	{
		
		$command = Yii::app()->db->createCommand(' 
			SELECT SUM(saldo) AS saldo, MIN(vencimento) AS vencimento
			  FROM tbltitulo 
			 WHERE codpessoa = :codpessoa
			   AND saldo <> 0
			');

		$command->params = array("codpessoa" => $this->codpessoa);

		$ret = $command->queryRow();
		$ret["vencimentodias"] = 0;
		
		if ($venc = DateTime::createFromFormat("Y-m-d",$ret["vencimento"]))
		{
			$ret["vencimento"] = $venc->format("d/m/Y");
			$hoje = new DateTime("NOW");
			$dif = $hoje->diff($venc);
			$ret["vencimentodias"] = $dif->format("%r%a");
		}
		
		return $ret;
	}
	
	public function avaliaLimiteCredito($valorAvaliar = 0)
	{
		//se esta com o credito marcado como bloqueado
		if ($this->creditobloqueado)
			return false;
		
		//busca no banco total dos titulos
		$total = $this->totalTitulos();
		
		//calcula 
		$creditototal = $total["saldo"] + $valorAvaliar;

		//vefica o valor do credito 
		if ((!empty($this->credito)) && (($this->credito * 1.05) < $creditototal))
			return false;
		
		//verifica o atraso
		if (($total["vencimentodias"] <= 0) && (abs($total["vencimentodias"]) > $this->toleranciaatraso))
			return false;
		
		
		return true;
		
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codpessoa', 'pessoa'),
				'order'=>'pessoa ASC',
				),
			);
	}
	
	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codpessoa', 'pessoa');
	}
	

}