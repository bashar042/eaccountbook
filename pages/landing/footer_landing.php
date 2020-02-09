<footer id="footer"><!--Footer-->				
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Informations</h2>
							<ul class="nav nav-pills nav-stacked">								
								<li><a href="?page=services">Service Information</a></li>
								<li><a href="?page=faq">FAQ’s</a></li>
							</ul>
						</div>
					</div>
					
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Policies</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="?page=termsconditions">Terms of Use</a></li>
								<li><a href="?page=privacy">Privecy Policy</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>About</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Contact us</a></li>								
								<li><a href="#">Our Mission & Vission</a></li>								
								
							</ul>
						</div>
					</div>					
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Social Media</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Facebook</a></li>
								<li><a href="#">Google Plus</li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="single-widget">
							<h2>Quick Contact</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="tel:+8801718792556"><i class="fa fa-phone"></i> +88 01718 792 556</a></li>
								<li><a href="mailto:info@eaccountbook.com" target="_top"><i class="fa fa-envelope"></i> info@eaccountbook.com</a></li>
							</ul>
						</div>
					</div>					
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<p class="pull-left">Copyright © 2015 eaccountbook.com. All rights reserved.</p>
						<p class="pull-right">Powered by <span><a target="_blank" href="http://www.ideaitbd.com/">ideaitbd.com</a></span></p>
					</div>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
	<script src="js/jquery_003.js"></script>
	<script src="js/bootstrap.js"></script>
	
    <script type='text/javascript' src='js/jquery.mobile.customized.min.js'></script>
    <script type='text/javascript' src='js/jquery.easing.1.3.js'></script> 
    <script type='text/javascript' src='js/camera.js'></script> 
    
    <script>
		jQuery(function(){
			
			jQuery('#camera_wrap_4').camera({
				height: '400',
				loader: 'bar',
				pagination: false,
				thumbnails: false,
				hover: false,
				opacityOnGrid: false,
				imagePath: 'images/'
			});

		});
	</script>
	<script>
		jQuery(document).ready(function($){
			// browser window scroll (in pixels) after which the "back to top" link is shown
			var offset = 300,
				//browser window scroll (in pixels) after which the "back to top" link opacity is reduced
				offset_opacity = 1200,
				//duration of the top scrolling animation (in ms)
				scroll_top_duration = 700,
				//grab the "back to top" link
				$back_to_top = $('.cd-top');

			//hide or show the "back to top" link
			$(window).scroll(function(){
				( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
				if( $(this).scrollTop() > offset_opacity ) { 
					$back_to_top.addClass('cd-fade-out');
				}
			});

			//smooth scroll to top
			$back_to_top.on('click', function(event){
				event.preventDefault();
				$('body,html').animate({
					scrollTop: 0 ,
					}, scroll_top_duration
				);
			});

		});
	</script>
	<a href="#0" class="cd-top">Top</a>
</body>
</html>	