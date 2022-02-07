<?php
/*
  Plugin Name: Resido Core
  Plugin URI: http://smartdatasoft.com/
  Description: Helping for the Resido theme.
  Author: SmartDataSoft Team
  Version: 1.8
  Author URI: http://smartdatasoft.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/breadcrumb-navxt/breadcrumb-navxt.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/includes/mb-term-meta/mb-term-meta.php';
require_once __DIR__ . '/combine-vc-ele-css/combine-vc-ele-css.php';
require_once __DIR__ . '/page-option/page-option.php';

/**
 * The main plugin class
 */
final class Resido_Helper {


	/**
	 * Plugin version
	 *
	 * @var string
	 */
	const version = '1.0';


	/**
	 * Plugin Version
	 *
	 * @since 1.2.0
	 * @var   string The plugin version.
	 */
	const VERSION = '1.2.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.2.0
	 * @var   string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.2.0
	 * @var   string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Constructor
	 *
	 * @since  1.0.0
	 * @access public
	 */

	/**
	 * Class construcotr
	 */
	private function __construct() {
		$this->define_constants();
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
	}

	/**
	 * Initializes a singleton instance
	 *
	 * @return \Resido
	 */
	public static function init() {
		 static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}


	/**
	 * Define the required plugin constants
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'RESIDO_CORE_VERSION', self::version );
		define( 'RESIDO_CORE_FILE', __FILE__ );
		define( 'RESIDO_CORE_PATH', __DIR__ );
		define( 'RESIDO_CORE_URL', plugin_dir_url( __FILE__ ) );
		define( 'RESIDO_CORE_ASSETS_DEPENDENCY_CSS', RESIDO_CORE_URL . '/assets/elementor/css/' );
		define( 'RESIDO_CORE_ASSETS', RESIDO_CORE_URL . 'assets' );
		$theme = wp_get_theme();
		define( 'THEME_VERSION_CORE', $theme->Version );
	}

	/**
	 * Initialize the plugin
	 *
	 * @return void
	 */
	public function init_plugin() {
		 $this->checkElementor();
		load_plugin_textdomain( 'resido-core', false, basename( dirname( __FILE__ ) ) . '/languages' );
		new \Resido\Helper\Hooks();
		// sidebar generator
		new \Resido\Helper\Sidebar_Generator();

		new \Resido\Helper\Widgets();
		if ( did_action( 'elementor/loaded' ) ) {
			new \Resido\Helper\Elementor();
		}

		if ( is_admin() ) {
			new \Resido\Helper\Admin();
		}
	}

	public function checkElementor() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = '<p>If you want to use Elementor Version of "<strong>resido</strong>" Theme, Its requires "<strong>Elementor</strong>" to be installed and activated.</p>';

