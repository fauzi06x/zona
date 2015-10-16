<section class="content-header">
	<h1>
	Berita
	<small>Tambah Berita</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Yii::app()->baseUrl.'/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?php echo Yii::app()->baseUrl.'/berita'; ?>"><i class="fa fa-newspaper-o"></i> Berita</a></li>
		<li class="active"><i class="fa fa-pencil"></i> Tambah Berita</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-pencil"></i> Tambah Berita</h3>
				</div><!-- /.box-header -->
				<?php
					echo CHtml::beginForm(array('berita/tambah'),'post', array('id'=>'form-tambah','class'=>'form-horizontal','enctype'=>'multipart/form-data'));
				?>
				<div class="box-body">
					<div class="form-group">
						<?php  echo CHtml::activeLabel($model, 'judul', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<?php 
								echo CHtml::activetextField($model,'judul', array('class'=>'form-control', 'placeholder'=>'Judul')); 
								echo '<br>'.CHtml::error($model,'judul', array('class'=>'help-inline help-small no-left-padding')); 
							 ?>
						</div>
					</div>
					<div class="form-group">
						<?php  echo CHtml::activeLabel($model, 'isi', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-9">
							<?php 
							echo CHtml::activeTextArea($model,'isi', array('class'=>'span8 ckeditor')); 
							?>
						</div>
					</div>
					<div class="form-group">
						<?php  echo CHtml::activeLabel($model, 'gambar', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
									<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
								</div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
								<div>
									<span class="btn btn-success btn-file"><span class="fileupload-new">Select image</span>
										<span class="fileupload-exists">Change</span>
										<?php echo CHtml::activefileField($model,'gambar', array('class'=>'default')); ?>
										
									</span>
									<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<div class="col-xs-4 col-xs-push-2">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
					</div>
					<a class="btn btn-warning pull-right" href="<?php echo Yii::app()->baseUrl;?>/berita" ><i class="fa fa-undo"></i> Kembali</a>
				</div>
				<?php echo CHtml::endForm(); ?>
			</div>
		</div>	
	</div>			
</section>
