<?php

/**
 * This is the model class for table "mgsis.tblbaseremota".
 *
 * The followings are the available columns in table 'mgsis.tblbaseremota':
 * @property string $codbaseremota
 * @property string $baseremota
 * @property string $conexao
 * @property string $inicioreplicacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Auditoria[] $tblauditorias
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 */
class BaseRemota extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblbaseremota';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codbaseremota, baseremota, inicioreplicacao', 'required'),
			array('baseremota', 'length', 'max'=>50),
			array('conexao', 'length', 'max'=>500),
			array('alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codbaseremota, baseremota, conexao, inicioreplicacao, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'tblauditorias' => array(self::MANY_MANY, 'Auditoria', 'tblauditoriatransmissao(codbaseremota, codauditoria)'),
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
			'codbaseremota' => 'Codbaseremota',
			'baseremota' => 'Baseremota',
			'conexao' => 'Conexao',
			'inicioreplicacao' => 'Inicioreplicacao',
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

		$criteria->compare('codbaseremota',$this->codbaseremota,true);
		$criteria->compare('baseremota',$this->baseremota,true);
		$criteria->compare('conexao',$this->conexao,true);
		$criteria->compare('inicioreplicacao',$this->inicioreplicacao,true);
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
	 * @return BaseRemota the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
