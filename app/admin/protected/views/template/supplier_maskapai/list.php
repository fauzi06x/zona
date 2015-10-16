<script type="text/javascript">
function del(id) {
	if(id!='')
		url = '<?php echo Yii::app()->baseUrl.'/supplier_maskapai/delete/'; ?>' + id;
	return window.location.replace(url);
}
</script>

<div class="row-fluid">
	<div class="span12">
		<h3 class="supplier_maskapai-title">Supplier Maskapai</h3>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box green">
			<div class="portlet-title">
				<h4><i class="icon-file-alt"></i>All supplier Maskapai</h4>
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
						<a class="btn blue" href="<?php echo Yii::app()->baseUrl ?>/supplier_maskapai/add"><i class="icon-pencil"></i> Add Mupplier Maskapai</a>
					</div>
				</div>
				<table class="table table-striped table-bordered table-hover" id="table">
					<thead align="center">
						<tr>
							<th width="18">No</th>
							<th>Nama Akun</th>
							<th>Nama Maskapai</th>
							<th>Saldo</th>
							
							<th width="150">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if($supplier_maskapai): $no = 0; ?>
						<?php foreach($supplier_maskapai as $key=>$val): $no++; ?>
						<tr id="<?php echo $val['id_supp_maskapai']; ?>">
							<td><?php echo $no; ?></td>
							<td><?php echo $val['akun_supp_maskapai']; ?></td>
							<td><?php echo $val['id_maskapai']; ?></td>
							<td><?php echo $val['saldo_supp_maskapai']; ?></td>
							<td>
								<a class="btn mini green" href="<?php echo Yii::app()->baseUrl.'/supplier_maskapai/update/'.$val['id_supp_maskapai']; ?>"><i class="icon-edit"></i>Edit</a> 
								<a class="btn mini red Del" href="javascript:del('<?php echo $val['id_supp_maskapai']; ?>');" onclick="return confirm('Are you sure?');"><i class="icon-remove"></i>Delete</a>
							</td>
						</tr>
						<?php endforeach; ?>
						<?php else: ?>
						<tr>
							<td colspan="4"><center>Data not found.</center></td>
						</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>