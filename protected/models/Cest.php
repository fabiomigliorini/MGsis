<?php

/**
 * This is the model class for table "mgsis.tblcest".
 *
 * The followings are the available columns in table 'mgsis.tblcest':
 * @property bigserial $codcest
 * @property bigint $codncm
 * @property string $cest
 * @property string $ncm
 * @property string $descricao
 * @property timestamp $alteracao
 * @property bigint $codusuarioalteracao
 * @property timestamp $criacao
 * @property bigint $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Ncm $Ncm
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property Produto[] $Produtos
 */
class Cest extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblcest';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cest, ncm, descricao, codncm', 'required'),
			array('cest', 'length', 'max'=>7),
			array('ncm', 'length', 'max'=>8),
			array('descricao', 'length', 'max'=>600),
			array('alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codcest, cest, ncm, descricao, alteracao, codusuarioalteracao, criacao, codusuariocriacao, codncm', 'safe', 'on'=>'search'),
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
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'Ncm' => array(self::BELONGS_TO, 'Ncm', 'codncm'),
			'Produtos' => array(self::HAS_MANY, 'Produto', 'codproduto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codcest' => '#',
			'cest' => 'Cest',
			'codncm' => 'NCM',
			'ncm' => 'NCM',
			'descricao' => 'Descrição',
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

		$criteria->compare('codcest',$this->codcest,true);
		$criteria->compare('cest',$this->cest,true);
		$criteria->compare('ncm',$this->ncm,true);
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		$criteria->compare('codncm',$this->codncm,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
