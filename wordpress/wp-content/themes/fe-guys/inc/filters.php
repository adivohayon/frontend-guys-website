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
	

	add_action( 'wp_ajax_project_assets', 'project_assets' );
	add_action( 'wp_ajax_nopriv_project_assets', 'project_assets' );

	function project_assets() {
		global $wpdb; // this is how you get access to the database
		check_ajax_referer( 'my-special-string', 'security' );

		$project_id = $_POST['project_id'];
		$asset_type = $_POST['asset_type'];

		//Retreive project by ID
		$args = array(
			'post_type' => 'projects',
			'post_status' => 'publish',
			'p' => $project_id 
		);

		$query = new WP_Query( $args );
		
		// The Loop
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();

				/*===================================
				=            Screenshots            =
				===================================*/
				$screenshots = acf_photo_gallery('screenshots', get_the_ID());
				if( count($screenshots) ) {
					foreach($screenshots as &$image) {
						$id = $image['id'];
						$screenshot_screen = wp_get_attachment_image_src( $id, 'desktop-screenshots' );
						$screenshot_screen_src = $screenshot_screen[0];
						$image['screen_src'] = $screenshot_screen_src;
						$image['device_type'] = get_field('device_type', $id);
						
					}
				}

				/*==============================
				=            Videos            =
				==============================*/
				$videos = array();
				for ($i = 0 ; $i < 5; $i++) {
					if ( get_field('video-' . $i)) {
						$video_url = get_field('video-' . $i);
						$args = array(
							'width'=>684, 
							'height'=>394
						);
						array_push(
							$videos,
							wp_oembed_get($video_url, $args)
						);
					}
				}
		
				/*===================================
				=            Styleguides            =
				===================================*/
				$styleguide_images = acf_photo_gallery('styleguide_images', get_the_ID());
				if( count($styleguide_images) ) {
					foreach($styleguide_images as &$image) {
						$id = $image['id'];
						$screenshot_screen = wp_get_attachment_image_src( $id, 'desktop-screenshots' );
						$screenshot_screen_src = $screenshot_screen[0];
						$image['screen_src'] = $screenshot_screen_src;
						$image['device_type'] = get_field('device_type', $id);
						
					}
				}

				//Preparing assets objects which includes all assets
				$assets = array(
					'postId' => get_the_ID(),
					'screenshots' => $screenshots,
					'videos' => $videos,
					'styleguide_images' => $styleguide_images
				);

				//If there's an asset_type, filter only those assets
				if ( $asset_type && $assets[$asset_type] ) {
					$assets = $assets[$asset_type];
				}

				//Send response back to client
				wp_send_json($assets);
			}
		} else {
			wp_send_json(null);
		}

		
		// echo 'aaa';
		
	}

	/*=====================================
	=            oEmbed Filter            =
	=====================================*/
	function imp_custom_youtube_querystring( $html, $url, $args ) {
		if(strpos($html, 'youtube')!= FALSE) {
			parse_str( parse_url( $url, PHP_URL_QUERY ), $query_array );
			$args = [
				'rel' 				=> 0,
				'showinfo' 			=> 0,
				'modestbranding' 	=> 1,
				'controls' 			=> isset($args['controls']) ? $args['controls'] : 0,
				'autoplay' 			=> isset($args['autoplay']) ? $args['autoplay'] : 0,
				'loop' 				=> isset($args['loop']) 	? $args['loop'] 	: 0,
				'playlist'			=> isset($args['playlist']) ? $args['playlist'] : $query_array['v'] 
				// 'width'				=> isset($args['width']) 	? $args
			];
			$params = '?feature=oembed&';
			foreach($args as $arg => $value){
				$params .= $arg;
				$params .= '=';
				$params .= $value;
				$params .= '&';
			}
			$params = substr($params, 0, -1);
			$result = str_replace( '?feature=oembed', $params, $html );
		}
		return $result;
	}
	add_filter('oembed_result', 'imp_custom_youtube_querystring', 10, 3);

	/*===========================================
	=            Gallery Extra Field            =
	===========================================*/
	//Create extra fields called Altnative Text and Custom Classess
	function my_extra_gallery_fields( $args, $attachment_id, $field ){
	    // $args['alt'] = array('type' => 'text', 'label' => 'Altnative Text', 'name' => 'alt', 'value' => get_field($field . '_alt', $attachment_id) ); // Creates Altnative Text field
	    $args['device_type'] = array('type' => 'text', 'label' => 'Device Type', 'name' => 'device_type', 'value' => get_field('device_type', $attachment_id) ); // Creates Custom Classess field

	    // $args['device_type'] = array('type' => 'text', 'label' => 'Custom Classess', 'name' => 'device_type', 'value' => get_field($field . '_class', $attachment_id) ); // Creates Custom Classess field
	    return $args;
	}
	add_filter( 'acf_photo_gallery_image_fields', 'my_extra_gallery_fields', 10, 3 );

	


?>