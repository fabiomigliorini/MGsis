<?php

/**
 * This is the model class for table "mgsis.tblpagarmebandeira".
 *
 * The followings are the available columns in table 'mgsis.tblpagarmebandeira':
 * @property string $codpagarmebandeira
 * @property string $bandeira
 * @property string $scheme
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 *
 * The followings are the available model relations:
 * @property Pagarmepagamento[] $pagarmepagamentos
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 */
class PagarMeBandeira extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblpagarmebandeira';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bandeira', 'required'),
			array('bandeira', 'length', 'max'=>100),
			array('scheme', 'length', 'max'=>20),
			array('criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codpagarmebandeira, bandeira, scheme, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe', 'on'=>'search'),
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
			'PagarMePagamentos' => array(self::HAS_MANY, 'PagarMePagamento', 'codpagarmebandeira'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codpagarmebandeira' => '#',
			'bandeira' => 'Bandeira',
			'scheme' => 'Scheme',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuario Criação',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuario Alteração',
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

		$criteria->compare('codpagarmebandeira',$this->codpagarmebandeira,true);
		$criteria->compare('bandeira',$this->bandeira,true);
		$criteria->compare('scheme',$this->scheme,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PagarMeBandeira the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
