<?php

/**
 * This is the model class for table "mgsis.tblmarca".
 *
 * The followings are the available columns in table 'mgsis.tblmarca':
 * @property string $codmarca
 * @property string $marca
 * @property boolean $site
 * @property string $descricaosite
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Produto[] $produtos
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 */
class Marca extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblmarca';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('marca', 'required'),
			array('marca', 'length', 'max'=>50),
			array('descricaosite', 'length', 'max'=>1024),
			array('site, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codmarca, marca, site, descricaosite, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Produtos' => array(self::HAS_MANY, 'Produto', 'codmarca'),
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
			'codmarca' => '#',
			'marca' => 'Marca',
			'site' => 'Disponível no Site',
			'descricaosite' => 'Descrição Site',
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

		$criteria->compare('codmarca',$this->codmarca,false);
		$criteria->compare('marca',$this->marca,true);
		switch ($this->site) // '1'=>'No Site', '2'=>'Fora do Site'), 
		{
			case 1:
				$criteria->addCondition("t.site  = true");
				continue;
			case 2:
				$criteria->addCondition("t.site = false");
				continue;
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'t.marca ASC'),
			'pagination'=>array('pageSize'=>20)
		));
		
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Marca the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codmarca', 'marca'),
				'order'=>'marca ASC',
				),
			);
	}

	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codmarca', 'marca');
	}	
	
}
