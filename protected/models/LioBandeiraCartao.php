<?php

/**
 * This is the model class for table "mgsis.tblliobandeiracartao".
 *
 * The followings are the available columns in table 'mgsis.tblliobandeiracartao':
 * @property string $codliobandeiracartao
 * @property string $bandeiracartao
 * @property string $siglalio
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 *
 * The followings are the available model relations:
 * @property LioPedidoPagamento[] $LioPedidoPagamentos
 * @property Usuario $UsuarioCriacao
 * @property Usuario $UsuarioAlteracao
 */
class LioBandeiraCartao extends MGActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mgsis.tblliobandeiracartao';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('bandeiracartao', 'required'),
            array('bandeiracartao', 'length', 'max'=>100),
            array('siglalio', 'length', 'max'=>50),
            array('criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('codliobandeiracartao, bandeiracartao, siglalio, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe', 'on'=>'search'),
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
            'LioPedidoPagamentos' => array(self::HAS_MANY, 'LioPedidoPagamento', 'codliobandeiracartao'),
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
            'codliobandeiracartao' => 'Codliobandeiracartao',
            'bandeiracartao' => 'Bandeiracartao',
            'siglalio' => 'payments.brand',
            'criacao' => 'Criacao',
            'codusuariocriacao' => 'Codusuariocriacao',
            'alteracao' => 'Alteracao',
            'codusuarioalteracao' => 'Codusuarioalteracao',
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

        $criteria->compare('codliobandeiracartao', $this->codliobandeiracartao, true);
        $criteria->compare('bandeiracartao', $this->bandeiracartao, true);
        $criteria->compare('siglalio', $this->siglalio, true);
        $criteria->compare('criacao', $this->criacao, true);
        $criteria->compare('codusuariocriacao', $this->codusuariocriacao, true);
        $criteria->compare('alteracao', $this->alteracao, true);
        $criteria->compare('codusuarioalteracao', $this->codusuarioalteracao, true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LioBandeiraCartao the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
