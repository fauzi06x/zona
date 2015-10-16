<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>AdminLTE 2 | General Form Elements</title>
		<?php
		  $baseUrl = Yii::app()->theme->baseUrl; 
		  $cs = Yii::app()->getClientScript();
		  // Yii::app()->clientScript->registerCoreScript('jquery');
		?>
		<?php  
			$cs->registerCssFile($baseUrl.'/assets/bootstrap/css/bootstrap.min.css');
			$cs->registerCssFile('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
			$cs->registerCssFile('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');
			$cs->registerCssFile($baseUrl.'/assets/dist/css/AdminLTE.min.css');
			$cs->registerCssFile($baseUrl.'/assets/dist/css/skins/_all-skins.min.css');
			$cs->registerCssFile($baseUrl.'/assets/dist/css/styleCostum.css');
		?>
		
	</head>
	
	<body class="login hold-transition skin-blue sidebar-mini">
		
		
			<?php echo $content; ?>
		
		<?php  
			$cs->registerScriptFile($baseUrl.'/assets/plugins/jQuery/jQuery-2.1.4.min.js');
			$cs->registerScriptFile($baseUrl.'/assets/bootstrap/js/bootstrap.min.js');
			$cs->registerScriptFile($baseUrl.'/assets/plugins/fastclick/fastclick.min.js');
			$cs->registerScriptFile($baseUrl.'/assets/dist/js/app.min.js');
			$cs->registerScriptFile($baseUrl.'/assets/dist/js/demo.js');
		?>
	</body>
</html>
