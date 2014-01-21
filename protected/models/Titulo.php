<?php

/**
 * This is the model class for table "mgsis.tbltitulo".
 *
 * The followings are the available columns in table 'mgsis.tbltitulo':
 * @property string $codtitulo
 * @property string $codtipotitulo
 * @property string $codfilial
 * @property string $codportador
 * @property string $codpessoa
 * @property string $codcontacontabil
 * @property string $numero
 * @property string $fatura
 * @property string $transacao
 * @property string $sistema
 * @property string $emissao
 * @property string $vencimento
 * @property string $vencimentooriginal
 * @property string $debito
 * @property string $credito
 * @property boolean $gerencial
 * @property string $observacao
 * @property boolean $boleto
 * @property string $nossonumero
 * @property string $debitototal
 * @property string $creditototal
 * @property string $saldo
 * @property string $debitosaldo
 * @property string $creditosaldo
 * @property string $transacaoliquidacao
 * @property string $codnegocioformapagamento
 * @property string $codtituloagrupamento
 * @property string $remessa
 * @property string $estornado
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Movimentotitulo[] $movimentotitulos
 * @property Movimentotitulo[] $movimentotitulos1
 * @property Contacontabil $codcontacontabil
 * @property Filial $codfilial
 * @property Negocioformapagamento $codnegocioformapagamento
 * @property Pessoa $codpessoa
 * @property Portador $codportador
 * @property Tipotitulo $codtipotitulo
 * @property Tituloagrupamento $codtituloagrupamento
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 * @property Boletoretorno[] $boletoretornos
 * @property Cobranca[] $cobrancas
 * @property Cobrancahistoricotitulo[] $cobrancahistoricotitulos
 */
class Titulo extends MGActiveRecord
{
	
	public $vencimento_de;
	public $vencimento_ate;
	public $emissao_de;
	public $emissao_ate;
	public $criacao_de;
	public $criacao_ate;
	public $Juros;
	public $operacao;
	public $valor;
	public $gerado_automaticamente;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tbltitulo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codtipotitulo, valor, codfilial, codpessoa, codcontacontabil, transacao, emissao, vencimento, vencimentooriginal', 'required'),
			array('valor', 'validaPodeAlterarValor'),
			array('codtipotitulo', 'validaPodeAlterarTipoTitulo'),
			array('boleto', 'validaBoleto'),
			array('codportador', 'validaFilialPortador'),
			array('transacao', 'validaDataTransacao'),
			array('numero', 'validaNumero'),
			array('numero, nossonumero', 'length', 'max'=>20),
			array('fatura', 'length', 'max'=>50),
			array('debito, credito, debitototal, creditototal, saldo, debitosaldo, creditosaldo', 'length', 'max'=>14),
			array('vencimento', 'date', 'format'=>Yii::app()->locale->getDateFormat('medium')),
			array('observacao', 'length', 'max'=>255),
			array('codportador, gerencial, boleto, transacaoliquidacao, codnegocioformapagamento, codtituloagrupamento, remessa, estornado, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('transacao','date','format'=>Yii::app()->locale->getDateFormat('medium')),
			//array('sistema','datetime'),
			array('sistema','date','format'=> strtr(Yii::app()->locale->getDateTimeFormat(), array("{0}" => Yii::app()->locale->getTimeFormat('medium'), "{1}" => Yii::app()->locale->getDateFormat('medium')))),
			array('codtitulo, vencimento_de, vencimento_ate, emissao_de, emissao_ate, criacao_de, criacao_ate, codtipotitulo, codfilial, codportador, codpessoa, codcontacontabil, numero, emissao, vencimento, credito, gerencial, boleto, nossonumero, saldo, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
		);
	}

	public function validaPodeAlterarValor($attribute, $params)
	{
		if (!$this->isNewRecord)
		{
			$old = self::findByPk($this->codtitulo);
			if ($old->saldo == 0)
			{
				if ($old->valor <> $this->valor)
					$this->addError($attribute, 'Impossível alterar o valor de um título baixado ou estornado!');
			}
		}
	}

