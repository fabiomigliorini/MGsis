<?php

/**
 * This is the model class for table "mgsis.tblpdv".
 *
 * The followings are the available columns in table 'mgsis.tblpdv':
 * @property string $codpdv
 * @property string $apelido
 * @property string $codfilial
 * @property double $precisao
 * @property string $ip
 * @property string $uuid
 * @property double $latitude
 * @property double $longitude
 * @property boolean $desktop
 * @property string $navegador
 * @property string $versaonavegador
 * @property string $plataforma
 * @property boolean $autorizado
 * @property string $inativo
 * @property string $criacao
 * @property string $codusuariocriacao
 * @property string $alteracao
 * @property string $codusuarioalteracao
 *
 * The followings are the available model relations:
 * @property Tblfilial $codfilial
 * @property Tblusuario $codusuariocriacao
 * @property Tblusuario $codusuarioalteracao
 * @property Tblnegocio[] $tblnegocios
 */
class Pdv extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mgsis.tblpdv';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uuid', 'required'),
            array('precisao, latitude, longitude', 'numerical'),
            array('apelido, navegador', 'length', 'max'=>100),
            array('versaonavegador', 'length', 'max'=>15),
            array('plataforma', 'length', 'max'=>50),
            array('codfilial, ip, desktop, autorizado, inativo, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('codpdv, apelido, codfilial, precisao, ip, uuid, latitude, longitude, desktop, navegador, versaonavegador, plataforma, autorizado, inativo, criacao, codusuariocriacao, alteracao, codusuarioalteracao', 'safe', 'on'=>'search'),
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
            'codfilial' => array(self::BELONGS_TO, 'Tblfilial', 'codfilial'),
            'codusuariocriacao' => array(self::BELONGS_TO, 'Tblusuario', 'codusuariocriacao'),
            'codusuarioalteracao' => array(self::BELONGS_TO, 'Tblusuario', 'codusuarioalteracao'),
            'tblnegocios' => array(self::HAS_MANY, 'Tblnegocio', 'codpdv'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'codpdv' => 'Codpdv',
            'apelido' => 'Apelido',
            'codfilial' => 'Codfilial',
            'precisao' => 'Precisao',
            'ip' => 'Ip',
            'uuid' => 'Uuid',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'desktop' => 'Desktop',
            'navegador' => 'Navegador',
            'versaonavegador' => 'Versaonavegador',
            'plataforma' => 'Plataforma',
            'autorizado' => 'Autorizado',
            'inativo' => 'Inativo',
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

        $criteria->compare('codpdv',$this->codpdv,true);
        $criteria->compare('apelido',$this->apelido,true);
        $criteria->compare('codfilial',$this->codfilial,true);
        $criteria->compare('precisao',$this->precisao);
        $criteria->compare('ip',$this->ip,true);
        $criteria->compare('uuid',$this->uuid,true);
        $criteria->compare('latitude',$this->latitude);
        $criteria->compare('longitude',$this->longitude);
        $criteria->compare('desktop',$this->desktop);
        $criteria->compare('navegador',$this->navegador,true);
        $criteria->compare('versaonavegador',$this->versaonavegador,true);
        $criteria->compare('plataforma',$this->plataforma,true);
        $criteria->compare('autorizado',$this->autorizado);
        $criteria->compare('inativo',$this->inativo,true);
        $criteria->compare('criacao',$this->criacao,true);
        $criteria->compare('codusuariocriacao',$this->codusuariocriacao,true);
        $criteria->compare('alteracao',$this->alteracao,true);
        $criteria->compare('codusuarioalteracao',$this->codusuarioalteracao,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Pdv the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}