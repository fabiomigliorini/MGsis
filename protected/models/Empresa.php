<?php

/**
 * This is the model class for table "mgsis.tblempresa".
 *
 * The followings are the available columns in table 'mgsis.tblempresa':
 * @property string $codempresa
 * @property string $empresa
 * @property string $modoemissaonfce
 * @property string $contingenciadata
 * @property string $contingenciajustificativa
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Filial[] $Filials
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class Empresa extends MGActiveRecord
{
	const MODOEMISSAONFCE_NORMAL = 1;
	const MODOEMISSAONFCE_OFFLINE = 9;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblempresa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('empresa, modoemissaonfce', 'required'),
			array('modoemissaonfce', 'validaModoEmissaoNFCe'),
			array('contingenciadata', 'validaDataContingencia'),
			array('empresa', 'length', 'max'=>50),
			array('contingenciajustificativa, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codempresa, empresa, modoemissaonfce, contingenciadata, contingenciajustificativa, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
		);
	}
	
	//verifica data da contingencia
	public function validaDataContingencia($attribute, $params)
	{
		if ($this->modoemissaonfce != Empresa::MODOEMISSAONFCE_OFFLINE)
			return true;
			
		if (empty($this->contingenciadata))
		{
			$this->addError('contingenciadata', 'Informe a data e hora de entrada em Contingência.');
			return false;
		}
		
		if (!$dh = DateTime::createFromFormat ('d/m/Y H:i:s', $this->contingenciadata,  new DateTimeZone('America/Cuiaba')))
		{
			$this->addError('contingenciadata', 'Formato de data e hora de entrada em Contingência inválido.');
			return false;
		}
		
		$cdh = new DateTime();
		
		if ($dh > $cdh)
		{
			$this->addError('contingenciadata', 'Data e hora posterior à data e hora correntes.');
			return false;
		}
		
		$dd = date_diff($dh, $cdh);
		 
		if ($dd->days >= 1)
		{
			$this->addError('contingenciadata', 'Data e hora superior à 24 horas.');
			return false;
		}
		
		if (empty($this->contingenciadata))
		{
			$this->addError('contingenciadata', 'Informe a data e hora de entrada em Contingência.');
			return false;
		}
	}
	
	//verifica se foi informada justificativa da contingencia
	public function validaModoEmissaoNFCe($attribute, $params)
	{
		if ($this->modoemissaonfce == Empresa::MODOEMISSAONFCE_OFFLINE)
		{
			if (empty($this->contingenciajustificativa))
				$this->addError('contingenciajustificativa', 'Informe a Justificativa de entrada em Contingência.');
		}
	}
	

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'Filials' => array(self::HAS_MANY, 'Filial', 'codempresa'),
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
			'codempresa' => '#',
			'empresa' => 'Empresa:',
			'modoemissaonfce' => 'Modo Emissão NFCe:',
			'contingenciadata' => 'Contingência Ativada em:',
			'contingenciajustificativa' => 'Justificativa Contingência:',
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

		//$criteria->compare('codempresa',$this->codempresa,false);
		$criteria->compare('codempresa',Yii::app()->format->numeroLimpo($this->codempresa),false);
		//$criteria->compare('empresa',$this->empresa,true);
		if (!empty($this->empresa))
		{
			$texto  = str_replace(' ', '%', trim($this->empresa));
			$criteria->addCondition('t.empresa ILIKE :empresa');
			$criteria->params = array_merge($criteria->params, array(':empresa' => '%'.$texto.'%'));
		}
                
		$criteria->compare('alteracao',$this->alteracao,false);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('criacao',$this->criacao,false);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Empresa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codempresa', 'empresa'),
				'order'=>'empresa ASC',
				),
			);
	}
	
	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codempresa', 'empresa');
	}	

	function getModoEmissaoNFCeListaCombo()
	{
		return array(
			self::MODOEMISSAONFCE_NORMAL => "Normal",
			self::MODOEMISSAONFCE_OFFLINE => "Off-Line",
		);
	}
	
	
}
