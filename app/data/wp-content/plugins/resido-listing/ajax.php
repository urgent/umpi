<?php
add_action('wp_ajax_resido_additionaldetails', 'ajax_resido_additionaldetails');
add_action('wp_ajax_nopriv_resido_additionaldetails', 'ajax_resido_additionaldetails');
function ajax_resido_additionaldetails()
{
	$data = '';
	if (isset($_POST['feature_ft_counter']) && $_POST['feature_ft_counter'] != '') {
		for ($i = 0; $i < $_POST['feature_ft_counter']; $i++) {
			$data .= '

            <div class="row">
                <div class="form-group col-md-4"><label>Title</label>
                    <input type="text" name="rlisting_short_title[]" class="form-control" value="">
                </div>
                <div class="form-group col-md-4"><label>Value</label>
                    <input type="text" name="rlisting_short_value[]" class="form-control" value="">
                </div>
            </div>
            
            ';
		}
	}
	echo json_encode(array('data' => $data));
	wp_die();
}



add_action('wp_ajax_resido_get_floorplan', 'ajax_resido_get_floorplan');
add_action('wp_ajax_nopriv_resido_get_floorplan', 'ajax_resido_get_floorplan');
function ajax_resido_get_floorplan()
{
	$data = '';
	if (isset($_POST['floor_counter']) && $_POST['floor_counter'] != '') {
		for ($i = 0; $i < $_POST['floor_counter']; $i++) {
			$data .= '
            <div class="row">
                <div class="form-group col-md-4"><label>Floor Title</label>
                    <input type="text" name="rlfloor_title[]" class="form-control" value="">
                </div>
                <div class="form-group col-md-4"><label>Floor Size</label>
                    <input type="text" name="rlfloor_size[]" class="form-control" value="">
                </div>
                <div class="form-group col-md-4"><label>Size Postfix</label>
                    <input type="text" name="rlfloor_postfix[]" class="form-control" value="">
                </div>
				<input type="hidden" id="rlisting_floor_image' . $i . '" name="rlisting_floor_image[]" value="" />
				<div class="form-group col-md-12">
					please add floor information and submit / update to get the floor image insertion field.
				</div>
            </div>
            
            ';
		}
	}
	echo json_encode(array('data' => $data));
	wp_die();
}



add_action('wp_ajax_resido_city_change', 'ajax_resido_city_change');
add_action('wp_ajax_nopriv_resido_city_change', 'ajax_resido_city_change');
function ajax_resido_city_change()
{
	$data     = '';
	$city_ids = get_term_children($_POST['country_id'], 'rlisting_location');
	if (!empty($city_ids)) {
		foreach ($city_ids as $city_id) {

			$data .= '<option value="' . $city_id . '">' . get_term($city_id)->name . '</option>';
		}
	} else {
		$data .= '<option value="">No city found</option>';
	}
	echo json_encode(array('data' => $data));
	wp_die();
}


add_action('wp_ajax_resido_agent_add', 'ajax_resido_agent_add');
add_action('wp_ajax_nopriv_resido_agent_add', 'ajax_resido_agent_add');
function ajax_resido_agent_add()
{
	$data = '';
	if (isset($_POST['agency_id']) && $_POST['agency_id'] != '') {
		$args                = array(
			'post_type'   => 'ragents',
			'post_status' => 'publish',
			'meta_query'  => array(
				array(
					'key'     => 'rlisting_parent_agency',
					'value'   => $_POST['agency_id'],
					'compare' => '=',
				),
			),
		);
		$current_agent_posts = get_posts($args);
		if (!empty($current_agent_posts)) {
			foreach ($current_agent_posts as $single_post) {
				$data .= '<option value="' . $single_post->ID . '">' . $single_post->post_title . '</option>';
			}
		} else {
			$data .= '<option value="">No agent found</option>';
		}
	}
	echo json_encode(array('data' => $data));
	wp_die();
}

