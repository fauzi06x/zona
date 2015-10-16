<?php

/**
 * This is the model class for table "halaman".
 *
 * The followings are the available columns in table 'halaman':
 * @property integer $id_halaman
 * @property string $judul
 * @property string $isi
 * @property string $gambar
 * @property string $url
 * @property integer $status
 * @property string $waktu_tambah
 * @property string $waktu_ubah
 */
class Halaman extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'halaman';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_halaman' => 'Id Halaman',
			'judul' => 'Judul',
			'isi' => 'Isi',
			'gambar' => 'Gambar',
			'url' => 'Url',
			'status' => 'Status',
			'waktu_tambah' => 'Waktu Tambah',
			'waktu_ubah' => 'Waktu Ubah',
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

		$criteria->compare('id_halaman',$this->id_halaman);
		$criteria->compare('judul',$this->judul,true);
		$criteria->compare('isi',$this->isi,true);
		$criteria->compare('gambar',$this->gambar,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('waktu_tambah',$this->waktu_tambah,true);
		$criteria->compare('waktu_ubah',$this->waktu_ubah,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Halaman the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
