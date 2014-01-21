<?php

/**
 * This is the model class for table "mgsis.tbltituloagrupamento".
 *
 * The followings are the available columns in table 'mgsis.tbltituloagrupamento':
 * @property string $codtituloagrupamento
 * @property string $emissao
 * @property string $cancelamento
 * @property string $observacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Usuario $codusuarioalteracao
 * @property Usuario $codusuariocriacao
 * @property Movimentotitulo[] $movimentotitulos
 * @property Titulo[] $titulos
 */
class TituloAgrupamento extends MGActiveRecord
{
	
	public $codpessoa;
	public $codtitulos;
	public $saldo;
	public $multa;
	public $juros;
	public $desconto;
	public $total;
	public $emissao_de;
	public $emissao_ate;
	public $criacao_de;
	public $criacao_ate;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tbltituloagrupamento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codtituloagrupamento, emissao, codpessoa, codtitulos', 'required'),
			array('saldo, multa, juros, desconto, total', 'safe', 'on'=>'insert'),
			array('observacao', 'length', 'max'=>200),
			array('cancelamento, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('emissao_de, emissao_ate, criacao_de, criacao_ate, codpessoa, codtituloagrupamento, emissao', 'safe', 'on'=>'search'),
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
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'MovimentoTitulos' => array(self::HAS_MANY, 'MovimentoTitulo', 'codtituloagrupamento', 'order'=>'credito asc, debito asc'),
			'Titulos' => array(self::HAS_MANY, 'Titulo', 'codtituloagrupamento', 'order'=>'vencimento asc, saldo asc'),
			//'Pessoa' => array(self::BELONGS_TO, 'Pessoa', 'codpessoa'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codtituloagrupamento' => '#',
			'codpessoa' => 'Pessoa',
			'codtitulos' => 'Titulos',
			'emissao' => 'Emissão',
			'cancelamento' => 'Cancelamento',
			'observacao' => 'Observação',
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
		
		$criteria->compare('"Titulos".codpessoa', $this->codpessoa, false);
		$criteria->compare('t.codtituloagrupamento', $this->codtituloagrupamento, false);
		if ($emissao_de = DateTime::createFromFormat("d/m/y",$this->emissao_de))
		{
			$criteria->addCondition('t.emissao >= :emissao_de');
			$criteria->params = array_merge($criteria->params, array(':emissao_de' => $emissao_de->format('Y-m-d').' 00:00:00.0'));
		}
		if ($emissao_ate = DateTime::createFromFormat("d/m/y",$this->emissao_ate))
		{
			$criteria->addCondition('t.emissao <= :emissao_ate');
			$criteria->params = array_merge($criteria->params, array(':emissao_ate' => $emissao_ate->format('Y-m-d').' 23:59:59.9'));
		}
		if ($criacao_de = DateTime::createFromFormat("d/m/y",$this->criacao_de))
		{
			$criteria->addCondition('t.criacao >= :criacao_de');
			$criteria->params = array_merge($criteria->params, array(':criacao_de' => $criacao_de->format('Y-m-d').' 00:00:00.0'));
		}
		if ($criacao_ate = DateTime::createFromFormat("d/m/y",$this->criacao_ate))
		{
			$criteria->addCondition('t.criacao <= :criacao_ate');
			$criteria->params = array_merge($criteria->params, array(':criacao_ate' => $criacao_ate->format('Y-m-d').' 23:59:59.9'));
		}
		
		$criteria->with = array(
				'Titulos' => array(
					'together' => true,
					'with' => array(
						'Pessoa' => array(
							'select' => 'fantasia'
						)
					)
			),
		);		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.criacao DESC, t.emissao DESC, "Pessoa".fantasia ASC'),
			//'sort'=>array('defaultOrder'=>'"Pessoa".fantasia ASC, t.codtituloagrupamento ASC'),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TituloAgrupamento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function calculaTotal()
	{
		$total = 0;
		foreach ($this->Titulos as $titulo)
		{
			$total += $titulo->debito - $titulo->credito;
		}
		return $total;
	}
}
