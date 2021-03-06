<?php

/**
 * This is the model class for table "mgsis.tblestoquemovimentotipo".
 *
 * The followings are the available columns in table 'mgsis.tblestoquemovimentotipo':
 * @property string $codestoquemovimentotipo
 * @property string $descricao
 * @property string $sigla
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property EstoqueMovimento[] $EstoqueMovimentos
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property NaturezaOperacao[] $NaturezaOperacaos
 */
class EstoqueMovimentoTipo extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblestoquemovimentotipo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descricao, sigla', 'required'),
			array('descricao', 'length', 'max'=>100),
			array('sigla', 'length', 'max'=>3),
			array('alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codestoquemovimentotipo, descricao, sigla, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'EstoqueMovimentos' => array(self::HAS_MANY, 'EstoqueMovimento', 'codestoquemovimentotipo'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'NaturezaOperacaos' => array(self::HAS_MANY, 'NaturezaOperacao', 'codestoquemovimentotipo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codestoquemovimentotipo' => '#',
			'descricao' => 'Descrição',
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

		$criteria->compare('codestoquemovimentotipo',$this->codestoquemovimentotipo,true);
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('sigla',$this->sigla,true);
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
	 * @return EstoqueMovimentoTipo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function scopes ()
	{
		return array(
			'combo'=>array(
				'select'=>array('codestoquemovimentotipo', 'descricao'),
				'order'=>'descricao ASC',
				),
			);
	}

	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codestoquemovimentotipo', 'descricao');
	}

}
