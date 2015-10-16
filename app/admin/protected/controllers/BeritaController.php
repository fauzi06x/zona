<?php

class BeritaController extends Controller
{
	public $modelApi = 'Berita';
	public $condition = 'status = 1';
	public $order = 'id_Berita ASC';
	
	public function actionIndex(){

		$model= $this->getModelClass();
		// $function = $this->getVcrudAPI();
		 // function Berita_list($model = null, $select = null, $with = null, $condition = null, $order = null)
		$dataListBerita = Yii::app()->_Api->listData($this->modelApi, null, null, $this->condition, $this->order);
		if(isset($_POST['Berita'])){
			$dataSearchListBerita = array();
			$BeritaPost =$_POST['Berita'];
			if(isset($BeritaPost['status'])){
				if(!is_numeric($BeritaPost['status']) ){
					if (strpos('aktif', $BeritaPost['status']) !== false )
						$BeritaPost['status'] = 1;
					else
						$BeritaPost['status'] = 0;
				}
			}
			
			$globalFunction = new globalFunction;		
			$result = $globalFunction->multi_array_search($dataListBerita,$BeritaPost);
			foreach($result as $key )
				$dataSearchListBerita[$key]=$dataListBerita[$key];
			$data['berita'] = $dataSearchListBerita;
		}else{
			$data['berita'] = $dataListBerita;
		}
		
		$data['model'] = $model;
		$this->render('list',$data);

	}
	public function actionTambah(){
		

		$model= $this->getModelClass();
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['Berita'])){
			$model->attributes=$_POST['Berita'];
			$data = $model->attributes;
			
            $model->gambar=CUploadedFile::getInstance($model,'gambar');
			if($model->gambar){
			if($model->gambar->saveAs('../../uploads/Berita/'.$model->gambar))
				$data['gambar']=$model->gambar->name;
			}
			if($model->validate() && $model->tambahData($this->modelApi, $data)){
				Yii::app()->user->setFlash('success', "Sukses!, Data berhasil disimpan.");
				$this->redirect('index');
			}
		}
		$this->render('form_tambah',array('model'=>$model));
	}
	public function actionUbah($id){
		
		$model = $this->getModelClass();
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['Berita'])){
			
			$model->attributes=$_POST['Berita'];
			$data = $_POST['Berita'];
            if(!isset($data['gambar'])){
				$model->image=CUploadedFile::getInstance($model,'gambar');

				if($model->image){
					if($model->image->saveAs('../../uploads/news/'.$model->gambar))
						$data['gambar']=$model->image->name;
				}
			}else{
				unset($data['gambar']);	
			}
			if($model->validate() && $model->ubahData($this->modelApi, $id, $data)){
				Yii::app()->user->setFlash('success', "Sukses!, Data berhasil disimpan.");
				$this->redirect('../');
			}
		}
		
		$data['model'] = $model;
		$data['berita'] = $model->tampilData($this->modelApi, $id);

		$this->render('form_ubah',$data);
	}
	
	public function actionHapus($id){
		$model = $this->getModelClass();
			if($model->hapusData($this->modelApi, $id)){
			Yii::app()->user->setFlash('success', "Sukses!, Data berhasil dihapus.");
				$this->redirect('../index');
			}	
		$this->render('list');
	}
	
	public function getModelClass(){
        return new Berita;
    }
	
	public function filters()
	{
		return array(
			'accessControl',
		);
	}
	public function accessRules(){         
		return array(        
			array('allow',
				'actions'=>array('index', 'tambah', 'ubah', 'hapus'),
				// 'users'=>array('*'),
				'expression'=>array('BeritaController','allowOnlyOwner')
			),
			array('deny',
				'users'=>array('*'),
			),
		);     

	}
	public function allowOnlyOwner(){
		$privilage = new Privilage;
		$rules = $privilage->roleUser();
		return $rules;
    }
   
}