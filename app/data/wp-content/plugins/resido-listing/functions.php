<?php
function get_terms_by_taxonomy($tax_name)
{
	return get_the_terms(get_the_ID(), $tax_name);
}

function listing_meta_field($field_name)
{
	$field_name = 'rlisting_' . $field_name;
	echo get_post_meta(get_the_ID(), $field_name, true);
}

function get_listing_meta_field($field_name)
{
	$field_name = 'rlisting_' . $field_name;
	return get_post_meta(get_the_ID(), $field_name, true);
}

function listing_meta_fields($field_name)
{
	$field_name = 'rlisting_' . $field_name;
	return get_post_meta(get_the_ID(), $field_name);
}


function listing_meta_field_gallery($field_name)
{
	$field_name = 'rlisting_' . $field_name;
	return get_post_meta(get_the_ID(), $field_name);
}

function listing_meta_edit_field_gallery($p_id, $field_name)
{
	$field_name = 'rlisting_' . $field_name;
	return get_post_meta($p_id, $field_name);
}

function listing_meta_field_map($field_name)
{
	$field_name = 'rlisting_' . $field_name;
	return get_post_meta(get_the_ID(), $field_name, true);
}

if (!function_exists('resido_currency_symbol')) {

	function resido_currency_symbol()
	{
		$listing_option = resido_listing_option();
		if (!empty($listing_option['currency_symbol'])) {
			echo $listing_option['currency_symbol'];
		} else {
			echo '$';
		}
	}
}

function resido_listing_insert_enquiry_message($args = array())
{
	global $wpdb;
	if (empty($args['name'])) {
		return new \WP_Error('no-name', __('You must provide a name.', 'resido-listing'));
	}
	$created_for = (int) $args['created_for'];
	$defaults    = array(
		'name'        => '',
		'email'       => '',
		'message'     => '',
		'created_for' => $created_for,
		'created_at'  => current_time('mysql'),
	);

	$data     = wp_parse_args($args, $defaults);
	$inserted = $wpdb->insert(
		$wpdb->prefix . 'enquiry_message',
		$data,
		array(
			'%s',
			'%s',
			'%s',
			'%d',
			'%s',
		)
	);

	if (!$inserted) {
		return new \WP_Error('failed-to-insert', __('Failed to insert data', 'resido-listing'));
	}

	return $wpdb->insert_id;
}

function get_lsiting_featured()
{
	$rlisting_features = get_terms(
		array(
			'taxonomy'   => 'rlisting_features',
			'hide_empty' => false,
		)
	);

	if (!empty($rlisting_features)) {
		foreach ($rlisting_features as $key => $single) { ?>
			<li>
				<input id="rlisting_features<?php echo $key; ?>" class="rlisting_features checkbox-custom" name="rlisting_features[]" type="checkbox" value="<?php echo $single->slug; ?>">
				<label for="rlisting_features<?php echo $key; ?>" class="checkbox-custom-label"><?php echo $single->name; ?></label>
			</li>
	<?php
		}
	}
}

function resido_set_post_view()
{
	$key     = 'post_views_count';
	$post_id = get_the_ID();
	$count   = (int) get_post_meta($post_id, $key, true);
	$count++;
	update_post_meta($post_id, $key, $count);
}

function resido_get_post_view()
{
	$count = get_post_meta(get_the_ID(), 'post_views_count', true);
	return $count . __(' views', 'resido-listing');
}

function resido_total_active_lingting_by_user()
{
	global $current_user;
	$args = array(
		'author'         => $current_user->ID,
		'post_type'      => 'rlisting',
		'posts_per_page' => -1, // no limit,
	);

	$current_user_posts = get_posts($args);
	return count($current_user_posts);
}

function resido_total_view()
{
	global $current_user;
	$args = array(
		'author'         => $current_user->ID,
		'post_type'      => 'rlisting',
		'posts_per_page' => -1, // no limit,
	);

	$count              = 0;
	$current_user_posts = get_posts($args);
	foreach ($current_user_posts as $single_post) {
		$single_count = get_post_meta($single_post->ID, 'post_views_count', true);
		$count       += (int) $single_count;
	}

	return $count;
}

