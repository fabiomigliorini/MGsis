<?php

/**
 * This is the model class for table "mgsis.tblfilial".
 *
 * The followings are the available columns in table 'mgsis.tblfilial':
 * @property string $codfilial
 * @property string $codempresa
 * @property string $codpessoa
 * @property string $filial
 * @property boolean $emitenfe
 * @property string $acbrnfemonitorcaminho
 * @property string $acbrnfemonitorcaminhorede
 * @property string $acbrnfemonitorbloqueado
 * @property string $acbrnfemonitorcodusuario
 * @property string $empresadominio
 * @property string $acbrnfemonitorip
 * @property string $acbrnfemonitorporta
 * @property string $odbcnumeronotafiscal
 * @property string $crt
 * @property string $nfcetoken
 * @property string $nfcetokenid
 * @property string $senhacertificado
 * @property string $tokenibpt
 * @property string $ultimonsu
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property integer $nfeambiente Description
 *
 * The followings are the available model relations:
 * @property Titulo[] $Titulos
 * @property Usuario $AcbrNfeMonitorUsuario
 * @property Empresa $Empresa
 * @property Pessoa $Pessoa
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property Portador[] $Portadors
 * @property Usuario[] $Usuarios
 * @property EstoqueMovimento[] $EstoqueMovimentos
 * @property Ecf[] $Ecfs
 * @property Negocio[] $Negocios
 * @property EstoqueSaldo[] $EstoqueSaldos
 * @property EstoqueLocal[] $EstoqueLocals
 * @property StoneFilial[] $StoneFilials
 */
class Filial extends MGActiveRecord
{
	const CRT_SIMPLES = 1;
	const CRT_SIMPLES_EXCESSO = 2;
	const CRT_REGIME_NORMAL = 3;

