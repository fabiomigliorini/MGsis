<?php

/**
 * This is the model class for table "mgsis.tblliquidacaotitulo".
 *
 * The followings are the available columns in table 'mgsis.tblliquidacaotitulo':
 * @property string $codliquidacaotitulo
 * @property string $transacao
 * @property string $sistema
 * @property string $codportador
 * @property string $observacao
 * @property string $codusuario
 * @property string $estornado
 * @property string $codusuarioestorno
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Portador $codportador
 * @property Usuario $codusuario
 * @property Usuario $codusuarioestorno
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 * @property Movimentotitulo[] $movimentotitulos
 */
class LiquidacaoTitulo extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblliquidacaotitulo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codliquidacaotitulo, transacao, sistema, codportador', 'required'),
			array('observacao', 'length', 'max'=>200),
			array('codusuario, estornado, codusuarioestorno, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codliquidacaotitulo, transacao, sistema, codportador, observacao, codusuario, estornado, codusuarioestorno, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'codportador' => array(self::BELONGS_TO, 'Portador', 'codportador'),
			'codusuario' => array(self::BELONGS_TO, 'Usuario', 'codusuario'),
			'codusuarioestorno' => array(self::BELONGS_TO, 'Usuario', 'codusuarioestorno'),
			'codusuarioalteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'codusuariocriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'movimentotitulos' => array(self::HAS_MANY, 'Movimentotitulo', 'codliquidacaotitulo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codliquidacaotitulo' => 'Codliquidacaotitulo',
			'transacao' => 'Transacao',
			'sistema' => 'Sistema',
			'codportador' => 'Codportador',
			'observacao' => 'Observacao',
			'codusuario' => 'Codusuario',
			'estornado' => 'Estornado',
			'codusuarioestorno' => 'Codusuarioestorno',
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

		$criteria->compare('codliquidacaotitulo',$this->codliquidacaotitulo,true);
		$criteria->compare('transacao',$this->transacao,true);
		$criteria->compare('sistema',$this->sistema,true);
		$criteria->compare('codportador',$this->codportador,true);
		$criteria->compare('observacao',$this->observacao,true);
		$criteria->compare('codusuario',$this->codusuario,true);
		$criteria->compare('estornado',$this->estornado,true);
		$criteria->compare('codusuarioestorno',$this->codusuarioestorno,true);
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
	 * @return LiquidacaoTitulo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
