<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
	<head>
		<meta charset="utf-8" />
		<title>Login | AdminCMS</title>
		<meta content="width=device-width, initial-scale=1.0" name="viewport" />
		<meta name="author" content="Irfan Fauzi" />
		<meta name="contact" content="fauzi06x@gmail.com" />
		<meta name="application-name" content="VelkyCMS" />
		<meta name="generator" content="FauziCMS" />
		<?php
		  $baseUrl = Yii::app()->theme->baseUrl; 
		  $cs = Yii::app()->getClientScript();
		  Yii::app()->clientScript->registerCoreScript('jquery');
		?>
		<?php  
			$cs->registerCssFile($baseUrl.'/assets/bootstrap/css/bootstrap.min.css');
			$cs->registerCssFile($baseUrl.'/assets/css/metro.css');
			$cs->registerCssFile($baseUrl.'/assets/font-awesome/css/font-awesome.css');
			$cs->registerCssFile($baseUrl.'/assets/css/style.css');
			$cs->registerCssFile($baseUrl.'/assets/css/style_responsive.css');
			$cs->registerCssFile($baseUrl.'/assets/css/style_default.css');
			$cs->registerCssFile($baseUrl.'/assets/uniform/css/uniform.default.css');
		?>
		<link rel="shortcut icon" href="template/favicon.ico" />
	</head>
	<style>
	.form-actions{
		background-color:#e8e9e9 !important;	
	}
	</style>
	<body class="login">
		<div class="logo">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/administrator.png" alt="" width="200" height="200" /> 
		</div>
		<div class="content">
			<?php echo $content; ?>
		</div>
		<div class="copyright">
		</div>
		<?php  
			$cs->registerScriptFile($baseUrl.'/assets/js/jquery-1.8.3.min.js');
			$cs->registerScriptFile($baseUrl.'/assets/bootstrap/js/bootstrap.min.js');
			$cs->registerScriptFile($baseUrl.'/assets/uniform/jquery.uniform.min.js');
			$cs->registerScriptFile($baseUrl.'/assets/jquery-validation/dist/jquery.validate.min.js');
			$cs->registerScriptFile($baseUrl.'/assets/js/jquery.blockui.js');
			$cs->registerScriptFile($baseUrl.'/assets/js/jquery.form.js');
			$cs->registerScriptFile($baseUrl.'/assets/js/jquery.pulsate.min.js');
			$cs->registerScriptFile($baseUrl.'/assets/js/app.js');
		?>
		
		<script>
			jQuery(document).ready(function() {
				App.initLogin();
			});
		</script>
	</body>
</html>
