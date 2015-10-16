<section class="content-header">
	<h1>
	Profit Share  Maskapai
	<small>Ubah Maskapai</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Yii::app()->baseUrl.'/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?php echo Yii::app()->baseUrl.'/profitShareMaskapai'; ?>"><i class="fa fa-plane"></i> Profit Share  Maskapai</a></li>
		<li class="active"><i class="fa fa-pencil"></i> Ubah Profit Share  Maskapai</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-pencil"></i> Ubah Profit Share  Maskapai</h3>
				</div><!-- /.box-header -->
				<?php
					echo CHtml::beginForm(array('profitShareMaskapai/ubah/'.$profitShareMaskapai['id_profit_share_maskapai']),'post', array('id'=>'form-bah','class'=>'form-horizontal','enctype'=>'multipart/form-data'));
				?>
				<div class="box-body">
					<div class="form-group" id="for_nama_maskapai">
						<?php  echo CHtml::activeLabel($model, 'id_maskapai', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<select id="nama_maskapai" name="ProfitShareMaskapai[id_maskapai]" class="form-control">
								<option value="">-- Pilih salah satu--</option>
								<?php
									foreach($maskapai as $key=>$val){
										if($val['id_maskapai']==$profitShareMaskapai['id_maskapai'])
											$selected = 'selected';
										else
											$selected = '';
										echo '<option value="'.$val['id_maskapai'].'" '.$selected.'>'.$val['nama_maskapai'].'</option>';
									}
								?>
							</select>
							<?php 
								echo CHtml::error($model,'id_maskapai', array('id'=>'error_nama_maskapai', 'class'=>'label-error')); 
							 ?>
						</div>
					</div>
					<div class="form-group" id="for_kelas_maskapai">
						<?php  echo CHtml::activeLabel($model, 'kelas_maskapai', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<?php 
								echo CHtml::activetextField($model,'kelas_maskapai', array('value'=>$profitShareMaskapai['kelas_maskapai'], 'class'=>'form-control', 'placeholder'=>'Kelas Maskapai')); 
								echo '<br>'.CHtml::error($model,'kelas_maskapai', array('id'=>'error_url_maskapai', 'class'=>'label-error')); 
							 ?>
						</div>
					</div>
					<div class="form-group" id="for_full_share">
						<?php  echo CHtml::activeLabel($model, 'full_share', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-2">
							<div class="input-group">
							<?php 
								echo CHtml::activetextField($model,'full_share', array('value'=>$profitShareMaskapai['full_share'], 'class'=>'form-control', 'placeholder'=>'Persentase HPP'));
							?>
							<span class="input-group-addon">%</span>
							</div>
							<?php
								echo CHtml::error($model,'full_share', array('id'=>'error_full_share', 'class'=>'label-error')); 
							?>
						</div>
					</div>
					<div class="form-group">
						<?php  echo CHtml::activeLabel($model, 'tipe_share', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-3">
							<select name="ProfitShareMaskapai[tipe_share]" class="form-control">
								<option value=0 <?php echo $profitShareMaskapai['tipe_share']==0 ? 'selected':''; ?>>Diskon</option>
								<option value=1 <?php echo $profitShareMaskapai['tipe_share']==1 ? 'selected':''; ?>>Profit</option>
							</select>
						</div>
					</div>
					<div class="form-group" id="for_url_maskapai">
						<?php  echo CHtml::activeLabel($model, 'nilai_share', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-2">
							<div class="input-group">
							<?php 
								echo CHtml::activetextField($model,'nilai_share', array('value'=>$profitShareMaskapai['nilai_share'], 'class'=>'form-control', 'placeholder'=>'Persentase Share'));
							?>
							<span class="input-group-addon">%</span>
							</div>
							<?php
								echo CHtml::error($model,'nilai_share', array('id'=>'error_nilai_share', 'class'=>'label-error')); 
							?>
							
						</div>
					</div>
				</div>
				<div class="box-footer">
					<div class="col-xs-4 col-xs-push-2">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
					</div>
					<a class="btn btn-warning pull-right" href="<?php echo Yii::app()->baseUrl;?>/profitShareMaskapai" ><i class="fa fa-undo"></i> Kembali</a>
				</div>
				<?php echo CHtml::endForm(); ?>
			</div>
		</div>	
	</div>			
</section>

<script>
$(document).ready(function(){


	if ($('#error_nama_maskapai').html())
		$("#for_nama_maskapai").addClass('has-error');
	if ($('#error_url_maskapai').html())
		$("#for_url_maskapai").addClass('has-error');
	
	$('#HPPMaskapai_akun_supp_maskapai').keyup(function(){
		$("#for_akun_supp_maskapai").removeClass('has-error');
		$("#error_akun_supp_maskapai").remove();
	});
	$('#HPPMaskapai_nama_maskapai').change(function(){
		$("#for_nama_maskapai").removeClass('has-error');
		$("#error_nama_maskapai").remove();
	});
	$('#HPPMaskapai_url_maskapai').keyup(function(){
		$("#for_url_maskapai").removeClass('has-error');
		$("#error_url_maskapai").remove();
	});

	
});
</script>
