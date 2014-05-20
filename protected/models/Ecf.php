<?php

/**
 * This is the model class for table "mgsis.tblecf".
 *
 * The followings are the available columns in table 'mgsis.tblecf':
 * @property string $codecf
 * @property string $ecf
 * @property string $acbrmonitorcaminho
 * @property string $acbrmonitorcaminhorede
 * @property string $codusuario
 * @property string $bloqueado
 * @property string $serie
 * @property string $codfilial
 * @property string $modelo
 * @property integer $numero
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $criacao
 * @property string $codusuariocriacao
 *
 * The followings are the available model relations:
 * @property Usuario[] $Usuarios
 * @property CupomFiscal[] $CupomFiscals
 * @property Filial $Filial
 * @property Usuario $Usuario
 * @property Usuario $UsuarioAlteracao
 * @property Usuario $UsuarioCriacao
 * @property EcfReducaoZ[] $EcfReducaoZs
 */
class Ecf extends MGActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mgsis.tblecf';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codecf, ecf, acbrmonitorcaminho, acbrmonitorcaminhorede', 'required'),
			array('numero', 'numerical', 'integerOnly'=>true),
			array('ecf', 'length', 'max'=>50),
			array('acbrmonitorcaminho, acbrmonitorcaminhorede', 'length', 'max'=>100),
			array('serie', 'length', 'max'=>20),
			array('modelo', 'length', 'max'=>2),
			array('codusuario, bloqueado, codfilial, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codecf, ecf, acbrmonitorcaminho, acbrmonitorcaminhorede, codusuario, bloqueado, serie, codfilial, modelo, numero, alteracao, codusuarioalteracao, criacao, codusuariocriacao', 'safe', 'on'=>'search'),
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
			'Usuarios' => array(self::HAS_MANY, 'Usuario', 'codecf'),
			'CupomFiscals' => array(self::HAS_MANY, 'CupomFiscal', 'codecf'),
			'Filial' => array(self::BELONGS_TO, 'Filial', 'codfilial'),
			'Usuario' => array(self::BELONGS_TO, 'Usuario', 'codusuario'),
			'UsuarioAlteracao' => array(self::BELONGS_TO, 'Usuario', 'codusuarioalteracao'),
			'UsuarioCriacao' => array(self::BELONGS_TO, 'Usuario', 'codusuariocriacao'),
			'EcfReducaoZs' => array(self::HAS_MANY, 'EcfReducaoZ', 'codecf'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codecf' => '#',
			'ecf' => 'ECF',
			'acbrmonitorcaminho' => 'ACBR Monitor Caminho',
			'acbrmonitorcaminhorede' => 'ACBR Monitor Caminho Rede',
			'codusuario' => 'Usuário',
			'bloqueado' => 'Bloqueado',
			'serie' => 'Série',
			'codfilial' => 'Filial',
			'modelo' => 'Modelo',
			'numero' => 'Número',
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

		$criteria->compare('codecf',$this->codecf,true);
		$criteria->compare('ecf',$this->ecf,true);
		$criteria->compare('acbrmonitorcaminho',$this->acbrmonitorcaminho,true);
		$criteria->compare('acbrmonitorcaminhorede',$this->acbrmonitorcaminhorede,true);
		$criteria->compare('codusuario',$this->codusuario,true);
		$criteria->compare('bloqueado',$this->bloqueado,true);
		$criteria->compare('serie',$this->serie,true);
		$criteria->compare('codfilial',$this->codfilial,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('numero',$this->numero);
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
	 * @return Ecf the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes () 
	{
		return array(
			'combo'=>array(
				'select'=>array('codecf', 'ecf'),
				'order'=>'ecf ASC',
				),
			);
	}

	public function getListaCombo ()
	{
		$lista = self::model()->combo()->findAll();
		return CHtml::listData($lista, 'codecf', 'ecf');
	}	

}
