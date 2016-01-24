<?php

/**
 * This is the model class for table "mgsis.tblncm".
 *
 * The followings are the available columns in table 'mgsis.tblncm':
 * @property bigserial $codncm
 * @property bigint $codncmpai
 * @property string $ncm
 * @property string $descricao
 * @property timestamp $alteracao
 * @property bigint $codusuarioalteracao
 * @property timestamp $criacao
 * @property bigint $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property Ncm $NcmPai
 * @property Ncm[] $Ncms
 * @property Ibptax[] $Ibptaxs
 * @property RegulamentoIcmsStMt[] $RegulamentoIcmsStMts
 * @property Cest[] $Cests
 * 
 */
class Ncm extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblncm';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ncm, descricao', 'required'),
			array('ncm', 'length', 'max'=>10),
			array('descricao', 'length', 'max'=>1500),
			array('codncmpai, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codncm, ncm, descricao, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'NcmPai' => array(self::BELONGS_TO, 'Ncm', 'codncmpai'),
			'Ncms' => array(self::HAS_MANY, 'Ncm', 'codncmpai', 'order'=>'ncm ASC'),
			'Ibptaxs' => array(self::HAS_MANY, 'Ibptax', 'codncm', 'order'=>'codigo ASC'),
			'RegulamentoIcmsStMts' => array(self::HAS_MANY, 'RegulamentoIcmsStMt', 'codncm', 'order'=>'ncm ASC'),
			'Cests' => array(self::HAS_MANY, 'Cest', 'codncm', 'order'=>'ncm ASC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codncm' => '#',
			'codncmpai' => 'Filho de',
			'ncm' => 'NCM',
			'descricao' => 'Descrição',
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

		//$criteria->compare('codncm',$this->codncm,false);
		$criteria->compare('codncm',Yii::app()->format->numeroLimpo($this->codncm),false);
		//$criteria->compare('ncm',$this->ncm,FALSE);
		if (!empty($this->ncm))
		{
			$texto  = str_replace(' ', '%', trim($this->ncm));
			$criteria->addCondition('t.ncm ILIKE :ncm');
			$criteria->params = array_merge($criteria->params, array(':ncm' => $texto.'%'));
		}
		//$criteria->compare('descricao',$this->descricao,true);
		if (!empty($this->descricao))
		{
			$texto  = str_replace(' ', '%', trim($this->descricao));
			$criteria->addCondition('t.descricao ILIKE :descricao');
			$criteria->params = array_merge($criteria->params, array(':descricao' => '%'.$texto.'%'));
		}
		
		$criteria->compare('alteracao',$this->alteracao,false);
		$criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,false);
		$criteria->compare('criacao',$this->criacao,false);
		$criteria->compare('codusuariocriacao',$this->codusuariocriacao,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.codncm ASC'),
			'pagination'=>array('pageSize'=>20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ncm the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'raiz'=>array(
				'condition'=>'codncmpai is null',
				'order'=>'ncm ASC',
				),
			);
	}
	
	/**
	 * 
	 * @return Cest[]
	 */
	public function cestsDisponiveis()
	{
		$cests = array();
		if (sizeof($this->Cests) > 0)
			$cests = array_merge ($cests, $this->Cests);
		if (isset($this->NcmPai))
			$cests = array_merge ($cests, $this->NcmPai->cestsDisponiveis());
		return $cests;
	}

	/**
	 * 
	 * @return Cest[]
	 */
	public function regulamentoIcmsStMtsDisponiveis()
	{
		$regs = array();
		
		// pega regulamentos do registro corrente
		if (sizeof($this->RegulamentoIcmsStMts) > 0)
			$regs = array_merge ($regs, $this->RegulamentoIcmsStMts);
		
		// pega regulamentos da arvore recursivamente
		if (isset($this->NcmPai))
			$regs = array_merge ($regs, $this->NcmPai->regulamentoIcmsStMtsDisponiveis());

		// apaga os Excetos
		$i = 0;
		$apagar = array();
		foreach($regs as $reg)
		{
			if (strstr($reg->ncmexceto, $this->ncm))
				$apagar[] = $i;
			$i++;
		}
		
		foreach ($apagar as $i)
			unset($regs[$i]);
		
		return $regs;
	}
	
}
