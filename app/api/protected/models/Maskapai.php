<?php

/**
 * This is the model class for table "maskapai".
 *
 * The followings are the available columns in table 'maskapai':
 * @property integer $id_maskapai
 * @property string $nama_maskapai
 * @property string $jenis_maskapai
 * @property string $kode_maskapai
 * @property integer $kode_api
 * @property string $kode_share
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property SupplierMaskapai[] $supplierMaskapais
 */
class Maskapai extends CActiveRecord
{
	public $nama_maskapai;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'maskapai';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kode_api, status', 'numerical', 'integerOnly'=>true),
			array('nama_maskapai, jenis_maskapai', 'length', 'max'=>100),
			array('kode_maskapai, kode_share', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_maskapai, nama_maskapai, jenis_maskapai, kode_maskapai, kode_api, kode_share, status', 'safe', 'on'=>'search'),
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
			'supplierMaskapais' => array(self::HAS_MANY, 'SupplierMaskapai', 'id_maskapai'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_maskapai' => 'Id Maskapai',
			'nama_maskapai' => 'Nama Maskapai',
			'jenis_maskapai' => 'Jenis Maskapai',
			'kode_maskapai' => 'Kode Maskapai',
			'kode_api' => 'Kode Api',
			'kode_share' => 'Kode Share',
			'status' => 'Status',
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

		$criteria->compare('id_maskapai',$this->id_maskapai);
		$criteria->compare('nama_maskapai',$this->nama_maskapai,true);
		$criteria->compare('jenis_maskapai',$this->jenis_maskapai,true);
		$criteria->compare('kode_maskapai',$this->kode_maskapai,true);
		$criteria->compare('kode_api',$this->kode_api);
		$criteria->compare('kode_share',$this->kode_share,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Maskapai the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
