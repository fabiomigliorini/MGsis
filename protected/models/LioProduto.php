<?php

/**
 * This is the model class for table "mgsis.tbllioproduto".
 *
 * The followings are the available columns in table 'mgsis.tbllioproduto':
 * @property string $codlioproduto
 * @property string $lioproduto
 * @property string $nomeprimario
 * @property integer $codigoprimario
 * @property string $nomesecundario
 * @property integer $codigosecundario
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 *
 * The followings are the available model relations:
 * @property Liopedidopagamento[] $liopedidopagamentos
 * @property Usuario $codusuariocriacao
 * @property Usuario $codusuarioalteracao
 */
class LioProduto extends MGActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mgsis.tbllioproduto';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lioproduto, nomeprimario, codigoprimario, nomesecundario, codigosecundario', 'required'),
            array('codigoprimario, codigosecundario', 'numerical', 'integerOnly'=>true),
            array('lioproduto, nomeprimario, nomesecundario', 'length', 'max'=>100),
            array('criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('codlioproduto, lioproduto, nomeprimario, codigoprimario, nomesecundario, codigosecundario, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe', 'on'=>'search'),
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
            'LioPedidoPagamentos' => array(self::HAS_MANY, 'LioPedidoPagamento', 'codlioproduto'),
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
            'codlioproduto' => 'Codlioproduto',
            'lioproduto' => 'payments.paymentFilelds.productName',
            'nomeprimario' => 'payments.paymentFilelds.primaryProductName',
            'codigoprimario' => 'payments.paymentFilelds.primaryProductCode',
            'nomesecundario' => 'payments.paymentFilelds.secondaryProductName',
            'codigosecundario' => 'payments.paymentFilelds.primaryProductCode',
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

        $criteria->compare('codlioproduto', $this->codlioproduto, true);
        $criteria->compare('lioproduto', $this->lioproduto, true);
        $criteria->compare('nomeprimario', $this->nomeprimario, true);
        $criteria->compare('codigoprimario', $this->codigoprimario);
        $criteria->compare('nomesecundario', $this->nomesecundario, true);
        $criteria->compare('codigosecundario', $this->codigosecundario);
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
     * @return LioProduto the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
