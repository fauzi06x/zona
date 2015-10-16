<?php

class ApiController extends Controller
{

	public $result = array(
		'success'=>array('result'=>'success'),
		'failed'=>array('result'=>'failed'),
		'null'=>array('result'=>'null'),
	);
    private $format = 'json';
	
	
    
    public function filters()
    {
            return array();
    }
	
    public function actionIndex()
    {
        echo CJSON::encode(array(1, 2, 3));
    } 
	
	
	 public function actionSearch()
    {
		
        $this->_checkAuth();
		
		$tbl = $_SERVER['HTTP_X_'.self::APPLICATION_ID.'_MODEL'];
		$models = $tbl::model()->findAll();
		$rows = array();
			$i=0;
            foreach($models as $model){
                $rows[$i] = $model->attributes;
				if(isset($_POST['with'])){
					$with[$i] = $model->$_POST['with']->attributes;
					$rows[$i] = array_merge($rows[$i],$with[$i]);
				}
				
			$i++;
			}	

            $this->_sendResponse(200, CJSON::encode($models));
        
    } 
	
	//show all item
    public function actionList()
    {
		$globalFunction = $this->globalFunction();
		
		$api_user 	  = isset($_POST['api_user'])? $_POST['api_user']:'';
		$api_password = isset($_POST['api_password'])? $_POST['api_password']:'';
		$signature 	  = isset($_POST['signature'])? $_POST['signature']:'';
		$model 	  	  = isset($_POST['model'])? $_POST['model']:'';
		$params 	  = isset($_POST['params'])? $_POST['params']:'';
		$globalFunction->_checkSignature($signature,$_POST);
		$globalFunction->_checkAuth($api_user,$api_password);
		if(is_null($model) || $model=='')
			$globalFunction->_sendResponse(500, 'Error: Parameter <b>model</b> is missing' );
		
		$Criteria = new CDbCriteria();
		if(isset($params['select']))
			$Criteria->select=$params['select'];
		if(isset($params['with']))
			$Criteria->with=$params['with'];
		if(isset($params['condition']))
			$Criteria->condition = '1=1 '.$params['condition'];
		if(isset($params['group']))
			$Criteria->group = $params['group'];
		if(isset($params['order']))
			$Criteria->order = $params['order'];
		if(isset($params['limit']))
			$Criteria->limit = $params['limit'];
		if(isset($params['offset']))
			$Criteria->offset = $params['offset'];
		
		$models = $model::model()->findAll($Criteria);
		$rows = array();
		$i=0;
		foreach($models as $model){
			$rows[$i] = $model->attributes;
			if(isset($params['with'])){
				$with[$i] = $model->$params['with']->attributes;
				$rows[$i] = array_merge($rows[$i],$with[$i]);
			}
		$i++;
		}
		$globalFunction->_sendResponse(200, CJSON::encode($rows));
    } 
   
    public function actionView()
    {
		$globalFunction = $this->globalFunction();
		
		$api_user 	  = isset($_POST['api_user'])? $_POST['api_user']:'';
		$api_password = isset($_POST['api_password'])? $_POST['api_password']:'';
		$signature 	  = isset($_POST['signature'])? $_POST['signature']:'';
		$model 	  	  = isset($_POST['model'])? $_POST['model']:'';
		$params 	  = isset($_POST['params'])? $_POST['params']:'';
		
		$globalFunction->_checkSignature($signature,$_POST);
		$globalFunction->_checkAuth($api_user,$api_password);
		
		$Criteria = new CDbCriteria();
		if(isset($params['select']))
			$Criteria->select=$params['select'];
		if(isset($params['with']))
			$Criteria->with=$params['with'];
		if(isset($params['condition']))
			$Criteria->condition = '1=1 '.$params['condition'];
		if(isset($params['group']))
			$Criteria->group = $params['group'];
		if(isset($params['order']))
			$Criteria->order = $params['order'];
       
		if(is_null($model) || $model=='')
			$globalFunction->_sendResponse(500, 'Error: Parameter <b>model</b> is missing' );
		if(isset($params['id'])){
            if($model = $model::model()->findByPk($params['id']))
            $globalFunction->_sendResponse(200, $globalFunction->_getObjectEncoded($model, $model->attributes));
		}else{
			$model = $model::model()->find($Criteria);
            $globalFunction->_sendResponse(200, $globalFunction->_getObjectEncoded($model, $model->attributes));
			
		}
		
		
		

    } 
	
