<?php

/**
 * This is the model class for table "mgsis.tblregistrospc".
 *
 * The followings are the available columns in table 'mgsis.tblregistrospc':
 * @property string $codregistrospc
 * @property string $codpessoa
 * @property string $inclusao
 * @property string $baixa
 * @property string $valor
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $observacoes
 * 
 * The followings are the available model relations:
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property Pessoa $Pessoa
 */
class RegistroSpc extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblregistrospc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codpessoa, inclusao, valor', 'required'),
			array('valor', 'length', 'max'=>14),
			array('observacoes', 'length', 'max'=>500),
			array('baixa, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codregistrospc, codpessoa, inclusao, baixa, valor, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codregistrospc' => '#',
			'codpessoa' => 'Pessoa',
			'inclusao' => 'Inclusão',
			'baixa' => 'Baixa',
			'valor' => 'Valor',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuario Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuario Criação',
			'observacoes' => 'Observações',
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

		//$criteria->compare('codregistrospc',$this->codregistrospc,false);
		$criteria->compare('codregistrospc',Yii::app()->format->numeroLimpo($this->codregistrospc),false);
		//$criteria->compare('codpessoa',$this->codpessoa,false);
		$criteria->compare('codpessoa',Yii::app()->format->numeroLimpo($this->codpessoa),false);
		$criteria->compare('inclusao',$this->inclusao,false);
		$criteria->compare('baixa',$this->baixa,false);
		$criteria->compare('valor',$this->valor,false);
		$criteria->compare('alteracao',$this->alteracao,false);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('criacao',$this->criacao,false);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.baixa DESC, t.inclusao DESC'),
			'pagination'=>array('pageSize'=>20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RegistroSpc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}
