<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
	<head>
		<base href="#">
		<meta charset="utf-8" />
		<title>AdminCMS</title>
		<?php
			$baseUrl = Yii::app()->baseUrl;
			$baseUrlTemplate = Yii::app()->theme->baseUrl; 
			$cs = Yii::app()->getClientScript();
			Yii::app()->clientScript->registerCoreScript('jquery');
			
			// LOAD CSS
			$cs->registerCssFile($baseUrlTemplate.'/assets/bootstrap/css/bootstrap.min.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/css/metro.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/font-awesome/css/font-awesome.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/css/style.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/css/style_responsive.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/css/style_default.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/uniform/css/uniform.default.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/bootstrap/css/bootstrap.min.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/css/metro.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/bootstrap/css/bootstrap-responsive.min.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/bootstrap-fileupload/bootstrap-fileupload.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/font-awesome/css/font-awesome.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/css/style.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/css/style_responsive.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/css/style_default.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/gritter/css/jquery.gritter.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/chosen-bootstrap/chosen/chosen.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/jquery-tags-input/jquery.tagsinput.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/clockface/css/clockface.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/bootstrap-datepicker/css/datepicker.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/bootstrap-timepicker/compiled/timepicker.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/bootstrap-colorpicker/css/colorpicker.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/data-tables/DT_bootstrap.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/jquery-nestable/jquery.nestable.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/bootstrap-daterangepicker/daterangepicker.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/uniform/css/uniform.default.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/fancybox/source/jquery.fancybox.css');
			
			// LOAD JS
			$cs->registerScriptFile($baseUrlTemplate.'/assets/js/jquery-1.8.3.min.js');  
			$cs->registerScriptFile($baseUrlTemplate.'/assets/js/jquery.form.js');
		?>
		<link rel="shortcut icon" href="favicon.ico" />
	</head>
	<body class="fixed-top">
		<div class="header navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="brand" href="#">
						<!--<img src="<?php echo $baseUrlTemplate; ?>/assets/img/logo.png" alt="logo" style="height:35px;" />-->
					</a>
					<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
						<img src="<?php echo $baseUrlTemplate; ?>/assets/img/menu-toggler.png" alt="" />
					</a>
					<ul class="nav pull-right">
						<li class="dropdown user">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img alt="" src="<?php echo $baseUrlTemplate; ?>/assets/img/avatar1_small.jpg" />
								<span class="username"><?php echo Yii::app()->user->username; ?></span>
								<i class="icon-angle-down"></i>
							</a>
							<ul class="dropdown-menu">
								<li><a href="setting"><i class="icon-user"></i> Setting</a></li>
								<li><a href="setting/password"><i class="icon-user"></i> Change Password</a></li>
								<li class="divider"></li>
								<li><a href="<?php echo $baseUrl; ?>/site/logout"><i class="icon-key"></i> Log Out</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="page-container row-fluid">
			<div class="page-sidebar nav-collapse collapse">
				
				<?php
					//Menu Sidebar
					/*$menu = new Menu;
					$menuList= $menu->menuList(Yii::app()->user->api_user,Yii::app()->user->api_password);
					
					$arrmenu[]=array('label'=>'<div class="sidebar-toggler hidden-phone"></div>');
					$x=1;
					foreach($menuList as $key=>$val){
						if($val['parent_id']==0)
						$arrmenu[$x]=array(
						'label'		=> '<i class="'.$val['icon'].'"></i><span class="title">'.$val['name'].'</span>', 
						'url'		=> array('/'.$val['seo']),
						'active'	=> Yii::app()->controller->id==$val['seo'] ? 1:0,
						);
					$x++;
					}
					$this->widget('zii.widgets.CMenu',array(
						'encodeLabel'=>false,
						'items'=>$arrmenu,
					));*/ 
					
				?>
				<ul>
					<li>
						<div class="sidebar-toggler hidden-phone"></div>
					</li>
					<li class="start <?php if (Yii::app()->controller->id == "dashboard") echo "active"; ?>">
						<a href="<?php echo $baseUrl; ?>/dashboard">
							<i class="icon-home"></i>
							<span class="title">Dashboard</span>
							<?php if (Yii::app()->controller->id == "dashboard") echo '<span class="selected"></span>'; ?>
						</a>
					</li>
					<li class="start <?php if (Yii::app()->controller->id == "page") echo "active"; ?>">
						<a href="<?php echo $baseUrl; ?>/page">
							<i class="icon-file-alt"></i>
							<span class="title">Page</span>
							<?php if (Yii::app()->controller->id == "page") echo '<span class="selected"></span>'; ?>
						</a>
					</li>
					<li class="start <?php if (Yii::app()->controller->id == "news") echo "active"; ?>">
						<a href="<?php echo $baseUrl; ?>/news">
							<i class="icon-file-alt"></i>
							<span class="title">News</span>
							<?php if (Yii::app()->controller->id == "news") echo '<span class="selected"></span>'; ?>
						</a>
					</li>
					<li class="start <?php if (Yii::app()->controller->id == "slider") echo "active"; ?>">
						<a href="<?php echo $baseUrl; ?>/slider">
							<i class="icon-picture"></i>
							<span class="title">Slider</span>
							<?php if (Yii::app()->controller->id == "slider") echo '<span class="selected"></span>'; ?>
						</a>
					</li>
					<li class="has-sub <?php if (in_array(Yii::app()->controller->id, array('maskapai','kereta','hotel'))) echo "active"; ?>">
						<a href="javascript:;">
							<i class="icon-cogs"></i>
							<span class="title">Produk</span>
							<?php if (in_array(Yii::app()->controller->id, array('maskapai','kereta','hotel'))) echo '<span class="selected"></span>'; ?>
							<span class="arrow <?php if (in_array(Yii::app()->controller->id, array('maskapai','kereta','hotel'))) echo "open"; ?>"></span>
						</a>
						<ul class="sub">
							<li><a href="<?php echo $baseUrl; ?>/maskapai">Maskapai</a></li>
							<li><a href="<?php echo $baseUrl; ?>/supplier">Kereta</a></li>
							<li><a href="<?php echo $baseUrl; ?>/supplier">Hotel</a></li>
							<li><a href="<?php echo $baseUrl; ?>/supplier">Kost-kostan</a></li>
						</ul>
					</li>
					<li class="has-sub <?php if (in_array(Yii::app()->controller->id, array('suppliermaskapai','kereta','hotel'))) echo "active"; ?>">
						<a href="javascript:;">
							<i class="icon-cogs"></i>
							<span class="title">Supplier</span>
							<?php if (in_array(Yii::app()->controller->id, array('suppliermaskapai','kereta','hotel'))) echo '<span class="selected"></span>'; ?>
							<span class="arrow <?php if (in_array(Yii::app()->controller->id, array('suppliermaskapai','kereta','hotel'))) echo "open"; ?>"></span>
						</a>
						<ul class="sub">
							<li><a href="<?php echo $baseUrl; ?>/suppliermaskapai">Supplier Maskapai</a></li>
							<li><a href="<?php echo $baseUrl; ?>/supplier">Supplier Kereta</a></li>
							<li><a href="<?php echo $baseUrl; ?>/supplier">Supplier Hotel</a></li>
							<li><a href="<?php echo $baseUrl; ?>/supplier">Supplier Kost-kostan</a></li>
						</ul>
					</li>
					<li class="has-sub <?php if (in_array(Yii::app()->controller->id, array('hppmaskapai','kereta','hotel'))) echo "active"; ?>">
						<a href="javascript:;">
							<i class="icon-cogs"></i>
							<span class="title">Harga Pokok Penjualan</span>
							<?php if (in_array(Yii::app()->controller->id, array('hppmaskapai','kereta','hotel'))) echo '<span class="selected"></span>'; ?>
							<span class="arrow <?php if (in_array(Yii::app()->controller->id, array('hppmaskapai','kereta','hotel'))) echo "open"; ?>"></span>
						</a>
						<ul class="sub">
							<li><a href="<?php echo $baseUrl; ?>/hppmaskapai">HPP Maskapai</a></li>
							<li><a href="<?php echo $baseUrl; ?>/supplier">HPP Kereta</a></li>
							<li><a href="<?php echo $baseUrl; ?>/supplier">HPP Hotel</a></li>
							<li><a href="<?php echo $baseUrl; ?>/supplier">HPP Kost-kostan</a></li>
						</ul>
					</li>
					<li class="start <?php if (Yii::app()->controller->id == "member") echo "active"; ?>">
						<a href="<?php echo $baseUrl; ?>/member">
							<i class="icon-home"></i>
							<span class="title">Member</span>
							<?php if (Yii::app()->controller->id == "member") echo '<span class="selected"></span>'; ?>
						</a>
					</li>
					<li class="has-sub <?php if (in_array(Yii::app()->controller->id, array('hppmaskapai','kereta','hotel'))) echo "active"; ?>">
						<a href="javascript:;">
							<i class="icon-cogs"></i>
							<span class="title">Member</span>
							<?php if (in_array(Yii::app()->controller->id, array('hppmaskapai','kereta','hotel'))) echo '<span class="selected"></span>'; ?>
							<span class="arrow <?php if (in_array(Yii::app()->controller->id, array('hppmaskapai','kereta','hotel'))) echo "open"; ?>"></span>
						</a>
						<ul class="sub">
							<li><a href="<?php echo $baseUrl; ?>/memberPremium">Member Premium</a></li>
							<li><a href="<?php echo $baseUrl; ?>/memberAgen">Member Agen</a></li>
						</ul>
					</li>
					<li class="has-sub <?php if (Yii::app()->controller->id == "tools") echo "active"; ?>">
						<a href="javascript:;">
							<i class="icon-cogs"></i>
							<span class="title">Tools</span>
							<?php if (Yii::app()->controller->id == "tools") echo '<span class="selected"></span>'; ?>
							<span class="arrow <?php if (Yii::app()->controller->id == "setting") echo "open"; ?>"></span>
						</a>
						<ul class="sub">
							<li><a href="<?php echo $baseUrl; ?>/address">Address</a></li>
							<li><a href="<?php echo $baseUrl; ?>/supplier">Supplier</a></li>
							<li><a href="setting">Hpp</a></li>
							<li><a href="setting/seo">Airline</a></li>
							<li><a href="wisdom">Users</a></li>
							<li><a href="wisdom">Bonuses</a></li>
						</ul>
					</li>
					<li class="has-sub <?php if (Yii::app()->controller->id == "tools") echo "active"; ?>">
						<a href="javascript:;">
							<i class="icon-cogs"></i>
							<span class="title">Member</span>
							<?php if (Yii::app()->controller->id == "setting") echo '<span class="selected"></span>'; ?>
							<span class="arrow <?php if (Yii::app()->controller->id == "setting") echo "open"; ?>"></span>
						</a>
						<ul class="sub">
							<li><a href="setting">Member List</a></li>
							<li><a href="setting/seo">Member Deposit</a></li>
							<li><a href="setting">Member Valid</a></li>
							<li><a href="setting/seo">Booking</a></li>
						</ul>
					</li>
					<li class="has-sub <?php if (Yii::app()->controller->id == "tools") echo "active"; ?>">
						<a href="javascript:;">
							<i class="icon-cogs"></i>
							<span class="title">Report</span>
							<?php if (Yii::app()->controller->id == "setting") echo '<span class="selected"></span>'; ?>
							<span class="arrow <?php if (Yii::app()->controller->id == "setting") echo "open"; ?>"></span>
						</a>
						<ul class="sub">
							<li><a href="setting">Supplier Mutation</a></li>
							<li><a href="setting/seo">Mutation</a></li>
						</ul>
					</li>
					<li class="has-sub <?php if (Yii::app()->controller->id == "setting") echo "active"; ?>">
						<a href="javascript:;">
							<i class="icon-cogs"></i>
							<span class="title">Setting</span>
							<?php if (Yii::app()->controller->id == "setting") echo '<span class="selected"></span>'; ?>
							<span class="arrow <?php if (Yii::app()->controller->id == "setting") echo "open"; ?>"></span>
						</a>
						<ul class="sub">
							<li><a href="setting">General Setting</a></li>
							<li><a href="setting/seo">SEO Setting</a></li>
							<li><a href="setting/footer">Footer Setting</a></li>
							<li><a href="setting/widget_home">Home Widget</a></li>
							<li><a href="setting/sidebar">Sidebar</a></li>
							<li><a href="setting/password">Change Password</a></li>
						</ul>
					</li>
				</ul>	
			</div>
			<div class="page-content">
				<div class="container-fluid">
					<?php echo $content; ?>
				</div>
			</div>
		</div>
		<div class="footer">
			<div class="span pull-right">
				<span class="go-top"><i class="icon-angle-up"></i></span>
			</div>
		</div>
		<?php
			// LOAD JS
			$cs->registerScriptFile($baseUrlTemplate.'/assets/ckeditor/ckeditor.js'); 
			$cs->registerScriptFile($baseUrlTemplate.'/assets/breakpoints/breakpoints.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/bootstrap/js/bootstrap.min.js');   
			$cs->registerScriptFile($baseUrlTemplate.'/assets/bootstrap-fileupload/bootstrap-fileupload.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/js/jquery.blockui.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/js/jquery.cookie.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/chosen-bootstrap/chosen/chosen.jquery.min.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/uniform/jquery.uniform.min.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/bootstrap-datepicker/js/bootstrap-datepicker.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/bootstrap-daterangepicker/date.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/bootstrap-daterangepicker/daterangepicker.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/bootstrap-timepicker/js/bootstrap-timepicker.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/jquery-tags-input/jquery.tagsinput.min.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/clockface/js/clockface.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/jquery-validation/dist/jquery.validate.min.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/jquery-nestable/jquery.nestable.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/data-tables/jquery.dataTables.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/data-tables/DT_bootstrap.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/fancybox/source/jquery.fancybox.js');
			$cs->registerScriptFile($baseUrlTemplate.'/assets/js/app.js');
			
		?>
		
		<script>
			jQuery(document).ready(function() {
				App.setPage("form_validation");
				App.setPage("table_managed");
				
				App.init();
			});
		</script>
	</body>
</html>