<?php

/**
 * This is the model class for table "mgsis.tblgrupocliente".
 *
 * The followings are the available columns in table 'mgsis.tblgrupocliente':
 * @property string $codgrupocliente
 * @property string $grupocliente
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Pessoa[] $Pessoas
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class GrupoCliente extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblgrupocliente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('grupocliente', 'required'),
			array('grupocliente', 'length', 'max'=>50),
			array('alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codgrupocliente, grupocliente, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Pessoas' => array(self::HAS_MANY, 'Pessoa', 'codgrupocliente'),
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
			'codgrupocliente' => '#',
			'grupocliente' => 'Grupo do Cliente',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuario Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuario Criação',
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

		//$criteria->compare('codgrupocliente',$this->codgrupocliente,false);
		$criteria->compare('codgrupocliente',Yii::app()->format->numeroLimpo($this->codgrupocliente),false);

		//$criteria->compare('grupocliente',$this->grupocliente,true);
		if (!empty($this->grupocliente))
		{
			$texto  = str_replace(' ', '%', trim($this->grupocliente));
			$criteria->addCondition('t.grupocliente ILIKE :grupocliente');
			$criteria->params = array_merge($criteria->params, array(':grupocliente' => '%'.$texto.'%'));
		}	
		$criteria->compare('alteracao',$this->alteracao,false);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('criacao',$this->criacao,false);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.codgrupocliente ASC'),
			'pagination'=>array('pageSize'=>20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GrupoCliente the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codgrupocliente', 'grupocliente'),
				'order'=>'grupocliente ASC',
				),
			);
	}
	
	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codgrupocliente', 'grupocliente');
	}	
}
