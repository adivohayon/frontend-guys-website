<!--============================
=            #Hello            =
=============================-->
<div 
	class="row section" id="section-hello" 
	style="background-image: url(<?php echo get_stylesheet_directory_uri() . '/assets/images/bg-table-day.jpg' ?>);"
>
	<div class="scrim-top"></div>
	<div class="scrim-bottom"></div>
	<div class="col-xs-12">
		<img id="frontend-guys-logo" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/frontend-guys-logo-dark_bg.svg' ?>" alt="Frontend Guys Logo">
		<h2><span>Developers Turned Designers</span></h2>

	</div>

	<div class="visuals-container-full">
		
		<!--====================================
		=            Desktop-Screen            =
		=====================================-->
		<div class="visual desktop-screen">
			<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/desktop.svg' ?>" alt="Large Monitor">
			<div class="screen-content">
				<div class="spinner">
					<div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
				</div>
				<div class="asset">
					<?php
						$image = get_field('hello-desktop-image');
						echo '<img src="' . $image['sizes']['medium_large'] . '" alt="' . $image['title'] . '" title="' . $image['title'] . '">';
						// print_r(get_field('hello-desktop-image'));
					?>
				</div>
			</div>
		</div>

		<!--===================================
		=            Laptop-Screen            =
		====================================-->
		<div class="visual laptop-screen">
			<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/laptop.png' ?>" alt="Laptop">
			<div class="screen-content">
				<div class="spinner">
					<div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
				</div>
				<div class="asset">
					
					<div class="youtube-embed">
						<?php
							$args = array(
								'height'=>247,
								'loop'=>1,
								'autoplay'=>1
							);
							$video_url = get_field( 'hello-laptop-video');
							echo wp_oembed_get($video_url, $args);
							
						?>
					</div>
				</div>
			</div>
		</div>
		
		<!--==================================
		=            Orange-Juice            =
		===================================-->
		<div class="visual orange-juice">
			<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/orange-juice.png' ?>" alt="Orange Juice">
		</div>
		<!--==============================
		=            Mouse-3D            =
		===============================-->
		<div class="visual mouse-3d">
			<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/mouse-3d.svg' ?>" alt="Mouse 3D">
		</div>
		
		<!--================================
		=            Mouse-Scroll-Down     =
		=================================-->
		<div class="visual mouse-scroll-down">
			<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/mouse-scroll-down.svg' ?>" alt="Mouse Scroll Down">
		</div>
		
	</div>
	
</div><!-- #section-hello -->