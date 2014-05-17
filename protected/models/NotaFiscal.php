<?php

/**
 * This is the model class for table "mgsis.tblnotafiscal".
 *
 * The followings are the available columns in table 'mgsis.tblnotafiscal':
 * @property string $codnotafiscal
 * @property string $codnaturezaoperacao
 * @property boolean $emitida
 * @property string $nfechave
 * @property boolean $nfeimpressa
 * @property integer $serie
 * @property integer $numero
 * @property string $emissao
 * @property string $saida
 * @property string $codfilial
 * @property string $codpessoa
 * @property string $observacoes
 * @property integer $volumes
 * @property boolean $fretepagar
 * @property string $codoperacao
 * @property string $nfereciboenvio
 * @property string $nfedataenvio
 * @property string $nfeautorizacao
 * @property string $nfedataautorizacao
 * @property string $valorfrete
 * @property string $valorseguro
 * @property string $valordesconto
 * @property string $valoroutras
 * @property string $nfecancelamento
 * @property string $nfedatacancelamento
 * @property string $nfeinutilizacao
 * @property string $nfedatainutilizacao
 * @property string $justificativa
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Notafiscalprodutobarra[] $notafiscalprodutobarras
 * @property Operacao $codoperacao
 * @property Naturezaoperacao $codnaturezaoperacao
 * @property Filial $codfilial
 * @property Pessoa $codpessoa
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property Notafiscalcartacorrecao[] $notafiscalcartacorrecaos
 * @property Notafiscalduplicatas[] $notafiscalduplicatases
 */
class NotaFiscal extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnotafiscal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codnaturezaoperacao, serie, numero, emissao, saida, codfilial, codpessoa', 'required'),
			array('serie, numero, volumes', 'numerical', 'integerOnly'=>true),
			array('nfechave, nfereciboenvio, nfeautorizacao, nfecancelamento, nfeinutilizacao', 'length', 'max'=>100),
			array('observacoes', 'length', 'max'=>500),
			array('valorfrete, valorseguro, valordesconto, valoroutras', 'length', 'max'=>14),
			array('justificativa', 'length', 'max'=>200),
			array('emitida, nfeimpressa, fretepagar, codoperacao, nfedataenvio, nfedataautorizacao, nfedatacancelamento, nfedatainutilizacao, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnotafiscal, codnaturezaoperacao, emitida, nfechave, nfeimpressa, serie, numero, emissao, saida, codfilial, codpessoa, observacoes, volumes, fretepagar, codoperacao, nfereciboenvio, nfedataenvio, nfeautorizacao, nfedataautorizacao, valorfrete, valorseguro, valordesconto, valoroutras, nfecancelamento, nfedatacancelamento, nfeinutilizacao, nfedatainutilizacao, justificativa, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'NotaFiscalProdutoBarras' => array(self::HAS_MANY, 'Notafiscalprodutobarra', 'codnotafiscal'),
			'Operacao' => array(self::BELONGS_TO, 'Operacao', 'codoperacao'),
			'NaturezaOperacao' => array(self::BELONGS_TO, 'Naturezaoperacao', 'codnaturezaoperacao'),
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),			
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'NotaFiscalCartaCorrecaos' => array(self::HAS_MANY, 'Notafiscalcartacorrecao', 'codnotafiscal'),
			'NotaFiscalDuplicatass' => array(self::HAS_MANY, 'Notafiscalduplicatas', 'codnotafiscal'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codnotafiscal' => 'Codnotafiscal',
			'codnaturezaoperacao' => 'Codnaturezaoperacao',
			'emitida' => 'Emitida',
			'nfechave' => 'Nfechave',
			'nfeimpressa' => 'Nfeimpressa',
			'serie' => 'Serie',
			'numero' => 'Numero',
			'emissao' => 'Emissao',
			'saida' => 'Saida',
			'codfilial' => 'Codfilial',
			'codpessoa' => 'Codpessoa',
			'observacoes' => 'Observacoes',
			'volumes' => 'Volumes',
			'fretepagar' => 'Fretepagar',
			'codoperacao' => 'Codoperacao',
			'nfereciboenvio' => 'Nfereciboenvio',
			'nfedataenvio' => 'Nfedataenvio',
			'nfeautorizacao' => 'Nfeautorizacao',
			'nfedataautorizacao' => 'Nfedataautorizacao',
			'valorfrete' => 'Valorfrete',
			'valorseguro' => 'Valorseguro',
			'valordesconto' => 'Valordesconto',
			'valoroutras' => 'Valoroutras',
			'nfecancelamento' => 'Nfecancelamento',
			'nfedatacancelamento' => 'Nfedatacancelamento',
			'nfeinutilizacao' => 'Nfeinutilizacao',
			'nfedatainutilizacao' => 'Nfedatainutilizacao',
			'justificativa' => 'Justificativa',
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

		$criteria->compare('codnotafiscal',$this->codnotafiscal,true);
		$criteria->compare('codnaturezaoperacao',$this->codnaturezaoperacao,true);
		$criteria->compare('emitida',$this->emitida);
		$criteria->compare('nfechave',$this->nfechave,true);
		$criteria->compare('nfeimpressa',$this->nfeimpressa);
		$criteria->compare('serie',$this->serie);
		$criteria->compare('numero',$this->numero);
		$criteria->compare('emissao',$this->emissao,true);
		$criteria->compare('saida',$this->saida,true);
		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('codpessoa',$this->codpessoa,true);
		$criteria->compare('observacoes',$this->observacoes,true);
		$criteria->compare('volumes',$this->volumes);
		$criteria->compare('fretepagar',$this->fretepagar);
		$criteria->compare('codoperacao',$this->codoperacao,true);
		$criteria->compare('nfereciboenvio',$this->nfereciboenvio,true);
		$criteria->compare('nfedataenvio',$this->nfedataenvio,true);
		$criteria->compare('nfeautorizacao',$this->nfeautorizacao,true);
		$criteria->compare('nfedataautorizacao',$this->nfedataautorizacao,true);
		$criteria->compare('valorfrete',$this->valorfrete,true);
		$criteria->compare('valorseguro',$this->valorseguro,true);
		$criteria->compare('valordesconto',$this->valordesconto,true);
		$criteria->compare('valoroutras',$this->valoroutras,true);
		$criteria->compare('nfecancelamento',$this->nfecancelamento,true);
		$criteria->compare('nfedatacancelamento',$this->nfedatacancelamento,true);
		$criteria->compare('nfeinutilizacao',$this->nfeinutilizacao,true);
		$criteria->compare('nfedatainutilizacao',$this->nfedatainutilizacao,true);
		$criteria->compare('justificativa',$this->justificativa,true);
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
	 * @return NotaFiscal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
