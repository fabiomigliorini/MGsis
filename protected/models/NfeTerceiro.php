<?php

/**
 * This is the model class for table "mgsis.tblnfeterceiro".
 *
 * The followings are the available columns in table 'mgsis.tblnfeterceiro':
 * @property string $codnfeterceiro
 * @property string $nsu
 * @property string $nfechave
 * @property string $cnpj
 * @property string $ie
 * @property string $emitente
 * @property string $codpessoa
 * @property string $codfilial
 * @property string $emissao
 * @property string $nfedataautorizacao
 * @property string $codoperacao
 * @property string $valortotal
 * @property integer $indsituacao
 * @property integer $indmanifestacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Pessoa $Pessoa
 * @property Filial $Filial
 * @property Operacao $Operacao
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class NfeTerceiro extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnfeterceiro';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codfilial, emitente', 'required'),
			array('indsituacao, indmanifestacao', 'numerical', 'integerOnly'=>true),
			array('nsu, ie', 'length', 'max'=>20),
			array('nfechave, emitente', 'length', 'max'=>100),
			array('cnpj, valortotal', 'length', 'max'=>14),
			array('codpessoa, emissao, nfedataautorizacao, codoperacao, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnfeterceiro, codfilial, nsu, nfechave, cnpj, ie, emitente, codpessoa, emissao, nfedataautorizacao, codoperacao, valortotal, indsituacao, indmanifestacao, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'Operacao' => array(self::BELONGS_TO, 'Operacao', 'codoperacao'),
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
			'codnfeterceiro' => '#',
			'nsu' => 'NSU',
			'nfechave' => 'Chave',
			'cnpj' => 'Cnpj',
			'ie' => 'IE',
			'emitente' => 'Emitente',
			'codpessoa' => 'Pessoa',
			'codfilial' => 'Filial',
			'emissao' => 'Emissão',
			'nfedataautorizacao' => 'Autorização',
			'codoperacao' => 'Operação',
			'valortotal' => 'Valor Total',
			'indsituacao' => 'Situação',
			'indmanifestacao' => 'Manifestação',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuário Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuario Criação',
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

		$criteria->compare('codnfeterceiro',$this->codnfeterceiro,true);
		$criteria->compare('nsu',$this->nsu,true);
		$criteria->compare('nfechave',$this->nfechave,true);
		$criteria->compare('cnpj',$this->cnpj,true);
		$criteria->compare('ie',$this->ie,true);
		$criteria->compare('emitente',$this->emitente,true);
		$criteria->compare('codpessoa',$this->codpessoa,true);
		$criteria->compare('emissao',$this->emissao,true);
		$criteria->compare('nfedataautorizacao',$this->nfedataautorizacao,true);
		$criteria->compare('codoperacao',$this->codoperacao,true);
		$criteria->compare('valortotal',$this->valortotal,true);
		$criteria->compare('indsituacao',$this->indsituacao);
		$criteria->compare('indmanifestacao',$this->indmanifestacao);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.emissao DESC, t.valortotal asc'),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NfeTerceiro the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function beforeSave()
	{
		if (empty($this->codpessoa))
		{
			$pessoas = Pessoa::model()->findAll("cnpj = :cnpj", array(":cnpj" => $this->cnpj));
			
			foreach ($pessoas as $pessoa)
			{
				if (Yii::app()->format->numeroLimpo($this->ie) == Yii::app()->format->numeroLimpo($pessoa->ie))
					$this->codpessoa = $pessoa->codpessoa;
			}
		}
		
		return parent::beforeSave();
	}
	
	
}
