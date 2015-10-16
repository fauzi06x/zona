<?php

class AddressController extends Controller
{

	public function actionIndex(){
		
		$address= new address;

		$data['address'] = $address->address_list();
		$this->render('list',$data);

	}
	public function actionAdd(){
		
		$model= new address;
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['Address'])){
			$prov = explode("_",$_POST['Address']['prov']);
			$_POST['Address']['prov']=$prov[1];
			$model->attributes=$_POST['Address'];
			$data=$model->attributes;
			if($model->validate() && $model->address_insert($data)){
				Yii::app()->user->setFlash('success', "Success! , Data saved.");
				$this->redirect('index');
			}
		}
		$this->render('form_add',array('model'=>$model));
	}
	public function actionUpdate($id){
		
		$model = new address;
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['Address'])){
			
			$prov = explode("_",$_POST['Address']['prov']);
			$_POST['Address']['prov']=$prov[1];
			$model->attributes=$_POST['Address'];
			$data=$model->attributes;
			if($model->validate() && $model->address_update($id,$data)){
				Yii::app()->user->setFlash('success', "Success! , Data deleted.");
				$this->redirect('../index');
			}
		}
		$data['model'] = $model;
		$data['address'] = $model->address_update($id);
		// 
		$this->render('form_update',$data);
	}
	
	public function actionDelete($id){
		$model = new address;
			if($model->address_delete($id)){
			Yii::app()->user->setFlash('success', "Success! , Data deleted.");
				$this->redirect('../index');
			}	
		$this->render('list');
	}
	public function actionGetCode($id){
		echo $id+1;
	}
   
}