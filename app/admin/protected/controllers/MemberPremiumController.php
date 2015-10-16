<?php

class MemberPremiumController extends Controller
{

	public function actionIndex(){
		
		$memberPremium= new memberPremium;
		$dataListMemberPremium = $memberPremium->memberPremium_list();
		if(isset($_POST['MemberPremium'])){
			
			$dataSearchListMemberAgen = array();
			$MemberPremiumPost =$_POST['MemberPremium'];
			if(isset($MemberPremiumPost['status'])){
				if(!is_numeric($MemberPremiumPost['status']) ){
					if (strpos('aktif', $MemberPremiumPost['status']) !== false )
						$MemberPremiumPost['status'] = 1;
					else
						$MemberPremiumPost['status'] = 0;
				}
			}
			$globalFunction = new globalFunction;		
			$result = $globalFunction->multi_array_search($dataListMemberPremium,$MemberPremiumPost);

			foreach($result as $key )
				$dataSearchListMemberPremium[$key]=$dataListMemberPremium[$key];
			$data['memberPremium'] = $dataSearchListMemberPremium;
		}else{
			$data['memberPremium'] = $dataListMemberPremium;
		}

		$data['model'] = $memberPremium;
		$this->render('list',$data);

	}
	public function actionAdd(){
		
		$model= new MemberPremium;
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['Maskapai'])){
			$model->attributes=$_POST['Maskapai'];
			$data = $model->attributes;
            
			if($model->validate() && $model->maskapai_insert($data)){
				Yii::app()->user->setFlash('success', "Success! , Data saved.");
				$this->redirect('index');
			}
		}
		$this->render('form_add',array('model'=>$model));
	}
	public function actionUpdate($id){
		
		$model = new MemberPremium;
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['Maskapai'])){
			$model->attributes=$_POST['Maskapai'];

			$data = $model->attributes;
			if($data['status']=='')
				$data['status']=0;
			if($model->validate() && $model->maskapai_update($id,$data)){
				Yii::app()->user->setFlash('success', "Success! , Data updated.");
				$this->redirect('../index');
			}
		}
		$data['model'] = $model;
		$data['maskapai'] = $model->maskapai_update($id);

		$this->render('form_update',$data);
	}
	
	public function actionTipeAgen($id){
		
		$modelTipeAgen = new TipeAgen;
		$modelMemberPremium = new MemberPremium;		
		$condition = "AND t.id_member_premium=".$id;
		$data['memberPremium'] = $modelMemberPremium->memberPremium_update($id);
		$data['tipeAgen'] = $modelTipeAgen->TipeAgen_list($condition);
		$data['model'] = $modelTipeAgen;
		$this->render('list_tipe_agen',$data);
	
	}
	
	public function actionDelete($id){
		$model = new maskapai;
			if($model->maskapai_delete($id)){
			Yii::app()->user->setFlash('success', "Success! , Data deleted.");
				$this->redirect('../index');
			}	
		$this->render('list');
	}
	public function actionView($id){

		$memberPremium= new memberPremium;

		$data['memberPremium'] = $memberPremium->memberPremium_view($id);
		$this->render('list',$data);

	}
	public function actionList1(){
		$result = array(
            'draw'              => 1,
            'recordsTotal'      => 2,
            'recordsFiltered'   => 2,
            'data'              => array()
        );
		 $result['data'][] = array(
                   'dsa',
				'tesss'
                );
				$result['data'][] = array(
                   'dsa',
				'tesss'
                );

		echo json_encode($result);
	}
   
}