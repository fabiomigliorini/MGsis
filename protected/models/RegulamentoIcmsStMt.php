<?php

/**
 * This is the model class for table "mgsis.tblregulamentoicmsstmt".
 *
 * The followings are the available columns in table 'mgsis.tblregulamentoicmsstmt':
 * @property bigserial $codregulamentoicmsstmt
 * @property bigint $codncm
 * @property string $subitem
 * @property string $descricao
 * @property string $ncm
 * @property string $ncmexceto
 * @property double $icmsstsul
 * @property double $icmsstnorte
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property Ncm $Ncm
 */
class RegulamentoIcmsStMt extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblregulamentoicmsstmt';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subitem, descricao, ncm', 'required'),
			array('subitem', 'length', 'max'=>10),
			array('descricao', 'length', 'max'=>600),
			array('ncm', 'length', 'max'=>8),
			array('ncmexceto', 'length', 'max'=>100),
			array('icmsstsul', 'length', 'max'=>4),
			array('icmsstnorte', 'length', 'max'=>14),
			array('alteracao, codusuarioalteracao, criacao, codusuariocriacao, codncm', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codregulamentoicmsstmt, subitem, descricao, ncm, ncmexceto, icmsstsul, icmsstnorte, alteracao, codusuarioalteracao, criacao, codusuariocriacao, codncm', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codregulamentoicmsstmt' => '#',
			'subitem' => 'Subitem',
			'descricao' => 'Descrição',
			'codncm' => 'NCM',
			'ncm' => 'NCM',
			'ncmexceto' => 'Ncm Exceto',
			'icmsstsul' => 'ICMS ST Sul',
			'icmsstnorte' => 'ICMS ST Norte',
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

		$criteria->compare('codregulamentoicmsstmt',$this->codregulamentoicmsstmt,true);
		$criteria->compare('subitem',$this->subitem,true);
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('ncm',$this->ncm,true);
		$criteria->compare('ncmexceto',$this->ncmexceto,true);
		$criteria->compare('icmsstsul',$this->icmsstsul,true);
		$criteria->compare('icmsstnorte',$this->icmsstnorte,true);
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
	 * @return RegulamentoIcmsStMt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
