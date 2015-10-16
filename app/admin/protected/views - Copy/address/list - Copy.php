<script type="text/javascript">
function del(id) {
	if(id!='')
		url = '<?php echo Yii::app()->baseUrl.'/address/delete/'; ?>' + id;
	return window.location.replace(url);
}
</script>

<div class="row-fluid">
	<div class="span12">
		<h3 class="Address-title">Address</h3>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box green">
			<div class="portlet-title">
				<h4><i class="icon-file-alt"></i>All Address</h4>
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
						<a class="btn blue" href="<?php echo Yii::app()->baseUrl ?>/address/add"><i class="icon-pencil"></i> Add Address</a>
					</div>
				</div>
				<table class="table table-striped table-bordered table-hover" id="table">
					<thead align="center">
						<tr>
							<th width="18">No</th>
							<th>Kec</th>
							<th>Kab</th>
							<th>Prov</th>
							<th>Code</th>
							<th width="150">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if($address): $no = 0; ?>
						<?php foreach($address as $key=>$val): $no++; ?>
						<tr id="<?php echo $val['id']; ?>">
							<td><?php echo $no; ?></td>
							<td><?php echo $val['kec']; ?></td>
							<td><?php echo $val['kab']; ?></td>
							<td><?php echo $val['prov']; ?></td>
							<td><?php echo $val['code']; ?></td>
							<td>
								<a class="btn mini green" href="<?php echo Yii::app()->baseUrl.'/address/update/'.$val['id']; ?>"><i class="icon-edit"></i>Edit</a> 
								<a class="btn mini red Del" href="javascript:del('<?php echo $val['id']; ?>');" onclick="return confirm('Are you sure?');"><i class="icon-remove"></i>Delete</a>
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