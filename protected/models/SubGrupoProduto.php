<?php

/**
 * This is the model class for table "mgsis.tblsubgrupoproduto".
 *
 * The followings are the available columns in table 'mgsis.tblsubgrupoproduto':
 * @property string $codsubgrupoproduto
 * @property string $codgrupoproduto
 * @property string $subgrupoproduto
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Grupoproduto $codgrupoproduto
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 * @property Produto[] $produtos
 */
class SubGrupoProduto extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblsubgrupoproduto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codsubgrupoproduto', 'required'),
			array('subgrupoproduto', 'length', 'max'=>50),
			array('codgrupoproduto, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codsubgrupoproduto, codgrupoproduto, subgrupoproduto, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'GrupoProduto' => array(self::BELONGS_TO, 'GrupoProduto', 'codgrupoproduto'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'Produtos' => array(self::HAS_MANY, 'Produto', 'codsubgrupoproduto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codsubgrupoproduto' => 'Codsubgrupoproduto',
			'codgrupoproduto' => 'Codgrupoproduto',
			'subgrupoproduto' => 'Subgrupoproduto',
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

		$criteria->compare('codsubgrupoproduto',$this->codsubgrupoproduto,true);
		$criteria->compare('codgrupoproduto',$this->codgrupoproduto,true);
		$criteria->compare('subgrupoproduto',$this->subgrupoproduto,true);
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
	 * @return SubGrupoProduto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codsubgrupoproduto', 'subgrupoproduto'),
				'with'=>array(
					'GrupoProduto' => array(
						'select'=>array('codgrupoproduto', 'grupoproduto')
					)
				),
				'order'=>'"GrupoProduto".grupoproduto ASC, subgrupoproduto ASC',
				),
			);
	}
	
	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codsubgrupoproduto', 'subgrupoproduto', 'GrupoProduto.grupoproduto');
	}	
	
}
