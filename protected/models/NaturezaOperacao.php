<?php

/**
 * This is the model class for table "mgsis.tblnaturezaoperacao".
 *
 * The followings are the available columns in table 'mgsis.tblnaturezaoperacao':
 * @property string $codnaturezaoperacao
 * @property string $naturezaoperacao
 * @property string $codoperacao
 * @property boolean $emitida
 * @property string $observacoesnf
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Negocio[] $Negocios
 * @property TributacaoNaturezaOperacao[] $TributacaoNaturezaOperacaos
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class NaturezaOperacao extends MGActiveRecord
{
	const VENDA = 1;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnaturezaoperacao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codnaturezaoperacao', 'required'),
			array('naturezaoperacao', 'length', 'max'=>50),
			array('observacoesnf', 'length', 'max'=>500),
			array('codoperacao, emitida, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnaturezaoperacao, naturezaoperacao, codoperacao, emitida, observacoesnf, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Negocios' => array(self::HAS_MANY, 'Negocio', 'codnaturezaoperacao'),
			'TributacaoNaturezaOperacaos' => array(self::HAS_MANY, 'TributacaoNaturezaOperacao', 'codnaturezaoperacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codnaturezaoperacao' => '#',
			'naturezaoperacao' => 'Natureza Operação',
			'codoperacao' => 'Operação',
			'emitida' => 'Emitida',
			'observacoesnf' => 'Observações NF',
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

		$criteria->compare('codnaturezaoperacao',$this->codnaturezaoperacao,true);
		$criteria->compare('naturezaoperacao',$this->naturezaoperacao,true);
		$criteria->compare('codoperacao',$this->codoperacao,true);
		$criteria->compare('emitida',$this->emitida);
		$criteria->compare('observacoesnf',$this->observacoesnf,true);
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
	 * @return NaturezaOperacao the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codnaturezaoperacao', 'naturezaoperacao'),
				'order'=>'t.codoperacao ASC, t.naturezaoperacao ASC',
				),
			);
	}
	
	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codnaturezaoperacao', 'naturezaoperacao');
	}	
	
}