function resido_total_review()
{
	global $current_user;
	$args = array(
		'author'         => $current_user->ID,
		'post_type'      => 'rlisting',
		'posts_per_page' => -1, // no limit,
	);

	$comments           = 0;
	$current_user_posts = get_posts($args);
	foreach ($current_user_posts as $single_post) {
		$single_comments = get_comments(array('post_id' => $single_post->ID));
		$comments       += (int) count($single_comments);
	}
	return $comments;
}

function resido_get_favarited_meta_value($userid, $postid)
{

	return get_user_meta($userid, '_favorite_posts');
}

function resido_total_saved()
{
	global $current_user;
	$user_meta = get_user_meta($current_user->ID, '_favorite_posts');
	echo count($user_meta);
}

function resido_get_usermeta($metafield)
{

	global $current_user;
	return get_user_meta($current_user->ID, $metafield, true);
}

function resido_get_listing_meta($id, $metafield)
{

	return get_post_meta($id, $metafield, true);
}

function resido_get_agent_meta($id, $metafield)
{
	return get_user_meta($id, $metafield, true);
}

function add_custom_query_var($vars)
{
	$vars[] = 'editlisting';
	$vars[] = 'map_var';
	$vars[] = 'editagency';
	$vars[] = 'editagent';
	return $vars;
}

add_filter('query_vars', 'add_custom_query_var');

function resido_get_listing_cat($post_id)
{
	$term_name = wp_get_object_terms($post_id, 'rlisting_category', array('fields' => 'names'));
	if ($term_name) {
		return $term_name[0];
	} else {
		return null;
	}
}

if (!function_exists('resido_get_average_rate')) {

	function resido_get_average_rate($post_id)
	{

		$comments = get_comments(
			array(
				'post_id' => $post_id,
				'status'  => 'approve',
			)
		);

		if (!empty($comments)) {

			$average = array();
			foreach ($comments as $comment) {

				$rservice     = get_comment_meta($comment->comment_ID, 'rservice', true);
				$rmoney       = get_comment_meta($comment->comment_ID, 'rmoney', true);
				$rcleanliness = get_comment_meta($comment->comment_ID, 'rcleanliness', true);
				$rlocation    = get_comment_meta($comment->comment_ID, 'rlocation', true);

				if ($rservice) {
					$total_rate[] = (int) $rservice;
				}

				if ($rmoney) {
					$total_rate[] = (int) $rmoney;
				}

				if ($rcleanliness) {
					$total_rate[] = (int) $rcleanliness;
				}

				if ($rlocation) {
					$total_rate[] = (int) $rlocation;
				}

				$average[] = array_sum($total_rate) / count($total_rate);
			}

			$total_average = array_sum($average) / count($comments);
			return round($total_average, 1);
		} else {
			return false;
		}
	}
}

if (!function_exists('resido_get_average_ratting_name')) {

	function resido_get_average_ratting_name($post_id)
	{

		$rservice_array     = array();
		$rmoney_array       = array();
		$rcleanliness_array = array();
		$rlocation_array    = array();

		$comments = get_comments(
			array(
				'post_id' => $post_id,
				'status'  => 'approve',
			)
		);

		foreach ($comments as $key => $comment) {

			$rservice     = get_comment_meta($comment->comment_ID, 'rservice', true);
			$rmoney       = get_comment_meta($comment->comment_ID, 'rmoney', true);
			$rcleanliness = get_comment_meta($comment->comment_ID, 'rcleanliness', true);
			$rlocation    = get_comment_meta($comment->comment_ID, 'rlocation', true);

			$rservice_array[]     = (int) $rservice;
			$rmoney_array[]       = (int) $rmoney;
			$rcleanliness_array[] = (int) $rcleanliness;
			$rlocation_array[]    = (int) $rlocation;
		}

		$total_average['service']     = array_sum($rservice_array) / count($comments);
		$total_average['money']       = array_sum($rmoney_array) / count($comments);
		$total_average['cleanliness'] = array_sum($rcleanliness_array) / count($comments);
		$total_average['location']    = array_sum($rlocation_array) / count($comments);

		return $total_average;
	}
}