add_action('wp_ajax_resido_adv_search', 'ajax_resido_adv_search');
add_action('wp_ajax_nopriv_resido_adv_search', 'ajax_resido_adv_search');
function ajax_resido_adv_search()
{
	if (!wp_verify_nonce($_POST['resido_nonce'], 'resido_adv_search')) {
		wp_send_json_error(
			array(
				'message' => esc_html__('Nonce verification failed!', 'resido-listing'),
			)
		);
	}

	$listing_option = resido_listing_option();

	$_name = '';
	if (isset($_POST['name']) && $_POST['name'] != '') {
		$_name = $_POST['name'];
	}

	$_search_res = '';
	if (isset($_POST['search_res']) && $_POST['search_res'] != '') {
		$_search_res = '?' . $_POST['search_res'];
		$_parsed_url = parse_url($_search_res);
		parse_str($_parsed_url['query'], $params);
		if (isset($params['listing_loc']) && !empty($params['listing_loc'])) {
			$_listing_loc = $params['listing_loc'];
		}
		if (isset($params['listing_cate']) && !empty($params['listing_cate'])) {
			$_listing_cate = $params['listing_cate'];
		}
		if (isset($params['rlisting_st']) && !empty($params['rlisting_st'])) {
			$_rlisting_st = $params['rlisting_st'];
		}
		if (isset($params['rl_bed']) && !empty($params['rl_bed'])) {
			$_rl_bed = $params['rl_bed'];
		}
		if (isset($params['rl_features']) && !empty($params['rl_features'])) {
			$_rl_features = $params['rl_features'];
		}
		if (isset($params['s']) && !empty($params['s'])) {
			$_name = $params['s'];
		}
	}

	$page_num = '';
	if (isset($_POST['page_num'])) {
		$page_num = $_POST['page_num'];
	}

	$query_args = array(
		'post_type'      => 'rlisting', // your CPT
		'post_status'    => 'publish',
		'paged'          => $page_num,
		'posts_per_page' => $listing_option['listing_post_per_page'],
		's'              => $_name, // looks into everything with the keyword from your 'name field'
	);

	if (isset($_POST['sort_by_order']) && $_POST['sort_by_order'] != '') {
		if ($_POST['sort_by_order'] == 'most_viewed') {
			$query_args['meta_key'] = 'post_views_count';
			$query_args['orderby']  = 'meta_value_num';
			$query_args['order']    = 'DESC';
		} elseif ($_POST['sort_by_order'] == 'new_listing') {
			$query_args['orderby'] = 'DATE';
			$query_args['order']   = 'DESC';
		} elseif ($_POST['sort_by_order'] == 'old_listing') {
			$query_args['orderby'] = 'DATE';
			$query_args['order']   = 'ASC';
		} elseif ($_POST['sort_by_order'] == 'high_rated') {
			$query_args['meta_key'] = 'resido_avarage_rate';
			$query_args['orderby']  = 'meta_value_num';
			$query_args['order']    = 'DESC';
		}
	}

	$tax_array = array();

	if (isset($_POST['rl_taxonomy']) && $_POST['rl_term'] != '') {
		$tax_array[] = array(
			'taxonomy' => $_POST['rl_taxonomy'],
			'terms'    => $_POST['rl_term'],
			'field'    => 'slug',
		);
	}

	if (isset($_POST['listing_cate']) && $_POST['listing_cate'] != '') {
		$tax_array[] = array(
			'taxonomy' => 'rlisting_category',
			'terms'    => $_POST['listing_cate'],
			'field'    => 'slug',
		);
	}

	if (isset($_POST['listing_city']) && $_POST['listing_city'] != '') {
		$tax_array[] = array(
			'taxonomy' => 'rlisting_location',
			'terms'    => $_POST['listing_city'],
			'field'    => 'slug',
		);
	}

	if (isset($_POST['rlisting_location']) && $_POST['rlisting_location'] != '') {
		$rlisting_loc = explode(',', $_POST['rlisting_location']);
		$tax_array[]  = array(
			'taxonomy' => 'rlisting_location',
			'terms'    => $rlisting_loc,
			'field'    => 'slug',
		);
	}

	if (isset($_POST['rlisting_category']) && $_POST['rlisting_category'] != '') {
		$rlisting_cate = explode(',', $_POST['rlisting_category']);
		$tax_array[]   = array(
			'taxonomy' => 'rlisting_category',
			'terms'    => $rlisting_cate,
			'field'    => 'slug',
		);
	}

	if (isset($_POST['rlisting_status']) && $_POST['rlisting_status'] != '') {
		$rlisting_loc = explode(',', $_POST['rlisting_status']);
		$tax_array[]  = array(
			'taxonomy' => 'rlisting_status',
			'terms'    => $rlisting_loc,
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

	if (isset($_POST['category_slug'])) {
		$category_slug = $_POST['category_slug'];
		$tax_array[]   = array(
			'taxonomy' => 'rlisting_location',
			'field'    => 'slug',
			'terms'    => $category_slug,
		);
	}

	if (isset($_listing_loc)) {
		$tax_array[] = array(
			'taxonomy' => 'rlisting_location',
			'terms'    => $_listing_loc,
			'field'    => 'slug',
		);
	}

	if (isset($_listing_cate)) {
		$tax_array[] = array(
			'taxonomy' => 'rlisting_category',
			'terms'    => $_listing_cate,
			'field'    => 'slug',
		);
	}

	if (isset($_rlisting_st)) {
		$tax_array[] = array(
			'taxonomy' => 'rlisting_status',
			'terms'    => $_rlisting_st,
			'field'    => 'slug',
		);
	}

	if (isset($_rl_features)) {
		$tax_array[] = array(
			'taxonomy' => 'rlisting_features',
			'terms'    => $_rl_features,
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

	if (isset($_POST['rlisting_bedval']) && $_POST['rlisting_bedval'] != '') {
		$meta_array = array(
			'key'     => 'rlisting_bedrooms',
			'value'   => $_POST['rlisting_bedval'],
			'compare' => '==',
			'type'    => 'numeric',
		);
	}

	if (isset($_rl_bed)) {
		$meta_array[] = array(
			'key'     => 'rlisting_bedrooms',
			'value'   => $_rl_bed,
			'compare' => 'IN',
		);
	}

	if (!empty($meta_array)) {
		$query_args['meta_query'] = array(
			'relation' => 'AND',
			$meta_array,
		);
	}

	$layout = isset($_POST['layout']) ? $_POST['layout'] : 'list';

	$locations = array();
	$key       = isset($_POST['length']) ? (int) $_POST['length'] : 0;

	$wp_query = new WP_Query($query_args);
	// Open this line to Debug what's query WP has just run
	// Show the results
	$data = '';

	$listing_option  = resido_listing_option();
	$currency_symbol = isset($listing_option['currency_symbol']) ? $listing_option['currency_symbol'] : '$';

	if ($wp_query->have_posts()) :
		$key = 0;
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
			$locations[$key]['url']       = get_post_permalink(get_the_ID());
			$locations[$key]['image']     = get_the_post_thumbnail_url(get_the_ID());
			$locations[$key]['price']     = $currency_symbol . $rlisting_price_from . ' - ' . $currency_symbol . $rlisting_price_to;
			$locations[$key]['category']  = $category;
			$locations[$key]['title']     = $title;
			$locations[$key]['latitude']  = $rlisting_latitude;
			$locations[$key]['longitude'] = $rlisting_longitude;

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
		// print_r($wp_query->max_num_pages);
		$page = '';
		if ($listing_option['pagination_layout'] == '2') {
			$page = resido_get_ajax_nav_pagination($page_num, $wp_query->max_num_pages);
		} else {
			if ($wp_query->post_count > $listing_option['listing_post_per_page']) {
				$dd = resido_require_To_Var(RESIDO_LISTING_PATH . '/templates/loop/ajax-load-pagination.php');
				// print_r($dd);
				$data .= resido_require_To_Var(RESIDO_LISTING_PATH . '/templates/loop/ajax-load-pagination.php');
			}
		}
		echo json_encode(
			array(
				'data' => $data,
				'loc'  => $locations,
				'page' => $page,
			)
		);
	else :
		echo json_encode(
			array(
				'data' => '<p class="no-result">' . __(
					'Sorry, nothing matched your search criteria',
					'resido-listing'
				) . '</p>',
				'loc'  => array(),
			)
		);

	endif;
	wp_reset_postdata();
	wp_die();
}

add_action('wp_ajax_resido_user_login', 'resido_ajax_user_login');
add_action('wp_ajax_nopriv_resido_user_login', 'resido_ajax_user_login');

function resido_ajax_user_login()
{
	if (!wp_verify_nonce($_REQUEST['login_form'], 'resido_log_form')) {
		wp_send_json_error(
			array(
				'message' => esc_html__('Nonce verification failed!', 'resido-listing'),
			)
		);
	}

	if (isset($_POST)) {
		$creds                  = array();
		$creds['user_login']    = stripslashes(trim(sanitize_text_field($_POST['rlusername'])));
		$creds['user_password'] = stripslashes(trim(sanitize_text_field($_POST['rlpassword'])));
		// $creds['remember'] = isset( $_POST['rememberMe'] ) ? sanitize_text_field( $_POST['rememberMe'] ) : '';
		$creds['remember'] = true;
		$redirect_to       = esc_url_raw($_POST['redirect_to']);
		$user              = wp_signon($creds, true);

		// do_action('wp_login', $_POST['rlusername']);
		if (!is_wp_error($user)) {

			$userID = $user->ID;
			wp_set_current_user($userID, $_POST['rlusername']);
			wp_set_auth_cookie($userID, true, false);

			wp_send_json_success(
				array(
					'message' => esc_html__('Successfully redirecting ...', 'resido-listing'),
				)
			);
		} else {
			wp_send_json_error(
				array(
					'message' => '<strong>' . esc_html__('ERROR', 'resido-listing') . '</strong>: ' . esc_html__('User name or password is incorrect.', 'resido-listing'),
				)
			);
		}
	}
}

add_action('wp_ajax_resido_user_registration', 'ajax_user_registration');
add_action('wp_ajax_nopriv_resido_user_registration', 'ajax_user_registration');

function ajax_user_registration()
{
	if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'resido_resgis_form')) {
		wp_send_json_error(
			array(
				'message' => esc_html__('Nonce verification failed!', 'resido-listing'),
			)
		);
	}

	global $wpdb;
	if ($_POST) {

		$fisrt_name   = sanitize_text_field($_POST['first_name']);
		$last_name    = sanitize_text_field($_POST['last_name']);
		$username     = sanitize_text_field($_POST['user_name']);
		$email        = sanitize_text_field($_POST['email']);
		$password     = sanitize_text_field($_POST['password']);
		$confPassword = sanitize_text_field($_POST['conf_password']);

		$error = array();
		if (strpos($username, ' ') !== false) {
			$error['error_msg'] = esc_html__('Username has Space', 'resido-listing');
		}

		if (empty($username)) {
			$error['error_msg'] = esc_html__('Needed Username must', 'resido-listing');
		}

		if (username_exists($username)) {
			$error['error_msg'] = esc_html__('Username already exists', 'resido-listing');
		}

		if (!is_email($email)) {
			$error['error_msg'] = esc_html__('Email has no valid value', 'resido-listing');
		}

		if (email_exists($email)) {
			$error['error_msg'] = esc_html__('Email already exists', 'resido-listing');
		}

		if (strcmp($password, $confPassword) !== 0) {
			$error['error_msg'] = esc_html__("Password didn't match", 'resido-listing');
		}

		if (count($error) == 0) {
			$userdata = array(
				'user_login'   => $username,
				'user_pass'    => $password, // When creating an user, `user_pass` is expected.
				'first_name'   => $fisrt_name,
				'last_name'    => $last_name,
				'user_email'   => $email,
				'display_name' => $fisrt_name . $last_name,
				'role'         => 'resido_admin',
			);

			$user_id = wp_insert_user($userdata);
			// On success.
			if (!is_wp_error($user_id)) {
				$creds                  = array();
				$creds['user_login']    = stripslashes(trim(sanitize_text_field($userdata['user_login'])));
				$creds['user_password'] = stripslashes(trim(sanitize_text_field($userdata['user_pass'])));
				$creds['remember']		= true;
				$user					= wp_signon($creds, true);
				wp_send_json_success(
					array(
						'message' => esc_html__('Successfully registered.', 'resido-listing'),
					)
				);
			}
		} else {
			wp_send_json_error(
				array(
					'message' => esc_html__('Sometings wrong goes here', 'resido-listing'),
					'error'   => wp_json_encode($error),
				)
			);
		}
	}
	die();
}

add_action('wp_ajax_resido_listing_enquiry', 'resido_ajax_listing_enquiry');
add_action('wp_ajax_nopriv_resido_listing_enquiry', 'resido_ajax_listing_enquiry');

function resido_ajax_listing_enquiry()
{
	if (!wp_verify_nonce($_REQUEST['resido_enquiry'], 'resido-enquiry-form')) {
		wp_send_json_error(
			array(
				'message' => esc_html__('Nonce verification failed!', 'resido-listing'),
			)
		);
	}


	$name          = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
	$for           = isset($_POST['_wp_http_referer']) ? sanitize_text_field($_POST['_wp_http_referer']) : '';
	$created_for   = isset($_POST['created_for']) ? sanitize_text_field($_POST['created_for']) : 1;
	$email         = isset($_POST['email']) ? sanitize_text_field($_POST['email']) : '';
	$phone         = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
	$message       = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
	$listing_email = isset($_POST['listing_email']) ? sanitize_textarea_field($_POST['listing_email']) : '';

	$args = array(
		'name'        => $name,
		'email'       => $email,
		'phone'       => $phone,
		'message'     => $message,
		'created_for' => $created_for,
	);

	$listing_option = resido_listing_option();
	// $subject        = $listing_option['listing_message_subject'];

	// if (!$subject) {
	$subject = 'Listing enquiry message';
	// }

	$sent_message  = '';
	$sent_message .= 'Name - ' . $name . 'Email - ' . $email . 'Phone - ' . $phone . 'Listing - ' . $for .  'Messege -' . "\r\n" . $message;
	$headers       = 'From: ' . $email . "\r\n" .
		'Reply-To: ' . $email . "\r\n";

	// Here put your Validation and send mail
	$sent = wp_mail($listing_email, $subject, strip_tags($sent_message), $headers);
	// 	$sent = wp_mail($listing_email, strip_tags($sent_message), $headers);
	if ($sent) {

		$insert_id = resido_listing_insert_enquiry_message($args);

		if (is_wp_error($insert_id)) {

			wp_send_json_error(
				array(
					'message' => $insert_id->get_error_message(),
				)
			);
		}

		if ($insert_id) {
			wp_send_json_success(
				array(
					'message' => esc_html__('Enquiry has been sent successfully!', 'resido-listing'),
				)
			);
		}
	} //message sent!
	else {

		wp_send_json_error(
			array(
				'message' => esc_html__('Failed to send message', 'resido-listing'),
			)
		);
	} //message wasn't sent

}

add_action('wp_ajax_resido_save_listing_bookmark', 'resido_save_listing_bookmark_func');
add_action('wp_ajax_nopriv_resido_save_listing_bookmark', 'resido_save_listing_bookmark_func');

function resido_save_listing_bookmark_func()
{
	global $current_user;
	// If the ID is not set, return
	if (!isset($_POST['post_id']) || !isset($_POST['user_id'])) {
		echo 'error';
		die();
	}
	// Store user and product's ID
	$rpost_id  = sanitize_text_field($_POST['post_id']);
	$ruser_id  = sanitize_text_field($_POST['user_id']);
	$user_meta = get_user_meta($current_user->ID, '_favorite_posts');

	// Check if the post is favorited or not
	if (in_array($rpost_id, $user_meta)) {
		delete_user_meta($current_user->ID, '_favorite_posts', $rpost_id);
		echo 'delate';
		die();
	} else {
		add_user_meta($ruser_id, '_favorite_posts', $rpost_id);
		echo 'added';
		die();
	}
	die();
}

add_action('wp_ajax_resido_save_listing_featured', 'resido_save_listing_featured_func');
// add_action('wp_ajax_nopriv_resido_save_listing_featured', 'resido_save_listing_featured_func');

function resido_save_listing_featured_func()
{
	// If the ID is not set, return
	if (!isset($_POST['post_id'])) {
		echo 'error';
		die();
	}
	// Store user and product's ID
	$rpost_id = sanitize_text_field($_POST['post_id']);
	$is_meta  = get_post_meta($rpost_id, 'featured');
	if ($is_meta) {
		// update_post_meta($rpost_id, 'featured', 0);
		delete_post_meta($rpost_id, 'featured');
		echo 'delete';
	} else {
		add_post_meta($rpost_id, 'featured', 1);
		echo 'added';
	}

	die();
}

add_action('wp_ajax_resido_add_listing_varified', 'resido_add_listing_varified');

function resido_add_listing_varified()
{
	// If the ID is not set, return
	if (!isset($_POST['post_id'])) {
		echo 'error';
		die();
	}
	// Store user and product's ID
	$rpost_id = sanitize_text_field($_POST['post_id']);
	$is_meta  = get_post_meta($rpost_id, 'varified');
	if ($is_meta) {
		delete_post_meta($rpost_id, 'varified');
		echo 'delete';
	} else {
		add_post_meta($rpost_id, 'varified', 1);
		echo 'added';
	}
	die();
}

add_action('wp_ajax_resido_delete_gallery_image', 'resido_delete_gallery_image');
function resido_delete_gallery_image()
{
	if (!isset($_POST['gimage'])) {
		echo 'error';
		die();
	}
	// Store user and product's ID
	$gimage = sanitize_text_field($_POST['gimage']);
	$postid = sanitize_text_field($_POST['postid']);
	if ($gimage) {
		wp_delete_attachment($gimage);
		delete_post_meta($postid, 'rlisting_gallery-image', $gimage);
	}
	echo 'added';
	die();
}

add_action('wp_ajax_nopriv_ajaxforgotpassword', 'ajax_forgotPassword');

function ajax_forgotPassword()
{
	// First check the nonce, if it fails the function will break
	check_ajax_referer('ajax-forgot-nonce', 'security');
	$account = $_POST['user_login'];
	if (empty($account)) {
		$error = __('Enter an username or e-mail address.', 'resido-listing');
	} else {
		if (is_email($account)) {
			if (email_exists($account)) {
				$get_by = 'email';
			} else {
				$error = esc_html__('There is no user registered with that email address.', 'resido-listing');
			}
		} elseif (validate_username($account)) {
			if (username_exists($account)) {
				$get_by = 'login';
			} else {
				$error = esc_html__('There is no user registered with that username.', 'resido-listing');
			}
		} else {
			$error = esc_html__('Invalid username or e-mail address.', 'resido-listing');
		}
	}

	if (empty($error)) {
		// lets generate our new password
		// $random_password = wp_generate_password( 12, false );
		$random_password = wp_generate_password();
		// Get user data by field and data, fields are id, slug, email and login
		$user        = get_user_by($get_by, $account);
		$update_user = wp_update_user(
			array(
				'ID'        => $user->ID,
				'user_pass' => $random_password,
			)
		);
		// if update user return true then lets send user an email containing the new password
		if ($update_user) {
			$from = 'shahin@smartdatasoft.net'; // Set whatever you want like mail@yourdomain.com
			if (!(isset($from) && is_email($from))) {
				$sitename = strtolower($_SERVER['SERVER_NAME']);
				if (substr($sitename, 0, 4) == 'www.') {
					$sitename = substr($sitename, 4);
				}
				$from = 'admin@' . $sitename;
			}
			$to        = $user->user_email;
			$subject   = 'Your new password';
			$sender    = 'From: ' . get_option('name') . ' <' . $from . '>' . "\r\n";
			$message   = 'Your new password is: ' .
				$random_password;
			$headers[] = 'MIME-Version: 1.0' . "\r\n";
			$headers[] = 'Content-type: text/html; charset=iso-8859-1'
				. "\r\n";
			$headers[] = "X-Mailer: PHP \r\n";
			$headers[] = $sender;
			$mail      = wp_mail($to, $subject, $message, $headers);
			if ($mail) {
				$success = __('Check your email address for you new password.', 'resido-listing');
			} else {
				$error = __('System is unable to send you mail contain your new password.', 'resido-listing');
			}
		} else {
			$error = __('Oops! Something went wrong while updating your account.', 'resido-listing');
		}
	}
	if (!empty($error)) {
		echo json_encode(
			array(
				'loggedin' => false,
				'message'  => esc_html($error),
			)
		);
	}

	if (!empty($success)) {
		echo json_encode(
			array(
				'loggedin' => false,
				'message'  => esc_html($success),
			)
		);
	}

	die();
}

add_action('wp_ajax_resido_state_by_country', 'resido_state_by_country');
add_action('wp_ajax_nopriv_resido_state_by_country', 'resido_state_by_country');

function resido_state_by_country()
{
	$country = isset($_POST['country']) ? $_POST['country'] : '';
	if (empty($country)) {
		return false;
	}
	$uchildren  = get_terms(
		'rlisting_location',
		array(
			'hide_empty' => 0,
			'parent'     => $_POST['country'],
		)
	);
	$roptions   = array();
	$roptions[] = '<option value=""> ' . __('Select City', 'resido-listing') . '</option>';
	foreach ($uchildren as $state) {
		$roptions[] = '<option value="' . $state->term_id . '">' . $state->name . '</option>';
	}
	echo json_encode($roptions);
	die();
}


add_action('wp_ajax_resido-delete-message', 'resido_delete_message_from_dashboard');
add_action('wp_ajax_nopriv_resido-delete-message', 'resido_delete_message_from_dashboard');

function resido_delete_message_from_dashboard()
{
	global $wpdb;
	$message_id = $_POST['message_id'];
	$return     = $wpdb->delete($wpdb->prefix . 'enquiry_message', array('id' => $message_id));
	echo $return;
	die();
}


add_action('wp_ajax_resido-delete-listing', 'resido_delete_listing_from_dashboard');
add_action('wp_ajax_nopriv_resido-delete-listing', 'resido_delete_listing_from_dashboard');

function resido_delete_listing_from_dashboard()
{
	$listing_id = $_POST['listing_id'];
	$response   = wp_delete_post($listing_id, true);
	if ($response) {
		echo 'done';
	} else {
		echo false;
	}
	die();
}


// Make Featured
add_action('wp_ajax_resido-make-featured', 'resido_make_featured_listing_from_dashboard');
add_action('wp_ajax_nopriv_resido-make-featured', 'resido_make_featured_listing_from_dashboard');

function resido_make_featured_listing_from_dashboard()
{
	$listing_id     = $_POST['listing_id'];
	$featured_state = get_post_meta($listing_id, 'featured', true);
	if ($featured_state != 1) {
		$response = update_post_meta($listing_id, 'featured', 1);
		$notice   = 'Successfully Removed from Featured';
	} else {
		$response = update_post_meta($listing_id, 'featured', false);
		$notice   = 'Successfully Featured';
	}

	if ($response) {
		echo $notice;
	} else {
		echo false;
	}
	die();
}
