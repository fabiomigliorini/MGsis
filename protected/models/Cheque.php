<?php

/**
 * This is the model class for table "mgsis.tblcheque".
 *
 * The followings are the available columns in table 'mgsis.tblcheque':
 * @property string $codcheque
 * @property string $cmc7
 * @property string $codbanco
 * @property string $agencia
 * @property string $contacorrente
 * @property string $emitente
 * @property string $numero
 * @property string $emissao
 * @property string $vencimento
 * @property string $repasse
 * @property string $destino
 * @property string $devolucao
 * @property string $motivodevolucao
 * @property string $observacao
 * @property string $lancamento
 * @property string $alteracao
 * @property string $cancelamento
 * @property string $valor
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Cobranca[] $Cobrancas
 * @property ChequeEmitente[] $ChequeEmitentes
 * @property Banco $Banco
 * @property Usuario $usuarioAlteracao
 * @property Usuario $usuarioCriacao
 */
class Cheque extends MGActiveRecord
{
	const CODSTATUS_ABERTO = 10;
	const CODSTATUS_REPASSADO = 20;
	const CODSTATUS_DEVOLVIDO = 30;
	const CODSTATUS_CANCELADO = 90;
	
	public $vencimento_de;
	public $vencimento_ate;
	public $emissao_de;
	public $emissao_ate;
	public $repasse_de;
	public $repasse_ate;
	public $devolucao_de;
	public $devolucao_ate;
	public $codstatus;
	public $status;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblcheque';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codbanco, agencia, contacorrente, emitente, numero, emissao, vencimento, valor', 'required'),
			array('cmc7, destino, motivodevolucao', 'length', 'max'=>50),
			array('agencia', 'length', 'max'=>10),
			array('contacorrente, numero', 'length', 'max'=>15),
			array('emitente', 'length', 'max'=>100),
			array('observacao', 'length', 'max'=>200),
			array('valor', 'length', 'max'=>14),
			array('repasse, devolucao, alteracao, cancelamento, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('vencimento_de, vencimento_ate, emissao_de, emissao_ate, repasse_de, repasse_ate, devolucao_de, devolucao_ate, codstatus, codcheque, cmc7, codbanco, agencia, contacorrente, emitente, numero, emissao, vencimento, repasse, destino, devolucao, motivodevolucao, observacao, lancamento, alteracao, cancelamento, valor, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'Cobrancas' => array(self::HAS_MANY, 'Cobranca', 'codcheque'),
			'ChequeEmitentes' => array(self::HAS_MANY, 'ChequeEmitente', 'codcheque'),
			'Banco' => array(self::BELONGS_TO, 'Banco', 'codbanco'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codcheque' => '#',
			'cmc7' => 'CMC7',
			'codbanco' => 'Banco',
			'agencia' => 'Agência',
			'contacorrente' => 'Conta Corrente',
			'emitente' => 'Emitente',
			'numero' => 'Número',
			'emissao' => 'Emissão',
			'vencimento' => 'Vencimento',
			'repasse' => 'Repasse',
			'destino' => 'Destino',
			'devolucao' => 'Devolução',
			'motivodevolucao' => 'Motivo da Devolução',
			'observacao' => 'Observação',
			'lancamento' => 'Lançamento',
			'alteracao' => 'Alteração',
			'cancelamento' => 'Cancelamento',
			'valor' => 'Valor',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codcheque',$this->codcheque,false);
		
		$criteria->compare('cmc7',$this->cmc7,false);
		
		$criteria->compare('codbanco',$this->codbanco,false);
		
		$criteria->compare('agencia',$this->agencia,false);
		
		$criteria->compare('contacorrente',$this->contacorrente,false);
		
		//$criteria->compare('emitente',$this->emitente,false);
		if (!empty($this->emitente))
		{
			$texto  = str_replace(' ', '%', trim($this->emitente));
			$criteria->addCondition('t.emitente ILIKE :emitente');
			$criteria->params = array_merge($criteria->params, array(':emitente' => '%'.$texto.'%'));
		}
		
		$criteria->compare('numero',$this->numero,false);
		
		//$criteria->compare('emissao',$this->emissao,false);
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

		
		//$criteria->compare('vencimento',$this->vencimento,false);
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
		
		//$criteria->compare('repasse',$this->repasse,false);
		if ($repasse_de = DateTime::createFromFormat("d/m/y",$this->repasse_de))
		{
			$criteria->addCondition('t.repasse >= :repasse_de');
			$criteria->params = array_merge($criteria->params, array(':repasse_de' => $repasse_de->format('Y-m-d').' 00:00:00.0'));
		}
		
		if ($repasse_ate = DateTime::createFromFormat("d/m/y",$this->repasse_ate))
		{
			$criteria->addCondition('t.repasse <= :repasse_ate');
			$criteria->params = array_merge($criteria->params, array(':repasse_ate' => $repasse_ate->format('Y-m-d').' 23:59:59.9'));
		}
		
		
		//$criteria->compare('destino',$this->destino,false);
		if (!empty($this->destino))
		{
			$texto  = str_replace(' ', '%', trim($this->destino));
			$criteria->addCondition('t.destino ILIKE :destino');
			$criteria->params = array_merge($criteria->params, array(':destino' => '%'.$texto.'%'));
		}
		
		//$criteria->compare('devolucao',$this->devolucao,false);
		if ($devolucao_de = DateTime::createFromFormat("d/m/y",$this->devolucao_de))
		{
			$criteria->addCondition('t.devolucao >= :devolucao_de');
			$criteria->params = array_merge($criteria->params, array(':devolucao_de' => $devolucao_de->format('Y-m-d').' 00:00:00.0'));
		}
		
		if ($devolucao_ate = DateTime::createFromFormat("d/m/y",$this->devolucao_ate))
		{
			$criteria->addCondition('t.devolucao <= :devolucao_ate');
			$criteria->params = array_merge($criteria->params, array(':devolucao_ate' => $devolucao_ate->format('Y-m-d').' 23:59:59.9'));
		}
		
		//$criteria->compare('motivodevolucao',$this->motivodevolucao,false);
		if (!empty($this->motivodevolucao))
		{
			$texto  = str_replace(' ', '%', trim($this->motivodevolucao));
			$criteria->addCondition('t.motivodevolucao ILIKE :motivodevolucao');
			$criteria->params = array_merge($criteria->params, array(':motivodevolucao' => '%'.$texto.'%'));
		}
		
		$criteria->compare('observacao',$this->observacao,false);
		
		$criteria->compare('lancamento',$this->lancamento,false);
		
		$criteria->compare('alteracao',$this->alteracao,false);
		
		$criteria->compare('cancelamento',$this->cancelamento,false);
		
		$criteria->compare('valor',$this->valor,false);
		
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		
		$criteria->compare('criacao',$this->criacao,false);
		
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);
		
		switch ($this->codstatus)
		{
			case self::CODSTATUS_ABERTO:
				$criteria->addCondition('t.cancelamento IS NULL AND t.devolucao IS NULL AND t.repasse IS NULL');
				break;
			
			case self::CODSTATUS_REPASSADO:
				$criteria->addCondition('t.cancelamento IS NULL AND t.devolucao IS NULL AND t.repasse IS NOT NULL');
				break;
			
			case self::CODSTATUS_DEVOLVIDO:
				$criteria->addCondition('t.cancelamento IS NULL AND t.devolucao IS NOT NULL');
				break;
			
			case self::CODSTATUS_CANCELADO:
				$criteria->addCondition('t.cancelamento IS NOT NULL');
				break;
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.vencimento ASC, t.valor ASC'),
			'pagination'=>array('pageSize'=>20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cheque the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	function getStatusListaCombo()
	{
		return array(
			self::CODSTATUS_ABERTO => "Aberto",
			self::CODSTATUS_REPASSADO => "Repassado",
			self::CODSTATUS_DEVOLVIDO => "Devolvido",
			self::CODSTATUS_CANCELADO => "Cancelado"
		);
	}
	
	protected function afterFind()
	{
		$this->calculaStatus();
		return parent::afterFind();
	}
	
	function calculaStatus()
	{
		$codstatus = $this->calculaCodStatus();
		$opcoes = $this->getStatusListaCombo();
		$this->status = $opcoes[$codstatus];
	}
	
	function calculaCodStatus()
	{
		if (!empty($this->cancelamento))
		{
			$this->codstatus = self::CODSTATUS_CANCELADO;
			return $this->codstatus;
		}
		
		if (!empty($this->devolucao))
		{
			$this->codstatus = self::CODSTATUS_DEVOLVIDO;
			return $this->codstatus;
		}
		
		if (!empty($this->repasse))
		{
			$this->codstatus = self::CODSTATUS_REPASSADO;
			return $this->codstatus;
		}

		$this->codstatus = self::CODSTATUS_ABERTO;
		return $this->codstatus;
		
	}
}
