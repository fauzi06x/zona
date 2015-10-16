<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> 
<html lang="en"> <!--<![endif]-->
	<head>
		<base href="#">
		<meta charset="utf-8" />
		<title><?php echo ucfirst(Yii::app()->controller->id); ?> | Administrator</title>
		<?php
			
			$baseUrl = Yii::app()->baseUrl;
			$baseUrlTemplate = Yii::app()->theme->baseUrl; 
			$cs = Yii::app()->getClientScript();
			// LOAD CSS
			
			 // <!-- Bootstrap 3.3.5 -->
			$cs->registerCssFile($baseUrlTemplate.'/assets/bootstrap/css/bootstrap.min.css');
			
			// <!-- Font Awesome -->
			$cs->registerCssFile('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
			
			// <!-- Ionicons -->
			$cs->registerCssFile('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/plugins/datatables/dataTables.bootstrap.css');	
			
			// <!-- Theme style -->
			$cs->registerCssFile($baseUrlTemplate.'/assets/dist/css/AdminLTE.min.css');
			
			// <!-- AdminLTE Skins. Choose a skin from the css/skins
				 // folder instead of downloading all of them to reduce the load. -->
			$cs->registerCssFile($baseUrlTemplate.'/assets/dist/css/skins/_all-skins.min.css');	 
			// <!-- iCheck -->
			$cs->registerCssFile($baseUrlTemplate.'/assets/plugins/iCheck/flat/blue.css');	
			
			// <!-- Morris chart -->
			$cs->registerCssFile($baseUrlTemplate.'/assets/plugins/morris/morris.css');	
			// <!-- jvectormap -->
			$cs->registerCssFile($baseUrlTemplate.'/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css');
			// <!-- Date Picker -->
			$cs->registerCssFile($baseUrlTemplate.'/assets/plugins/datepicker/datepicker3.css');
			// <!-- Daterange picker -->
			$cs->registerCssFile($baseUrlTemplate.'/assets/plugins/daterangepicker/daterangepicker-bs3.css');
			// <!-- bootstrap -->
			$cs->registerCssFile($baseUrlTemplate.'/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/dist/css/styleCostum.css');
			// $cs->registerCssFile($baseUrlTemplate.'/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css');
			$cs->registerCssFile($baseUrlTemplate.'/assets/plugins/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css');
			
		$init[] = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/assets/plugins/jQuery/jQuery-2.1.4.min.js');
		$init[] = Yii::app()->getClientScript()->registerScriptFile('https://code.jquery.com/ui/1.11.4/jquery-ui.min.js');
		?>
		<script>
		$.widget.bridge('uibutton', $.ui.button);
		</script>
		<script src="<?php echo $baseUrlTemplate; ?>/assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<link rel="shortcut icon" href="favicon.ico" />
	</head>
	<body class="hold-transition skin-green sidebar-mini">
		<div class="wrapper">
			<header class="main-header">
				<!-- Logo -->
				<a href="index2.html" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"><b>A</b>SB</span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"><b>Admin</b>SIBISNIS</span>
				</a>
				<!-- Header Navbar: style can be found in header.less -->
				<nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
						<!-- Messages: style can be found in dropdown.less-->
							<li class="dropdown messages-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-envelope-o"></i>
									<span class="label label-success">0</span>
								</a>
								<ul class="dropdown-menu">
									<li class="header">You have 0 messages</li>
									<li>
										<!-- inner menu: contains the actual data -->
										<ul class="menu">
										</ul>
									</li>
									<li class="footer"><a href="#">See All Messages</a></li>
								</ul>
							</li>
							<!-- Notifications: style can be found in dropdown.less -->
							<li class="dropdown notifications-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-bell-o"></i>
								<span class="label label-warning">1</span>
								</a>
								<ul class="dropdown-menu">
									<li class="header">
										You have 1 notifications
									</li>
										<li>
										<!-- inner menu: contains the actual data -->
										<ul class="menu">
											<li>
												<a href="#">
												<i class="fa fa-users text-aqua"></i> 5 new members joined today
												</a>
											</li>
										</ul>
									</li>
									<li class="footer"><a href="#">View all</a></li>
								</ul>
							</li>
							<!-- User Account: style can be found in dropdown.less -->
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="<?php echo $baseUrlTemplate; ?>/assets/image/dummy.JPG" class="img-circle" alt="User Image" style="border-radius: 50%;float: left;height: 25px;margin-right: 10px;margin-top: -2px;width: 25px;">
									<span class="hidden-xs"><?php echo ucfirst(Yii::app()->user->username); ?></span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header">
									
										<img src="<?php echo $baseUrlTemplate; ?>/assets/image/dummy.JPG" class="img-circle" alt="User Image">
										<p>
											<?php echo ucfirst(Yii::app()->user->username); ?>
										</p>
									</li>
									<!-- Menu Footer-->
									<li class="user-footer">
										<div class="pull-left">
											<a href="#" class="btn btn-default btn-flat">Profile</a>
										</div>
										<div class="pull-right">
											<a href="<?php echo $baseUrl; ?>/site/logout" class="btn btn-default btn-flat">Sign out</a>
										</div>
									</li>
								</ul>
							</li>
							<!-- Control Sidebar Toggle Button -->	
						</ul>
					</div>
				</nav>
			</header>
			<!-- Left side column. contains the logo and sidebar -->
			<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
				<section class="sidebar">
				<!-- Sidebar user panel -->
					<div class="user-panel">
						<div class="pull-left image">
							<img src="<?php echo $baseUrlTemplate; ?>/assets/image/dummy.JPG" class="img-circle" alt="User Image">
						</div>
						<div class="pull-left info">
							<p><?php echo ucfirst(Yii::app()->user->username); ?></p>
							<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
						</div>
					</div>
					<!-- search form -->
					<form action="#" method="get" class="sidebar-form">
						<div class="input-group">
							<input type="text" name="q" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
							<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</form>
					<!-- /.search form -->
					<!-- sidebar menu: : style can be found in sidebar.less -->
					<ul class="sidebar-menu">
						<li class="header">MENU UTAMA</li>
						<li class="<?php if (Yii::app()->controller->id == "dashboard") echo "active"; ?>">
							<a href="<?php echo $baseUrl; ?>/dashboard">
								<i class="fa fa-dashboard"></i> <span>Dashboard</span>
							</a>
						</li>
						<li class="<?php if (Yii::app()->controller->id == "halaman") echo "active"; ?>">
							<a href="<?php echo $baseUrl; ?>/halaman">
								<i class="fa fa-map-o"></i> <span>Halaman</span>
							</a>
						</li>
						<li class="<?php if (Yii::app()->controller->id == "berita") echo "active"; ?>">
							<a href="<?php echo $baseUrl; ?>/berita">
								<i class="fa fa-newspaper-o"></i> <span>Berita</span>
							</a>
						</li>
						<li class="<?php if (Yii::app()->controller->id == "slider") echo "active"; ?>">
							<a href="<?php echo $baseUrl; ?>/slider">
								<i class="fa fa-image"></i> <span>Slider</span>
							</a>
						</li>
						<li class="<?php if (Yii::app()->controller->id == "maskapai") echo "active"; ?> treeview">
							<a href="#">
								<i class="fa fa-cubes"></i> <span>Produk</span> <i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li class="<?php if (Yii::app()->controller->id == "maskapai") echo "active"; ?>">
									<a href="<?php echo $baseUrl; ?>/maskapai"><i class="fa fa-plane"></i> Maskapai</a>
								</li>
								<li>
									<a href="<?php echo $baseUrl; ?>/maskapai"><i class="fa fa-train"></i> Kereta</a>
								</li>
							</ul>
						</li>
						<li class="<?php if (Yii::app()->controller->id == "supplierMaskapai") echo "active"; ?> treeview">
							<a href="#">
								<i class="fa fa-user-plus"></i> <span>Supplier</span> <i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li class="<?php if (Yii::app()->controller->id == "supplierMaskapai") echo "active"; ?>">
									<a href="<?php echo $baseUrl; ?>/supplierMaskapai"><i class="fa fa-plane"></i> Supplier Maskapai</a>
								</li>
								<li>
									<a href="<?php echo $baseUrl; ?>/maskapai"><i class="fa fa-train"></i> Supplier Kereta</a>
								</li>
							</ul>
						</li>
						<li class="<?php if (Yii::app()->controller->id == "hppMaskapai") echo "active"; ?> treeview">
							<a href="#">
								<i class="fa fa-money"></i> <span>Harga Pokok Penjualan</span> <i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li class="<?php if (Yii::app()->controller->id == "hppMaskapai") echo "active"; ?>">
									<a href="<?php echo $baseUrl; ?>/hppMaskapai"><i class="fa fa-plane"></i> HPP Maskapai</a>
								</li>
								<li>
									<a href="<?php echo $baseUrl; ?>/hppKereta"><i class="fa fa-train"></i> Supplier Kereta</a>
								</li>
							</ul>
						</li>
						<li class="<?php if (Yii::app()->controller->id == "profitShareMaskapai") echo "active"; ?> treeview">
							<a href="#">
								<i class="fa fa-money"></i> <span>Profit Share</span> <i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li class="<?php if (Yii::app()->controller->id == "profitShareMaskapai") echo "active"; ?>">
									<a href="<?php echo $baseUrl; ?>/profitShareMaskapai"><i class="fa fa-plane"></i> Profit Share Maskapai</a>
								</li>
								<li>
									<a href="<?php echo $baseUrl; ?>/profitShareKereta"><i class="fa fa-train"></i> Profit Share Kereta</a>
								</li>
							</ul>
						</li>
						<li class="<?php if (Yii::app()->controller->id == "hppmaskapai") echo "active"; ?> treeview">
							<a href="#">
								<i class="fa fa-users"></i> <span>Member</span> <i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li class="<?php if (Yii::app()->controller->id == "hppmaskapai") echo "active"; ?>">
									<a href="<?php echo $baseUrl; ?>/memberPremium"><i class="fa fa-users"></i> Member Premium</a>
								</li>
								<li>
									<a href="<?php echo $baseUrl; ?>/memberAgen"><i class="fa fa-users"></i> Member Agen</a>
								</li>
							</ul>
						</li>
					</ul>
				</section>
				<!-- /.sidebar -->
			</aside>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<?php echo $content; ?>
			</div><!-- /.content-wrapper -->
			<footer class="main-footer">
				<div class="pull-right hidden-xs">
					<b></b>
				</div>
				<strong>Copyright &copy; 2014-2015 Sibisnis.com</strong> - All rights reserved.
			</footer>
		</div><!-- ./wrapper -->

		
		<script src="<?php echo $baseUrlTemplate; ?>/assets/dist/js/app.min.js" type="text/javascript"></script>
		<script src="<?php echo $baseUrlTemplate; ?>/assets/dist/js/demo.js" type="text/javascript"></script>
		
	</body>
	
</html>