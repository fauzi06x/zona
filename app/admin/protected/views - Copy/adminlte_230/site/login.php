
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
				</div><!-- /.box-body -->
				<div class="box-footer">
				<button type="submit" class="btn btn-info pull-right">Sign in</button>
				</div><!-- /.box-footer -->
			<?php $this->endWidget(); ?>
		</div><!-- /.box -->
	</div>
</div>
</div>

<script>
$(document).ready(function(){
	var usererror = $('#LoginForm_username_em_').attr('style');
	if (usererror != 'display:none'){
		$("#usernameID").addClass('has-error');
	}
	var passerror = $('#LoginForm_password_em_').attr('style');
	if (passerror != 'display:none'){
		$("#passwordID").addClass('has-error');
	}
	$('#LoginForm_username').keyup(function(){
		$("#usernameID").removeClass('has-error');
		$('#LoginForm_username_em_').hide();
		$('#LoginForm_errorAll_em_').remove();
	});
	$('#LoginForm_password').keyup(function(){
		$("#passwordID").removeClass('has-error');
		$('#LoginForm_password_em_').hide();
		$('#LoginForm_errorAll_em_').remove();
	});
	$('button.close').click(function(){
		$('input').removeAttr('value');
	});
	
});
</script>
