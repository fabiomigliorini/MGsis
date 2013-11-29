<?php

/**
 * This is the model class for table "mgsis.tblecf".
 *
 * The followings are the available columns in table 'mgsis.tblecf':
 * @property string $codecf
 * @property string $ecf
 * @property string $acbrmonitorcaminho
 * @property string $acbrmonitorcaminhorede
 * @property string $codusuario
 * @property string $bloqueado
 * @property string $serie
 * @property string $codfilial
 * @property string $modelo
 * @property integer $numero
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Usuario[] $usuarios
 * @property Cupomfiscal[] $cupomfiscals
 * @property Filial $codfilial
 * @property Usuario $codusuario
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 * @property Ecfreducaoz[] $ecfreducaozs
 */
class Ecf extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblecf';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codecf, ecf, acbrmonitorcaminho, acbrmonitorcaminhorede', 'required'),
			array('numero', 'numerical', 'integerOnly'=>true),
			array('ecf', 'length', 'max'=>50),
			array('acbrmonitorcaminho, acbrmonitorcaminhorede', 'length', 'max'=>100),
			array('serie', 'length', 'max'=>20),
			array('modelo', 'length', 'max'=>2),
			array('codusuario, bloqueado, codfilial, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codecf, ecf, acbrmonitorcaminho, acbrmonitorcaminhorede, codusuario, bloqueado, serie, codfilial, modelo, numero, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'usuarios' => array(self::HAS_MANY, 'Usuario', 'codecf'),
			'cupomfiscals' => array(self::HAS_MANY, 'Cupomfiscal', 'codecf'),
			'codfilial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'codusuario' => array(self::BELONGS_TO, 'Usuario', 'codusuario'),
			'codusuarioalteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'codusuariocriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'ecfreducaozs' => array(self::HAS_MANY, 'Ecfreducaoz', 'codecf'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codecf' => 'Codecf',
			'ecf' => 'Ecf',
			'acbrmonitorcaminho' => 'Acbrmonitorcaminho',
			'acbrmonitorcaminhorede' => 'Acbrmonitorcaminhorede',
			'codusuario' => 'Codusuario',
			'bloqueado' => 'Bloqueado',
			'serie' => 'Serie',
			'codfilial' => 'Codfilial',
			'modelo' => 'Modelo',
			'numero' => 'Numero',
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

		$criteria->compare('codecf',$this->codecf,true);
		$criteria->compare('ecf',$this->ecf,true);
		$criteria->compare('acbrmonitorcaminho',$this->acbrmonitorcaminho,true);
		$criteria->compare('acbrmonitorcaminhorede',$this->acbrmonitorcaminhorede,true);
		$criteria->compare('codusuario',$this->codusuario,true);
		$criteria->compare('bloqueado',$this->bloqueado,true);
		$criteria->compare('serie',$this->serie,true);
		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('numero',$this->numero);
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
	 * @return Ecf the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codecf', 'ecf'),
				'order'=>'ecf ASC',
				),
			);
	}

	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codecf', 'ecf');
	}	

}
