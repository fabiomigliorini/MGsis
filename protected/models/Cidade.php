<?php

/**
 * This is the model class for table "mgsis.tblcidade".
 *
 * The followings are the available columns in table 'mgsis.tblcidade':
 * @property string $codcidade
 * @property string $codestado
 * @property string $cidade
 * @property string $sigla
 * @property string $codigooficial
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Pessoa[] $Pessoas
 * @property Pessoa[] $PessoaCobrancas
 * @property Estado $Estado
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class Cidade extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblcidade';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cidade, codigooficial', 'required'),
			array('cidade', 'length', 'max'=>50),
			array('sigla', 'length', 'max'=>3),
			array('codestado, codigooficial, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codcidade, codestado, cidade, sigla, codigooficial, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Pessoas' => array(self::HAS_MANY, 'Pessoa', 'codcidade'),
			'PessoaCobrancas' => array(self::HAS_MANY, 'Pessoa', 'codcidadecobranca'),
			'Estado' => array(self::BELONGS_TO, 'Estado', 'codestado'),
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
			'codcidade' => '#',
			'codestado' => 'Estado',
			'cidade' => 'Cidade',
			'sigla' => 'Sigla',
			'codigooficial' => 'Código Oficial',
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

		$criteria->compare('codcidade',Yii::app()->format->numeroLimpo($this->codcidade),false);
		$criteria->compare('codestado',$this->codestado,false);
		if (!empty($this->cidade))
		{
			$texto  = str_replace(' ', '%', trim($this->cidade));
			$criteria->addCondition('t.cidade ILIKE :cidade');
			$criteria->params = array_merge($criteria->params, array(':cidade' => '%'.$texto.'%'));
		}
		//$criteria->compare('cidade',$this->cidade,false);
		$criteria->compare('sigla',$this->sigla,false);
		$criteria->compare('codigooficial',$this->codigooficial,false);
		$criteria->compare('alteracao',$this->alteracao,false);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('criacao',$this->criacao,false);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.cidade ASC'),
			'pagination'=>array('pageSize'=>20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cidade the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codcidade', 'cidade'),
				'order'=>'cidade ASC',
				),
			);
	}
	
	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codcidade', 'cidade');
	}
}