		// $message = sprintf(
		// * translators: 1: Plugin name 2: Elementor */
		// esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-hello-world'), '<strong>' . esc_html__('Elementor Resido', 'elementor-hello-world') . '</strong>', '<strong>' . esc_html__('Elementor', 'elementor-hello-world') . '</strong>'
		// esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-hello-world'), '<strong>' . esc_html__('If you want to use Elementor Version of Theme, ', 'elementor-hello-world') . '</strong>', '<strong>' . esc_html__('Elementor', 'elementor-hello-world') . '</strong>'
		// );

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-hello-world' ),
			'<strong>' . esc_html__( 'Elementor Resido', 'elementor-hello-world' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-hello-world' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'resido-core' ),
			'<strong>' . esc_html__( 'Elementor Resido', 'resido-core' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'resido-core' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}


	/**
	 * Do stuff upon plugin activation
	 *
	 * @return void
	 */
	public function activate() {
		$installer = new Resido\Helper\Installer();
		$installer->run();
	}
}

/**
 * Initializes the main plugin
 *
 * @return \Resido
 */
function Resido() {
	 return Resido_Helper::init();
}

// kick-off the plugin
Resido();




function resido_get_contact_form_7_posts() {
	$args    = array(
		'post_type'      => 'wpcf7_contact_form',
		'posts_per_page' => -1,
	);
	$catlist = array();

	if ( $categories = get_posts( $args ) ) {
		foreach ( $categories as $category ) {
			(int) $catlist[ $category->ID ] = $category->post_title;
		}
	} else {
		(int) $catlist['0'] = esc_html__( 'No contect From 7 form found', 'resido-core' );
	}
	return $catlist;
}


// Get The Menu List
function resido_get_menu_list() {
	$menulist = array();
	$menus    = get_terms( 'nav_menu' );
	foreach ( $menus as $menu ) {
		$menulist[ $menu->name ] = $menu->name;
	}
	return $menulist;
}
// Put it on the output side

// $menu     = $menu_select;
// $menulist = wp_get_nav_menu_items( $menu, $args = array() );
// if ( $menulist ) :
// foreach ( $menulist as $navItem ) {
// echo '<li><a href="' . $navItem->url . '" title="' . $navItem->title . '">' . $navItem->title . '</a></li>';
// }
// endif;

// Put it on the output side

// Get The Menu List


/**
 * Passing Classes to Menu
 */
add_action(
	'wp_nav_menu_item_custom_fields',
	function ( $item_id, $item ) {
		if ( $item->menu_item_parent == '0' ) {
			$show_as_megamenu = get_post_meta( $item_id, '_show-as-megamenu', true ); ?>
		<p class="description-wide">
			<label for="megamenu-item-<?php echo $item_id; ?>"> <input type="checkbox" id="megamenu-item-<?php echo $item_id; ?>" name="megamenu-item[<?php echo $item_id; ?>]" <?php checked( $show_as_megamenu, true ); ?> /><?php _e( 'Mega menu', 'sds' ); ?>
			</label>
		</p>
			<?php
		}
	},
	10,
	2
);

add_action(
	'wp_update_nav_menu_item',
	function ( $menu_id, $menu_item_db_id ) {
		$button_value = ( isset( $_POST['megamenu-item'][ $menu_item_db_id ] ) && $_POST['megamenu-item'][ $menu_item_db_id ] == 'on' ) ? true : false;
		update_post_meta( $menu_item_db_id, '_show-as-megamenu', $button_value );
	},
	10,
	2
);

add_filter(
	'nav_menu_css_class',
	function ( $classes, $menu_item ) {
		if ( $menu_item->menu_item_parent == '0' ) {
			$show_as_megamenu = get_post_meta( $menu_item->ID, '_show-as-megamenu', true );
			if ( $show_as_megamenu ) {
				$classes[] = 'megamenu';
			}
		}
		return $classes;
	},
	10,
	2
);



// Post Nevigation

add_action( 'resido_navigation_post', 'resido_navigation_post_ready' );
function resido_navigation_post_ready( $post_id ) {
	$resido_prev_post = get_adjacent_post( false, '', true );
	$resido_next_post = get_adjacent_post( false, '', false );
	?>

	<div class="single-post-pagination">
		<?php
		if ( ! empty( $resido_prev_post ) ) {
			?>
			<div class="prev-post">
				<a href="<?php echo esc_url( get_permalink( $resido_prev_post->ID ) ); ?>">
					<div class="title-with-link">
						<span class="intro"><?php echo esc_attr__( 'Prev Post', 'resido-core' ); ?></span>
						<h3 class="title"><?php echo esc_html( $resido_prev_post->post_title ); ?></h3>
					</div>
				</a>
			</div>
		<?php } ?>
		<div class="post-pagination-center-grid">
			<a href="#"><i class="ti-layout-grid3"></i></a>
		</div>
		<?php
		if ( ! empty( $resido_next_post ) ) {
			?>
			<div class="next-post">
				<a href="<?php echo esc_url( get_permalink( $resido_next_post->ID ) ); ?>">
					<div class="title-with-link">
						<span class="intro"><?php echo esc_attr__( 'Next Post', 'resido-core' ); ?></span>
						<h3 class="title"><?php echo esc_html( $resido_next_post->post_title ); ?></h3>
					</div>
				</a>
			</div>
		<?php } ?>
	</div>
	<?php
}

// Custom Author Fields

function resido_user_social_links( $user_contact ) {
	$user_contact['facebook'] = __( 'Facebook', 'resido-core' );
	$user_contact['twitter']  = __( 'Twitter', 'resido-core' );
	$user_contact['behance']  = __( 'Behance', 'resido-core' );
	$user_contact['youtube']  = __( 'Youtube', 'resido-core' );
	$user_contact['linkedin'] = __( 'Linkedin', 'resido-core' );
	$user_contact['phone']    = __( 'Phone', 'resido-core' );

	return $user_contact;
}
add_filter( 'user_contactmethods', 'resido_user_social_links' );


// Enqueue Style During Editing
add_action(
	'elementor/editor/before_enqueue_styles',
	function () {
		wp_enqueue_style( 'elementor-stylesheet', plugins_url() . '/resido-core/assets/elementor/stylesheets.css', true );
		wp_enqueue_script( 'resido-core-script', plugins_url() . '/resido-core/assets/elementor/addons-script.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'resido-core-script', plugins_url() . '/resido-core/assets/elementor/js/custom.js', array( 'jquery' ), time(), true );
	}
);

if ( ! function_exists( 'resido_blog_social' ) ) :
	function resido_blog_social() {
		?>
		<li>
			<a onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>"><span class="fab fa-facebook-f"></span></a>
		</li>
		<li>
			<a onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://twitter.com/home?status=<?php echo urlencode( get_the_title() ); ?>-<?php echo esc_url( get_permalink() ); ?>"><span class="fab fa-twitter"></span></a>
		</li>
		<li>
			<a onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url( get_permalink() ); ?>" target="_blank">
				<span class="fab fa-linkedin-in"></span>
			</a>
		</li>
		<li>
			<a onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="http://www.stumbleupon.com/submit?url=<?php echo esc_url( get_permalink() ); ?>&amp;text=<?php echo urlencode( get_the_title() ); ?>"><span class="fab fa-mix"></span></a>
		</li>
		<?php
	}
endif;
