<?php

/**
 * This is the model class for table "mgsis.tblnotafiscalreferenciada".
 *
 * The followings are the available columns in table 'mgsis.tblnotafiscalreferenciada':
 * @property string $codnotafiscalreferenciada
 * @property string $nfechave
 * @property string $codnotafiscal
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property NotaFiscal $NotaFiscal
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class NotaFiscalReferenciada extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblnotafiscalreferenciada';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nfechave, codnotafiscal', 'required'),
			array('nfechave', 'length', 'max'=>100),
			array('nfechave', 'validaChaveNFE'),
			array('nfechave', 'validaChaveNFEDuplicada'),
			array('alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codnotafiscalreferenciada, nfechave, codnotafiscal, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
		);
	}
	
	// valida duplicidade
	public function validaChaveNFEDuplicada($attribute, $params)
	{
		if (empty($this->nfechave))
			return;
		
		if (empty($this->codnotafiscal))
			return;
		
		/**
		 * @var NotaFiscalReferenciada[] $nfrs
		 */
		$nfrs = NotaFiscalReferenciada::model()->findAll(
			array(
				'select' => 'codnotafiscalreferenciada, codnotafiscal, nfechave', 
				'condition' => 'nfechave = :nfechave AND codnotafiscal = :codnotafiscal', 
				'params' => 
					array(
						'nfechave' => $this->nfechave,
						'codnotafiscal' => $this->codnotafiscal,
					)
			)
		);
		
		/**
		 * @var NotaFiscalReferenciada $nfr
		 */
		foreach ($nfrs as $nfr)
			if ($nfr->codnotafiscalreferenciada != $this->codnotafiscalreferenciada)
				$this->addError($attribute, "Esta chave já está referenciada nesta Nota Fiscal!");
		
	}
	
	// valida chave da NFE
	public function validaChaveNFE($attribute, $params)
	{
		if (empty($this->nfechave))
			return;
		
		$digito = NotaFiscal::calculaDigitoChaveNFE($this->nfechave);
		
		if ($digito == -1)
			$this->addError($attribute, "Chave da NFE Inválida!");
		
		if (substr($this->nfechave, 43, 1) <> $digito)
			$this->addError($attribute, "Dígito da Chave da NFE Inválido!");
	}
	

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'NotaFiscal' => array(self::BELONGS_TO, 'NotaFiscal', 'codnotafiscal'),
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
			'codnotafiscalreferenciada' => '#',
			'nfechave' => 'Chave da Nfe Referenciada',
			'codnotafiscal' => 'Nota Fsical',
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

		$criteria->compare('codnotafiscalreferenciada',$this->codnotafiscalreferenciada,true);
		$criteria->compare('nfechave',$this->nfechave,true);
		$criteria->compare('codnotafiscal',$this->codnotafiscal,true);
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
	 * @return NotaFiscalReferenciada the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