	const NFEAMBIENTE_PRODUCAO = 1;
	const NFEAMBIENTE_HOMOLOGACAO = 2;


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblfilial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codpessoa, filial, crt, nfeambiente', 'required'),
			array('filial, acbrnfemonitorip', 'length', 'max'=>20),
			array('acbrnfemonitorcaminho, acbrnfemonitorcaminhorede', 'length', 'max'=>100),
			array('empresadominio', 'length', 'max'=>7),
			array('crt', 'length', 'max'=>7),
			array('nfcetoken', 'length', 'max'=>32),
			array('nfcetoken', 'length', 'min'=>32),
			array('nfcetokenid', 'length', 'max'=>6),
			array('nfcetokenid', 'length', 'min'=>6),
			array('senhacertificado', 'length', 'max'=>50),
			array('tokenibpt', 'length', 'max'=>200),
			array('nfeambiente', 'length', 'max'=>2),
			array('nfeambiente', 'length', 'min'=>1),
			array('crt', 'numerical'),
			array('odbcnumeronotafiscal', 'length', 'max'=>500),
			array('codempresa, ultimonsu, codpessoa, emitenfe, acbrnfemonitorbloqueado, acbrnfemonitorcodusuario, acbrnfemonitorporta, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codfilial, codempresa, codpessoa, filial, emitenfe, acbrnfemonitorcaminho, acbrnfemonitorcaminhorede, acbrnfemonitorbloqueado, acbrnfemonitorcodusuario, empresadominio, acbrnfemonitorip, acbrnfemonitorporta, odbcnumeronotafiscal, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Titulos' => array(self::HAS_MANY, 'Titulo', 'codfilial'),
			'AcbrNfeMonitorUsuario' => array(self::BELONGS_TO, 'Usuario', 'acbrnfemonitorcodusuario'),
			'Empresa' => array(self::BELONGS_TO, 'Empresa', 'codempresa'),
			'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'Portadors' => array(self::HAS_MANY, 'Portador', 'codfilial'),
			'Usuarios' => array(self::HAS_MANY, 'Usuario', 'codfilial'),
			'EstoqueMovimentos' => array(self::HAS_MANY, 'EstoqueMovimento', 'codfilial'),
			'Ecfs' => array(self::HAS_MANY, 'Ecf', 'codfilial'),
			'Negocios' => array(self::HAS_MANY, 'Negocio', 'codfilial'),
			'EstoqueSaldos' => array(self::HAS_MANY, 'EstoqueSaldo', 'codfilial'),
			'EstoqueLocals' => array(self::HAS_MANY, 'EstoqueLocal', 'codfilial'),
			'StoneFilials' => array(self::HAS_MANY, 'StoneFilial', 'codfilial'),
			'PagarMePoss' => array(self::HAS_MANY, 'PagarMePos', 'codfilial', 'order'=>'apelido ASC, serial ASC, codpagarmepos ASC'),
			'PagarMePagamentos' => array(self::HAS_MANY, 'PagarMePagamento', 'codfilial'),
			'PagarMePedidos' => array(self::HAS_MANY, 'PagarMePedido', 'codfilial'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codfilial' => '#',
			'codempresa' => 'Empresa',
			'codpessoa' => 'Pessoa',
			'filial' => 'Filial',
			'emitenfe' => 'Emitir NFE',
			'acbrnfemonitorcaminho' => 'Caminho Monitor ACBR',
			'acbrnfemonitorcaminhorede' => 'Caminho Rede ACBR',
			'acbrnfemonitorbloqueado' => 'Monitor ACBR Bloqueado',
			'acbrnfemonitorcodusuario' => 'Usuario Bloqueio ACBR Monitor',
			'empresadominio' => 'Empresa Domínio',
			'acbrnfemonitorip' => 'ACBR Monitor IP',
			'acbrnfemonitorporta' => 'ACBR Monitor Porta',
			'odbcnumeronotafiscal' => 'ODBC Número Nota Fiscal',
			'alteracao' => 'Alteração',
			'codusuarioalteracao' => 'Usuário Alteração',
			'criacao' => 'Criação',
			'codusuariocriacao' => 'Usuário Criação',
			'crt' => 'CRT - Código do Regime Tributário',
			'nfcetoken' => 'Token NFCe',
			'nfcetokenid' => 'ID Token NFCe',
			'senhacertificado' => 'Senha Certificado PFX',
			'nfeambiente' => 'Ambiente NFe',
			'ultimonsu' => 'Último NSU Consultado na Sefaz',
			'tokenibpt' => 'Token IBPT',
			'pagarmesk' => 'Pagarme Secret Key',
			'pagarmeid' => 'Pagarme ID',
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

		$criteria->compare('codfilial',$this->codfilial,false);
		$criteria->compare('codempresa',$this->codempresa,false);
		$criteria->compare('codpessoa',$this->codpessoa,false);
		//$criteria->compare('filial',$this->filial,false);
		if (!empty($this->filial))
		{
			$texto  = str_replace(' ', '%', trim($this->filial));
			$criteria->addCondition('t.filial ILIKE :filial');
			$criteria->params = array_merge($criteria->params, array(':filial' => '%'.$texto.'%'));
		}
		$criteria->compare('emitenfe',$this->emitenfe);
		$criteria->compare('acbrnfemonitorcaminho',$this->acbrnfemonitorcaminho,false);
		$criteria->compare('acbrnfemonitorcaminhorede',$this->acbrnfemonitorcaminhorede,false);
		$criteria->compare('acbrnfemonitorbloqueado',$this->acbrnfemonitorbloqueado,false);
		$criteria->compare('acbrnfemonitorcodusuario',$this->acbrnfemonitorcodusuario,false);
		$criteria->compare('empresadominio',$this->empresadominio,false);
		$criteria->compare('acbrnfemonitorip',$this->acbrnfemonitorip,false);
		$criteria->compare('acbrnfemonitorporta',$this->acbrnfemonitorporta,false);
		$criteria->compare('odbcnumeronotafiscal',$this->odbcnumeronotafiscal,false);
		$criteria->compare('alteracao',$this->alteracao,false);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('criacao',$this->criacao,false);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.codfilial ASC'),
			'pagination'=>array('pageSize'=>20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Filial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function scopes ()
	{
		return array(
			'combo'=>array(
				'select'=>array('codfilial', 'filial'),
				'order'=>'codfilial ASC',
				),
			);
	}

	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codfilial', 'filial');
	}

}