if (!function_exists('resido_get_avat')) {

	function resido_get_avat($size = 70)
	{
		global $post;
		$wp_user_avatar = get_user_meta($post->post_author, 'wp_user_avatar', true);
		if ($wp_user_avatar) {
			$avatar_url = wp_get_attachment_image_url($wp_user_avatar, 'thumbnail');
			echo '<img src="' . $avatar_url . '" class="author-avater-img" width="' . $size . '" height="' . $size . '"  alt="img">';
		} else {
			return get_avatar($post->post_author, $size);
		}
	}
}

if (!function_exists('resido_get_avat_by_user')) {

	function resido_get_avat_by_user()
	{
		$current_user   = wp_get_current_user();
		$wp_user_avatar = get_user_meta($current_user->ID, 'wp_user_avatar', true);
		if ($wp_user_avatar) {
			$avatar_url = wp_get_attachment_image_url($wp_user_avatar, 'thumbnail');
			return '<img src="' . $avatar_url . '" class="author-avater-img" width="100" height="100" alt="img">';
		} else {
			return get_avatar($current_user->ID);
		}
	}
}

if (!function_exists('resido_get_avatar_url')) {

	function resido_get_avatar_url()
	{
		$current_user   = wp_get_current_user();
		$wp_user_avatar = get_user_meta($current_user->ID, 'wp_user_avatar', true);
		if ($wp_user_avatar) {
			return wp_get_attachment_image_url($wp_user_avatar, 'thumbnail');
		} else {
			return get_avatar_url($current_user->ID);
		}
	}
}

if (!function_exists('resido_listing_option')) {

	function resido_listing_option()
	{
		return get_option('resido_listings_options');
	}
}



function resido_custom_excerpt_length($length)
{
	return 5;
}
add_filter('excerpt_length', 'resido_custom_excerpt_length', 999);

function resido_require_To_Var($file)
{
	ob_start();
	require $file;
	return ob_get_clean();
}

function resido_get_ajax_nav_pagination($paged, $max_num_pages)
{

	ob_start();
	?>
	<div class="pagination blogpagination_ajax">
		<?php
		echo paginate_links(
			array(
				'base'      => '%_%',
				'format'    => '?paged=%#%',
				'total'     => $max_num_pages,
				'current'   => max(1, $paged),
				'prev_text' => '<i class="fa fa-arrow-left"></i>',
				'next_text' => '<i class="fa fa-arrow-right"></i>',
			)
		);
		?>
		<span class="ajax_page_number"></span>
	</div>
<?php

	return ob_get_clean();
}

function resido_get_country_list_by_location()
{
	$rlisting_location = get_terms(
		array(
			'taxonomy'   => 'rlisting_location',
			'hide_empty' => false,
			'parent'     => 0,
		)
	);

	$country_list = array();
	if (!empty($rlisting_location)) {
		foreach ($rlisting_location as $single) {
			$country_list[$single->term_id] = $single->name;
		}
	}

	return $country_list;
}

if (!function_exists('resido_get_country_tax_name')) {

	function resido_get_country_tax_name()
	{

		$country = get_post_meta(get_the_ID(), 'rlisting_country', true);
		if ($country) {
			$country_obj = get_term($country);
			if ($country_obj) {
				return strtoupper($country_obj->slug);
			}
		}
	}
}

if (!function_exists('resido_get_city_tax_name')) {

	function resido_get_city_tax_name()
	{

		$city = get_post_meta(get_the_ID(), 'rlisting_city', true);
		if ($city) {
			$city_obj = get_term($city);
			if ($city_obj) {
				return $city_obj->name;
			}
		}
	}
}

function resido_get_city_and_country_tax()
{
	return resido_get_city_tax_name() . ', ' . resido_get_country_tax_name();
}

