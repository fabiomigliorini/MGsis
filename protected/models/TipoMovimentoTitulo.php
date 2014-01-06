<?php

/**
 * This is the model class for table "mgsis.tbltipomovimentotitulo".
 *
 * The followings are the available columns in table 'mgsis.tbltipomovimentotitulo':
 * @property string $codtipomovimentotitulo
 * @property string $tipomovimentotitulo
 * @property boolean $implantacao
 * @property boolean $ajuste
 * @property boolean $armotizacao
 * @property boolean $juros
 * @property boolean $desconto
 * @property boolean $pagamento
 * @property boolean $estorno
 * @property string $observacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 * @property Movimentotitulo[] $movimentotitulos
 * @property Tipotitulo[] $tipotitulos
 */
class TipoMovimentoTitulo extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tbltipomovimentotitulo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codtipomovimentotitulo', 'required'),
			array('tipomovimentotitulo', 'length', 'max'=>20),
			array('observacao', 'length', 'max'=>255),
			array('implantacao, ajuste, armotizacao, juros, desconto, pagamento, estorno, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codtipomovimentotitulo, tipomovimentotitulo, implantacao, ajuste, armotizacao, juros, desconto, pagamento, estorno, observacao, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'codusuarioalteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'codusuariocriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'movimentotitulos' => array(self::HAS_MANY, 'Movimentotitulo', 'codtipomovimentotitulo'),
			'tipotitulos' => array(self::HAS_MANY, 'Tipotitulo', 'codtipomovimentotitulo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codtipomovimentotitulo' => 'Codtipomovimentotitulo',
			'tipomovimentotitulo' => 'Tipomovimentotitulo',
			'implantacao' => 'Implantacao',
			'ajuste' => 'Ajuste',
			'armotizacao' => 'Armotizacao',
			'juros' => 'Juros',
			'desconto' => 'Desconto',
			'pagamento' => 'Pagamento',
			'estorno' => 'Estorno',
			'observacao' => 'Observacao',
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

		$criteria->compare('codtipomovimentotitulo',$this->codtipomovimentotitulo,true);
		$criteria->compare('tipomovimentotitulo',$this->tipomovimentotitulo,true);
		$criteria->compare('implantacao',$this->implantacao);
		$criteria->compare('ajuste',$this->ajuste);
		$criteria->compare('armotizacao',$this->armotizacao);
		$criteria->compare('juros',$this->juros);
		$criteria->compare('desconto',$this->desconto);
		$criteria->compare('pagamento',$this->pagamento);
		$criteria->compare('estorno',$this->estorno);
		$criteria->compare('observacao',$this->observacao,true);
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
	 * @return TipoMovimentoTitulo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
