<?php
add_action('wp_ajax_resido_adv_search_ajax', 'resido_adv_search_loadmore');
add_action('wp_ajax_nopriv_resido_adv_search_ajax', 'resido_adv_search_loadmore');
function resido_adv_search_loadmore()
{

	// if (!wp_verify_nonce($_POST['resido_nonce'], 'resido_adv_search')) {
	// wp_send_json_error([
	// 'message' => 'Nonce verification failed!'
	// ]);
	// }
	$listing_option = resido_listing_option();
	$_name          = $_POST['name'] != '' ? $_POST['name'] : '';
	// $page_num = $_POST['page_num'] != '' ? $_POST['page_num'] : 1;
	$page_num = $_POST['page_num'] + 1;
	// Start the Query
	$query_args = array(
		'post_type'      => 'rlisting', // your CPT
		'post_status'    => 'publish',
		'paged'          => $page_num,
		'posts_per_page' => $listing_option['listing_post_per_page'],
		's'              => $_name, // looks into everything with the keyword from your 'name field'
	);

	$earth_radius = 3959;
	if (isset($_POST['is_radius']) && !empty($_POST['is_radius'])) {
		if (isset($_POST['lat']) && !empty($_POST['lat'])) {
			$latitude  = $_POST['lat'];
			$longitude = $_POST['long'];
			$distance  = $_POST['distance'];
			global $wpdb;
			$sql             = $wpdb->prepare(
				"
            SELECT DISTINCT
                p.ID,
                p.post_title,
                latitude.meta_value as locLat,
                longitude.meta_value as locLong,
                ( %d * acos(
                cos( radians( %s ) )
                * cos( radians( latitude.meta_value ) )
                * cos( radians( longitude.meta_value ) - radians( %s ) )
                + sin( radians( %s ) )
                * sin( radians( latitude.meta_value ) )
                ) )
                AS distance
            FROM $wpdb->posts p
            INNER JOIN $wpdb->postmeta latitude ON p.ID = latitude.post_id
            INNER JOIN $wpdb->postmeta longitude ON p.ID = longitude.post_id
            WHERE 1 = 1
            AND p.post_type = 'rlisting'
            AND p.post_status = 'publish'
            AND latitude.meta_key = 'rlisting_latitude'
            AND longitude.meta_key = 'rlisting_longitude'
            HAVING distance < %s
            ORDER BY distance ASC",
				$earth_radius,
				$latitude,
				$longitude,
				$latitude,
				$distance
			);
			$nearbyLocations = $wpdb->get_results($sql);
			$post_ids        = array_column($nearbyLocations, 'ID');
			$query_args      = array(
				'post_type'      => 'rlisting', // your CPT
				'post_status'    => 'publish',
				'paged'          => $page_num,
				'posts_per_page' => $listing_option['listing_post_per_page'],
				's'              => $_name, // looks into everything with the keyword from your 'name field'
				'post__in'       => $post_ids,
				// 'orderby' => 'post__in'
			);
		}
	}

	if (isset($_POST['sort_by_order']) && $_POST['sort_by_order'] != '') {
		if ($_POST['sort_by_order'] == 'most_viewed') {
			$query_args['meta_key'] = 'post_views_count';
			$query_args['orderby']  = 'meta_value_num';
			$query_args['order']    = 'DESC';
		} elseif ($_POST['sort_by_order'] == 'new_listing') {
			$query_args['orderby'] = 'ID';
			$query_args['order']   = 'DESC';
		} elseif ($_POST['sort_by_order'] == 'old_listing') {
			$query_args['orderby'] = 'ID';
			$query_args['order']   = 'ASC';
		} elseif ($_POST['sort_by_order'] == 'high_rated') {
			$query_args['meta_key'] = 'resido_avarage_rate';
			$query_args['orderby']  = 'meta_value_num';
			$query_args['order']    = 'DESC';
		}
	}

	$tax_array = array();

	if (isset($_POST['listing_cate']) && $_POST['listing_cate'] != '') {
		$tax_array[] = array(
			'taxonomy' => 'rlisting_category',
			'terms'    => $_POST['listing_cate'],
			'field'    => 'slug',
		);
	}

	if (isset($_POST['rlisting_features']) && $_POST['rlisting_features'] != '') {
		$features_slugs = explode(',', $_POST['rlisting_features']);
		$tax_array[]    = array(
			'taxonomy' => 'rlisting_features',
			'terms'    => $features_slugs,
			'field'    => 'slug',
		);
	}


	if (!empty($tax_array)) {
		$query_args['tax_query'] = array(
			'relation' => 'AND',
			$tax_array,
		);
	}

	$meta_array = array();
	if (isset($_POST['location']) && $_POST['location'] != '') {
		$meta_array[] = array(
			'key'     => 'rlisting_location',
			'value'   => $_POST['location'],
			'compare' => 'LIKE',
		);
	}

	if (isset($_POST['rlcity']) && $_POST['rlcity'] != '') {
		$meta_array[] = array(
			'key'     => 'rlisting_city',
			'value'   => $_POST['rlcity'],
			'compare' => 'LIKE',
		);
	}

	if (!empty($meta_array)) {
		$query_args['meta_query'] = array(
			'relation' => 'AND',
			array(
				'key'     => 'rlisting_address',
				'value'   => $_POST['location'],
				'compare' => 'LIKE',
			),
		);
	}

	$layout = isset($_POST['layout']) ? $_POST['layout'] : 'list';

	if (isset($_POST['locations_obj']) && $_POST['locations_obj'] != '') {
		$locations = $_POST['locations_obj'];
	} else {
		$locations = array();
	}
	$key = isset($_POST['length']) ? (int) $_POST['length'] : 0;
	$listing_option = resido_listing_option();
	$wp_query = new WP_Query($query_args);
	// Open this line to Debug what's query WP has just run
	// Show the results
	$data = '';
	if ($wp_query->have_posts()) :
		while ($wp_query->have_posts()) :
			$wp_query->the_post();
			// Assumed your cars' names are stored as a CPT post title
			$category                       = resido_get_listing_cat(get_the_ID());
			$title                          = get_the_title();
			$featured_image_url             = get_the_post_thumbnail_url(get_the_ID());
			$rlisting_latitude              = resido_get_listing_meta(get_the_ID(), 'rlisting_latitude');
			$rlisting_longitude             = resido_get_listing_meta(get_the_ID(), 'rlisting_longitude');
			$rlisting_price_from            = resido_get_listing_meta(get_the_ID(), 'rlisting_price_from');
			$rlisting_price_to              = resido_get_listing_meta(get_the_ID(), 'rlisting_price_to');
			$locations[$key]['url']       	= get_post_permalink(get_the_ID());
			$locations[$key]['image']     	= get_the_post_thumbnail_url(get_the_ID());
			$locations[$key]['price']		= $listing_option['currency_symbol'] . ' ' . get_post_meta(get_the_ID(), 'rlisting_sale_or_rent', true);
			$locations[$key]['category']  	= $category;
			$locations[$key]['title']     	= $title;
			$locations[$key]['latitude']  	= $rlisting_latitude;
			$locations[$key]['longitude'] 	= $rlisting_longitude;
			if (isset($_POST['layout']) && $_POST['layout'] == 'list') {
				$data .= resido_require_To_Var(RESIDO_LISTING_PATH . '/templates/loop/listing.php');
			} elseif (isset($_POST['layout']) && $_POST['layout'] == 'grid') {
				$data .= resido_require_To_Var(RESIDO_LISTING_PATH . '/templates/loop/grid-listing.php');
			} elseif (isset($_POST['layout']) && $_POST['layout'] == 'grid-full') {
				$data .= resido_require_To_Var(RESIDO_LISTING_PATH . '/templates/loop/grid-listing-full.php');
			} else {
				$data .= resido_require_To_Var(RESIDO_LISTING_PATH . '/templates/loop/listing.php');
			}
			$key++;
		endwhile;
		// global $wp_query; // you can remove this line if everything works for you
		// don't display the button if there are not enough posts
		if ($wp_query->post_count > $listing_option['listing_post_per_page']) {
			$data .= '<div class="col-md-12 col-sm-12 mt-3" id="load_more_button">
                <div id="ajax_scroll_loadmore_ajax">
                    <div id="loading_tag" class="ajax_load text-center">
                        <div class="resido_loadmore_ajax btn btn-theme" id="resido_loadmore_ajax" data-page_num="' . $page_num . '">
' . esc_html__('Load More', 'listing-core') . '
</div>
</div>
</div>
</div>';
		}
		echo json_encode(
			array(
				'data' => $data,
				'loc'  => $locations,
			)
		);
	endif;
	wp_reset_postdata();
	wp_die();
}

