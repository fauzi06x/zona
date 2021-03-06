<?php 
$baseUrl = Yii::app()->baseUrl;
?>

<div class="row-fluid">
	<div class="span12">
		<h3 class="news-title">Update News</h3>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-plus"></i>Update News</h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body form">
				<?php
					echo CHtml::beginForm(array('news/update/'.$news['id']),'post', array('id'=>'add-form','class'=>'form-horizontal','enctype'=>'multipart/form-data'));
				?>
					<div class="control-group">
						<?php  echo CHtml::activeLabel($model, 'Title : ', array('class'=>'control-label'));?>
						<div class="controls">
							<?php echo CHtml::activetextField($model,'title', array('class'=>'m-wrap placeholder-no-fix', 'placeholder'=>'Title','value'=>$news['title'])); ?>
							<?php echo '<br>'.CHtml::error($model,'title', array('class'=>'help-inline help-small no-left-padding')); ?>
						</div>
					</div>
					<div class="control-group">
						<?php  echo CHtml::activeLabel($model, 'Content : ', array('class'=>'control-label'));?>
						<div class="controls">
							<?php echo CHtml::activeTextArea($model,'content', array('class'=>'span8 ckeditor', 'value'=>$news['content'])); ?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Image</label>
						<div class="controls">
							<div class="fileupload fileupload-<?php if($news['image'] != ''){ echo 'exists'; } else { echo 'new'; } ?>" data-provides="fileupload">
								<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
									<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
								</div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
									<img src="../../../../uploads/news/<?php echo $news['image']; ?>" alt="" />
								</div>
								<div>
									<span class="btn btn-file"><span class="fileupload-new">Select image</span>
										<span class="fileupload-exists">Change</span>
										<?php echo CHtml::activefileField($model,'image', array('class'=>'default')); ?>
										
									</span>
									<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
								</div>
							</div>
						</div>
					</div>
					<div class="form-actions">
						<button class="btn green"><i class="icon-save"></i> Save</button>
						<a class="btn red" href="<?php echo Yii::app()->baseUrl;?>/news"><i class="icon-remove-sign"></i> Cancel</a>
					</div>
				<?php echo CHtml::endForm(); //$this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>