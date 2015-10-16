<?php

class Model_all extends CActiveRecord
{
	public function selectAll($column, ){
	$q = Yii::app()->db->createCommand()
						->select('AccountId,CharityId,SUM(Amount) as Amount')
						->from('trans')
						->where('AccountId=:id, CharityId=:cha', array(':id'=>Yii::app()->user->id, ':cha'=>$this->CharityId))
						->group('AccountId,CharityId')
						->query();

	return $q;
	}
}
