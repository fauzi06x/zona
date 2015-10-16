<?php

/**
 * This is the model class for table "hpp_maskapai".
 *
 * The followings are the available columns in table 'hpp_maskapai':
 * @property integer $id_hpp_maskapai
 * @property string $class_maskapai
 * @property string $hpp_maskapai
 * @property string $value_share
 * @property integer $type_share
 * @property integer $id_maskapai
 *
 * The followings are the available model relations:
 * @property Maskapai $idMaskapai
 */
class HppMaskapai extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hpp_maskapai';
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
			'id_hpp_maskapai' => 'Id Hpp Maskapai',
			'class_maskapai' => 'Class Maskapai',
			'hpp_maskapai' => 'Hpp Maskapai',
			'value_share' => 'Value Share',
			'type_share' => 'Type Share',
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

		$criteria->compare('id_hpp_maskapai',$this->id_hpp_maskapai);
		$criteria->compare('class_maskapai',$this->class_maskapai,true);
		$criteria->compare('hpp_maskapai',$this->hpp_maskapai,true);
		$criteria->compare('value_share',$this->value_share,true);
		$criteria->compare('type_share',$this->type_share);
		$criteria->compare('id_maskapai',$this->id_maskapai);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HppMaskapai the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
