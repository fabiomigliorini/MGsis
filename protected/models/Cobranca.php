<?php

/**
 * This is the model class for table "mgsis.tblcobranca".
 *
 * The followings are the available columns in table 'mgsis.tblcobranca':
 * @property string $codcobranca
 * @property string $codtitulo
 * @property string $codcheque
 * @property string $agendamento
 * @property string $posicao
 * @property string $codportador
 * @property string $reagendamento
 * @property string $observacoes
 * @property string $debitoacerto
 * @property string $creditoacerto
 * @property boolean $acertado
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property MovimentoTitulo[] $MovimentoTitulos
 * @property Cheque $Cheque
 * @property Portador $Portador
 * @property Titulo $Titulo
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class Cobranca extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblcobranca';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codcobranca, agendamento, codportador', 'required'),
			array('posicao, observacoes', 'length', 'max'=>500),
			array('debitoacerto, creditoacerto', 'length', 'max'=>14),
			array('codtitulo, codcheque, reagendamento, acertado, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codcobranca, codtitulo, codcheque, agendamento, posicao, codportador, reagendamento, observacoes, debitoacerto, creditoacerto, acertado, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'MovimentoTitulos' => array(self::HAS_MANY, 'Movimentotitulo', 'codcobranca'),
			'Cheque' => array(self::BELONGS_TO, 'Cheque', 'codcheque'),
			'Portador' => array(self::BELONGS_TO, 'Portador', 'codportador'),
			'Titulo' => array(self::BELONGS_TO, 'Titulo', 'codtitulo'),
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
			'codcobranca' => 'Codcobranca',
			'codtitulo' => 'Codtitulo',
			'codcheque' => 'Codcheque',
			'agendamento' => 'Agendamento',
			'posicao' => 'Posicao',
			'codportador' => 'Codportador',
			'reagendamento' => 'Reagendamento',
			'observacoes' => 'Observacoes',
			'debitoacerto' => 'Debitoacerto',
			'creditoacerto' => 'Creditoacerto',
			'acertado' => 'Acertado',
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

		$criteria->compare('codcobranca',$this->codcobranca,true);
		$criteria->compare('codtitulo',$this->codtitulo,true);
		$criteria->compare('codcheque',$this->codcheque,true);
		$criteria->compare('agendamento',$this->agendamento,true);
		$criteria->compare('posicao',$this->posicao,true);
		$criteria->compare('codportador',$this->codportador,true);
		$criteria->compare('reagendamento',$this->reagendamento,true);
		$criteria->compare('observacoes',$this->observacoes,true);
		$criteria->compare('debitoacerto',$this->debitoacerto,true);
		$criteria->compare('creditoacerto',$this->creditoacerto,true);
		$criteria->compare('acertado',$this->acertado);
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
	 * @return Cobranca the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
