<?php
global $woocommerce;

//Put your code here that needs any woocommerce class
//You can also Instantiate your main plugin file here
/**
 * WC_Product_Data_Store_CPT class file.
 *
 * @package WooCommerce/Classes
 * @path woocommerce/includes/data-stores/class-wc-product-data-store-cpt.php
 */

class Resido_WC_Product_Data_Store_CPT extends WC_Product_Data_Store_CPT
{

    /**
     * Method to read a product from the database.
     *
     * @param WC_Product $product Product object.
     * @throws Exception If invalid product.
     *
     * @since 3.0.0
     */
    public function read(&$product)
    {

        $product->set_defaults();
        $post_object = get_post($product->get_id());
        $product->set_props(
            array(
                'name' => $post_object->post_title,
                'slug' => $post_object->post_name,
                'date_created' => 0 < $post_object->post_date_gmt ? wc_string_to_timestamp($post_object->post_date_gmt) : null,
                'date_modified' => 0 < $post_object->post_modified_gmt ? wc_string_to_timestamp($post_object->post_modified_gmt) : null,
                'status' => $post_object->post_status,
                'description' => $post_object->post_content,
                'short_description' => $post_object->post_excerpt,
                'parent_id' => $post_object->post_parent,
                'menu_order' => $post_object->menu_order,
                'reviews_allowed' => 'open' === $post_object->comment_status,
            )
        );

        $this->read_attributes($product);
        $this->read_downloads($product);
        $this->read_visibility($product);
        $this->read_product_data($product);
        $this->read_extra_data($product);
        $product->set_object_read(true);
    }

    /**
     * Get the product type based on product ID.
     *
     * @since 3.0.0
     * @param int $product_id
     * @return bool|string
     */
    public function get_product_type($product_id)
    {

        $post_type = get_post_type($product_id);
        if ('product_variation' === $post_type) {
            return 'variation';
        } elseif (in_array($post_type, array('rlisting', 'pricing_plan', 'product'))) { // change birds with your post type
            $terms = get_the_terms($product_id, 'product_type');
            return !empty($terms) ? sanitize_title(current($terms)->name) : 'simple';
        } else {
            return false;
        }
    }
}

// custom product for lplan
class Resido_WC_Product_Plan extends WC_Product_Simple
{
    /**
     * Set if should be sold individually.
     *
     * @since 3.0.0
     * @param bool $sold_individually Whether or not product is sold individually.
     */
    public function set_sold_individually($sold_individually)
    {
        $this->set_prop('sold_individually', true);
    }
}

// extend WC_Order_Item_Product class
class Resido_WC_Order_Item_Product extends WC_Order_Item_Product
{

    public function set_product_id($value)
    {
        $this->set_prop('product_id', absint($value));
    }
}

class Resido_WC_Product_Listing_Cpt extends WC_Product
{
    public function __construct($product)
    {
        $this->product_type = 'rlisting';
        parent::__construct($product);
    }

    public function get_catalog_visibility($context = 'view')
    {
        return $this->get_prop('catalog_visibility', $context);
    }
}

// https://github.com/woocommerce/woocommerce/wiki/Data-Stores
add_filter('woocommerce_data_stores', 'resido_addons_woo_data_stores');

function resido_addons_woo_data_stores($stores)
{
    $stores['product'] = 'Resido_WC_Product_Data_Store_CPT';
    return $stores;
}

add_filter('woocommerce_product_class', 'resido_addons_woo_product_class', 10, 4);
function resido_addons_woo_product_class($classname, $product_type, $variation, $product_id)
{
    if ('pricing_plan' == get_post_type($product_id)) {
        $classname = 'Resido_WC_Product_Plan';
    }
    return $classname;
}

add_action('wp_ajax_product_add_to_cart', 'resido_product_add_to_cart');
add_action('wp_ajax_nopriv_product_add_to_cart', 'resido_product_add_to_cart');

if (!function_exists('resido_product_add_to_cart')) {

    function resido_product_add_to_cart()
    {
        global $woocommerce;
        if (!$woocommerce || !$woocommerce->cart) {
            return $_POST['product_id'];
        }
        $cart_items = $woocommerce->cart->get_cart();
        $woo_cart_param = array(
            'product_id' => sanitize_text_field($_POST['product_id']),
            'check_in_date' => '',
            'check_out_date' => '',
            'quantity' => sanitize_text_field($_POST['quantity']),
        );
        $woo_cart_id = $woocommerce->cart->generate_cart_id($woo_cart_param['product_id'], null, array(), $woo_cart_param);
        if (array_key_exists($woo_cart_id, $cart_items)) {
            $woocommerce->cart->set_quantity($woo_cart_id, $_POST['quantity']);
        } else {
            $woocommerce->cart->add_to_cart($woo_cart_param['product_id'], $woo_cart_param['quantity'], null, array(), $woo_cart_param);
        }
        $woocommerce->cart->calculate_totals();
        // Save cart to session
        $woocommerce->cart->set_session();
        // Maybe set cart cookies
        $woocommerce->cart->maybe_set_cart_cookies();
        echo esc_html('success');
        wp_die();
    }
}

