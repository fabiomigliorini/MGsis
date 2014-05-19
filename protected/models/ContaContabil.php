<?php

/**
 * This is the model class for table "mgsis.tblcontacontabil".
 *
 * The followings are the available columns in table 'mgsis.tblcontacontabil':
 * @property string $codcontacontabil
 * @property string $contacontabil
 * @property string $numero
 * @property boolean $inativo
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Titulo[] $Titulos
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class ContaContabil extends MGActiveRecord
{
	
	const AGRUPAMENTO = 7;
	const VENDA = 2;
	const COMPRA = 1;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblcontacontabil';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codcontacontabil', 'required'),
			array('contacontabil', 'length', 'max'=>50),
			array('numero', 'length', 'max'=>15),
			array('inativo, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codcontacontabil, contacontabil, numero, inativo, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Titulos' => array(self::HAS_MANY, 'Titulo', 'codcontacontabil'),
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
			'codcontacontabil' => 'Codcontacontabil',
			'contacontabil' => 'Contacontabil',
			'numero' => 'Numero',
			'inativo' => 'Inativo',
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

		$criteria->compare('codcontacontabil',$this->codcontacontabil,true);
		$criteria->compare('contacontabil',$this->contacontabil,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('inativo',$this->inativo);
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
	 * @return ContaContabil the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codcontacontabil', 'contacontabil'),
				'order'=>'contacontabil ASC',
				),
			);
	}
	
	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codcontacontabil', 'contacontabil');
	}	
	
}
