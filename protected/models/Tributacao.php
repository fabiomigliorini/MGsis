<?php

/**
 * This is the model class for table "mgsis.tbltributacao".
 *
 * The followings are the available columns in table 'mgsis.tbltributacao':
 * @property string $codtributacao
 * @property string $tributacao
 * @property string $aliquotaicmsecf
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Produto[] $Produtos
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property TributacaoNaturezaOperacao[] $TributacaoNaturezaOperacaos
 */
class Tributacao extends MGActiveRecord
{

	const TRIBUTADO = 1;
	const ISENTO = 2;
	const SUBSTITUICAO = 3;
	const DIFERIDO = 4;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tbltributacao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tributacao, aliquotaicmsecf', 'required'),
			array('tributacao', 'length', 'max'=>50),
			array('aliquotaicmsecf', 'length', 'max'=>10),
			array('alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codtributacao, tributacao, aliquotaicmsecf, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Produtos' => array(self::HAS_MANY, 'Produto', 'codtributacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'TributacaoNaturezaOperacaos' => array(self::HAS_MANY, 'TributacaoNaturezaOperacao', 'codtributacao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codtributacao' => '#',
			'tributacao' => 'Tributação',
			'aliquotaicmsecf' => 'Aliquota ICMS ECF',
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

		$criteria->compare('codtributacao',Yii::app()->format->numeroLimpo($this->codtributacao),false);
		if (!empty($this->tributacao))
		{
			$texto  = str_replace(' ', '%', trim($this->tributacao));
			$criteria->addCondition('t.tributacao ILIKE :tributacao');
			$criteria->params = array_merge($criteria->params, array(':tributacao' => '%'.$texto.'%'));
		}
		$criteria->compare('aliquotaicmsecf',$this->aliquotaicmsecf,false);
		$criteria->compare('alteracao',$this->alteracao,false);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('criacao',$this->criacao,false);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.codtributacao ASC'),
			'pagination'=>array('pageSize'=>20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tributacao the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function scopes ()
	{
		return array(
			'combo'=>array(
				'select'=>array('codtributacao', 'tributacao'),
				'order'=>'tributacao ASC',
				),
			);
	}

	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codtributacao', 'tributacao');
	}

}
