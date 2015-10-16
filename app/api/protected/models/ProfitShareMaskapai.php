<?php

/**
 * This is the model class for table "profit_share_maskapai".
 *
 * The followings are the available columns in table 'profit_share_maskapai':
 * @property integer $id_profit_share_maskapai
 * @property string $kelas_maskapai
 * @property string $full_share
 * @property string $nilai_share
 * @property integer $tipe_share
 * @property integer $id_maskapai
 *
 * The followings are the available model relations:
 * @property Maskapai $idMaskapai
 */
class ProfitShareMaskapai extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'profit_share_maskapai';
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
			'idMaskapai' => array(self::BELONGS_TO, 'Maskapai', 'id_maskapai'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_profit_share_maskapai' => 'Id Profit Share Maskapai',
			'kelas_maskapai' => 'Kelas Maskapai',
			'full_share' => 'Full Share',
			'nilai_share' => 'Nilai Share',
			'tipe_share' => 'Tipe Share',
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

		$criteria->compare('id_profit_share_maskapai',$this->id_profit_share_maskapai);
		$criteria->compare('kelas_maskapai',$this->kelas_maskapai,true);
		$criteria->compare('full_share',$this->full_share,true);
		$criteria->compare('nilai_share',$this->nilai_share,true);
		$criteria->compare('tipe_share',$this->tipe_share);
		$criteria->compare('id_maskapai',$this->id_maskapai);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProfitShareMaskapai the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