function resido_loadmore_ajax_handler()
{
	// global $wp_query;
	// prepare our arguments for the query
	$args                = json_decode(stripslashes($_POST['query']), true);
	$args['paged']       = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';
	$args['post_type']   = 'rlisting';
	$wp_query            = new WP_Query($args);
	// $wp_query = null;
	// $wp_query = $custom_query;
	// it is always better to use WP_Query but not here
	// query_posts($args);
	if ($wp_query->have_posts()) :
		// $locations = [];
		if (isset($_POST['locations_obj']) && $_POST['locations_obj'] != '') {
			$locations = $_POST['locations_obj'];
		} else {
			$locations = array();
		}

		$listing_option  = resido_listing_option();

		// run the loop
		$key  = isset($_POST['length']) ? (int) $_POST['length'] : 0;
		$data = '';
		while ($wp_query->have_posts()) :
			$wp_query->the_post();

			$category                       = resido_get_listing_cat(get_the_ID());
			$title                          = get_the_title();
			$rlisting_latitude              = resido_get_listing_meta(get_the_ID(), 'rlisting_latitude');
			$rlisting_longitude             = resido_get_listing_meta(get_the_ID(), 'rlisting_longitude');
			$locations[$key]['url']       = get_post_permalink(get_the_ID());
			$locations[$key]['image']     = get_the_post_thumbnail_url(get_the_ID());
			$locations[$key]['price']     = $listing_option['currency_symbol'] . ' ' . get_post_meta(get_the_ID(), 'rlisting_sale_or_rent', true);
			$locations[$key]['category']  = $category;
			$locations[$key]['title']     = $title;
			$locations[$key]['latitude']  = $rlisting_latitude;
			$locations[$key]['longitude'] = $rlisting_longitude;

			if (isset($_POST['layout']) && $_POST['layout'] == 'list') {
				$data .= resido_require_To_Var(RESIDO_LISTING_PATH . '/templates/loop/listing.php');
			} elseif (isset($_POST['layout']) && $_POST['layout'] == 'grid') {
				$data .= resido_require_To_Var(RESIDO_LISTING_PATH . '/templates/loop/grid-listing.php');
			} else {
				$data .= resido_require_To_Var(RESIDO_LISTING_PATH . '/templates/loop/listing.php');
			}
			$key++;
		endwhile;
	endif;

	echo json_encode(
		array(
			'data' => $data,
			'loc'  => $locations,
		)
	);
	die; // here we exit the script and even no wp_reset_query() required!
}

add_action('wp_ajax_loadmore', 'resido_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'resido_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}
