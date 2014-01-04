<?php

/**
 * This is the model class for table "mgsis.tblnegocioformapagamento".
 *
 * The followings are the available columns in table 'mgsis.tblnegocioformapagamento':
 * @property string $codnegocioformapagamento
 * @property string $codnegocio
 * @property string $codformapagamento
 * @property string $valorpagamento
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Titulo[] $titulos
 * @property Formapagamento $codformapagamento
 * @property Negocio $codnegocio
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 */
class NegocioFormaPagamento extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnegocioformapagamento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codnegocioformapagamento, codnegocio, codformapagamento, valorpagamento', 'required'),
			array('valorpagamento', 'length', 'max'=>14),
			array('alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnegocioformapagamento, codnegocio, codformapagamento, valorpagamento, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'titulos' => array(self::HAS_MANY, 'Titulo', 'codnegocioformapagamento'),
			'codformapagamento' => array(self::BELONGS_TO, 'Formapagamento', 'codformapagamento'),
			'codnegocio' => array(self::BELONGS_TO, 'Negocio', 'codnegocio'),
			'codusuarioalteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'codusuariocriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codnegocioformapagamento' => 'Codnegocioformapagamento',
			'codnegocio' => 'Codnegocio',
			'codformapagamento' => 'Codformapagamento',
			'valorpagamento' => 'Valorpagamento',
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

		$criteria->compare('codnegocioformapagamento',$this->codnegocioformapagamento,true);
		$criteria->compare('codnegocio',$this->codnegocio,true);
		$criteria->compare('codformapagamento',$this->codformapagamento,true);
		$criteria->compare('valorpagamento',$this->valorpagamento,true);
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
	 * @return NegocioFormaPagamento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
