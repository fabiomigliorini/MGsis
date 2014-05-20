<?php

/**
 * This is the model class for table "mgsis.tblportador".
 *
 * The followings are the available columns in table 'mgsis.tblportador':
 * @property string $codportador
 * @property string $portador
 * @property string $codbanco
 * @property string $agencia
 * @property integer $agenciadigito
 * @property string $conta
 * @property integer $contadigito
 * @property boolean $emiteboleto
 * @property string $codfilial
 * @property string $convenio
 * @property string $diretorioremessa
 * @property string $diretorioretorno
 * @property integer $carteira
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property MovimentoTitulo[] $MovimentoTitulos
 * @property Titulo[] $Titulos
 * @property Filial $Filial
 * @property Banco $Banco
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property Usuario[] $Usuarios
 * @property BoletoRetorno[] $BoletoRetornos
 * @property Cobranca[] $Cobrancas
 * @property LiquidacaoTitulo[] $LiquidacaoTitulos
 */
class Portador extends MGActiveRecord
{
	
	const CARTEIRA = 999;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblportador';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codportador', 'required'),
			array('agenciadigito, contadigito, carteira', 'numerical', 'integerOnly'=>true),
			array('portador', 'length', 'max'=>50),
			array('convenio', 'length', 'max'=>20),
			array('diretorioremessa, diretorioretorno', 'length', 'max'=>100),
			array('codbanco, agencia, conta, emiteboleto, codfilial, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codportador, portador, codbanco, agencia, agenciadigito, conta, contadigito, emiteboleto, codfilial, convenio, diretorioremessa, diretorioretorno, carteira, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'MovimentoTitulos' => array(self::HAS_MANY, 'MovimentoTitulo', 'codportador'),
			'Titulos' => array(self::HAS_MANY, 'Titulo', 'codportador'),
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'Banco' => array(self::BELONGS_TO, 'Banco', 'codbanco'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'Usuarios' => array(self::HAS_MANY, 'Usuario', 'codportador'),
			'BoletoRetornos' => array(self::HAS_MANY, 'BoletoRetorno', 'codportador'),
			'Cobrancas' => array(self::HAS_MANY, 'Cobranca', 'codportador'),
			'LiquidacaoTitulos' => array(self::HAS_MANY, 'LiquidacaoTitulo', 'codportador'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codportador' => 'Codportador',
			'portador' => 'Portador',
			'codbanco' => 'Banco ALisson',
			'agencia' => 'Agencia',
			'agenciadigito' => 'Agenciadigito',
			'conta' => 'Conta',
			'contadigito' => 'Contadigito',
			'emiteboleto' => 'Emiteboleto',
			'codfilial' => 'Codfilial',
			'convenio' => 'Convenio',
			'diretorioremessa' => 'Diretorioremessa',
			'diretorioretorno' => 'Diretorioretorno',
			'carteira' => 'Carteira',
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

		$criteria->compare('codportador',$this->codportador,true);
		$criteria->compare('portador',$this->portador,true);
		$criteria->compare('codbanco',$this->codbanco,true);
		$criteria->compare('agencia',$this->agencia,true);
		$criteria->compare('agenciadigito',$this->agenciadigito);
		$criteria->compare('conta',$this->conta,true);
		$criteria->compare('contadigito',$this->contadigito);
		$criteria->compare('emiteboleto',$this->emiteboleto);
		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('convenio',$this->convenio,true);
		$criteria->compare('diretorioremessa',$this->diretorioremessa,true);
		$criteria->compare('diretorioretorno',$this->diretorioretorno,true);
		$criteria->compare('carteira',$this->carteira);
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
	 * @return Portador the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codportador', 'portador'),
				'order'=>'portador ASC',
				),
			);
	}

	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codportador', 'portador');
	}	

}
