<?php

/**
 * This is the model class for table "mgsis.tbltipotitulo".
 *
 * The followings are the available columns in table 'mgsis.tbltipotitulo':
 * @property string $codtipotitulo
 * @property string $tipotitulo
 * @property boolean $pagar
 * @property boolean $receber
 * @property string $observacoes
 * @property string $codtipomovimentotitulo
 * @property boolean $debito
 * @property boolean $credito
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Titulo[] $Titulos
 * @property TipoMovimentoTitulo $TipoMovimentoTitulo
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class TipoTitulo extends MGActiveRecord
{
	
	const AGRUPAMENTO_CREDITO = 911;
	const AGRUPAMENTO_DEBITO = 921;
	const VENDA = 200;
	const COMPRA = 100;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tbltipotitulo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codtipotitulo', 'required'),
			array('tipotitulo', 'length', 'max'=>20),
			array('observacoes', 'length', 'max'=>255),
			array('pagar, receber, codtipomovimentotitulo, debito, credito, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codtipotitulo, tipotitulo, pagar, receber, observacoes, codtipomovimentotitulo, debito, credito, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Titulos' => array(self::HAS_MANY, 'Titulo', 'codtipotitulo'),
			'TipoMovimentoTitulo' => array(self::BELONGS_TO, 'TipoMovimentoTitulo', 'codtipomovimentotitulo'),
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
			'codtipotitulo' => '#',
			'tipotitulo' => 'Tipo Titulo',
			'pagar' => 'Pagar',
			'receber' => 'Receber',
			'observacoes' => 'Observações',
			'codtipomovimentotitulo' => 'Tipo Movimento Titulo',
			'debito' => 'Débito',
			'credito' => 'Crédito',
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

		$criteria->compare('codtipotitulo',$this->codtipotitulo,true);
		$criteria->compare('tipotitulo',$this->tipotitulo,true);
		$criteria->compare('pagar',$this->pagar);
		$criteria->compare('receber',$this->receber);
		$criteria->compare('observacoes',$this->observacoes,true);
		$criteria->compare('codtipomovimentotitulo',$this->codtipomovimentotitulo,true);
		$criteria->compare('debito',$this->debito);
		$criteria->compare('credito',$this->credito);
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
	 * @return TipoTitulo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codtipotitulo', 'tipotitulo'),
				'order'=>'tipotitulo ASC',
				),
			);
	}
	
	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codtipotitulo', 'tipotitulo');
	}	
	
}
