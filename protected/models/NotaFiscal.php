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
 * @property NotaFiscalProdutoBarra[] $NotaFiscalProdutoBarras
 * @property Operacao $Operacao
 * @property NaturezaOperacao $NaturezaOperacao
 * @property Filial $Filial
 * @property Pessoa $Pessoa
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property NotafiscalCartaCorrecao[] $NotafiscalCartaCorrecaos
 * @property NotafiscalDuplicatas[] $NotafiscalDuplicatass
 */
class NotaFiscal extends MGActiveRecord
{
	
	const CODSTATUS_NOVA = 0;
	const CODSTATUS_DIGITACAO = 1;
	const CODSTATUS_AUTORIZADA = 2;
	const CODSTATUS_LANCADA = 9;
	const CODSTATUS_NAOAUTORIZADA = 97;
	const CODSTATUS_INUTILIZADA = 98;
	const CODSTATUS_CANCELADA = 99;
	
	public $status;
	public $codstatus;
	
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
			'NotaFiscalProdutoBarras' => array(self::HAS_MANY, 'NotaFiscalProdutoBarra', 'codnotafiscal'),
			'Operacao' => array(self::BELONGS_TO, 'Operacao', 'codoperacao'),
			'NaturezaOperacao' => array(self::BELONGS_TO, 'NaturezaOperacao', 'codnaturezaoperacao'),
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),			
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'NotaFiscalCartaCorrecaos' => array(self::HAS_MANY, 'NotaFiscalCartaCorrecao', 'codnotafiscal'),
			'NotaFiscalDuplicatass' => array(self::HAS_MANY, 'NotaFiscalDuplicatas', 'codnotafiscal'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codnotafiscal' => '#',
			'codnaturezaoperacao' => 'Natureza Operação',
			'emitida' => 'Emitida',
			'nfechave' => 'Nfe Chave',
			'nfeimpressa' => 'Nfe Impressa',
			'serie' => 'Série',
			'numero' => 'Número',
			'emissao' => 'Emissão',
			'saida' => 'Saida',
			'codfilial' => 'Filial',
			'codpessoa' => 'Pessoa',
			'observacoes' => 'Observações',
			'volumes' => 'Volumes',
			'fretepagar' => 'Frete à Pagar',
			'codoperacao' => 'Operação',
			'nfereciboenvio' => 'Nfe Recibo do Envio',
			'nfedataenvio' => 'Nfe Data Envio',
			'nfeautorizacao' => 'Nfe Autorização',
			'nfedataautorizacao' => 'Nfe Data Autorização',
			'valorfrete' => 'Valor do Frete',
			'valorseguro' => 'Valor do Seguro',
			'valordesconto' => 'Valor do Desconto',
			'valoroutras' => 'Valor de Outras',
			'nfecancelamento' => 'Nfe cancelamento',
			'nfedatacancelamento' => 'Nfe Data do Cancelamento',
			'nfeinutilizacao' => 'Nfe Inutilização',
			'nfedatainutilizacao' => 'Nfe Data da Inutilização',
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
	
	function calculaCodStatus()
	{

		if ($this->isNewRecord)
		{
			$this->codstatus = self::CODSTATUS_NOVA;
			return $this->codstatus;
		}
		
		if (!empty($this->nfeinutilizacao))
		{
			$this->codstatus = self::CODSTATUS_INUTILIZADA;
			return $this->codstatus;
		}
		
		if (!empty($this->nfecancelamento))
		{
			$this->codstatus = self::CODSTATUS_CANCELADA;
			return $this->codstatus;
		}
		
		if ($this->emitida)
		{
			if (empty($this->nfechave))
			{
				$this->codstatus = self::CODSTATUS_DIGITACAO;
				return $this->codstatus;
			}
			
			if (!empty($this->nfeautorizacao))
			{
				$this->codstatus = self::CODSTATUS_AUTORIZADA;
				return $this->codstatus;
			}

			$this->codstatus = self::CODSTATUS_NAOAUTORIZADA;
			return $this->codstatus;
		}
		
		$this->codstatus = self::CODSTATUS_LANCADA;
		return $this->codstatus;
		
	}
	
	function calculaStatus()
	{
		$codstatus = $this->calculaCodStatus();
		$opcoes = $this->listagemStatus();
		$this->status = $opcoes[$codstatus];
	}
	
	function listagemStatus()
	{
		return array(
			self::CODSTATUS_NOVA => "Nova",
			self::CODSTATUS_DIGITACAO => "Em Digitação",
			self::CODSTATUS_AUTORIZADA => "Autorizada",
			self::CODSTATUS_LANCADA => "Lançada",
			self::CODSTATUS_NAOAUTORIZADA => "Não Autorizada",
			self::CODSTATUS_INUTILIZADA => "Inutilizada",
			self::CODSTATUS_CANCELADA => "Cancelada"
		);
	}
	
	protected function afterFind()
	{
		
		$this->calculaStatus();
		return parent::afterFind();
	}		

}
