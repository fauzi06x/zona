<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title><?php echo "| Zonatik"; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <link rel="shortcut icon" href="<?php //echo base_url('assets/img/favicon.png'); ?>">
        <?php
			$baseUrl = Yii::app()->baseUrl;
			$baseUrlImg = $baseUrl.'/../../uploads/';
			$baseUrlTemplate = Yii::app()->theme->baseUrl; 
			$cs = Yii::app()->getClientScript();
			$cs->registerCssFile($baseUrlTemplate.'/css/zonaticstyle.css');
			$cs->registerCssFile($baseUrlTemplate.'/css/slider.css');
			$cs->registerCssFile($baseUrlTemplate.'/css/jquery-ui.css');
			
			
			$cs->registerScriptFile($baseUrlTemplate.'/js/jquery.js');
			$cs->registerScriptFile($baseUrlTemplate.'/js/jquery-ui.js');
			$cs->registerScriptFile($baseUrlTemplate.'/js/modernizr.js');
			$cs->registerScriptFile($baseUrlTemplate.'/js/jquery.slitslider.js');
			
			
		?>
        <script type="text/javascript"> 
			$(function() {
				$( ".prodzona" ).tabs();
			});

			$(function() {
				var Page = (function() {
					var $nav = $( '#nav-dots > span' ),
					slitslider = $( '#slider' ).slitslider( {
						onBeforeChange : function( slide, pos ) {
							$nav.removeClass( 'nav-dot-current' );
							$nav.eq( pos ).addClass( 'nav-dot-current' );
						}
					}),
					init = function() {
						initEvents();
					},
					initEvents = function() {
						$nav.each( function( i ) {
							$( this ).on( 'click', function( event ) {
							var $dot = $( this );
							if( !slitslider.isActive() ) {
							$nav.removeClass( 'nav-dot-current' );
							$dot.addClass( 'nav-dot-current' );
							}
							slitslider.jump( i + 1 );
							return false;
							});
						});
					};
					return { init : init };
				})();
				Page.init();
			});

			$(document).ready(function() {
				// grab the initial top offset of the navigation 
				var stickyNavTop = $('.header').offset().top;

				// our function that decides weather the navigation bar should have "fixed" css position or not.
				var stickyNav = function(){
					var scrollTop = $(window).scrollTop(); // our current vertical position from the top

					// if we've scrolled more than the navigation, change its position to fixed to stick to top,
					// otherwise change it back to relative
					// if we've scrolled more than the navigation, change its position to fixed to stick to top,
                // otherwise change it back to relative
					if (scrollTop > 2) {
						$('.header').addClass('sticky');
					} else {
						$('.header').removeClass('sticky');
					}
					if (scrollTop > 5) {
						$('.zonasearch').addClass('sticky2');
					} else {
						$('.zonasearch').removeClass('sticky2');
					}
					if (scrollTop > 5) {
						$('.sl-fly').addClass('sticky2');
					} else {
						$('.sl-fly').removeClass('sticky2');
					}
					if (scrollTop > 5) {
						$('.loadcarilg').addClass('sticky2');
					} else {
						$('.loadcarilg').removeClass('sticky2');
					}
					if (scrollTop > 2) {
						$('#top-bar').addClass('sticky3');
					} else {
						$('#top-bar').removeClass('sticky3');
					}
				};
				stickyNav();
				// and run it again every time you scroll
				$(window).scroll(function() {
				stickyNav();
				});
			});
		</script>
    </head>
    <body>
			<div class="page-wrapper">
			<div id="top-bar">
				<div class="content">
					<span>Call Center: 021-84903131</span>
					<div>
					<a href="#" class="an-faq">FAQ</a>
					|
					<a href="#" class="an-help">Kontak</a>
					</div>
				</div>
			</div>
			<div class="header">
				<div class="content">
					<a href=""><img src="<?php echo $baseUrlImg; ?>logo/logo_sibisnis.png"></a>
					<div class="menu">
						<ul class="nav">
							<li>
								<a href="#">Tentang Zonatik</a>
								
							</li>
							<li>
								<a href="#">Cara Pesan</a>
								<ul>
									<li><a href="#">Cara Pesan</a></li>
									<li><a href="#">Cara Pesan</a></li>
								</ul>
							</li>            
							<li>
								<a href="#">FAQ</a>
								
							</li>
							<li>
								<a href="#">Kontak</a>
								
							</li>
						</ul>
						<button class="button button--wapasha" onclick="document.location = 'http://sibisnis.com/login.php'">Login/Register</button>
					</div>
					<div class="content mn-bt-bar"></div>
				</div>
			</div>

			<div class="container">
				<?php echo $content; ?>
			</div><!-- end container -->
			<div class="push"></div>
		</div>
		<div class="footer">
			<p>Chipsakti 2015</p>
			<p>Jl. Jatimakmur no. 16D Pondok Gede, Bekasi</p>
			<p>021-84903111</p>
		</div>
    </body>
</html>