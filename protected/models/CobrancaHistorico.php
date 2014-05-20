<?php

/**
 * This is the model class for table "mgsis.tblcobrancahistorico".
 *
 * The followings are the available columns in table 'mgsis.tblcobrancahistorico':
 * @property string $codcobrancahistorico
 * @property string $codpessoa
 * @property string $codusuario
 * @property string $sistema
 * @property string $historico
 * @property boolean $emailautomatico
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Pessoa $Pessoa
 * @property Usuario $Usuario
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property CobrancaHistoricoTitulo[] $CobrancaHistoricoTitulos
 */
class CobrancaHistorico extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblcobrancahistorico';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codcobrancahistorico, codpessoa, codusuario, sistema, historico', 'required'),
			array('historico', 'length', 'max'=>255),
			array('emailautomatico, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codcobrancahistorico, codpessoa, codusuario, sistema, historico, emailautomatico, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Usuario' => array(self::BELONGS_TO, 'Usuario', 'codusuario'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'CobrancaHistoricoTitulos' => array(self::HAS_MANY, 'CobrancaHistoricoTitulo', 'codcobrancahistorico'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codcobrancahistorico' => '#',
			'codpessoa' => 'Pessoa',
			'codusuario' => 'Usuário',
			'sistema' => 'Sistema',
			'historico' => 'Histórico',
			'emailautomatico' => 'Email Automatico',
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

		$criteria->compare('codcobrancahistorico',$this->codcobrancahistorico,true);
		$criteria->compare('codpessoa',$this->codpessoa,true);
		$criteria->compare('codusuario',$this->codusuario,true);
		$criteria->compare('sistema',$this->sistema,true);
		$criteria->compare('historico',$this->historico,true);
		$criteria->compare('emailautomatico',$this->emailautomatico);
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
	 * @return CobrancaHistorico the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
