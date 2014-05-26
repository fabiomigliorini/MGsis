<?php

/**
 * This is the model class for table "mgsis.tbltipomovimentotitulo".
 *
 * The followings are the available columns in table 'mgsis.tbltipomovimentotitulo':
 * @property string $codtipomovimentotitulo
 * @property string $tipomovimentotitulo
 * @property boolean $implantacao
 * @property boolean $ajuste
 * @property boolean $armotizacao
 * @property boolean $juros
 * @property boolean $desconto
 * @property boolean $pagamento
 * @property boolean $estorno
 * @property string $observacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property MovimentoTitulo[] $MovimentoTitulos
 * @property TipoTitulo[] $TipoTitulos
 */
class TipoMovimentoTitulo extends MGActiveRecord
{
	
	const TIPO_IMPLANTACAO = 100;
	const TIPO_ESTORNO_IMPLANTACAO = 900;
	
	const TIPO_AJUSTE = 200;
	const TIPO_ESTORNO_AJUSTE = 920;
	
	const TIPO_AMORTIZACAO = 300;
	const TIPO_ESTORNO_AMORTIZACAO = 933;
	
	const TIPO_JUROS = 400;
	const TIPO_ESTORNO_JUROS = 940;
	
	const TIPO_DESCONTO = 500;
	const TIPO_ESTORNO_DESCONTO = 950;
	
	const TIPO_LIQUIDACAO = 600;
	const TIPO_ESTORNO_LIQUIDACAO = 930;
	
	const TIPO_AGRUPAMENTO = 901;
	const TIPO_ESTORNO_AGRUPAMENTO = 991;
	
	const TIPO_LIQUIDACAO_COBRANCA = 610;
	const TIPO_ESTORNO_LIQUIDACAO_COBRANCA = 910;

	const TIPO_MULTA = 401;
	const TIPO_ESTORNO_MULTA = 941;
	

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tbltipomovimentotitulo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipomovimentotitulo', 'required'),
			array('tipomovimentotitulo', 'length', 'max'=>20),
			array('observacao', 'length', 'max'=>255),
			array('implantacao, ajuste, armotizacao, juros, desconto, pagamento, estorno, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codtipomovimentotitulo, tipomovimentotitulo, implantacao, ajuste, armotizacao, juros, desconto, pagamento, estorno, observacao, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'MovimentoTitulos' => array(self::HAS_MANY, 'MovimentoTitulo', 'codtipomovimentotitulo'),
			'TipoTitulos' => array(self::HAS_MANY, 'TipoTitulo', 'codtipomovimentotitulo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codtipomovimentotitulo' => '#',
			'tipomovimentotitulo' => 'Tipo Movimento Título',
			'implantacao' => 'Implantação',
			'ajuste' => 'Ajuste',
			'armotizacao' => 'Armotização',
			'juros' => 'Juros',
			'desconto' => 'Desconto',
			'pagamento' => 'Pagamento',
			'estorno' => 'Estorno',
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

		$criteria->compare('codtipomovimentotitulo',$this->codtipomovimentotitulo,false);
		//$criteria->compare('tipomovimentotitulo',$this->tipomovimentotitulo,false);
			if (!empty($this->tipomovimentotitulo))
		{
			$texto  = str_replace(' ', '%', trim($this->tipomovimentotitulo));
			$criteria->addCondition('t.tipomovimentotitulo ILIKE :tipomovimentotitulo');
			$criteria->params = array_merge($criteria->params, array(':tipomovimentotitulo' => '%'.$texto.'%'));
		}
		$criteria->compare('implantacao',$this->implantacao);
		$criteria->compare('ajuste',$this->ajuste);
		$criteria->compare('armotizacao',$this->armotizacao);
		$criteria->compare('juros',$this->juros);
		$criteria->compare('desconto',$this->desconto);
		$criteria->compare('pagamento',$this->pagamento);
		$criteria->compare('estorno',$this->estorno);
		$criteria->compare('observacao',$this->observacao,false);
		$criteria->compare('alteracao',$this->alteracao,false);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('criacao',$this->criacao,false);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.tipomovimentotitulo ASC'),
			'pagination'=>array('pageSize'=>20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TipoMovimentoTitulo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codtipomovimentotitulo', 'tipomovimentotitulo'),
				'order'=>'tipomovimentotitulo ASC',
				),
			);
	}
	
	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codtipomovimentotitulo', 'tipomovimentotitulo');
	}	
	
}