	public function validaPodeAlterarTipoTitulo($attribute, $params)
	{
		if (!$this->isNewRecord)
		{
			$old = self::findByPk($this->codtitulo);
			if ($this->codtipotitulo <> $old->codtipotitulo and !empty($this->codtipotitulo))
			{
				if (($this->TipoTitulo->debito <> $old->TipoTitulo->debito) || ($this->TipoTitulo->credito <> $old->TipoTitulo->credito))
				{
					$this->addError($attribute, 'Impossível alterar o tipo de título de DB para CR, e vice-versa!');
				}
			}
		}
	}
	
	public function validaFilialPortador($attribute, $params)
	{
		if (!empty($this->codfilial))
			if (!empty($this->codportador))
				if (($this->codfilial <> $this->Portador->codfilial) && !empty($this->Portador->codfilial))
					$this->addError($attribute, "Este portador só é válido para a filial {$this->Portador->Filial->filial}!");
	}

	public function validaBoleto($attribute, $params)
	{
		if (!$this->boleto)
			return;
		
		if (empty($this->codportador))
		{
			$this->addError($attribute, "Selecione um portador!");
			return;
		}
		
		if (!$this->Portador->emiteboleto)
			$this->addError($attribute, "O portador selecionado não permite boletos!");
	}
	
