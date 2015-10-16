<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<?php 
	$form=$this->beginWidget('CActiveForm', array(
			'id'=>'login-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
	)); 
?>
	<?php echo $form->error($model,'errorAll',array('class'=>'alert alert-error')); ?>
	
	<h3 class="form-title">Administrator Login</h3>
	<div class="control-group" id="usernameID">
		<?php echo $form->labelEx($model,'username', array('class'=>'control-label visible-ie8 visible-ie9')); ?>
		<div class="controls">
			<div class="input-icon left">
				<i class="icon-user"></i>
				<?php echo $form->textField($model,'username', array('class'=>'m-wrap placeholder-no-fix', 'placeholder'=>'Username')); ?>
			</div>
			<?php echo $form->error($model,'username', array('class'=>'help-inline help-small no-left-padding')); ?>
		</div>
	</div>
	<div class="control-group" id="passwordID">
		<?php echo $form->labelEx($model,'Password', array('class'=>'control-label visible-ie8 visible-ie9')); ?>
		
		<div class="controls">
			<div class="input-icon left">
				<i class="icon-lock"></i>
				<?php echo $form->passwordField($model,'password', array('class'=>'m-wrap placeholder-no-fix', 'placeholder'=>'Password')); ?>
			</div>
			<?php echo $form->error($model,'password', array('class'=>'help-inline help-small no-left-padding')); ?>
		</div>
	</div>
	<div class="form-actions">
	<button type="submit" class="btn green pull-right">
						Login <i class="m-icon-swapright m-icon-white"></i>
					</button>
		
		<?php //echo CHtml::submitButton('Login',array('class'=>'initLogin')); ?>          
	</div>
<?php $this->endWidget(); ?>

<script>
$(document).ready(function(){
	var usererror = $('#LoginForm_username_em_').attr('style');
	if (usererror != 'display:none'){
		$("#usernameID").addClass('error');
	}
	var passerror = $('#LoginForm_password_em_').attr('style');
	if (passerror != 'display:none'){
		$("#passwordID").addClass('error');
	}
	var usererror = $('#LoginForm_errorAll_em_').attr('style');
	if (usererror != 'display:none'){
		$(".alert").pulsate();
	}
	$('#LoginForm_username').keyup(function(){
		$("#usernameID").removeClass('error');
		$('#LoginForm_username_em_').hide();
		$('#LoginForm_errorAll_em_').remove();
	});
	$('#LoginForm_password').keyup(function(){
		$("#passwordID").removeClass('error');
		$('#LoginForm_password_em_').hide();
		$('#LoginForm_errorAll_em_').remove();
	});
	
});
</script>
