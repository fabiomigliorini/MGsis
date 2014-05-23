<?php

/**
 * This is the model class for table "mgsis.tblunidademedida".
 *
 * The followings are the available columns in table 'mgsis.tblunidademedida':
 * @property string $codunidademedida
 * @property string $unidademedida
 * @property string $sigla
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Produto[] $Produtos
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property ProdutoEmbalagem[] $ProdutoEmbalagems
 */
class UnidadeMedida extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblunidademedida';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('unidademedida, sigla', 'required'),
			array('unidademedida', 'length', 'max'=>15),
			array('sigla', 'length', 'max'=>3),
			array('alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codunidademedida, unidademedida, sigla, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Produtos' => array(self::HAS_MANY, 'Produto', 'codunidademedida'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'ProdutoEmbalagems' => array(self::HAS_MANY, 'ProdutoEmbalagem', 'codunidademedida'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codunidademedida' => '#',
			'unidademedida' => 'Descrição',
			'sigla' => 'Sigla',
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

		$criteria->compare('codunidademedida',Yii::app()->format->numeroLimpo($this->codunidademedida),false);
		//$criteria->compare('unidademedida',$this->unidademedida,false);
		if (!empty($this->unidademedida))
		{
			$texto  = str_replace(' ', '%', trim($this->unidademedida));
			$criteria->addCondition('t.unidademedida ILIKE :unidademedida');
			$criteria->params = array_merge($criteria->params, array(':unidademedida' => '%'.$texto.'%'));
		}
		$criteria->compare('sigla',$this->sigla,false);
		$criteria->compare('alteracao',$this->alteracao,false);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('criacao',$this->criacao,false);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.codunidademedida ASC'),
			'pagination'=>array('pageSize'=>20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UnidadeMedida the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codunidademedida', 'sigla'),
				'order'=>'sigla ASC',
				),
			);
	}
	
	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codunidademedida', 'sigla');
	}	
	
}
