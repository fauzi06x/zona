<script type="text/javascript">
function del(id) {
	if(id!='')
		url = '<?php echo Yii::app()->baseUrl.'/memberPremium/delete/'; ?>' + id;
	return window.location.replace(url);
}
</script>
<?php 
	
	
?>
<div class="row-fluid">
	<div class="span12">
		<h3 class="member-title">Tipe Agen</h3>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box green">
			<div class="portlet-title">
				<h4><i class="icon-file-alt"></i>Semua Tipe dari <?php echo $memberPremium['nama_lengkap']; ?></h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body">
				<?php if(Yii::app()->user->hasFlash('success')):?>
					<div class="message">
						<div class="alert alert-success">
							<button data-dismiss="alert" class="close"></button>
							<strong>Success!</strong> <?php echo Yii::app()->user->getFlash('success'); ?>
						</div>
					</div>
				<?php endif;?>
				<div class="clearfix">
					<div class="btn-group">
						<a class="btn blue" href="<?php echo Yii::app()->baseUrl ?>/member/add"><i class="icon-pencil"></i> Tambah Member</a>
					</div>
				</div>
				<table class="table table-striped table-bordered table-hover" id="table">
					<thead align="center">
						<tr>
							<th width="90">No</th>
							<th>Nama Tipe</th>
							<th width="150">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if($tipeAgen): $no = 0; ?>
						<?php foreach($tipeAgen as $key=>$val): $no++; ?>
						<tr id="<?php echo $val['id_tipe_agen']; ?>">
							<td><?php echo $no; ?></td>
							<td><?php echo $val['nama_tipe']; ?></td>
							<td>
								<a class="btn mini blue" title="Lihat Member Agen" href="<?php echo Yii::app()->baseUrl.'/member/member_agen/'.$val['id_member_premium']; ?>"><i class="icon-search"></i>Member Agen</a>
							</td>
						</tr>
						<?php endforeach; ?>
						<?php else: ?>
						<tr>
							<td colspan="6"><center>Data not found.</center></td>
						</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>