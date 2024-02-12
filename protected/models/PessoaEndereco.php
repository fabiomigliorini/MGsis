<?php

/**
 * This is the model class for table "mgsis.tblpessoaendereco".
 *
 * The followings are the available columns in table 'mgsis.tblpessoaendereco':
 * @property string $codpessoaendereco
 * @property string $codpessoa
 * @property integer $ordem
 * @property boolean $nfe
 * @property boolean $entrega
 * @property boolean $cobranca
 * @property string $cep
 * @property string $endereco
 * @property string $numero
 * @property string $complemento
 * @property string $bairro
 * @property string $codcidade
 * @property string $apelido
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $inativo
 *
 * The followings are the available model relations:
 * @property Cidade $Cidade
 * @property Pessoa $Pessoa
 * @property Usuario $UsuarioCriacao
 * @property Usuario $UsuarioAlteracao
 */
class PessoaEndereco extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblpessoaendereco';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codpessoa', 'required'),
			array('ordem', 'numerical', 'integerOnly'=>true),
			array('cep', 'length', 'max'=>8),
			array('endereco, apelido', 'length', 'max'=>100),
			array('numero', 'length', 'max'=>10),
			array('complemento, bairro', 'length', 'max'=>50),
			array('nfe, entrega, cobranca, codcidade, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codpessoaendereco, codpessoa, ordem, nfe, entrega, cobranca, cep, endereco, numero, complemento, bairro, codcidade, apelido, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo', 'safe', 'on'=>'search'),
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
			'Cidade' => array(self::BELONGS_TO, 'Cidade', 'codcidade'),
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
			'codpessoaendereco' => 'Codpessoaendereco',
			'codpessoa' => 'Codpessoa',
			'ordem' => 'Ordem',
			'nfe' => 'Nfe',
			'entrega' => 'Entrega',
			'cobranca' => 'Cobranca',
			'cep' => 'Cep',
			'endereco' => 'Endereco',
			'numero' => 'Numero',
			'complemento' => 'Complemento',
			'bairro' => 'Bairro',
			'codcidade' => 'Codcidade',
			'apelido' => 'Apelido',
			'criacao' => 'Criacao',
			'codusuariocriacao' => 'Codusuariocriacao',
			'alteracao' => 'Alteracao',
			'codusuarioalteracao' => 'Codusuarioalteracao',
			'inativo' => 'Inativo',
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

		$criteria->compare('codpessoaendereco',$this->codpessoaendereco,true);
		$criteria->compare('codpessoa',$this->codpessoa,true);
		$criteria->compare('ordem',$this->ordem);
		$criteria->compare('nfe',$this->nfe);
		$criteria->compare('entrega',$this->entrega);
		$criteria->compare('cobranca',$this->cobranca);
		$criteria->compare('cep',$this->cep,true);
		$criteria->compare('endereco',$this->endereco,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('complemento',$this->complemento,true);
		$criteria->compare('bairro',$this->bairro,true);
		$criteria->compare('codcidade',$this->codcidade,true);
		$criteria->compare('apelido',$this->apelido,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('inativo',$this->inativo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PessoaEndereco the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
