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
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
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
 */
class Filial extends MGActiveRecord
{
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
			array('codfilial, filial', 'required'),
			array('filial, acbrnfemonitorip', 'length', 'max'=>20),
			array('acbrnfemonitorcaminho, acbrnfemonitorcaminhorede', 'length', 'max'=>100),
			array('empresadominio', 'length', 'max'=>7),
			array('odbcnumeronotafiscal', 'length', 'max'=>500),
			array('codempresa, codpessoa, emitenfe, acbrnfemonitorbloqueado, acbrnfemonitorcodusuario, acbrnfemonitorporta, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
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
			'emitenfe' => 'Emite NFE',
			'acbrnfemonitorcaminho' => 'Caminho Monitor ACBR',
			'acbrnfemonitorcaminhorede' => 'Caminho Rede ACBR',
			'acbrnfemonitorbloqueado' => 'Monitor ACBR Bloqueado',
			'acbrnfemonitorcodusuario' => 'Usuario Bloqueio ACBR Monitor',
			'empresadominio' => 'Empresa Domínio',
			'acbrnfemonitorip' => 'Acbrnfemonitorip',
			'acbrnfemonitorporta' => 'Acbrnfemonitorporta',
			'odbcnumeronotafiscal' => 'Odbcnumeronotafiscal',
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

		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('codempresa',$this->codempresa,true);
		$criteria->compare('codpessoa',$this->codpessoa,true);
		$criteria->compare('filial',$this->filial,true);
		$criteria->compare('emitenfe',$this->emitenfe);
		$criteria->compare('acbrnfemonitorcaminho',$this->acbrnfemonitorcaminho,true);
		$criteria->compare('acbrnfemonitorcaminhorede',$this->acbrnfemonitorcaminhorede,true);
		$criteria->compare('acbrnfemonitorbloqueado',$this->acbrnfemonitorbloqueado,true);
		$criteria->compare('acbrnfemonitorcodusuario',$this->acbrnfemonitorcodusuario,true);
		$criteria->compare('empresadominio',$this->empresadominio,true);
		$criteria->compare('acbrnfemonitorip',$this->acbrnfemonitorip,true);
		$criteria->compare('acbrnfemonitorporta',$this->acbrnfemonitorporta,true);
		$criteria->compare('odbcnumeronotafiscal',$this->odbcnumeronotafiscal,true);
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
				'order'=>'filial ASC',
				),
			);
	}
	
	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codfilial', 'filial');
	}	
	
}