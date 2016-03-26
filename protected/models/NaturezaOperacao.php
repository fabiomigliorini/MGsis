<?php

/**
 * This is the model class for table "mgsis.tblnaturezaoperacao".
 *
 * The followings are the available columns in table 'mgsis.tblnaturezaoperacao':
 * @property string $codnaturezaoperacao
 * @property string $naturezaoperacao
 * @property string $codoperacao
 * @property string $finnfe
 * @property boolean $emitida
 * @property string $observacoesnf
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $mensagemprocom
 * @property string $codnaturezaoperacaodevolucao
 * @property string $codtipotitulo
 * @property string $codcontacontabil
 * @property boolean $financeiro Natureza gera movimento financeiro ou nao
 * @property boolean $ibpt
 * 
 * The followings are the available model relations:
 * @property Negocio[] $Negocios
 * @property TributacaoNaturezaOperacao[] $TributacaoNaturezaOperacaos
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property NaturezaOperacao $NaturezaOperacaoDevolucao
 * @property NaturezaOperacao[] $NaturezaOperacaoDevolucaos
 * @property Operacao $Operacao
 * @property TipoTitulo $TipoTitulo
 * @property ContaContabil $ContaContabil
 */
class NaturezaOperacao extends MGActiveRecord
{
	const VENDA = 1;
    const DEVOLUCAO_VENDA = 2;
	
	const FINNFE_NORMAL = 1;
	const FINNFE_COMPLEMENTAR = 2;
	const FINNFE_AJUSTE = 3;
	const FINNFE_DEVOLUCAO_RETORNO = 4;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnaturezaoperacao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('naturezaoperacao, codtipotitulo, codcontacontabil, finnfe', 'required'),
			array('naturezaoperacao', 'length', 'max'=>50),
			array('observacoesnf', 'length', 'max'=>500),
			array('mensagemprocom', 'length', 'max'=>300),
			array('ibpt, codoperacao, emitida, alteracao, codusuarioalteracao, criacao, codusuariocriacao, codnaturezaoperacaodevolucao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnaturezaoperacao, codtipotitulo, naturezaoperacao, codoperacao, emitida, observacoesnf, alteracao, codusuarioalteracao, criacao, codusuariocriacao, mensagemprocom, codnaturezaoperacaodevolucao', 'safe', 'on'=>'search'),
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
			'Negocios' => array(self::HAS_MANY, 'Negocio', 'codnaturezaoperacao'),
			'NaturezaOperacaoDevolucaos' => array(self::HAS_MANY, 'NaturezaOperacao', 'codnaturezaoperacaodevolucao'),
			'NaturezaOperacaoDevolucao' => array(self::BELONGS_TO, 'NaturezaOperacao', 'codnaturezaoperacaodevolucao'),
			'TributacaoNaturezaOperacaos' => array(self::HAS_MANY, 'TributacaoNaturezaOperacao', 'codnaturezaoperacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'Operacao' => array(self::BELONGS_TO, 'Operacao', 'codoperacao'),
			'TipoTitulo' => array(self::BELONGS_TO, 'TipoTitulo', 'codtipotitulo'),
			'ContaContabil' => array(self::BELONGS_TO, 'ContaContabil', 'codcontacontabil'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codnaturezaoperacao' => '#',
			'naturezaoperacao' => 'Natureza de Operação',
			'codoperacao' => 'Operação',
			'emitida' => 'Nossa Emissão',
			'observacoesnf' => 'Observações NF',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuário Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuário Criação',
			'mensagemprocom' => 'Mensagem Procom',
			'ibpt' => 'Calcular Tributos com base no IBPT',
			'codnaturezaoperacaodevolucao' => 'Natureza de Devolução',
			'codtipotitulo' => 'Tipo Titulo',
			'codcontacontabil' => 'Conta Contábil',
			'finnfe' => 'Finalidade NFe',
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

		$criteria->compare('codnaturezaoperacao',Yii::app()->format->numeroLimpo($this->codnaturezaoperacao),false);
		//$criteria->compare('naturezaoperacao',$this->naturezaoperacao,false);
		if (!empty($this->naturezaoperacao))
		{
			$texto  = str_replace(' ', '%', trim($this->naturezaoperacao));
			$criteria->addCondition('t.naturezaoperacao ILIKE :naturezaoperacao');
			$criteria->params = array_merge($criteria->params, array(':naturezaoperacao' => '%'.$texto.'%'));
		}
		$criteria->compare('codoperacao',$this->codoperacao,false);
		$criteria->compare('emitida',$this->emitida);
		$criteria->compare('observacoesnf',$this->observacoesnf,false);
		$criteria->compare('alteracao',$this->alteracao,false);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('criacao',$this->criacao,false);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);
		$criteria->compare('codnaturezaoperacaodevolucao',$this->codnaturezaoperacaodevolucao,false);
		$criteria->compare('codtipotitulo',$this->codtipotitulo,false);
		$criteria->compare('codcontacontabil',$this->codcontacontabil,false);
		$criteria->compare('finnfe',$this->finnfe,false);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.codnaturezaoperacao ASC'),
			'pagination'=>array('pageSize'=>20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NaturezaOperacao the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codnaturezaoperacao', 'naturezaoperacao'),
				'order'=>'t.codoperacao ASC, t.naturezaoperacao ASC',
				),
			);
	}
	
	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codnaturezaoperacao', 'naturezaoperacao');
	}	

	function getFinNfeListaCombo()
	{
		return array(
			self::FINNFE_NORMAL => self::FINNFE_NORMAL . " - Normal",
			self::FINNFE_COMPLEMENTAR => self::FINNFE_COMPLEMENTAR . " - Complementar",
			self::FINNFE_AJUSTE => self::FINNFE_AJUSTE . " - Ajuste",
			self::FINNFE_DEVOLUCAO_RETORNO => self::FINNFE_DEVOLUCAO_RETORNO . " - Devolução / Retorno",
		);
	}

}
