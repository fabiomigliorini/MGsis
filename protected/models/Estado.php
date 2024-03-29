<?php

/**
 * This is the model class for table "mgsis.tblestado".
 *
 * The followings are the available columns in table 'mgsis.tblestado':
 * @property string $codestado
 * @property string $codpais
 * @property string $estado
 * @property string $sigla
 * @property string $codigooficial
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property TributacaoNaturezaOperacao[] $TributacaoNaturezaOperacaos
 * @property Cidade[] $Cidades
 * @property Pais $Pais
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class Estado extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblestado';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estado, codpais, sigla, codigooficial', 'required'),
			array('estado', 'length', 'max'=>50),
			array('sigla', 'length', 'max'=>2),
			array('codigooficial', 'unique'),
			array('codpais, codigooficial, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codestado, codpais, estado, sigla, codigooficial, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'TributacaoNaturezaOperacaos' => array(self::HAS_MANY, 'TributacaoNaturezaOperacao', 'codestado'),
			'Cidades' => array(self::HAS_MANY, 'Cidade', 'codestado'),
			'Pais' => array(self::BELONGS_TO, 'Pais', 'codpais'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codestado' => '#',
			'codpais' => 'País',
			'estado' => 'Estado',
			'sigla' => 'Sigla',
			'codigooficial' => 'Côdigo Oficial',
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
		$criteria->compare('codestado',Yii::app()->format->numeroLimpo($this->codestado),false);
		//$criteria->compare('estado',$this->estado,false);
		if (!empty($this->estado))
		{
			$texto  = str_replace(' ', '%', trim($this->estado));
			$criteria->addCondition('t.estado ILIKE :estado');
			$criteria->params = array_merge($criteria->params, array(':estado' => '%'.$texto.'%'));
		}
		$criteria->compare('codpais',$this->codpais,false);
		//$criteria->compare('sigla',$this->sigla,false);
		if (!empty($this->sigla))
		{
			$texto  = str_replace(' ', '%', trim($this->sigla));
			$criteria->addCondition('t.sigla ILIKE :sigla');
			$criteria->params = array_merge($criteria->params, array(':sigla' => '%'.$texto.'%'));
		}
		$criteria->compare('codigooficial',$this->codigooficial,false);
		$criteria->compare('alteracao',$this->alteracao,false);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('criacao',$this->criacao,false);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.estado ASC'),
			'pagination'=>array('pageSize'=>20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Estado the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codestado', 'estado'),
				'order'=>'estado ASC',
				),
			);
	}
	
	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codestado', 'estado');
	}
}