function resido_get_country_list_city()
{
	$rlisting_location = get_terms(
		array(
			'taxonomy'   => 'rlisting_location',
			'hide_empty' => false,
		)
	);

	$country_list = array();

	if (!empty($rlisting_location)) {
		foreach ($rlisting_location as $single) {
			if ($single->parent > 0) {
				$country_list[$single->term_id] = $single->name;
			}
		}
	}

	return $country_list;
}


function resido_get_country_list_dumy()
{
	return array(
		'AF' => 'Afghanistan',
		'AL' => 'Albania',
		'DZ' => 'Algeria',
		'AS' => 'American Samoa',
		'AD' => 'Andorra',
		'AO' => 'Angola',
		'AI' => 'Anguilla',
		'AQ' => 'Antarctica',
		'AG' => 'Antigua and Barbuda',
		'AR' => 'Argentina',
		'AM' => 'Armenia',
		'AW' => 'Aruba',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'AZ' => 'Azerbaijan',
		'BS' => 'Bahamas',
		'BH' => 'Bahrain',
		'BD' => 'Bangladesh',
		'BB' => 'Barbados',
		'BY' => 'Belarus',
		'BE' => 'Belgium',
		'BZ' => 'Belize',
		'BJ' => 'Benin',
		'BM' => 'Bermuda',
		'BT' => 'Bhutan',
		'BO' => 'Bolivia',
		'BA' => 'Bosnia and Herzegovina',
		'BW' => 'Botswana',
		'BV' => 'Bouvet Island',
		'BR' => 'Brazil',
		'IO' => 'British Indian Ocean Territory',
		'BN' => 'Brunei Darussalam',
		'BG' => 'Bulgaria',
		'BF' => 'Burkina Faso',
		'BI' => 'Burundi',
		'KH' => 'Cambodia',
		'CM' => 'Cameroon',
		'CA' => 'Canada',
		'CV' => 'Cape Verde',
		'KY' => 'Cayman Islands',
		'CF' => 'Central African Republic',
		'TD' => 'Chad',
		'CL' => 'Chile',
		'CN' => 'China',
		'CX' => 'Christmas Island',
		'CC' => 'Cocos (Keeling) Islands',
		'CO' => 'Colombia',
		'KM' => 'Comoros',
		'CG' => 'Congo',
		'CD' => 'Congo, the Democratic Republic of the',
		'CK' => 'Cook Islands',
		'CR' => 'Costa Rica',
		'CI' => 'Cote D\'ivoire',
		'HR' => 'Croatia',
		'CU' => 'Cuba',
		'CY' => 'Cyprus',
		'CZ' => 'Czech Republic',
		'DK' => 'Denmark',
		'DJ' => 'Djibouti',
		'DM' => 'Dominica',
		'DO' => 'Dominican Republic',
		'EC' => 'Ecuador',
		'EG' => 'Egypt',
		'SV' => 'El Salvador',
		'GQ' => 'Equatorial Guinea',
		'ER' => 'Eritrea',
		'EE' => 'Estonia',
		'ET' => 'Ethiopia',
		'FK' => 'Falkland Islands (Malvinas)',
		'FO' => 'aroe Islands',
		'FJ' => 'Fiji',
		'FI' => 'Finland',
		'FR' => 'France',
		'GF' => 'French Guiana',
		'PF' => 'French Polynesia',
		'TF' => 'French Southern Territories',
		'GA' => 'Gabon',
		'GM' => 'Gambia',
		'GE' => 'Georgia',
		'DE' => 'Germany',
		'GH' => 'Ghana',
		'GI' => 'Gibraltar',
		'GR' => 'Greece',
		'GL' => 'Greenland',
		'GD' => 'Grenada',
		'GP' => 'Guadeloupe',
		'GU' => 'Guam',
		'GT' => 'Guatemala',
		'GN' => 'Guinea',
		'GW' => 'Guinea',
		'GY' => 'Guyana',
		'HT' => 'Haiti',
		'HM' => 'Heard Island and Mcdonald Islands',
		'VA' => 'Holy See (Vatican City State)',
		'HN' => 'Honduras',
		'HK' => 'Hong Kong',
		'HU' => 'Hungary',
		'IS' => 'Iceland',
		'IN' => 'India',
		'ID' => 'Indonesia',
		'IR' => 'Iran, Islamic Republic of',
		'IQ' => 'Iraq',
		'IE' => 'Ireland',
		'IL' => 'Israel',
		'IT' => 'Italy',
		'JM' => 'Jamaica',
		'JP' => 'Japan',
		'JO' => 'Jordan',
		'KZ' => 'Kazakhstan',
		'KE' => 'Kenya',
		'KI' => 'Kiribati',
		'KP' => 'Korea, Democratic People\'s Republic of',
		'KR' => 'Korea, Republic of',
		'KW' => 'Kuwait',
		'KG' => 'Kyrgyzstan',
		'LA' => 'Lao People\'s Democratic Republic',
		'LV' => 'Latvia',
		'LB' => 'Lebanon',
		'LS' => 'Lesotho',
		'LR' => 'Liberia',
		'LY' => 'Libyan Arab Jamahiriya',
		'LT' => 'Liechtenstein',
		'LU' => 'Luxembourg',
		'MO' => 'Macao',
		'MK' => 'Macedonia, the Former Yugosalv Republic of',
		'MG' => 'Madagascar',
		'MW' => 'Malawi',
		'MY' => 'Malaysia',
		'MV' => 'Maldives',
		'ML' => 'Mali',
		'MT' => 'Malta',
		'MH' => 'Marshall Islands',
		'MQ' => 'Martinique',
		'MR' => 'Mauritania',
		'MU' => 'Mauritius',
		'YT' => 'Mayotte',
		'MX' => 'Mexico',
		'FM' => 'Micronesia, Federated States of',
		'MD' => 'Moldova, Republic of',
		'MC' => 'Monaco',
		'MN' => 'Mongolia',
		'MS' => 'Montserrat',
		'MA' => 'Morocco',
		'MZ' => 'Mozambique',
		'MM' => 'Myanmar',
		'NA' => 'Namibia',
		'NR' => 'Nauru',
		'NP' => 'Nepal',
		'NL' => 'Netherlands',
		'AN' => 'Netherlands Antilles',
		'NC' => 'New Caledonia',
		'NZ' => 'New Zealand',
		'NI' => 'Nicaragua',
		'NE' => 'Niger',
		'NG' => 'Nigeria',
		'NU' => 'Niue',
		'NF' => 'Norfolk Island',
		'MP' => 'Northern Mariana Islands',
		'NO' => 'Norway',
		'OM' => 'Oman',
		'PK' => 'Pakistan',
		'PW' => 'Palau',
		'PS' => 'Palestinian Territory, Occupied',
		'PA' => 'Panama',
		'PG' => 'Papua New Guinea',
		'PY' => 'Paraguay',
		'PE' => 'Peru',
		'PH' => 'Philippines',
		'PN' => 'Pitcairn',
		'PL' => 'Poland',
		'PT' => 'Portugal',
		'PR' => 'Puerto Rico',
		'QA' => 'Qatar',
		'RE' => 'Reunion',
		'RO' => 'Romania',
		'RU' => 'Russian Federation',
		'RW' => 'Rwanda',
		'SH' => 'Saint Helena',
		'KN' => 'Saint Kitts and Nevis',
		'LC' => 'Saint Lucia',
		'PM' => 'Saint Pierre and Miquelon',
		'VC' => 'Saint Vincent and the Grenadines',
		'WS' => 'Samoa',
		'SM' => 'San Marino',
		'ST' => 'Sao Tome and Principe',
		'SA' => 'Saudi Arabia',
		'SN' => 'Senegal',
		'CS' => 'Serbia and Montenegro',
		'SC' => 'Seychelles',
		'SL' => 'Sierra Leone',
		'SG' => 'Singapore',
		'SK' => 'Slovakia',
		'SI' => 'Slovenia',
		'SB' => 'Solomon Islands',
		'SO' => 'Somalia',
		'ZA' => 'South Africa',
		'GS' => 'South Georgia and the South Sandwich Islands',
		'ES' => 'Spain',
		'LK' => 'Sri Lanka',
		'SD' => 'Sudan',
		'SR' => 'Suriname',
		'SJ' => 'Svalbard and Jan Mayen',
		'SZ' => 'Swaziland',
		'SE' => 'Sweden',
		'CH' => 'Switzerland',
		'SY' => 'Syrian Arab Republic',
		'TW' => 'Taiwan, Province of China',
		'TJ' => 'Tajikistan',
		'TZ' => 'Tanzania, United Republic of',
		'TH' => 'Thailand',
		'TL' => 'Timor-Leste',
		'TG' => 'Togo',
		'TK' => 'Tokelau',
		'TO' => 'Tonga',
		'TT' => 'Trinidad and Tobago',
		'TN' => 'Tunisia',
		'TR' => 'Turkey',
		'TM' => 'Turkmenistan',
		'TC' => 'Turks and Caicos Islands',
		'TV' => 'Tuvalu',
		'UG' => 'Uganda',
		'UA' => 'n;mhyyt',
		'AE' => 'United Arab Emirates',
		'UK' => 'United Kingdom',
		'US' => 'United States',
		'UM' => 'United States Minor Outlying Islands',
		'UY' => 'Uruguay',
		'UZ' => 'Uzbekistan',
		'VU' => 'Vanuatu',
		'VE' => 'Venezuela',
		'VN' => 'Viet Nam',
		'VG' => 'Virgin Islands, British',
		'VI' => 'Virgin Islands, U.S.',
		'WF' => 'Wallis and Futuna',
		'YE' => 'Yemen',
		'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe',
	);
}