// $item = apply_filters( 'woocommerce_checkout_create_order_line_item_object', new WC_Order_Item_Product(), $cart_item_key, $values, $order );
add_filter('woocommerce_checkout_create_order_line_item_object', 'citybook_addons_woo_checkout_create_order_line_item_object', 10, 4);
function citybook_addons_woo_checkout_create_order_line_item_object($item, $cart_item_key, $values, $order)
{
    $product = $values['data'];
    if ($product) {
        $post_type = get_post_type($product->get_id());
        if (in_array($post_type, array('pricing_plan'))) {
            return new Resido_WC_Order_Item_Product();
        }
    }

    // return default
    return $item;
}

// $classname = apply_filters( 'woocommerce_get_order_item_classname', $classname, $item_type, $id );
add_filter('woocommerce_get_order_item_classname', 'citybook_addons_woo_get_order_item_classname', 10, 3);
function citybook_addons_woo_get_order_item_classname($classname, $item_type, $id)
{

    $item = new Resido_WC_Order_Item_Product($id);
    $product_id = $item->get_product_id();

    if (in_array(get_post_type($product_id), array('pricing_plan'))) {
        return 'Resido_WC_Order_Item_Product';
    } else {
        return $classname;
    }
}

add_filter('woocommerce_is_sold_individually', 'wc_remove_quantity_field_from_cart', 10, 2);
function wc_remove_quantity_field_from_cart($return, $product)
{
    if (is_cart()) return true;
}

add_action('woocommerce_order_status_completed', 'resido_woo_order_status_completed', 10, 2);
function resido_woo_order_status_completed($order_id)
{

    $woo_order = new WC_Order($order_id);
    $order_user = $woo_order->get_user();
    $items = $woo_order->get_items();

    $product_id = '';
    $product_name = '';
    foreach ($items as $item) {
        $product_id = $item->get_product_id();
        $product_name = $item->get_name();
        $product_expire = get_post_meta($item->get_product_id(), 'rlisting_expire', true);
    }

    $date = strtotime(date("Y-m-d"));
    $date = strtotime("+$product_expire day", $date);
    $expire_date = date('Y-m-d h:i', $date);

    // - - - - - - - Renew Section

    $args = array(
        'post_type' => 'rsubscription',
        'post_status' => array('draft'),
        'author'    => $order_user->ID,
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'rlisting_package',
                'value' => $product_name,
                'compare' => '='
            )
        ),
    );
    $renew_query = new \WP_Query($args);

    if ($renew_query->have_posts()) { // - - - - - - - - - - - - Renew Subscription
        $sub_post_id = $renew_query->post->ID;
        $renew_post = array(
            'ID'           => $sub_post_id,
            'post_status'  => 'publish',
            'post_title'   => '',
            'post_content' => '',
        );
        // Update the post into the database
        global $wpdb;
        $rn_listings = $wpdb->get_col("SELECT `post_id` FROM $wpdb->postmeta WHERE meta_key = 'user_package_id' AND  meta_value IN ('$sub_post_id')");
        $rn_listings = implode('\',\'', $rn_listings);
        $update_listings = $wpdb->get_col("UPDATE {$wpdb->prefix}posts SET post_status = 'publish' WHERE id IN ('$rn_listings')");
        wp_update_post($renew_post);
        update_post_meta($sub_post_id, 'rlisting_expire', $expire_date);
        wp_reset_query();
    } else { // - - - - - - - - - - - - New Subscription
        $order_data = array();
        $order_data['post_title'] = $order_user->display_name;
        $order_data['post_content'] = '';
        $order_data['post_author'] = $order_user->ID;
        $order_data['post_status'] = 'publish';
        $order_data['post_type'] = 'rsubscription';

        $order_id = wp_insert_post($order_data, true);

        $order_metas = array(
            'listing_id' => 0, // listing id
            'package_id' => $product_id,
            'order_id' => $order_id,
            'package' => $product_name,
            'status' => 'Completed',
            'expire' => $expire_date,
            'quantity' => 1,
            'user_id' => $order_user->ID,
            'email' => $order_user->user_email,
            'first_name' => $order_user->user_firstname,
            'last_name' => $order_user->user_lastname,
            'display_name' => $order_user->display_name,
            'payment_method' => 'woo', // banktransfer - paypal - stripe - woo
        );

        foreach ($order_metas as $key => $value) {
            update_post_meta($order_id, 'rlisting_' . $key, $value);
        }
    }
}
