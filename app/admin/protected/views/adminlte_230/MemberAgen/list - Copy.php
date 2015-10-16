
<script type="text/javascript">
function del(id) {
	if(id!='')
		url = '<?php echo Yii::app()->baseUrl.'/memberPremium/delete/'; ?>' + id;
	return window.location.replace(url);
}
</script>
<?php 
	$tipeAgen = new TipeAgen;
	$tipeAgen_list = $tipeAgen->TipeAgen_list();
	
?>
<div class="row-fluid">
	<div class="span12">
		<h3 class="member-title">Member Agen</h3>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box green">
			<div class="portlet-title">
				<h4><i class="icon-file-alt"></i>Semua Member Agen</h4>
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
						<!--<a class="btn blue" href="<?php echo Yii::app()->baseUrl ?>/member/add"><i class="icon-pencil"></i> Tambah Member</a>-->
					</div>
				</div>
				<table class="table table-striped table-bordered table-hover" id="table">
					<thead align="center">
						<tr>
							<th width="90">Member ID</th>
							<th>Nama Member</th>
							<th>Tipe Agen</th>
							<th>Upline Premium</th>
							<th align="center">Status</th>
							<th width="150">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if($memberAgen): $no = 0; ?>
						<?php foreach($memberAgen as $key=>$val): $no++; 
						$modelMemberPremium = new MemberPremium;
						$memberPremium = $modelMemberPremium->MemberPremium_view($val['id_member_premium']);
						?>
						<tr id="<?php echo $val['id_member_agen']; ?>">
							<td><?php echo $no; ?></td>
							<td><?php echo $val['nama_lengkap']; ?></td>
							<td><?php echo $val['nama_tipe']; ?></td>
							<td><?php echo $memberPremium['nama_lengkap']; ?></td>
							<td><?php echo $val['status']==1 ? '<span class="label label-success">Aktif</span>':'<span class="label label-danger">Tidak Aktif</span>'; ?></td>
							<td>
								<a class="btn mini blue" title="Lihat Tipe Agen" href="<?php echo Yii::app()->baseUrl.'/memberPremium/tipeagen/'.$val['id_member_agen']; ?>"><i class="icon-search"></i>Tipe Agen</a>
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