function my_handle_attachment($file_handler, $post_id, $set_thu = false)
{
	// check to make sure its a successful upload
	// if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
	require_once ABSPATH . 'wp-admin' . '/includes/image.php';
	require_once ABSPATH . 'wp-admin' . '/includes/file.php';
	require_once ABSPATH . 'wp-admin' . '/includes/media.php';
	$attach_id = media_handle_upload($file_handler, $post_id);
	return $attach_id;
}


function rlisting_pre_get_post($query)
{

	if (isset($query->query['from_addon'])) {
		if ($query->query['from_addon'] == "yes") {
			return;
		}
	}

	if (is_admin() || !is_archive()) {
		return;
	}

	$listing_option = get_option('resido_listings_options');
	if (!isset($listing_option['listing_post_per_page'])) {
		$listing_post_per_page = '';
	} else {
		$listing_post_per_page = $listing_option['listing_post_per_page'];
	}
	if (!isset($listing_option['listing_order'])) {
		$listing_order = 'DESC';
	} else {
		$listing_order = $listing_option['listing_order'];
	}
	if (!isset($listing_option['listing_order_by'])) {
		$listing_order_by = 'meta_value_num';
	} else {
		$listing_order_by = $listing_option['listing_order_by'];
	}

	if (isset($query->query['post_type']) && $query->query['post_type'] == 'rlisting') :
		$query->set('posts_per_page', $listing_post_per_page);
		if (isset($_COOKIE['sort_by_order']) && !empty($_COOKIE['sort_by_order'])) {
			if ($_COOKIE['sort_by_order'] == 'most_viewed') {
				$query->set('meta_key', 'post_views_count');
				$query->set('orderby', 'meta_value_num');
				$query->set('order', 'DESC');
			} elseif ($_COOKIE['sort_by_order'] == 'new_listing') {
				$query->set('orderby', 'DATE');
				$query->set('order', 'DESC');
			} elseif ($_COOKIE['sort_by_order'] == 'old_listing') {
				$query->set('orderby', 'DATE');
				$query->set('order', 'ASC');
			} elseif ($_COOKIE['sort_by_order'] == 'high_rated') {
				$query->set('meta_key', 'resido_avarage_rate');
				$query->set('orderby', 'meta_value_num');
				$query->set('order', 'DESC');
			}
		} else {
			$query->set('orderby', $listing_order_by);
			$query->set('order', $listing_order);
		}
		// remove_action('pre_get_posts', 'rlisting_pre_get_post');
		return;
	endif;
}
add_action('pre_get_posts', 'rlisting_pre_get_post');

