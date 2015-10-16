<?php

class PageController extends Controller
{

	public function actionIndex(){
		
		$page= new page;

		$data['pages'] = $page->page_list();
		$this->render('list',$data);

	}
	public function actionAdd(){
		
		$model= new page;
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['Page'])){
			$model->attributes=$_POST['Page'];
			$data = $model->attributes;
            $model->image=CUploadedFile::getInstance($model,'image');
			if($model->image){
			if($model->image->saveAs('../../uploads/news/'.$model->image))
				$data['image']=$model->image->name;
			}
			if($model->validate() && $model->page_insert($data)){
				Yii::app()->user->setFlash('success', "Success! , Data saved.");
				$this->redirect('index');
			}
		}
		$this->render('form_add',array('model'=>$model));
	}
	public function actionUpdate($id){
		
		$model = new page;
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['Page'])){
			
			$model->attributes=$_POST['Page'];
			$data = $_POST['Page'];
            if(!isset($data['image'])){
				$model->image=CUploadedFile::getInstance($model,'image');

				if($model->image){
					if($model->image->saveAs('../../uploads/news/'.$model->image))
						$data['image']=$model->image->name;
				}
			}else{
				unset($data['image']);	
			}
			if($model->validate() && $model->page_update($id,$data)){
				Yii::app()->user->setFlash('success', "Success! , Data deleted.");
				$this->redirect('../index');
			}
		}
		$data['model'] = $model;
		$data['page'] = $model->page_update($id);
		$this->render('form_update',$data);
	}
	
	public function actionDelete($id){
		$model = new page;
			if($model->page_delete($id)){
			Yii::app()->user->setFlash('success', "Success! , Data deleted.");
				$this->redirect('../index');
			}	
		$this->render('list');
	}
   
}