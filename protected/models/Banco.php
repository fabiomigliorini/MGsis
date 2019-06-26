<?php

/**
 * This is the model class for table "mgsis.tblbanco".
 *
 * The followings are the available columns in table 'mgsis.tblbanco':
 * @property string $codbanco
 * @property string $banco
 * @property string $sigla
 * @property string $numerobanco
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Portador[] $Portadors
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property Cheque[] $Cheques
 */
class Banco extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblbanco';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('banco', 'required'),
			array('banco', 'length', 'max'=>50),
			array('sigla', 'length', 'max'=>3),
			array('numerobanco, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codbanco, banco, sigla, numerobanco, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Portadors' => array(self::HAS_MANY, 'Portador', 'codbanco'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'Cheques' => array(self::HAS_MANY, 'Cheque', 'codbanco'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codbanco' => '#',
			'banco' => 'Banco',
			'sigla' => 'Sigla',
			'numerobanco' => 'Número Banco',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('codbanco',$this->codbanco,false);
		$criteria->compare('codbanco',Yii::app()->format->numeroLimpo($this->codbanco),false);
		//$criteria->compare('banco',$this->banco,true);
		if (!empty($this->banco))
		{
			$texto  = str_replace(' ', '%', trim($this->banco));
			$criteria->addCondition('t.banco ILIKE :banco');
			$criteria->params = array_merge($criteria->params, array(':banco' => '%'.$texto.'%'));
		}
		$criteria->compare('sigla',$this->sigla,false);
		$criteria->compare('numerobanco',$this->numerobanco,false);
		$criteria->compare('alteracao',$this->alteracao,false);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('criacao',$this->criacao,false);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.codbanco ASC'),
			'pagination'=>array('pageSize'=>20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Banco the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codbanco', 'banco'),
				'order'=>'banco ASC',
				),
			);
	}

	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codbanco', 'banco');
	}
}
