<?php

/**
 * This is the model class for table "mgsis.tblcertidaoemissor".
 *
 * The followings are the available columns in table 'mgsis.tblcertidaoemissor':
 * @property string $codcertidaoemissor
 * @property string $certidaoemissor
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 * @property string $inativo
 *
 * The followings are the available model relations:
 * @property Pessoacertidao[] $pessoacertidaos
 */
class CertidaoEmissor extends MGActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mgsis.tblcertidaoemissor';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('certidaoemissor', 'required'),
            array('certidaoemissor', 'length', 'max'=>30),
            array('criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('codcertidaoemissor, certidaoemissor, criacao, codusuariocriacao, alteracao, codusuarioalteracao, inativo', 'safe', 'on'=>'search'),
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
            'pessoacertidaos' => array(self::HAS_MANY, 'Pessoacertidao', 'codcertidaoemissor'),
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
            'codcertidaoemissor' => '#',
            'certidaoemissor' => 'Nome do Órgão',
            'criacao' => 'Criação',
            'codusuariocriacao' => 'Usuário Criação',
            'alteracao' => 'Alteração',
            'codusuarioalteracao' => 'Usuário Alteração',
            'inativo' => 'Inativo',
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

        $criteria->compare('codcertidaoemissor', $this->codcertidaoemissor, true);
        $criteria->compare('certidaoemissor', $this->certidaoemissor, true);
        $criteria->compare('criacao', $this->criacao, true);
        $criteria->compare('codusuariocriacao', $this->codusuariocriacao, true);
        $criteria->compare('alteracao', $this->alteracao, true);
        $criteria->compare('codusuarioalteracao', $this->codusuarioalteracao, true);
        $criteria->compare('inativo', $this->inativo, true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CertidaoEmissor the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function scopes()
    {
        return array(
            'combo'=>array(
                'select'=>array('codcertidaoemissor', 'certidaoemissor'),
                'order'=>'certidaoemissor ASC',
                ),
            );
    }

    public function getListaCombo()
    {
        $lista = self::model()->combo()->findAll();
        return CHtml::listData($lista, 'codcertidaoemissor', 'certidaoemissor');
    }
}