	public function validaNumero($attribute, $params)
	{
		if (empty($this->numero))
			return;
		
		if (empty($this->codtipotitulo))
			return;

		$outro = false;
		if ($this->TipoTitulo->pagar)
		{
			$outro = Titulo::model()->find(
				array(
					'select'=>'codtitulo',
					'condition'=>'codpessoa = :codpessoa AND numero = :numero AND codtitulo <> :codtitulo',
					'params'=>array(':codpessoa'=>$this->codpessoa, ':numero'=>$this->numero, ':codtitulo' => (empty($this->codtitulo)?-1:$this->codtitulo))
				)
			);
			
		}
		elseif ($this->TipoTitulo->receber)
		{
			$outro = Titulo::model()->find(
				array(
					'select'=>'codtitulo',
					'condition'=>'codfilial = :codfilial AND numero = :numero AND codtitulo <> :codtitulo',
					'params'=>array(':codfilial'=>$this->codfilial, ':numero'=>$this->numero, ':codtitulo' => (empty($this->codtitulo)?-1:$this->codtitulo))
				)
			);
		}
		
		if ($outro)
		{
			$this->addError($attribute, "Numero {$this->numero} já utilizado no título " . CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($outro->codtitulo)),array('view','id'=>$outro->codtitulo)) . "!");
		}
	}
	
	public function validaDataTransacao ($attribute, $params)
	{
		if (!$this->isNewRecord)
			return;
		
		$pg = ParametrosGerais::model()->findByPK(1);
		
		if($pg===null)
			return;
		
		if ($pg->validaDataTransacao($this->transacao))
			return;
		
		$this->addError($attribute, "Data de transação inválida, deve ser entre '{$pg->transacaoinicial}' e '{$pg->transacaofinal}'!");
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'MovimentoTitulos' => array(self::HAS_MANY, 'MovimentoTitulo', 'codtitulo', 'order'=>'criacao asc, transacao asc'),
			'MovimentoTitulosRelacionado' => array(self::HAS_MANY, 'MovimentoTitulo', 'codtitulorelacionado'),
			'ContaContabil' => array(self::BELONGS_TO, 'ContaContabil', 'codcontacontabil'),
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'NegocioFormaPagamento' => array(self::BELONGS_TO, 'NegocioFormaPagamento', 'codnegocioformapagamento'),
			'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
			'Portador' => array(self::BELONGS_TO, 'Portador', 'codportador'),
			'TipoTitulo' => array(self::BELONGS_TO, 'TipoTitulo', 'codtipotitulo'),
			'TituloAgrupamento' => array(self::BELONGS_TO, 'TituloAgrupamento', 'codtituloagrupamento'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'BoletoRetornos' => array(self::HAS_MANY, 'BoletoRetorno', 'codtitulo', 'order'=>'criacao asc, codboletoretorno ASC'),
			'Cobrancas' => array(self::HAS_MANY, 'Cobranca', 'codtitulo'),
			'CobrancaHistoricoTitulos' => array(self::HAS_MANY, 'CobrancaHistoricoTitulo', 'codtitulo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codtitulo' => '#',
			'codtipotitulo' => 'Tipo Titulo',
			'codfilial' => 'Filial',
			'codportador' => 'Portador',
			'codpessoa' => 'Pessoa',
			'codcontacontabil' => 'Conta Contabil',
			'numero' => 'Número',
			'fatura' => 'Fatura',
			'transacao' => 'Transação',
			'sistema' => 'Sistema',
			'emissao' => 'Emissão',
			'vencimento' => 'Vencimento',
			'vencimentooriginal' => 'Vencimento Original',
			'valor' => 'Valor',
			'debito' => 'Débito',
			'credito' => 'Crédito',
			'gerencial' => 'Gerencial',
			'observacao' => 'Observação',
			'boleto' => 'Boleto',
			'nossonumero' => 'Nosso Número',
			'debitototal' => 'Débito Total',
			'creditototal' => 'Crédito Total',
			'saldo' => 'Saldo',
			'debitosaldo' => 'Saldo Débito',
			'creditosaldo' => 'Saldo Crédito',
			'transacaoliquidacao' => 'Liquidação',
			'codnegocioformapagamento' => 'Negócio Forma Pagamento',
			'codtituloagrupamento' => 'Título Agrupamento',
			'remessa' => 'Remessa',
			'estornado' => 'Estorno',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuário Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuário Criação',
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

		$criteria->compare('t.codtitulo', $this->codtitulo, false);
		$criteria->compare('t.codfilial', $this->codfilial, false);
		$criteria->compare('t.codpessoa', $this->codpessoa, false);
		if (!empty($this->numero))
		{
			$texto  = str_replace(' ', '%', trim($this->numero));
			$criteria->addCondition('t.numero ILIKE :numero');
			$criteria->params = array_merge($criteria->params, array(':numero' => '%'.$texto.'%'));
		}
		if ($vencimento_de = DateTime::createFromFormat("d/m/y",$this->vencimento_de))
		{
			$criteria->addCondition('t.vencimento >= :vencimento_de');
			$criteria->params = array_merge($criteria->params, array(':vencimento_de' => $vencimento_de->format('Y-m-d').' 00:00:00.0'));
		}
		if ($vencimento_ate = DateTime::createFromFormat("d/m/y",$this->vencimento_ate))
		{
			$criteria->addCondition('t.vencimento <= :vencimento_ate');
			$criteria->params = array_merge($criteria->params, array(':vencimento_ate' => $vencimento_ate->format('Y-m-d').' 23:59:59.9'));
		}
		if ($emissao_de = DateTime::createFromFormat("d/m/y",$this->emissao_de))
		{
			$criteria->addCondition('t.emissao >= :emissao_de');
			$criteria->params = array_merge($criteria->params, array(':emissao_de' => $emissao_de->format('Y-m-d').' 00:00:00.0'));
		}
		if ($emissao_ate = DateTime::createFromFormat("d/m/y",$this->emissao_ate))
		{
			$criteria->addCondition('t.emissao <= :emissao_ate');
			$criteria->params = array_merge($criteria->params, array(':emissao_ate' => $emissao_ate->format('Y-m-d').' 23:59:59.9'));
		}
		if ($criacao_de = DateTime::createFromFormat("d/m/y",$this->criacao_de))
		{
			$criteria->addCondition('t.criacao >= :criacao_de');
			$criteria->params = array_merge($criteria->params, array(':criacao_de' => $criacao_de->format('Y-m-d').' 00:00:00.0'));
		}
		if ($criacao_ate = DateTime::createFromFormat("d/m/y",$this->criacao_ate))
		{
			$criteria->addCondition('t.criacao <= :criacao_ate');
			$criteria->params = array_merge($criteria->params, array(':criacao_ate' => $criacao_ate->format('Y-m-d').' 23:59:59.9'));
		}
		
		
		switch ($this->saldo) 
		{
			case 9:
				break;
			case 1:
				$criteria->addCondition('t.saldo = 0');
				break;
			default:
				$criteria->addCondition('t.saldo <> 0');
				break;
		}		
		
		switch ($this->credito) 
		{
			case 2:
				$criteria->addCondition('t.debito > 0');
				break;
			case 1:
				$criteria->addCondition('t.credito > 0');
				break;
		}
		
		switch ($this->boleto)
		{
			case 2:
				$criteria->addCondition('t.boleto = false');
				break;
			case 1:
				$criteria->addCondition('t.boleto = true');
				break;
		}

		if (!empty($this->nossonumero))
		{
			$texto  = str_replace(' ', '%', trim($this->nossonumero));
			$criteria->addCondition('t.nossonumero ILIKE :nossonumero');
			$criteria->params = array_merge($criteria->params, array(':nossonumero' => '%'.$texto.'%'));
		}
		
		$criteria->compare('t.codportador',$this->codportador,false);
		$criteria->compare('t.codcontacontabil',$this->codcontacontabil,false);
		$criteria->compare('t.codtipotitulo',$this->codtipotitulo,false);
		
		switch ($this->gerencial)
		{
			case 2:
				$criteria->addCondition('t.gerencial = false');
				break;
			case 1:
				$criteria->addCondition('t.gerencial = true');
				break;
		}
		$criteria->compare('t.codusuariocriacao',$this->codusuariocriacao,false);
		
        $criteria->with = array(
				'Pessoa' => array('select' => '"Pessoa".fantasia'),
				'Filial' => array('select' => '"Filial".filial'),
				'Portador' => array('select' => '"Portador".portador'),
				'UsuarioCriacao' => array('select' => '"UsuarioCriacao".usuario'),
				'UsuarioAlteracao' => array('select' => '"UsuarioAlteracao".usuario'),
				'ContaContabil' => array('select' => '"ContaContabil".contacontabil'),
				'TipoTitulo' => array('select' => '"TipoTitulo".tipotitulo'),
			);
	
		$criteria->select = 't.codtitulo, t.vencimento, t.emissao, t.codfilial, t.numero, t.codportador, t.credito, t.debito, t.saldo, t.codtipotitulo, t.codcontacontabil, t.codusuariocriacao, t.nossonumero, t.gerencial, t.codpessoa, t.codusuarioalteracao, t.estornado';

		$criteria->order = '"Pessoa".fantasia ASC, t.vencimento ASC, t.saldo ASC';
		
		if ($comoDataProvider)
		{
			$params = array(
				'criteria'=>$criteria,
			);
			return new CActiveDataProvider($this, $params);
		}
		else
		{
			return $this->findAll($criteria);
		}
		
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Titulo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function afterFind()
	{
		$ret = parent::afterFind();
		$this->Juros = new MGJuros(array("de" => $this->vencimento,	"valorOriginal" => $this->saldo));
		$this->operacao = ($this->saldo<0 || $this->credito>$this->debito)?"CR":"DB";
		$this->valor = abs($this->debito-$this->credito);
		
		if (!empty($this->codnegocioformapagamento) || !empty($this->codtituloagrupamento))
			$this->gerado_automaticamente = true;
		else
			$this->gerado_automaticamente = false;
			
		return $ret;
	}
	
	protected function beforeSave()
	{
		$ret = parent::beforeSave();
		
		if (empty($this->sistema))
			$this->sistema = $this->criacao;
		
		if (empty($this->numero))
			$this->numero = $this->codtitulo;
		
		if ($this->TipoTitulo->credito)
		{
			$this->credito = Yii::app()->format->unformatNumber($this->valor);
			$this->debito = 0;
		}
		else
		{
			$this->credito = 0;
			$this->debito = Yii::app()->format->unformatNumber($this->valor);
		}

		//preenche nossonumero quando for boleto
		if (!empty($this->codportador) && $this->boleto)
		{
			if ($this->isNewRecord)
				$codportador_antigo = $this->codportador;
			else
			{
				$old = Titulo::model()->findByPk($this->codtitulo);
				$codportador_antigo = $old->codportador;
			}
			if (empty($this->nossonumero) || $this->codportador <> $codportador_antigo)
				$this->nossonumero = Codigo::PegaProximo ("NossoNumero-#{$this->codportador}");
		}
		
		return $ret;
		
	}
	

	protected function afterSave()
	{
		$ret = parent::afterSave();
		
		/*
		 * 
		 */
		return $ret;
	}
	
	public function save($runValidation=true, $attributes=NULL)
	{
		//variaveis do registro novo x antigo
		$novo = $this->isNewRecord;
		if (!$novo)
			$old = Titulo::model()->findByPk($this->codtitulo);
		
		//comeca transacao
		/*
		try
		{
			$trans = $this->dbConnection->beginTransaction();
		} catch (Exception $ex) {
			if ($ex->getMessage() != "There is already an active transaction")
			{
				throw new $ex;
			}
		}
		*/
		
		//salva registro do titulo
		$ret = parent::save($runValidation, $attributes);
		
		//se salvou o titulo
		if ($ret)
		{
			//inicializa variaveis
			$debito = 0;
			$credito = 0;
			$data = date('d/m/Y');
			
			//se registro novo
			if ($novo)
			{
				//os valores do movimento sao iguais ao do novo registro
				$debito = $this->debito;
				$credito = $this->credito;
				$codtipomovimento = $this->TipoTitulo->codtipomovimentotitulo;
				if ($data = DateTime::createFromFormat('Y-m-d', $this->transacao))
					$data = $data->format('d/m/Y');
			}
			else
			{
				//senao, pega a diferenca dos valores
				if ($this->debito > $old->debito)
					$debito = $this->debito - $old->debito;
				if ($this->debito < $old->debito)
					$credito = $old->debito - $this->debito;
				if ($this->credito > $old->credito)
					$credito = $this->credito - $old->credito;
				if ($this->credito < $old->credito)
					$debito = $old->credito - $this->credito;
				$codtipomovimento = 200;
			}

			//se teve diferenca, um registro de movimento
			if ($debito >0 || $credito >0)
			{
				$mov = new MovimentoTitulo('insert');
				$mov->codtitulo = $this->codtitulo;
				$mov->codtipomovimentotitulo = $codtipomovimento;
				$mov->codportador = $this->codportador;
				$mov->debito = $debito;
				$mov->credito = $credito;
				$mov->codtituloagrupamento = $this->codtituloagrupamento;
				$mov->transacao = $data;

				//se deu erro ao salvar, registra erro do movimento no titulo
				if (!$mov->save())
				{
					$this->addError($this->tableSchema->primaryKey, 'Erro ao gerar movimento do título!');
					$this->addErrors($mov->getErrors());
					$ret = false;
				}
			}
		}

		//se deu erro desfaz transacao, senao commit
		/*
		if (isset($trans))
		{
			if (!$ret)
				$trans->rollback();
			else
				$trans->commit();
		}
		*/
		
		//retorna
		return $ret;
	}
	
	public function atualizaSaldo()
	{
		$debito = 0;
		$credito = 0;
		$datatit = DateTime::createFromFormat('d/m/Y', $this->transacao);
		$dataestorno = false;
		foreach ($this->MovimentoTitulos as $mov)
		{
			$debito += $mov->debito;
			$credito += $mov->credito;
			if ($datamov = DateTime::createFromFormat('d/m/Y', $mov->transacao))
			{
				if ($datamov > $datatit)
					$datatit = $datamov;
			}
			if ($mov->codtipomovimentotitulo == 900)
			{
				if (!$dataestorno = DateTime::createFromFormat('d/m/Y H:i:s', $mov->criacao))
				{
					if (!$dataestorno = DateTime::createFromFormat('d/m/Y H:i:s', $mov->sistema))
						$dataestorno = new DateTime();
				}
			}
		}
		$this->debitototal = $debito;
		$this->creditototal = $credito;
		$this->saldo = $debito - $credito;
		if ($this->saldo >= 0)
		{
			$this->debitosaldo = abs($this->saldo);
			$this->creditosaldo = 0;
		}
		else
		{
			$this->debitosaldo = 0;
			$this->creditosaldo = abs($this->saldo);
		}
		if ($this->saldo == 0)
			$this->transacaoliquidacao = $datatit->format('d/m/Y');
		else
			$this->transacaoliquidacao = null;
		
		if ($this->saldo == 0 && $dataestorno)
			$this->estornado = $dataestorno->format('d/m/Y H:i:s');
		else
			$this->estornado = null;
		
		return $this->save();
	}

	public function estorna()
	{
		$ret = false;
		
		$trans = $this->dbConnection->beginTransaction();
		
		if ($this->saldo == ($this->debito - $this->credito))
		{
			$mov = new MovimentoTitulo('insert');
			$mov->codtipomovimentotitulo = 900;
			$mov->codtitulo = $this->codtitulo;
			$mov->codportador = $this->codportador;
			$mov->debito = $this->creditosaldo;
			$mov->credito = $this->debitosaldo;
			$mov->transacao = date('d/m/Y');
			$mov->sistema = date("d/m/Y H:i:s");
			if ($mov->save())
			{
				$ret = true;
			}
		}
		
		if ($ret)
			$trans->commit();
		else
			$trans->rollback();
		
		return $ret;
	}
		
}
