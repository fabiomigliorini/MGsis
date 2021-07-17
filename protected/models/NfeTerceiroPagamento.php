<?php

/**
 * This is the model class for table "mgsis.tblnfeterceiropagamento".
 *
 * The followings are the available columns in table 'mgsis.tblnfeterceiropagamento':
 * @property string $codnfeterceiropagamento
 * @property string $codnfeterceiro
 * @property integer $tpag
 * @property string $vpag
 * @property string $cnpj
 * @property integer $tband
 * @property string $caut
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property integer $indpag
 *
 * The followings are the available model relations:
 * @property Nfeterceiro $codnfeterceiro
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 */
class NfeTerceiroPagamento extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnfeterceiropagamento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tpag, tband, indpag', 'numerical', 'integerOnly'=>true),
			array('vpag', 'length', 'max'=>15),
			array('cnpj', 'length', 'max'=>14),
			array('caut', 'length', 'max'=>30),
			array('codnfeterceiro, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnfeterceiropagamento, codnfeterceiro, tpag, vpag, cnpj, tband, caut, criacao, codusuariocriacao, alteracao, codusuarioalteracao, indpag', 'safe', 'on'=>'search'),
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
			'NfeTerceiro' => array(self::BELONGS_TO, 'NfeTerceiro', 'codnfeterceiro'),
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
			'codnfeterceiropagamento' => 'Codnfeterceiropagamento',
			'codnfeterceiro' => 'Codnfeterceiro',
			'tpag' => '01=Dinheiro\n02=Cheque\n03=Cartão de Crédito\n04=Cartão de Débito\n05=Crédito Loja\n10=Vale Alimentação\n11=Vale Refeição\n12=Vale Presente\n13=Vale Combustível\n15=Boleto Bancário\n16=Depósito Bancário\n17=Pagamento Instantâneo (PIX)\n18=Transferência bancária, Carteira Digital\n19=Programa de fidelidade, Cashback, Crédito Virtual\n90=Sem pagamento\n99=Outros',
			'vpag' => 'vPag',
			'cnpj' => 'Cnpj',
			'tband' => 'tBand\n01=Visa\n02=Mastercard\n03=American Express\n04=Sorocred\n99=Outros',
			'caut' => 'cAut',
			'criacao' => 'Criacao',
			'codusuariocriacao' => 'Codusuariocriacao',
			'alteracao' => 'Alteracao',
			'codusuarioalteracao' => 'Codusuarioalteracao',
			'indpag' => '0=Pagamento à Vista\n1= Pagamento a Prazo',
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

		$criteria->compare('codnfeterceiropagamento',$this->codnfeterceiropagamento,true);
		$criteria->compare('codnfeterceiro',$this->codnfeterceiro,true);
		$criteria->compare('tpag',$this->tpag);
		$criteria->compare('vpag',$this->vpag,true);
		$criteria->compare('cnpj',$this->cnpj,true);
		$criteria->compare('tband',$this->tband);
		$criteria->compare('caut',$this->caut,true);
		$criteria->compare('criacao',$this->criacao,true);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
		$criteria->compare('alteracao',$this->alteracao,true);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);
		$criteria->compare('indpag',$this->indpag);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NfeTerceiroPagamento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
