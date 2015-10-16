<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Login | Administrator</title>
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
		<div id="main-wrapper">
			<div class="row">
				<div class="col-md-4 center">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Login Administrator</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<?php 
							$form=$this->beginWidget('CActiveForm', array(
									'id'=>'login-form',
									'enableAjaxValidation'=>false,
									'enableClientValidation'=>true,
									'htmlOptions'=>array(
										'class'=>'form-horizontal',
									),
									'clientOptions'=>array(
										'validateOnSubmit'=>true,
									),
							)); 
						?>
						<?php echo $form->error($model,'errorAll',array('class'=>'alert alert-error')); ?>
							<div class="box-body">
								<div class="form-group" id="usernameID">
									<?php echo $form->labelEx($model,'email', array('class'=>'col-sm-3 control-label')); ?>
									<div class="col-sm-8">
										<?php echo $form->textField($model,'username', array('class'=>'form-control', 'placeholder'=>'Username')); ?>
										<?php echo $form->error($model,'username', array('class'=>'label-error')); ?>
									</div>
									
								</div>
								<div class="form-group" id="passwordID">
									<?php echo $form->labelEx($model,'Password', array('class'=>'col-sm-3 control-label')); ?>
									<div class="col-sm-8">
										<?php echo $form->passwordField($model,'password', array('class'=>'form-control', 'placeholder'=>'Password')); ?>
										<?php echo $form->error($model,'password', array('class'=>'label-error')); ?>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<div class="checkbox">
											<label><input type="checkbox"> Remember me</label>
										</div>
									</div>
								</div>
							</div>
							<div class="box-footer">
							<button type="submit" class="btn btn-info pull-right">Sign in</button>
							</div>
						<?php $this->endWidget(); ?>
					</div>
				</div>
			</div>
		</div>
		<script>
		
			$(document).ready(function(){
				var jQuery = $.noConflict(true);
				
				var usererror = $('#Users_username_em_').attr('style');
				if (usererror != 'display:none'){
					alert(usererror);
					$("#usernameID").addClass('has-error');
				}

				var passerror = $('#Users_password_em_').attr('style');
				if (passerror != 'display:none'){
					$("#passwordID").addClass('has-error');
				}
				$('#Users_username').keyup(function(){
					$("#usernameID").removeClass('has-error');
					$('#Users_username_em_').hide();
					$('#Users_errorAll_em_').remove();
				});
				$('#Users_password').keyup(function(){
					$("#passwordID").removeClass('has-error');
					$('#Users_password_em_').hide();
					$('#Users_errorAll_em_').remove();
				});
				$('button.close').click(function(){
					$('input').removeAttr('value');
				});
				
			});
			
		</script>
			
			<script src="<?php echo $baseUrl; ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
	</body>
	
	<?php  

		// Yii::app()->clientScript->registerScript('test', "
			// var jQuery132 = $.noConflict(true);
		// ");

		// $cs->registerScriptFile($baseUrl.'/assets/plugins/jQuery/jQuery-2.1.4.min.js');
		// $cs->registerScriptFile($baseUrl.'/assets/bootstrap/js/bootstrap.min.js');
		// $cs->registerScriptFile($baseUrl.'/assets/plugins/fastclick/fastclick.min.js');
		// $cs->registerScriptFile($baseUrl.'/assets/dist/js/app.min.js');
		// $cs->registerScriptFile($baseUrl.'/assets/dist/js/demo.js');
		// Yii::app()->clientScript->registerScript('test', "
			// var jQuery132 = $.noConflict(true);
		// ");
	?>

</html>
