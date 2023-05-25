<?php

/**
 * This is the model class for table "mgsis.tblpessoacertidao".
 *
 * The followings are the available columns in table 'mgsis.tblpessoacertidao':
 * @property string $codpessoacertidao
 * @property string $codpessoa
 * @property string $codcertidaoemissor
 * @property string $numero
 * @property string $autenticacao
 * @property string $validade
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $inativo
 * @property string $codcertidaotipo
 *
 * The followings are the available model relations:
 * @property Pessoa $Pessoa
 * @property CertidaoEmissor $CertidaoEmissor
 * @property CertidaoTipo $CertidaoTipo
 */
class PessoaCertidao extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblpessoacertidao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codpessoa, codcertidaoemissor, numero, validade, codcertidaotipo', 'required'),
			array('numero, autenticacao', 'length', 'max'=>20),
			array('criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codpessoacertidao, codpessoa, codcertidaoemissor, numero, autenticacao, validade, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo, codcertidaotipo', 'safe', 'on'=>'search'),
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
			'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
			'CertidaoEmissor' => array(self::BELONGS_TO, 'CertidaoEmissor', 'codcertidaoemissor'),
			'CertidaoTipo' => array(self::BELONGS_TO, 'CertidaoTipo', 'codcertidaotipo'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codpessoacertidao' => '#',
			'codpessoa' => 'Pessoa',
			'codcertidaoemissor' => 'Emissor',
			'numero' => 'Número',
			'autenticacao' => 'Autenticação',
			'validade' => 'Validade',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuário Criação',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuário Alteração',
			'inativo' => 'Inativo',
			'codcertidaotipo' => 'Tipo',
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

		$criteria->compare('codpessoacertidao',$this->codpessoacertidao,true);
		$criteria->compare('codpessoa',$this->codpessoa);
		$criteria->compare('codcertidaoemissor',$this->codcertidaoemissor,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('autenticacao',$this->autenticacao,true);
		$criteria->compare('validade',$this->validade,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('inativo',$this->inativo,true);
		$criteria->compare('codcertidaotipo',$this->codcertidaotipo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.validade DESC'),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PessoaCertidao the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
