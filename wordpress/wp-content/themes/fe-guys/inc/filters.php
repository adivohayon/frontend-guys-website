<?php
	add_action( 'wp_ajax_filter_posts', 'filter_posts' );
	add_action( 'wp_ajax_nopriv_filter_posts', 'filter_posts' );

	function filter_posts() {
		global $wpdb; // this is how you get access to the database
		check_ajax_referer( 'my-special-string', 'security' );

		$tech_tag = $_POST['tech_tag'];
		$args = array(
			'post_type' => 'tech',
			'tax_query' => array(
				array(
					'taxonomy' => 'tech_categories',
					'field'    => 'slug',
					'terms'    => $tech_tag,
				),
			),
		);
		// echo $tech_tag;
		// wp_die();
		$query = new WP_Query( $args );
		// The Loop
		$technologies = array();
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				if ( has_post_thumbnail() ) {
					$orientation = get_field( "image_orientation" );
					array_push($technologies, array (
						'image' => get_the_post_thumbnail_url(),
						'title' => get_the_title(),
						'image_orientation' => $orientation ? $orientation : 'portrait'
					));
				}
			}
		}
		wp_send_json($technologies);


		
	}
?>