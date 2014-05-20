<?php

/**
 * This is the model class for table "mgsis.tblformapagamento".
 *
 * The followings are the available columns in table 'mgsis.tblformapagamento':
 * @property string $codformapagamento
 * @property string $formapagamento
 * @property boolean $boleto
 * @property boolean $fechamento
 * @property boolean $notafiscal
 * @property string $parcelas
 * @property string $diasentreparcelas
 * @property boolean $avista
 * @property string $formapagamentoecf
 * @property boolean $entrega
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property NegocioFormaPagamento[] $NegocioFormaPagamentos
 * @property Pessoa[] $Pessoas
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class FormaPagamento extends MGActiveRecord
{
	const DINHEIRO = 1010;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblformapagamento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codformapagamento, formapagamento', 'required'),
			array('formapagamento', 'length', 'max'=>50),
			array('formapagamentoecf', 'length', 'max'=>5),
			array('boleto, fechamento, notafiscal, parcelas, diasentreparcelas, avista, entrega, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codformapagamento, formapagamento, boleto, fechamento, notafiscal, parcelas, diasentreparcelas, avista, formapagamentoecf, entrega, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'NegocioFormaPagamentos' => array(self::HAS_MANY, 'NegocioFormaPagamento', 'codformapagamento'),
			'Pessoas' => array(self::HAS_MANY, 'Pessoa', 'codformapagamento'),
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
			'codformapagamento' => '#',
			'formapagamento' => 'Formapagamento',
			'boleto' => 'Boleto',
			'fechamento' => 'Fechamento',
			'notafiscal' => 'Nota Fiscal',
			'parcelas' => 'Parcelas',
			'diasentreparcelas' => 'Dias Entre Parcelas',
			'avista' => 'Avista',
			'formapagamentoecf' => 'Forma de Pagamento ecf',
			'entrega' => 'Entrega',
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

		$criteria->compare('codformapagamento',$this->codformapagamento,true);
		$criteria->compare('formapagamento',$this->formapagamento,true);
		$criteria->compare('boleto',$this->boleto);
		$criteria->compare('fechamento',$this->fechamento);
		$criteria->compare('notafiscal',$this->notafiscal);
		$criteria->compare('parcelas',$this->parcelas,true);
		$criteria->compare('diasentreparcelas',$this->diasentreparcelas,true);
		$criteria->compare('avista',$this->avista);
		$criteria->compare('formapagamentoecf',$this->formapagamentoecf,true);
		$criteria->compare('entrega',$this->entrega);
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
	 * @return FormaPagamento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codformapagamento', 'formapagamento'),
				'order'=>'formapagamento ASC',
				),
			);
	}

	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codformapagamento', 'formapagamento');
	}	
	
}
