<?php

/**
 * This is the model class for table "mgsis.tblnegocio".
 *
 * The followings are the available columns in table 'mgsis.tblnegocio':
 * @property string $codnegocio
 * @property string $codpessoa
 * @property string $codfilial
 * @property string $lancamento
 * @property string $codpessoavendedor
 * @property string $codoperacao
 * @property string $codnegociostatus
 * @property string $observacoes
 * @property string $codusuario
 * @property string $valordesconto
 * @property boolean $entrega
 * @property string $acertoentrega
 * @property string $codusuarioacertoentrega
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $codnaturezaoperacao
 * @property string $valorprodutos
 * @property string $valortotal
 * @property string $valoraprazo
 * @property string $valoravista
 *
 * The followings are the available model relations:
 * @property Filial $codfilial
 * @property Negociostatus $codnegociostatus
 * @property Operacao $codoperacao
 * @property Pessoa $codpessoa
 * @property Pessoa $codpessoavendedor
 * @property Usuario $codusuario
 * @property Usuario $codusuarioacertoentrega
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 * @property Naturezaoperacao $codnaturezaoperacao
 * @property Negocioformapagamento[] $negocioformapagamentos
 * @property Negocioprodutobarra[] $negocioprodutobarras
 */
class Negocio extends MGActiveRecord
{
	public $lancamento_de;
	public $lancamento_ate;
	public $horario_de;
	public $horario_ate;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnegocio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codnegocio, codfilial, lancamento, codoperacao, codnegociostatus, codusuario, codnaturezaoperacao', 'required'),
			array('observacoes', 'length', 'max'=>500),
			array('valordesconto, valorprodutos, valortotal, valoraprazo, valoravista', 'length', 'max'=>14),
			array('codpessoa, codpessoavendedor, entrega, acertoentrega, codusuarioacertoentrega, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('horario_de, horario_ate, lancamento_de, lancamento_ate, codnegocio, codpessoa, codfilial, lancamento, codpessoavendedor, codoperacao, codnegociostatus, observacoes, codusuario, valordesconto, entrega, acertoentrega, codusuarioacertoentrega, alteracao, codusuarioalteracao, criacao, codusuariocriacao, codnaturezaoperacao, valorprodutos, valortotal, valoraprazo, valoravista', 'safe', 'on'=>'search'),
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
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'NegocioStatus' => array(self::BELONGS_TO, 'NegocioStatus', 'codnegociostatus'),
			'Operacao' => array(self::BELONGS_TO, 'Operacao', 'codoperacao'),
			'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
			'Vendedor' => array(self::BELONGS_TO, 'Pessoa', 'codpessoavendedor'),
			'Usuario' => array(self::BELONGS_TO, 'Usuario', 'codusuario'),
			'UsuarioAcertoEntrega' => array(self::BELONGS_TO, 'Usuario', 'codusuarioacertoentrega'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'NaturezaOperacao' => array(self::BELONGS_TO, 'NaturezaOperacao', 'codnaturezaoperacao'),
			'NegocioFormaPagamentos' => array(self::HAS_MANY, 'NegocioFormaPagamento', 'codnegocio'),
			'NegocioProdutoBarras' => array(self::HAS_MANY, 'NegocioProdutoBarra', 'codnegocio', 'order'=>'alteracao DESC, codnegocioprodutobarra DESC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codnegocio' => '#',
			'codpessoa' => 'Pessoa',
			'codfilial' => 'Filial',
			'lancamento' => 'Lançamento',
			'codpessoavendedor' => 'Vendedor',
			'codoperacao' => 'Operação',
			'codnegociostatus' => 'Status',
			'observacoes' => 'Observações',
			'codusuario' => 'Usuário',
			'valordesconto' => 'Desconto',
			'entrega' => 'Entrega',
			'acertoentrega' => 'Acerto Entrega',
			'codusuarioacertoentrega' => 'Usuário Acerto Entrega',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuário Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuário Criação',
			'codnaturezaoperacao' => 'Natureza de Operação',
			'valorprodutos' => 'Produtos',
			'valortotal' => 'Total',
			'valoraprazo' => 'À Prazo',
			'valoravista' => 'À Vista',
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

		$criteria->compare('codnegocio',$this->codnegocio,false);
		$criteria->compare('codpessoa',$this->codpessoa,false);
		$criteria->compare('codfilial',$this->codfilial,false);
		$criteria->compare('lancamento',$this->lancamento,true);
		$criteria->compare('codpessoavendedor',$this->codpessoavendedor,false);
		$criteria->compare('codoperacao',$this->codoperacao,false);
		$criteria->compare('codnegociostatus',$this->codnegociostatus,false);
		$criteria->compare('observacoes',$this->observacoes,true);
		$criteria->compare('codusuario',$this->codusuario,false);
		$criteria->compare('valordesconto',$this->valordesconto,true);
		$criteria->compare('entrega',$this->entrega);
		$criteria->compare('acertoentrega',$this->acertoentrega,true);
		$criteria->compare('codusuarioacertoentrega',$this->codusuarioacertoentrega,false);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);
		$criteria->compare('codnaturezaoperacao',$this->codnaturezaoperacao,false);
		$criteria->compare('valorprodutos',$this->valorprodutos,true);
		$criteria->compare('valortotal',$this->valortotal,true);
		$criteria->compare('valoraprazo',$this->valoraprazo,true);
		$criteria->compare('valoravista',$this->valoravista,true);
		
		if ($lancamento_de = DateTime::createFromFormat("d/m/y H:i",$this->lancamento_de . " " . $this->horario_de))
		{
			$criteria->addCondition('t.lancamento >= :lancamento_de');
			$criteria->params = array_merge($criteria->params, array(':lancamento_de' => $lancamento_de->format('Y-m-d H:i').':00.0'));
		}
		if ($lancamento_ate = DateTime::createFromFormat("d/m/y H:i",$this->lancamento_ate  . " " . $this->horario_ate))
		{
			$criteria->addCondition('t.lancamento <= :lancamento_ate');
			$criteria->params = array_merge($criteria->params, array(':lancamento_ate' => $lancamento_ate->format('Y-m-d H:i').':59.9'));
		}
		
		/*
		echo "<pre>";
		print_r($criteria);
		echo "</pre>";
		*/
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.lancamento DESC, t.codnegocio DESC'),
			'pagination'=>array('pageSize'=>20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Negocio the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}
