<?php

/**
 * This is the model class for table "mgsis.tblestoquelocal".
 *
 * The followings are the available columns in table 'mgsis.tblestoquelocal':
 * @property string $codestoquelocal
 * @property string $estoquelocal
 * @property string $codfilial
 * @property string $inativo
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Filial $Filial
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property Estoquesaldo[] $EstoqueSaldos
 * @property Negocio[] $Negocios
 * @property Notafiscal[] $NotaFiscals
 */
class EstoqueLocal extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblestoquelocal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estoquelocal, codfilial', 'required'),
			array('estoquelocal', 'length', 'max'=>50),
			array('inativo, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codestoquelocal, estoquelocal, codfilial, inativo, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'EstoqueSaldos' => array(self::HAS_MANY, 'EstoqueSaldo', 'codestoquelocal'),
			'Negocios' => array(self::HAS_MANY, 'Negocio', 'codestoquelocal'),
			'NotaFiscals' => array(self::HAS_MANY, 'NotaFiscal', 'codestoquelocal'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codestoquelocal' => '#',
			'estoquelocal' => 'Local',
			'codfilial' => 'Filial',
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

		$criteria->compare('codestoquelocal',$this->codestoquelocal,true);
		$criteria->compare('estoquelocal',$this->estoquelocal,true);
		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('inativo',$this->inativo,true);
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
	 * @return EstoqueLocal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codestoquelocal', 'estoquelocal'),
				'order'=>'codestoquelocal ASC',
				),
			);
	}
	
	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codestoquelocal', 'estoquelocal');
	}	
	
}
