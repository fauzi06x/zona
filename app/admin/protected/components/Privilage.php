<?php
class Privilage{ 	
	
	public function roleUser(){
		$rules=array(1,2);
        if(isset(Yii::app()->user->user_group) && in_array(Yii::app()->user->user_group,$rules))
            return true;
        else  
			return false;     
	}          
	
}
?>  