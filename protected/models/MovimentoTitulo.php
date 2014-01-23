<?php

/**
 * This is the model class for table "mgsis.tblmovimentotitulo".
 *
 * The followings are the available columns in table 'mgsis.tblmovimentotitulo':
 * @property string $codmovimentotitulo
 * @property string $codtipomovimentotitulo
 * @property string $codtitulo
 * @property string $codportador
 * @property string $codtitulorelacionado
 * @property string $debito
 * @property string $credito
 * @property string $historico
 * @property string $transacao
 * @property string $sistema
 * @property string $codliquidacaotitulo
 * @property string $codtituloagrupamento
 * @property string $codboletoretorno
 * @property string $codcobranca
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Boletoretorno $codboletoretorno
 * @property Cobranca $codcobranca
 * @property Liquidacaotitulo $codliquidacaotitulo
 * @property Portador $codportador
 * @property Tipomovimentotitulo $codtipomovimentotitulo
 * @property Titulo $codtitulo
 * @property Tituloagrupamento $codtituloagrupamento
 * @property Titulo $codtitulorelacionado
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 */
class MovimentoTitulo extends MGActiveRecord
{
	
	public $valor;
	public $operacao;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblmovimentotitulo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codtitulo, codtipomovimentotitulo', 'required'),
			array('debito, credito', 'length', 'max'=>14),
			array('historico', 'length', 'max'=>255),
			array('codtipomovimentotitulo, codtitulo, codportador, codtitulorelacionado, transacao, sistema, codliquidacaotitulo, codtituloagrupamento, codboletoretorno, codcobranca, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codmovimentotitulo, codtipomovimentotitulo, codtitulo, codportador, codtitulorelacionado, debito, credito, historico, transacao, sistema, codliquidacaotitulo, codtituloagrupamento, codboletoretorno, codcobranca, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'BoletoRetorno' => array(self::BELONGS_TO, 'BoletoRetorno', 'codboletoretorno'),
			'Cobranca' => array(self::BELONGS_TO, 'Cobranca', 'codcobranca'),
			'LiquidacaoTitulo' => array(self::BELONGS_TO, 'LiquidacaoTitulo', 'codliquidacaotitulo'),
			'Portador' => array(self::BELONGS_TO, 'Portador', 'codportador'),
			'TipoMovimentoTitulo' => array(self::BELONGS_TO, 'TipoMovimentoTitulo', 'codtipomovimentotitulo'),
			'Titulo' => array(self::BELONGS_TO, 'Titulo', 'codtitulo'),
			'TituloAgrupamento' => array(self::BELONGS_TO, 'TitulAgrupamento', 'codtituloagrupamento'),
			'TituloRelacionado' => array(self::BELONGS_TO, 'Titulo', 'codtitulorelacionado'),
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
			'codmovimentotitulo' => 'Codmovimentotitulo',
			'codtipomovimentotitulo' => 'Codtipomovimentotitulo',
			'codtitulo' => 'Codtitulo',
			'codportador' => 'Codportador',
			'codtitulorelacionado' => 'Codtitulorelacionado',
			'debito' => 'Debito',
			'credito' => 'Credito',
			'historico' => 'Historico',
			'transacao' => 'Transacao',
			'sistema' => 'Sistema',
			'codliquidacaotitulo' => 'Codliquidacaotitulo',
			'codtituloagrupamento' => 'Codtituloagrupamento',
			'codboletoretorno' => 'Codboletoretorno',
			'codcobranca' => 'Codcobranca',
			'alteracao' => 'Alteracao',
			'codusuarioalteracao' => 'Codusuarioalteracao',
			'criacao' => 'Criacao',
			'codusuariocriacao' => 'Codusuariocriacao',
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

		$criteria->compare('codmovimentotitulo',$this->codmovimentotitulo,true);
		$criteria->compare('codtipomovimentotitulo',$this->codtipomovimentotitulo,true);
		$criteria->compare('codtitulo',$this->codtitulo,true);
		$criteria->compare('codportador',$this->codportador,true);
		$criteria->compare('codtitulorelacionado',$this->codtitulorelacionado,true);
		$criteria->compare('debito',$this->debito,true);
		$criteria->compare('credito',$this->credito,true);
		$criteria->compare('historico',$this->historico,true);
		$criteria->compare('transacao',$this->transacao,true);
		$criteria->compare('sistema',$this->sistema,true);
		$criteria->compare('codliquidacaotitulo',$this->codliquidacaotitulo,true);
		$criteria->compare('codtituloagrupamento',$this->codtituloagrupamento,true);
		$criteria->compare('codboletoretorno',$this->codboletoretorno,true);
		$criteria->compare('codcobranca',$this->codcobranca,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MovimentoTitulo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function save($runValidation=true, $attributes=NULL)
	{
		$trans = $this->dbConnection->beginTransaction();
		
		$ret = parent::save($runValidation, $attributes);
		
		if ($ret)
			$ret = $this->Titulo->atualizaSaldo();
		
		if ($ret)
			$trans->commit();
		else
			$trans->rollback();
		
		return $ret;
	}
	
	protected function afterDelete()
	{
		$ret = parent::afterDelete();
		$this->Titulo->atualizaSaldo();
		return $ret;
	}
	
	protected function afterFind()
	{
		$ret = parent::afterFind();
		$this->valor = $this->debito-$this->credito;
		$this->operacao = ($this->valor<0)?"CR":"DB";
		$this->valor = abs($this->valor);
		return $ret;
	}
	
	public function estorna()
	{
		$mov = new MovimentoTitulo('insert');
		
		switch ($this->codtipomovimentotitulo)
		{
			case TipoMovimentoTitulo::TIPO_IMPLANTACAO:
				$mov->codtipomovimentotitulo = TipoMovimentoTitulo::TIPO_ESTORNO_IMPLANTACAO;
				break;
			
			case TipoMovimentoTitulo::TIPO_AJUSTE:
				$mov->codtipomovimentotitulo = TipoMovimentoTitulo::TIPO_ESTORNO_AJUSTE;
				break;
			
			case TipoMovimentoTitulo::TIPO_AMORTIZACAO:
				$mov->codtipomovimentotitulo = TipoMovimentoTitulo::TIPO_ESTORNO_AMORTIZACAO;
				break;
			
			case TipoMovimentoTitulo::TIPO_JUROS:
				$mov->codtipomovimentotitulo = TipoMovimentoTitulo::TIPO_ESTORNO_JUROS;
				break;
			
			case TipoMovimentoTitulo::TIPO_DESCONTO:
				$mov->codtipomovimentotitulo = TipoMovimentoTitulo::TIPO_ESTORNO_DESCONTO;
				break;
			
			case TipoMovimentoTitulo::TIPO_LIQUIDACAO:
				$mov->codtipomovimentotitulo = TipoMovimentoTitulo::TIPO_ESTORNO_LIQUIDACAO;
				break;
			
			case TipoMovimentoTitulo::TIPO_AGRUPAMENTO:
				$mov->codtipomovimentotitulo = TipoMovimentoTitulo::TIPO_ESTORNO_AGRUPAMENTO;
				break;
			
			case TipoMovimentoTitulo::TIPO_LIQUIDACAO_COBRANCA:
				$mov->codtipomovimentotitulo = TipoMovimentoTitulo::TIPO_ESTORNO_LIQUIDACAO_COBRANCA;
				break;
			
			case TipoMovimentoTitulo::TIPO_MULTA:
				$mov->codtipomovimentotitulo = TipoMovimentoTitulo::TIPO_ESTORNO_MULTA;
				break;
		}
	
  		$mov->codtitulo = $this->codtitulo;
 		$mov->codportador = $this->codportador;
  		$mov->codtitulorelacionado = $this->codtitulorelacionado;
  		$mov->debito = $this->credito;
  		$mov->credito = $this->debito;
  		$mov->historico = $this->historico;
  		$mov->transacao = date('d/m/Y');
  		$mov->sistema = date('d/m/Y H:i:s');
  		$mov->codliquidacaotitulo = $this->codliquidacaotitulo;
  		$mov->codtituloagrupamento = $this->codtituloagrupamento;
  		$mov->codboletoretorno = $this->codboletoretorno;
  		$mov->codcobranca = $this->codcobranca;
		
		$ret = $mov->save();
		
		if (!$ret)
			$this->addErrors($mov->getErrors());
		
		return $ret;
	}
	
}
