<?php

/**
 * This is the model class for table "mgsis.tblpessoaemail".
 *
 * The followings are the available columns in table 'mgsis.tblpessoaemail':
 * @property string $codpessoaemail
 * @property string $codpessoa
 * @property integer $ordem
 * @property string $email
 * @property boolean $nfe
 * @property boolean $cobranca
 * @property string $apelido
 * @property string $verificacao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $inativo
 * @property integer $codverificacao
 *
 * The followings are the available model relations:
 * @property Pessoa $Pessoa
 * @property Usuario $UsuarioCriacao
 * @property Usuario $UsuarioAlteracao
 */
class PessoaEmail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblpessoaemail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codpessoa, email', 'required'),
			array('ordem, codverificacao', 'numerical', 'integerOnly'=>true),
			array('email, apelido', 'length', 'max'=>100),
			array('nfe, cobranca, verificacao, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codpessoaemail, codpessoa, ordem, email, nfe, cobranca, apelido, verificacao, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo, codverificacao', 'safe', 'on'=>'search'),
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
			'codpessoaemail' => 'Codpessoaemail',
			'codpessoa' => 'Codpessoa',
			'ordem' => 'Ordem',
			'email' => 'Email',
			'nfe' => 'Nfe',
			'cobranca' => 'Cobranca',
			'apelido' => 'Apelido',
			'verificacao' => 'Verificacao',
			'criacao' => 'Criacao',
			'codusuariocriacao' => 'Codusuariocriacao',
			'alteracao' => 'Alteracao',
			'codusuarioalteracao' => 'Codusuarioalteracao',
			'inativo' => 'Inativo',
			'codverificacao' => 'Codverificacao',
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

		$criteria->compare('codpessoaemail',$this->codpessoaemail,true);
		$criteria->compare('codpessoa',$this->codpessoa,true);
		$criteria->compare('ordem',$this->ordem);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('nfe',$this->nfe);
		$criteria->compare('cobranca',$this->cobranca);
		$criteria->compare('apelido',$this->apelido,true);
		$criteria->compare('verificacao',$this->verificacao,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('inativo',$this->inativo,true);
		$criteria->compare('codverificacao',$this->codverificacao);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PessoaEmail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
