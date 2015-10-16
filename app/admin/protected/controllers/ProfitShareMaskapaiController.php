<?php

class ProfitShareMaskapaiController extends Controller
{
	public $modelApi = 'profitShareMaskapai';
	public $condition = '';
	public $order = 't.id_profit_share_maskapai ASC';
	public $with = 'idMaskapai';
	
	public function actionIndex(){
		$model= $this->getModelClass();
		$function = $this->getVcrudAPI();
		$dataListProfitShareMaskapai = $function->listData($this->modelApi, null, $this->with, $this->condition, $this->order);
		if(isset($_POST['ProfitShareMaskapai'])){
			$dataSearchListProfitShareMaskapai = array();
			$ProfitShareMaskapaiPost =$_POST['ProfitShareMaskapai'];
			if(isset($ProfitShareMaskapaiPost['type_share'])){
				if(!is_numeric($ProfitShareMaskapaiPost['type_share']) ){
					if (strpos('diskon', $ProfitShareMaskapaiPost['type_share']) !== false )
						$ProfitShareMaskapaiPost['type_share'] = 0;
					else
						$ProfitShareMaskapaiPost['type_share'] = 1;
				}
			}
			$globalFunction = new globalFunction;		
			$result = $globalFunction->multi_array_search($dataListProfitShareMaskapai,$ProfitShareMaskapaiPost);
			foreach($result as $key )
				$dataSearchListProfitShareMaskapai[$key]=$dataListProfitShareMaskapai[$key];
			$data['profitShareMaskapai'] = $dataSearchListProfitShareMaskapai;
		}else{
			$data['profitShareMaskapai'] = $dataListProfitShareMaskapai;
		}
		$data['model'] = $model;
		$this->render('list',$data);
	}
	
	public function actionTambah(){
		
		$model= $this->getModelClass();
		$function = $this->getVcrudAPI();
		
		if(isset($_POST['ProfitShareMaskapai'])){
			$model->attributes=$_POST['ProfitShareMaskapai'];
			$data = $_POST['ProfitShareMaskapai'];

			if($model->validate() && $function->tambahData($this->modelApi, $data)){
				Yii::app()->user->setFlash('success', "Sukses! , Data berhasil disimpan.");
				$this->redirect('index');
			}
		}
		$data['model'] = $model;
		$data['maskapai'] = $this->getMaskapai();
		$this->render('form_tambah',$data);
	}
	
	public function actionUbah($id){
		$model= $this->getModelClass();
		$function = $this->getVcrudAPI();
		
		if(isset($_POST['ProfitShareMaskapai'])){
			
			$model->attributes=$_POST['ProfitShareMaskapai'];
			$data = $model->attributes;
			
			if($model->validate() && $function->ubahData($this->modelApi, $id, $data)){
				Yii::app()->user->setFlash('success', "Success! , Data deleted.");
				$this->redirect('../index');
			}
		}
		$data['model'] = $model;
		$data['profitShareMaskapai'] = $function->tampilData($this->modelApi, $id);
		$data['maskapai'] = $this->getMaskapai();
		$this->render('form_ubah',$data);
	}
	
	public function actionHapus($id){
		$function = $this->getVcrudAPI();
		if($function->hapusData($this->modelApi, $id)){
		Yii::app()->user->setFlash('success', "Sukses! , Data berhasil dihapus.");
			$this->redirect('../index');
		}	
		$this->render('list');
	}
	
	public function getMaskapai(){
		$function = $this->getVcrudAPI();
		$modelApi = 'maskapai';
		$condition = 'status=1';
		$order = 'nama_maskapai ASC';
		$result = $function->listData($modelApi, null, null, $condition, $order);
		if($result)
			return $result;	
	}
	
	public function getModelClass(){
        return new ProfitShareMaskapai;
    }
	
	public function getVcrudAPI(){
        return new VcrudAPI;
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
				'expression'=>array('ProfitShareMaskapaiController','allowOnlyOwner')
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