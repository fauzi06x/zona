<?php

class NewsController extends Controller
{

	public function actionIndex(){
		
		$news= new news;

		$data['news'] = $news->news_list();
		$this->render('list',$data);

	}
	public function actionAdd(){
		
		$model= new news;
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['News'])){
			$model->attributes=$_POST['News'];
			$data = $model->attributes;
            $model->image=CUploadedFile::getInstance($model,'image');
			if($model->image){
			if($model->image->saveAs('../../uploads/news/'.$model->image))
				$data['image']=$model->image->name;
			}
			if($model->validate() && $model->news_insert($data)){
				Yii::app()->user->setFlash('success', "Success! , Data saved.");
				$this->redirect('index');
			}
		}
		$this->render('form_add',array('model'=>$model));
	}
	public function actionUpdate($id){
		
		$model = new news;
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['News'])){
			
			$model->attributes=$_POST['News'];
			$data = $_POST['News'];
            if(!isset($data['image'])){
				$model->image=CUploadedFile::getInstance($model,'image');

				if($model->image){
					if($model->image->saveAs('../../uploads/news/'.$model->image))
						$data['image']=$model->image->name;
				}
			}else{
				unset($data['image']);	
			}
			if($model->validate() && $model->news_update($id,$data)){
				Yii::app()->user->setFlash('success', "Success! , Data updated.");
				$this->redirect('../index');
			}
		}
		$data['model'] = $model;
		$data['news'] = $model->news_update($id);

		$this->render('form_update',$data);
	}
	
	public function actionDelete($id){
		$model = new news;
			if($model->news_delete($id)){
			Yii::app()->user->setFlash('success', "Success! , Data deleted.");
				$this->redirect('../index');
			}	
		$this->render('list');
	}
   
}