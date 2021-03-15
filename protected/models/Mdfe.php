<?php

/**
 * This is the model class for table "mgsis.tblmdfe".
 *
 * The followings are the available columns in table 'mgsis.tblmdfe':
 * @property string $codmdfe
 * @property string $codmdfestatus
 * @property string $codfilial
 * @property integer $tipoemitente
 * @property integer $tipotransportador
 * @property integer $modelo
 * @property integer $serie
 * @property integer $numero
 * @property string $chmdfe
 * @property integer $modal
 * @property string $emissao
 * @property string $inicioviagem
 * @property integer $tipoemissao
 * @property string $codcidadecarregamento
 * @property string $codestadofim
 * @property string $informacoesadicionais
 * @property string $informacoescomplementares
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $inativo
 * @property string $protocoloautorizacao
 * @property string $protocolocancelamento
 * @property string $encerramento
 * @property string $justificativa
 *
 * The followings are the available model relations:
 * @property Mdfeveiculo[] $mdfeveiculos
 * @property Mdfeestado[] $mdfeestados
 * @property Mdfeenviosefaz[] $mdfeenviosefazs
 * @property Mdfenfe[] $mdfenves
 * @property Cidade $codcidadecarregamento
 * @property Estado $codestadofim
 * @property Filial $codfilial
 * @property Mdfestatus $codmdfestatus
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 */
class Mdfe extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblmdfe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codmdfestatus, codfilial, tipoemitente, serie, emissao, tipoemissao, codcidadecarregamento, codestadofim', 'required'),
			array('tipoemitente, tipotransportador, modelo, serie, numero, modal, tipoemissao', 'numerical', 'integerOnly'=>true),
			array('chmdfe', 'length', 'max'=>44),
			array('informacoesadicionais', 'length', 'max'=>2000),
			array('informacoescomplementares', 'length', 'max'=>5000),
			array('justificativa', 'length', 'max'=>100),
			array('inicioviagem, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo, protocoloautorizacao, protocolocancelamento, encerramento', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codmdfe, codmdfestatus, codfilial, tipoemitente, tipotransportador, modelo, serie, numero, chmdfe, modal, emissao, inicioviagem, tipoemissao, codcidadecarregamento, codestadofim, informacoesadicionais, informacoescomplementares, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo, protocoloautorizacao, protocolocancelamento, encerramento, justificativa', 'safe', 'on'=>'search'),
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
			'MdfeVeiculos' => array(self::HAS_MANY, 'MdfeVeiculo', 'codmdfe'),
			'MdfeEstados' => array(self::HAS_MANY, 'MdfeEstado', 'codmdfe'),
			'MdfeEnvioSefazs' => array(self::HAS_MANY, 'MdfeEnvioSefaz', 'codmdfe'),
			'MdfeNfes' => array(self::HAS_MANY, 'MdfeNfe', 'codmdfe'),
			'CidadeCarregamento' => array(self::BELONGS_TO, 'Cidade', 'codcidadecarregamento'),
			'EstadoFim' => array(self::BELONGS_TO, 'Estado', 'codestadofim'),
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'MdfeStatus' => array(self::BELONGS_TO, 'MdfeStatus', 'codmdfestatus'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codmdfe' => 'Codmdfe',
			'codmdfestatus' => 'Codmdfestatus',
			'codfilial' => 'Codfilial',
			'tipoemitente' => 'tpEmit\n1 - Prestador de Servico\n2 - Transportador Carga Propria\n3 - Prestador de Servico - CTe Globalizado',
			'tipotransportador' => 'tpTransp\n1 - ETC - Empresa\n2 - TAC - Autônomo\n3 - CTC - Cooperativa',
			'modelo' => 'mod',
			'serie' => 'Serie',
			'numero' => 'nMDF',
			'chmdfe' => 'chMDFe',
			'modal' => '1 - Rodoviario\n2 - Aereo\n3 - Aquaviario\n4 - Ferroviario',
			'emissao' => 'dhEmi',
			'inicioviagem' => 'dhIniViagem',
			'tipoemissao' => 'tpEmis\n1 - Normal\n2 - Contingencia',
			'codcidadecarregamento' => 'UFIni\ninfMunCarrega',
			'codestadofim' => 'UFFim',
			'informacoesadicionais' => 'infAdFisco',
			'informacoescomplementares' => 'infCpl',
			'criacao' => 'Criacao',
			'codusuariocriacao' => 'Codusuariocriacao',
			'alteracao' => 'Alteracao',
			'codusuarioalteracao' => 'Codusuarioalteracao',
			'inativo' => 'Inativo',
			'protocoloautorizacao' => 'Protocoloautorizacao',
			'protocolocancelamento' => 'Protocolocancelamento',
			'encerramento' => 'Encerramento',
			'justificativa' => 'Justificativa',
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

		$criteria->compare('codmdfe',$this->codmdfe,true);
		$criteria->compare('codmdfestatus',$this->codmdfestatus,true);
		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('tipoemitente',$this->tipoemitente);
		$criteria->compare('tipotransportador',$this->tipotransportador);
		$criteria->compare('modelo',$this->modelo);
		$criteria->compare('serie',$this->serie);
		$criteria->compare('numero',$this->numero);
		$criteria->compare('chmdfe',$this->chmdfe,true);
		$criteria->compare('modal',$this->modal);
		$criteria->compare('emissao',$this->emissao,true);
		$criteria->compare('inicioviagem',$this->inicioviagem,true);
		$criteria->compare('tipoemissao',$this->tipoemissao);
		$criteria->compare('codcidadecarregamento',$this->codcidadecarregamento,true);
		$criteria->compare('codestadofim',$this->codestadofim,true);
		$criteria->compare('informacoesadicionais',$this->informacoesadicionais,true);
		$criteria->compare('informacoescomplementares',$this->informacoescomplementares,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('inativo',$this->inativo,true);
		$criteria->compare('protocoloautorizacao',$this->protocoloautorizacao,true);
		$criteria->compare('protocolocancelamento',$this->protocolocancelamento,true);
		$criteria->compare('encerramento',$this->encerramento,true);
		$criteria->compare('justificativa',$this->justificativa,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mdfe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
