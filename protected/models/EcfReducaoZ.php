<?php

/**
 * This is the model class for table "mgsis.tblecfreducaoz".
 *
 * The followings are the available columns in table 'mgsis.tblecfreducaoz':
 * @property string $codecfreducaoz
 * @property string $codecf
 * @property string $movimento
 * @property string $observacoes
 * @property string $crz
 * @property string $coo
 * @property string $cro
 * @property string $grandetotal
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Ecf $codecf
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 */
class EcfReducaoZ extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblecfreducaoz';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codecfreducaoz, codecf, movimento', 'required'),
			array('observacoes', 'length', 'max'=>500),
			array('grandetotal', 'length', 'max'=>13),
			array('crz, coo, cro, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codecfreducaoz, codecf, movimento, observacoes, crz, coo, cro, grandetotal, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'codecf' => array(self::BELONGS_TO, 'Ecf', 'codecf'),
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
			'codecfreducaoz' => 'Codecfreducaoz',
			'codecf' => 'Codecf',
			'movimento' => 'Movimento',
			'observacoes' => 'Observacoes',
			'crz' => 'Crz',
			'coo' => 'Coo',
			'cro' => 'Cro',
			'grandetotal' => 'Grandetotal',
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

		$criteria->compare('codecfreducaoz',$this->codecfreducaoz,true);
		$criteria->compare('codecf',$this->codecf,true);
		$criteria->compare('movimento',$this->movimento,true);
		$criteria->compare('observacoes',$this->observacoes,true);
		$criteria->compare('crz',$this->crz,true);
		$criteria->compare('coo',$this->coo,true);
		$criteria->compare('cro',$this->cro,true);
		$criteria->compare('grandetotal',$this->grandetotal,true);
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
	 * @return EcfReducaoZ the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
