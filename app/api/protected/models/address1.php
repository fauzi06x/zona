<?php

class Address extends CActiveRecord
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
		return 'address';
	}
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('title, content, status, author_id', 'required'),
			// array('status', 'in', 'range'=>array(1,2,3)),
			// array('title', 'length', 'max'=>128),
			// array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/', 'message'=>'Tags can only contain word characters.'),
			// array('tags', 'normalizeTags'),

			// array('publish', 'on'=>'search'),
		);
	}
	
	public function search()
	{
		$criteria=new CDbCriteria;

		// $criteria->compare('title',$this->title,true);

		$criteria->compare('publish',$this->publish);

		return new CActiveDataProvider('Post', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id ASC'
			),
		));
	}
	
}
