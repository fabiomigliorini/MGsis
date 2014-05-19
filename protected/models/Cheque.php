<?php

/**
 * This is the model class for table "mgsis.tblcheque".
 *
 * The followings are the available columns in table 'mgsis.tblcheque':
 * @property string $codcheque
 * @property string $cmc7
 * @property string $codbanco
 * @property string $agencia
 * @property string $contacorrente
 * @property string $emitente
 * @property string $numero
 * @property string $emissao
 * @property string $vencimento
 * @property string $repasse
 * @property string $destino
 * @property string $devolucao
 * @property string $motivodevolucao
 * @property string $observacao
 * @property string $lancamento
 * @property string $alteracao
 * @property string $cancelamento
 * @property string $valor
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Cobranca[] $cobrancas
 * @property Chequeemitente[] $chequeemitentes
 * @property Banco $codbanco
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 */
class Cheque extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblcheque';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codcheque, codbanco, agencia, contacorrente, emitente, numero, emissao, vencimento, lancamento, valor', 'required'),
			array('cmc7, destino, motivodevolucao', 'length', 'max'=>50),
			array('agencia', 'length', 'max'=>10),
			array('contacorrente, numero', 'length', 'max'=>15),
			array('emitente', 'length', 'max'=>100),
			array('observacao', 'length', 'max'=>200),
			array('valor', 'length', 'max'=>14),
			array('repasse, devolucao, alteracao, cancelamento, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codcheque, cmc7, codbanco, agencia, contacorrente, emitente, numero, emissao, vencimento, repasse, destino, devolucao, motivodevolucao, observacao, lancamento, alteracao, cancelamento, valor, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'cobrancas' => array(self::HAS_MANY, 'Cobranca', 'codcheque'),
			'chequeemitentes' => array(self::HAS_MANY, 'Chequeemitente', 'codcheque'),
			'codbanco' => array(self::BELONGS_TO, 'Banco', 'codbanco'),
			'codusuarioalteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'codusuariocriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codcheque' => 'Codcheque',
			'cmc7' => 'Cmc7',
			'codbanco' => 'Codbanco',
			'agencia' => 'Agencia',
			'contacorrente' => 'Contacorrente',
			'emitente' => 'Emitente',
			'numero' => 'Numero',
			'emissao' => 'Emissao',
			'vencimento' => 'Vencimento',
			'repasse' => 'Repasse',
			'destino' => 'Destino',
			'devolucao' => 'Devolucao',
			'motivodevolucao' => 'Motivodevolucao',
			'observacao' => 'Observacao',
			'lancamento' => 'Lancamento',
			'alteracao' => 'Alteracao',
			'cancelamento' => 'Cancelamento',
			'valor' => 'Valor',
			'codusuarioalteracao' => 'Codusuarioalteracao',
			'criacao' => 'Criacao',
			'codusuariocriacao' => 'Codusuariocriacao',
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

		$criteria->compare('codcheque',$this->codcheque,true);
		$criteria->compare('cmc7',$this->cmc7,true);
		$criteria->compare('codbanco',$this->codbanco,true);
		$criteria->compare('agencia',$this->agencia,true);
		$criteria->compare('contacorrente',$this->contacorrente,true);
		$criteria->compare('emitente',$this->emitente,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('emissao',$this->emissao,true);
		$criteria->compare('vencimento',$this->vencimento,true);
		$criteria->compare('repasse',$this->repasse,true);
		$criteria->compare('destino',$this->destino,true);
		$criteria->compare('devolucao',$this->devolucao,true);
		$criteria->compare('motivodevolucao',$this->motivodevolucao,true);
		$criteria->compare('observacao',$this->observacao,true);
		$criteria->compare('lancamento',$this->lancamento,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('cancelamento',$this->cancelamento,true);
		$criteria->compare('valor',$this->valor,true);
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
	 * @return Cheque the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
