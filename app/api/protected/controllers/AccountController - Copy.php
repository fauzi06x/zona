<?php

class AccountController extends Controller
{
    Const APPLICATION_KEY = '51815N15';

    private $format = 'json';
    public function filters()
    {
            return array();
    } 
    public function actionIndex()
    {
        echo CJSON::encode(array(1, 2, 3));
    }
    public function actionLogin(){
		$api_user 	  = isset($_POST['api_user'])? $_POST['api_user']:'';
		$api_password = isset($_POST['api_password'])? $_POST['api_password']:'';
		$signature 	  = isset($_POST['signature'])? $_POST['signature']:'';
		$params 	  = isset($_POST['params'])? $_POST['params']:'';
		if($this->_checkSignature($signature,$_POST))
			if($this->_checkAuth($api_user,$api_password))
				$this->_checkLogin($params);
    } 

	private function _checkSignature($signature,$post)
    {
		extract($post);
		$date = date('dY');
		$signatureApi = sha1(md5(self::APPLICATION_KEY.$api_user.$api_password.$date));
		if($signatureApi != $signature)
			$this->_sendResponse(401);
       return true;
    }
	
    private function _checkAuth($api_user,$api_password)
    {
        if((isset($_SERVER['HTTP_X_KEY_API']))){
            $key = $_SERVER['HTTP_X_KEY_API'];
			if($key==self::APPLICATION_KEY)
				$UserApi=UserApi::model()->find('LOWER(username)=?',array(strtolower($api_user)));
				if($UserApi===null || !$UserApi->validatePassword($api_password))
					$this->_sendResponse(401);    
		}else
			$this->_sendResponse(401);
       return true;
    }
	
    private function _checkLogin($params)
    {
		extract($params);
        $user=User::model()->find('LOWER(username)=?',array(strtolower($username)));
        if($user===null || !$user->validatePassword($password))
            $this->_sendResponse(200, CJSON::encode(array('respons'=>'true')));
		
		return $this->_sendResponse(200, CJSON::encode($user));
    } 
	
    private function _getObjectEncoded($model, $array)
    {
        if(isset($_GET['format']))
            $this->format = $_GET['format'];

        if($this->format=='json')
        {
            return CJSON::encode($array);
        }
        elseif($this->format=='xml')
        {
            $result = '<?xml version="1.0">';
            $result .= "\n<$model>\n";
            foreach($array as $key=>$value)
                $result .= "    <$key>".utf8_encode($value)."</$key>\n"; 
            $result .= '</'.$model.'>';
            return $result;
        }
        else
        {
            return;
        }
    } 
	
	private function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        header('Content-type: ' . $content_type);
        if($body != '')
        {
            echo $body;
            exit;
        }else{
            $message = '';
            switch($status)
            {
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }
			
            $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];
			
            $body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
                        <html>
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                                <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
                            </head>
                            <body>
                                <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
                                <p>' . $message . '</p>
                                <hr />
                                <address>' . $signature . '</address>
                            </body>
                        </html>';

            echo $body;
            exit;
        }
    } 
	
	private function _getStatusCodeMessage($status)
    {
        $codes = Array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );

        return (isset($codes[$status])) ? $codes[$status] : '';
    } 
}
?>
