<?php

/**
 * This is the model class for table "supplier_maskapai".
 *
 * The followings are the available columns in table 'supplier_maskapai':
 * @property integer $id_supp_maskapai
 * @property string $akun_supp_maskapai
 * @property integer $saldo_supp_maskapai
 * @property string $url_maskapai
 * @property string $ket_maskapai
 * @property integer $id_maskapai
 *
 * The followings are the available model relations:
 * @property Maskapai $idMaskapai
 */
class SupplierMaskapai extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'supplier_maskapai';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('saldo_supp_maskapai, id_maskapai', 'numerical', 'integerOnly'=>true),
			array('akun_supp_maskapai, url_maskapai', 'length', 'max'=>100),
			array('ket_maskapai', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_supp_maskapai, akun_supp_maskapai, saldo_supp_maskapai, url_maskapai, ket_maskapai, id_maskapai', 'safe', 'on'=>'search'),
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
			'idMaskapai' => array(self::BELONGS_TO, 'Maskapai', 'id_maskapai'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_supp_maskapai' => 'Id Supp Maskapai',
			'akun_supp_maskapai' => 'Akun Supp Maskapai',
			'saldo_supp_maskapai' => 'Saldo Supp Maskapai',
			'url_maskapai' => 'Url Maskapai',
			'ket_maskapai' => 'Ket Maskapai',
			'id_maskapai' => 'Id Maskapai',
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

		$criteria->compare('id_supp_maskapai',$this->id_supp_maskapai);
		$criteria->compare('akun_supp_maskapai',$this->akun_supp_maskapai,true);
		$criteria->compare('saldo_supp_maskapai',$this->saldo_supp_maskapai);
		$criteria->compare('url_maskapai',$this->url_maskapai,true);
		$criteria->compare('ket_maskapai',$this->ket_maskapai,true);
		$criteria->compare('id_maskapai',$this->id_maskapai);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SupplierMaskapai the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
