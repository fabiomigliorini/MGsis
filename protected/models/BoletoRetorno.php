<?php

/**
 * This is the model class for table "mgsis.tblboletoretorno".
 *
 * The followings are the available columns in table 'mgsis.tblboletoretorno':
 * @property string $codboletoretorno
 * @property string $codboletomotivoocorrencia
 * @property string $codportador
 * @property string $dataretorno
 * @property string $linha
 * @property string $nossonumero
 * @property string $numero
 * @property string $valor
 * @property string $codbancocobrador
 * @property string $agenciacobradora
 * @property string $despesas
 * @property string $outrasdespesas
 * @property string $jurosatraso
 * @property string $abatimento
 * @property string $desconto
 * @property string $pagamento
 * @property string $jurosmora
 * @property string $protesto
 * @property string $codtitulo
 * @property string $arquivo
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Movimentotitulo[] $movimentotitulos
 * @property Portador $codportador
 * @property Titulo $codtitulo
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property BoletoMotivoOcorrencia $codboletomotivoocorrencia
 */
class BoletoRetorno extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblboletoretorno';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codboletoretorno, dataretorno, linha, nossonumero, arquivo', 'required'),
			array('nossonumero', 'length', 'max'=>12),
			array('numero', 'length', 'max'=>25),
			array('valor, despesas, outrasdespesas, jurosatraso, abatimento, desconto, pagamento, jurosmora', 'length', 'max'=>13),
			array('agenciacobradora', 'length', 'max'=>5),
			array('protesto', 'length', 'max'=>1),
			array('arquivo', 'length', 'max'=>20),
			array('codboletomotivoocorrencia, codportador, codbancocobrador, codtitulo, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codboletoretorno, codboletomotivoocorrencia, codportador, dataretorno, linha, nossonumero, numero, valor, codbancocobrador, agenciacobradora, despesas, outrasdespesas, jurosatraso, abatimento, desconto, pagamento, jurosmora, protesto, codtitulo, arquivo, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'MovimenTotitulos' => array(self::HAS_MANY, 'Movimentotitulo', 'codboletoretorno'),
			'Portador' => array(self::BELONGS_TO, 'Portador', 'codportador'),
			'Titulo' => array(self::BELONGS_TO, 'Titulo', 'codtitulo'),
			'BoletoMotivoOcorrencia' => array(self::BELONGS_TO, 'BoletoMotivoOcorrencia', 'codboletomotivoocorrencia'),
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
			'codboletoretorno' => 'Codboletoretorno',
			'codboletomotivoocorrencia' => 'Codboletomotivoocorrencia',
			'codportador' => 'Codportador',
			'dataretorno' => 'Dataretorno',
			'linha' => 'Linha',
			'nossonumero' => 'Nossonumero',
			'numero' => 'Numero',
			'valor' => 'Valor',
			'codbancocobrador' => 'Codbancocobrador',
			'agenciacobradora' => 'Agenciacobradora',
			'despesas' => 'Despesas',
			'outrasdespesas' => 'Outrasdespesas',
			'jurosatraso' => 'Jurosatraso',
			'abatimento' => 'Abatimento',
			'desconto' => 'Desconto',
			'pagamento' => 'Pagamento',
			'jurosmora' => 'Jurosmora',
			'protesto' => 'Protesto',
			'codtitulo' => 'Codtitulo',
			'arquivo' => 'Arquivo',
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

		$criteria->compare('codboletoretorno',$this->codboletoretorno,true);
		$criteria->compare('codboletomotivoocorrencia',$this->codboletomotivoocorrencia,true);
		$criteria->compare('codportador',$this->codportador,true);
		$criteria->compare('dataretorno',$this->dataretorno,true);
		$criteria->compare('linha',$this->linha,true);
		$criteria->compare('nossonumero',$this->nossonumero,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('codbancocobrador',$this->codbancocobrador,true);
		$criteria->compare('agenciacobradora',$this->agenciacobradora,true);
		$criteria->compare('despesas',$this->despesas,true);
		$criteria->compare('outrasdespesas',$this->outrasdespesas,true);
		$criteria->compare('jurosatraso',$this->jurosatraso,true);
		$criteria->compare('abatimento',$this->abatimento,true);
		$criteria->compare('desconto',$this->desconto,true);
		$criteria->compare('pagamento',$this->pagamento,true);
		$criteria->compare('jurosmora',$this->jurosmora,true);
		$criteria->compare('protesto',$this->protesto,true);
		$criteria->compare('codtitulo',$this->codtitulo,true);
		$criteria->compare('arquivo',$this->arquivo,true);
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
	 * @return BoletoRetorno the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
