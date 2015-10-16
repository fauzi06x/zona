<?php

class SupplierController extends Controller
{

	public function actionIndex(){
		
		$supplier= new supplier;

		$data['suppliers'] = $supplier->supplier_list();
		$this->render('list',$data);

	}
	public function actionAdd(){
		
		$model= new supplier;
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['supplier'])){
			$model->attributes=$_POST['supplier'];
			$data = $model->attributes;
            $model->image=CUploadedFile::getInstance($model,'image');
			if($model->image){
			if($model->image->saveAs('../../uploads/news/'.$model->image))
				$data['image']=$model->image->name;
			}
			if($model->validate() && $model->supplier_insert($data)){
				Yii::app()->user->setFlash('success', "Success! , Data saved.");
				$this->redirect('index');
			}
		}
		$this->render('form_add',array('model'=>$model));
	}
	public function actionUpdate($id){
		
		$model = new supplier;
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['supplier'])){
			
			$model->attributes=$_POST['supplier'];
			$data = $_POST['supplier'];
            if(!isset($data['image'])){
				$model->image=CUploadedFile::getInstance($model,'image');

				if($model->image){
					if($model->image->saveAs('../../uploads/news/'.$model->image))
						$data['image']=$model->image->name;
				}
			}else{
				unset($data['image']);	
			}
			if($model->validate() && $model->supplier_update($id,$data)){
				Yii::app()->user->setFlash('success', "Success! , Data deleted.");
				$this->redirect('../index');
			}
		}
		$data['model'] = $model;
		$data['supplier'] = $model->supplier_update($id);
		$this->render('form_update',$data);
	}
	
	public function actionDelete($id){
		$model = new supplier;
			if($model->supplier_delete($id)){
			Yii::app()->user->setFlash('success', "Success! , Data deleted.");
				$this->redirect('../index');
			}	
		$this->render('list');
	}
   
}