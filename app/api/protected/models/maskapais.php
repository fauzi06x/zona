<?php

class Maskapai extends CActiveRecord
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'maskapai';
	}
	
	public function rules()
	{
		return array();
	}
	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('publish',$this->publish);

		return new CActiveDataProvider('Post', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id ASC'
			),
		));
	}
	
}
