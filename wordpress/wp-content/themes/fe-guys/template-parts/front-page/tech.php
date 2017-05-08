<!--===========================
=            #Tech            =
============================-->
<div class="row section" id="section-tech">
	<div class="col-xs-12">
		<h2>Our Choice of <span class="green">Tech</span></h2>
		<div class="content accent-bg">
			<!--================================
			=            .Tech-Tags            =
			=================================-->
			<div class="tech-tags">
				<ul>
					<?php
						$terms = get_terms( array(
						    'taxonomy' => 'tech_categories',
						    'hide_empty' => false,
						) );
						foreach ( $terms as $term ) {
						    echo '<li class="tech-tag" data-term="' . $term->slug . '">' . $term->name . '</li>';
						}
					?>
				</ul>
			</div>
			<!-- .tech-tags -->
			
			<!--=================================
			=            .Tech-Icons            =
			==================================-->
			<!-- Slider main container -->
			<div class="tech-icons swiper-container">
			    <!-- Additional required wrapper -->
			    <div class="swiper-wrapper">
			        <!-- Slides -->
			       
			    </div>
			    
			    <!-- If we need navigation buttons -->
			    <div class="swiper-button-prev"></div>
			    <div class="swiper-button-next"></div>
			    
			    <!-- If we need scrollbar -->
			    <div class="swiper-scrollbar"></div>
			</div>
			<!-- .tech-icons-->

			
		</div>
		
	</div>
</div><!-- #section-tech -->