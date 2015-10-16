<?php

class HalamanController extends Controller
{
	
	public $model = 'halaman';
	public $condition = '';
	public $order = 'id_halaman ASC';
	
	public function actionIndex(){

		$model= Yii::app()->globalFunction->getModel($this->model);
		$data['columns'] = array(
            array("data" => "no"),
            array("data" => "judul"),
            array("data" => "status"),
            array("data" => "aksi")
        );
		$data['model'] = $model;
		$this->render('list',$data);

	}
	public function actionTambah(){

		$model= Yii::app()->globalFunction->getModel($this->model);
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['Halaman'])){
			$model->attributes=$_POST['Halaman'];
			$data = $model->attributes;
			
            $model->gambar=CUploadedFile::getInstance($model,'gambar');
			if($model->gambar){
			if($model->gambar->saveAs('../../uploads/halaman/'.$model->gambar))
				$data['gambar']=$model->gambar->name;
			}

			if($model->validate() && Yii::app()->_Api->tambahData($this->model, $data)){
				Yii::app()->user->setFlash('success', "Success! , Data berhasil disimpan.");
				$this->redirect('index');
			}
		}
		$this->render('form_tambah',array('model'=>$model));
	}
	public function actionUbah($id){
		
		$model= Yii::app()->globalFunction->getModel($this->model);
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['Halaman'])){
			
			$model->attributes=$_POST['Halaman'];
			$data = $_POST['Halaman'];
            if(!isset($data['gambar'])){
				$model->image=CUploadedFile::getInstance($model,'gambar');

				if($model->image){
					if($model->image->saveAs('../../uploads/news/'.$model->gambar))
						$data['gambar']=$model->image->name;
				}
			}else{
				unset($data['gambar']);	
			}
			if($model->validate() && Yii::app()->_Api->ubahData($this->model, $id, $data)){
				Yii::app()->user->setFlash('success', "Success! , Data berhasil disimpan.");
				$this->redirect('../index');
			}
		}
		
		$data['model'] = $model;
		$data['halaman'] = Yii::app()->_Api->tampilData($this->model, $id);
		$this->render('form_ubah',$data);
	}
	
	public function actionData(){
		$data['data']=array();
		$condition ='';
		$req = ($_REQUEST);
		$arrCol = array('no','judul','status','aksi');
		
		extract($_REQUEST);
		
		$searchData = '';
		foreach($columns as $key=>$val){
			if($val['search']['value']!='')
				$searchArr[$arrCol[$key]]=$val['search']['value'];
		}
		if(isset($searchArr)){
			foreach($searchArr as $key=>$val){
				if($key=='status')
					$searchData .=" AND ".$key."='".$val."'";
				else
					$searchData .=" AND ".$key." like '%".$val."%'";
			}	
		}
		$condition = $searchData;
		$countDataAll = count(Yii::app()->_Api->listData($this->model));
		$limit = $length;
		$offset = $start;
		$listDataHalaman = Yii::app()->_Api->listData($this->model, null, null, $condition, $this->order, $limit, $offset);
		$countDataFilter = count($listDataHalaman);
		
		$data['draw']=$draw;
		$data['recordsTotal']=$countDataAll;
		$data['recordsFiltered']=$countDataFilter;
		// print_r($listDataHalaman);
		$x=1;
		foreach($listDataHalaman as $r){
			$data['data'][]= array(
				'no' =>$x,
				'judul' =>$r['judul'],
				'status' =>$r['status'] == 1 ? '<span class="label label-success">Aktif</span>':'<span class="label label-danger">Tidak Aktif</span>',
				'aksi' =>"
				<a title=\'Ubah Halaman\' href='".Yii::app()->baseUrl."/halaman/ubah/".$r['id_halaman']."' ><i class=\'fa fa-edit\'></i> Ubah</a> | <a title='Hapus Halaman' href='javascript:del(".$r['id_halaman'].");' onclick='return confirm(\"Anda yakin ingin hapus data ini?\");' ><i class='fa fa-remove'></i> Hapus</a>"
			);
		$x++;	
		}
		
		echo json_encode($data);
	}	
	public function actionHapus($id){
		if(Yii::app()->_Api->hapusData($this->model, $id)){
		Yii::app()->user->setFlash('success', "Sukses! , Data berhasil dihapus.");
			$this->redirect('../index');
		}	
		$this->render('list');
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
				'actions'=>array('index', 'tambah', 'ubah', 'data', 'hapus'),
				// 'users'=>array('*'),
				'expression'=>array('HalamanController','allowOnlyOwner')
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