    public function actionCreate()
    {
        $globalFunction = $this->globalFunction();
		
		$api_user 	  = isset($_POST['api_user'])? $_POST['api_user']:'';
		$api_password = isset($_POST['api_password'])? $_POST['api_password']:'';
		$signature 	  = isset($_POST['signature'])? $_POST['signature']:'';
		$model 	  	  = isset($_POST['model'])? $_POST['model']:'';
		$params 	  = isset($_POST['params'])? $_POST['params']:'';
		
		$globalFunction->_checkSignature($signature,$_POST);
		$globalFunction->_checkAuth($api_user,$api_password);
		
		if(is_null($model) || $model=='')
			$globalFunction->_sendResponse(500, 'Error: Parameter <b>model</b> is missing' );
        
		$model = new $model;
		
        foreach($params as $var=>$value) {
			
            if($model->hasAttribute($var)) {
                $model->$var = $value;
            } else {
                $globalFunction->_sendResponse(500, sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var, $model) );
            }
        }

        if($model->save())
            $globalFunction->_sendResponse(200, $globalFunction->_getObjectEncoded($model, $this->result['success']) ); 
        else 
            $globalFunction->_sendResponse(200, $globalFunction->_getObjectEncoded($model, $this->result['failed'])); 
        
    } 
	
    public function actionUpdate()
    {
		
		$globalFunction = $this->globalFunction();
		
		$api_user 	  = isset($_POST['api_user'])? $_POST['api_user']:'';
		$api_password = isset($_POST['api_password'])? $_POST['api_password']:'';
		$signature 	  = isset($_POST['signature'])? $_POST['signature']:'';
		$model 	  	  = isset($_POST['model'])? $_POST['model']:'';
		$params 	  = isset($_POST['params'])? $_POST['params']:'';
		
		$globalFunction->_checkSignature($signature,$_POST);
		$globalFunction->_checkAuth($api_user,$api_password);
		
		if(!isset($params['id']))
            $globalFunction->_sendResponse(500, 'Error: Parameter <b>id</b> is missing' );
		if(is_null($model) || $model=='')
			$globalFunction->_sendResponse(500, 'Error: Parameter <b>model</b> is missing' );

		$model = $model::model()->findByPk($params['id']);
		unset($params['id']);
        foreach($params as $var=>$value) {
            if($model->hasAttribute($var)) {
               $model->$var = $value;
            } else {
                $globalFunction->_sendResponse(500, 'Parameter <b>%s</b> is not allowed for model <b>%s</b>');
            }
        }
		
        if($model->save())	
            $globalFunction->_sendResponse(200, $globalFunction->_getObjectEncoded($model, $this->result['success'] ));
        else 
            $globalFunction->_sendResponse(200, $globalFunction->_getObjectEncoded($model, $this->result['failed'] ));
        
    } 
	
    public function actionDelete()
    {
		
		$globalFunction = $this->globalFunction();
		
		$api_user 	  = isset($_POST['api_user'])? $_POST['api_user']:'';
		$api_password = isset($_POST['api_password'])? $_POST['api_password']:'';
		$signature 	  = isset($_POST['signature'])? $_POST['signature']:'';
		$model 	  	  = isset($_POST['model'])? $_POST['model']:'';
		$params 	  = isset($_POST['params'])? $_POST['params']:'';

		$globalFunction->_checkSignature($signature,$_POST);
		$globalFunction->_checkAuth($api_user,$api_password);
		
		if(!isset($params['id']))
            $globalFunction->_sendResponse(500, 'Error: Parameter <b>id</b> is missing' );
		if(is_null($model) || $model=='')
			$globalFunction->_sendResponse(500, 'Error: Parameter <b>model</b> is missing' );

		
		$model = $model::model()->findByPk($params['id']);

        if(is_null($model)) 
            $globalFunction->_sendResponse(400, $globalFunction->_getObjectEncoded($model, $this->result['failed']));

        $num = $model->delete();
        if($num > 0)
            $globalFunction->_sendResponse(200, $globalFunction->_getObjectEncoded($model, $this->result['success']));
        else
           $globalFunction->_sendResponse(400, $globalFunction->_getObjectEncoded($model, $this->result['failed']));
    } 
	
    public function globalFunction(){
		return new GlobalFunction;
	}
    
}
?>