function rlisting_subscr_check()
{
	global $wpdb;
	$today_expire    = date('Y-m-d');
	$strtotime       = strtotime($today_expire);
	$check_date_data = get_transient('check_date'); // Get transient val
	if ($strtotime != $check_date_data) {
		// Subscription Status Change
		$sposts      = $wpdb->get_col("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'rlisting_expire' AND  meta_value LIKE '%$today_expire%'");
		$sposts      = implode('\',\'', $sposts);
		$update_subs = $wpdb->get_col("UPDATE {$wpdb->prefix}posts SET post_status = 'draft' WHERE id IN ('$sposts')");
		// Listing Status Change
		$rposts      = $wpdb->get_col("SELECT `post_id` FROM $wpdb->postmeta WHERE meta_key = 'user_package_id' AND  meta_value IN ('$sposts')");
		$rposts      = implode('\',\'', $rposts);
		$update_post = $wpdb->get_col("UPDATE {$wpdb->prefix}posts SET post_status = 'draft' WHERE id IN ('$rposts')");

		set_transient('check_date', $strtotime, 0); // Update transient val
	}
}
add_action('init', 'rlisting_subscr_check');


if (!function_exists('resido_currency_html')) {

	function resido_currency_html()
	{
		if (get_listing_meta_field('sale_or_rent')) {
			$listing_option = resido_listing_option();
			if (isset($listing_option['currency_position']) && !empty($listing_option['currency_position'])) {
				$position = $listing_option['currency_position'];
			} else {
				$position = 1;
			}

			if ($position == 2) {
				listing_meta_field('sale_or_rent');
				if (!isset(resido_listing_option()['currency_symbol'])) {
					echo esc_html('$');
				} else {
					echo esc_html(resido_listing_option()['currency_symbol']);
				}
			} elseif ($position == 3) {
				if (!isset(resido_listing_option()['currency_symbol'])) {
					echo esc_html('$');
				} else {
					echo esc_html(resido_listing_option()['currency_symbol']);
				}
				echo '&nbsp;';
				listing_meta_field('sale_or_rent');
			} elseif ($position == 4) {

				listing_meta_field('sale_or_rent');
				echo '&nbsp;';
				if (!isset(resido_listing_option()['currency_symbol'])) {
					echo esc_html('$');
				} else {
					echo esc_html(resido_listing_option()['currency_symbol']);
				}
			} else {
				if (!isset(resido_listing_option()['currency_symbol'])) {
					echo esc_html('$');
				} else {
					echo esc_html(resido_listing_option()['currency_symbol']);
				}
				listing_meta_field('sale_or_rent');
			}
		} else {
			return false;
		}
	}
}

function change_resido_permalinks()
{
	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure('/%postname%/');
	$wp_rewrite->flush_rules();
}
// add_action('init', 'change_resido_permalinks');

function dashboard_permalink_notice()
{
	$structure = get_option('permalink_structure');
	if ($structure != '/%postname%/') {
		echo '<div class="notice notice-error is-dismissible"><p><a style="text-decoration:none;" href="options-permalink.php"><b>';
		echo esc_html__('Please Set Permalinks to Post Name', 'resido-listing');
		echo '</b></a></p></div>';
	}
}
add_action('admin_notices', 'dashboard_permalink_notice');


function update_settings_notice()
{
	$listing_option = get_option('resido_listings_options');

	if (!isset($listing_option['listing_post_per_page'])) {
		echo '<div class="notice notice-error is-dismissible"><p><a style="text-decoration:none;" href="edit.php?post_type=rlisting&page=resido-listings"><b>';
		echo esc_html__('Please update settings, to update settings go [ Lisitngs > Settings > Save ]', 'resido-listing');
		echo '</b></a></p></div>';
	}
}
add_action('admin_notices', 'update_settings_notice');
