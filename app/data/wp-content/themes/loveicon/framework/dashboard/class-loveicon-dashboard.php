<?php
class DashboardEssential {

	use pluginlist;
	private $liecence_endpoint = '';
	private $theme_name;
	private $theme_slug;
	private $token;
	private $item_id = null;
	public function __construct() {
		$this->liecence_endpoint = $this->update_url;
		$this->theme_name        = wp_get_theme();
		$this->theme_slug        = $this->theme_name->template;
		$this->item_id           = $this->themeitem_id;
		update_option( 'envato_theme_item_id', $this->item_id );
		$this->token = '';
		if ( get_option( 'envato_theme_license_token' ) ) {
			$this->token = get_option( 'envato_theme_license_token' );
		}
		$status = get_option( 'envato_theme_license_key_status' );
		if ( $this->token != '' && $status == 'valid' ) {
			add_filter( 'plugins_api', array( $this, 'envato_theme_license_dashboard_check_info' ), 10, 3 );
		}
		add_action( 'admin_menu', array( $this, 'envato_theme_license_dashboard_add_menu' ), 8 );
		add_action( 'admin_notices', array( $this, 'envato_theme_license_dashboard_sample_admin_notice' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'envato_theme_license_dashboard_style' ) );
		register_setting( 'envato_theme_license', 'envato_theme_license_key', array( $this, 'envato_theme_license_sanitize' ) );
		register_setting( 'envato_theme_license', 'envato_clientemail', array( $this, 'envato_client_sanitize' ) );
		add_action( 'admin_init', array( $this, 'envato_theme_license_dashboard_theme_activate_license' ) );
		add_action( 'admin_notices', array( $this, 'envato_theme_license_dashboard_conditional_admin_notice' ) );
		add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'envato_theme_license_dashboard_transient_update_plugins' ) );
		foreach ( $this->plugin_list_with_file as $key => $val ) {
			add_action( 'in_plugin_update_message-' . $key . '/' . $val, array( $this, 'envato_theme_license_dashboard_update_message_cb' ), 10, 2 );
		}
		if ( class_exists( 'OCDI_Plugin' ) && $this->token != '' ) {
			add_action( 'add_tab_menu_for_dashboard', array( $this, 'envato_theme_license_dashboard_get_tabs' ), 10, 1 );
		}
		if ( class_exists( 'iconmoonFontAdd' ) && $this->token != '' ) {
			add_action( 'add_icon_tab_menu_for_dashboard', array( $this, 'envato_theme_license_dashboard_get_tabs' ), 10, 1 );
		}
		add_action( 'wp_loaded', array( $this, 'envato_theme_license_dashboard_remove_js_composser_hook' ), 99 );
		add_filter( 'custom_menu_order', array( $this, 'envato_theme_license_dashboard_order_menu_page' ), 10 );
	}
	public function envato_theme_license_dashboard_remove_js_composser_hook() {
		global $wp_filter;
		if ( isset( $wp_filter['in_plugin_update_message-js_composer/js_composer.php'] ) ) {
			foreach ( $wp_filter['in_plugin_update_message-js_composer/js_composer.php']->callbacks[10] as $key => $value ) {
				if ( strpos( $key, 'envato_theme_license_dashboard_update_message_cb' ) === false ) {
					remove_action( 'in_plugin_update_message-js_composer/js_composer.php', $key, 10 );
					break;
				}
			}
		}

		if ( isset( $wp_filter['pre_set_site_transient_update_plugins'] ) ) {
			foreach ( $wp_filter['pre_set_site_transient_update_plugins']->callbacks[10] as $key => $value ) {
				if ( strpos( $key, 'check_update' ) !== false ) {
					remove_action( 'pre_set_site_transient_update_plugins', $key, 10 );
					break;
				}
			}
		}
	}

	public function envato_theme_license_dashboard_order_menu_page( $menu_ord ) {
		global $submenu;
		$support = '';
		if ( isset( $submenu[ $this->menu_slug_dashboard ] ) ) {
			foreach ( $submenu[ $this->menu_slug_dashboard ] as $key => $val ) {
				if ( $val[0] == 'Support' ) {
					$support = $submenu[ $this->menu_slug_dashboard ][ $key ];
					unset( $submenu[ $this->menu_slug_dashboard ][ $key ] );
				}
			}
			if ( $support != '' ) {
				array_push( $submenu[ $this->menu_slug_dashboard ], $support );
			}
			$submenu[ $this->menu_slug_dashboard ] = array_values( $submenu[ $this->menu_slug_dashboard ] );
		}
	}

	/* Active Licence */

	public function envato_theme_license_dashboard_check_info( $false, $action, $arg ) {
		$url      = $this->liecence_endpoint . 'ck-ensl-api?licence_action=jsonread&ck-ensl-purchase-key=NA&item_id=' . $this->item_id . '&site_url=' . get_site_url();
		$response = wp_remote_get( $url );
		if ( ! isset( $response->errors ) ) {
			$response = json_decode( $response['body'] );
			foreach ( $response as $key => $item ) {
				if ( file_exists( WP_PLUGIN_DIR . '/' . $key ) ) {
					if ( isset( $arg->slug ) && isset( $item->slug ) ) {
						if ( $arg->slug == $item->slug ) {
							$information                        = new stdClass();
							$information->name                  = $item->pname;
							$information->slug                  = $item->slug;
							$information->new_version           = $item->new_version;
							$information->last_updated          = '';
							$information->sections              = array(
								'details'   => 'Details',
								'changelog' => 'Changelog',
							);
							$information->sections['details']   = $item->details;
							$information->sections['changelog'] = $item->changelog;
							return $information;
						}
					}
				}
			}
		}
		return $false;
	}

	public function envato_theme_license_dashboard_update_message_cb( $plugin_data, $result ) {
		$purchase_key = trim( get_option( 'envato_theme_license_key' ) );
		$status       = get_option( 'envato_theme_license_key_status' );
		if ( $status != 'valid' ) {
			echo sprintf( __( 'To receive automatic updates license activation is required. Please visit <a href="%s">Setting</a> page.', 'loveicon' ), esc_url( admin_url() . 'admin.php?page=' . $this->menu_slug . 'product-registration' ) );

		}
	}

	public function envato_theme_license_dashboard_transient_update_plugins( $transient ) {
		$url      = $this->liecence_endpoint . 'ck-ensl-api?licence_action=jsonread&ck-ensl-purchase-key=NA&item_id=' . $this->item_id . '&site_url=' . get_site_url();
		$response = wp_remote_get( $url );
		if ( ! isset( $response->errors ) ) {
			$response     = json_decode( $response['body'] );
			$purchase_key = trim( get_option( 'envato_theme_license_key' ) );
			$status       = get_option( 'envato_theme_license_key_status' );
			if ( $status == 'valid' && $purchase_key != '' && $this->token != '' ) {
				foreach ( $response as $key => $item ) {

					if ( file_exists( WP_PLUGIN_DIR . '/' . $key ) ) {
						$data = get_plugin_data( WP_PLUGIN_DIR . '/' . $key, true, true );
						if ( version_compare( $data['Version'], $item->new_version, '<' ) ) {
							$item->url                   = $this->liecence_endpoint . 'ck-ensl-api?licence_action=downloadzip&ck-ensl-purchase-key=' . $purchase_key . '&token=' . $this->token . '&item_id=' . $this->item_id . '&site_url=' . get_site_url() . "&filename={$item->slug}";
							$item->package               = $this->liecence_endpoint . 'ck-ensl-api?licence_action=downloadzip&ck-ensl-purchase-key=' . $purchase_key . '&token=' . $this->token . '&item_id=' . $this->item_id . '&site_url=' . get_site_url() . "&filename={$item->slug}";
							$transient->response[ $key ] = $item;
						}
					}
				}
			} else {
				foreach ( $response as $key => $item ) {
					if ( file_exists( WP_PLUGIN_DIR . '/' . $key ) ) {
						$data = get_plugin_data( WP_PLUGIN_DIR . '/' . $key, true, true );
						if ( version_compare( $data['Version'], $item->new_version, '<' ) ) {
							$item->url                   = $this->liecence_endpoint . 'ck-ensl-api?licence_action=downloadzip&ck-ensl-purchase-key=' . $purchase_key . '&item_id=' . $this->item_id . '&site_url=' . get_site_url() . "&filename={$item->slug}";
							$transient->response[ $key ] = $item;
						}
					}
				}
			}
		}
		return $transient;

	}

	public function envato_theme_license_dashboard_conditional_admin_notice() {
		$traker = get_option( 'envato_theme_license_traker' );
		if ( isset( $_GET['settings-updated'] ) ) {
			if ( $traker != '' ) {
				$status = get_option( 'envato_theme_license_key_status' );
				if ( $status == 'valid' ) {?>
				<div class="notice notice-success">
					<p><strong><?php esc_html_e( 'License Activated', 'loveicon' ); ?> </strong></p>
				</div>
			<?php } elseif ( $status == 'deactivated' ) { ?>
				<div class="notice notice-success">
					<p><strong><?php esc_html_e( 'License Deactiveted', 'loveicon' ); ?><strong></p>
				</div>
			<?php } else { ?>
					<div class="notice notice-error">
						<p><strong><?php echo sprintf( __( '%s', 'loveicon' ), $status ); ?><strong></p>
					</div>
				<?php
			}
			} else {
				$token = get_option( 'envato_theme_license_key' );
				if ( $token != '' ) {
					?>
					<div class="notice notice-success">
						<p><strong><?php esc_html_e( 'License Key saved', 'loveicon' ); ?><strong></p>
					</div>
				<?php } else { ?>
					<div class="notice notice-error">
						<p><strong><?php esc_html_e( 'License Key blank', 'loveicon' ); ?><strong></p>
					</div>
					<?php
				}
			}
		}
		update_option( 'envato_theme_license_traker', '' );
	}

	public function envato_theme_license_dashboard_theme_activate_license() {
		if ( isset( $_POST['envato_theme_theme_license_activate'] ) ) {
			if ( ! check_admin_referer( 'envato_theme_nonce', 'envato_theme_nonce' ) ) {
				return; // get out if we didn't click the Activate button
			}
			$purchase_key = trim( get_option( 'envato_theme_license_key' ) );
			$client       = trim( get_option( 'envato_clientemail' ) );
			// print "You pressed Button activate";
			if ( isset( $_POST['envato_theme_theme_license_activate_checkbox'] ) && sanitize_text_field( $_POST['envato_theme_theme_license_activate_checkbox'] ) == 1 ) {
				$this->activated( $purchase_key, $client );
			}
		} elseif ( isset( $_POST['envato_theme_theme_license_deactivate'] ) ) {
			if ( ! check_admin_referer( 'envato_theme_nonce', 'envato_theme_nonce' ) ) {
				return; // get out if we didn't click the Activate button
			}
			$purchase_key = trim( get_option( 'envato_theme_license_key' ) );
			$this->deactivated( $purchase_key );
		}
		return;
	}
	public function activated( $license, $client ) {
		$client         = $client;
		$ciphering      = 'AES-128-CTR';
		$iv_length      = openssl_cipher_iv_length( $ciphering );
		$options        = 0;
		$encryption_iv  = '1234567891011121';
		$encryption_key = 'sdsdata';

		$client = openssl_encrypt(
			$client,
			$ciphering,
			$encryption_key,
			$options,
			$encryption_iv
		);

		$site_url = get_site_url();
		$url      = $this->liecence_endpoint . 'ck-ensl-api?licence_action=activate&ck-ensl-purchase-key=' . $license . '&item_id=' . $this->item_id . '&site_url=' . $site_url . '&validtoken=' . $client . '&multisite=' . is_multisite() . '&info=' . get_bloginfo();
		$args     = array(
			'timeout'   => 15,
			'sslverify' => false,
		);
		$response = wp_remote_get( $url, $args );
		if ( is_wp_error( $response ) ) {
			return false;
		}
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		if ( $license_data->status != 'alreadyactive' && $license_data->status != 'invalid' ) {
			update_option( 'envato_theme_license_key_status', $license_data->status );
			update_option( 'envato_theme_license_token', $license_data->token );
		}
		update_option( 'envato_theme_license_checkbox', 1 );
		update_option( 'envato_theme_license_traker', 'true' );

	}
	public function deactivated( $license ) {
		$site_url = get_site_url();
		$url      = $this->liecence_endpoint . 'ck-ensl-api?licence_action=deactivate&ck-ensl-purchase-key=' . $license . '&item_id=' . $this->item_id . '&site_url=' . $site_url . '&multisite=' . is_multisite() . '&info=' . get_bloginfo();
		$args     = array(
			'timeout'   => 15,
			'sslverify' => false,
		);
		$response = wp_remote_get( $url, $args );
		if ( is_wp_error( $response ) ) {
			return false;
		}
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		update_option( 'envato_theme_license_key_status', $license_data->status );
		update_option( 'envato_theme_license_key', '' );
		update_option( 'envato_theme_license_token', '' );
		update_option( 'envato_theme_license_traker', 'true' );
		update_option( 'envato_theme_license_checkbox', 0 );
	}

	public function envato_theme_license_sanitize( $new ) {
		$old = get_option( 'envato_theme_license_key' );
		if ( $old && $old != $new ) {
			update_option( 'envato_theme_license_key_status', 'deactivated' );
		}
		return esc_attr( $new );
	}

	/* End Active Licence */
	public function envato_theme_license_dashboard_sample_admin_notice() {
		$purchase_key = trim( get_option( 'envato_theme_license_key' ) );
		$status       = get_option( 'envato_theme_license_key_status' );
		if ( $status != 'valid' || $purchase_key == '' || $this->token == '' ) {
			?>
		   <div id="setting-error-notice" class="error settings-error notice is-dismissible">
		   <p><strong><span class="setting-error-notice-heading" style="margin-top:-0.4em"><?php echo esc_html__( 'Require Activation', 'loveicon' ); ?></span><span style="display: block; margin: 0.5em 0.5em 0 0; clear: both;"><?php echo sprintf( __( "%1\$s Theme Need to active with purchase code. Otherwise you can't Active / Update Bundle Plugin. You can active from <a href='%2\$s'>Here</a>.", 'loveicon' ), $this->dashboard_Name, esc_url( admin_url() . 'admin.php?page=' . $this->menu_slug . 'product-registration' ) ); ?> </span>
		   </strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__( 'Dismiss this notice.', 'loveicon' ); ?> </span></button></div>
			   <?php
		}
	}

	/**
	 * Register a custom menu page.
	 */

	public function envato_theme_license_dashboard_add_menu() {
		global $submenu;
		$page = add_menu_page(
			$this->dashboard_Name,
			$this->dashboard_Name,
			'read',
			$this->menu_slug_dashboard,
			array( $this, 'render' ),
			'',
			6
		);
		add_submenu_page( $this->menu_slug_dashboard, 'Welcome', 'Welcome', 'manage_options', $this->menu_slug_dashboard );

		add_submenu_page( $this->menu_slug_dashboard, 'Product Registration', 'Product Registration', 'manage_options', $this->menu_slug . 'product-registration', array( $this, 'product_registration' ) );
		add_submenu_page( $this->menu_slug_dashboard, 'System Status', 'System Status', 'manage_options', $this->menu_slug . 'system-status', array( $this, 'system_status' ) );
		add_submenu_page( $this->menu_slug_dashboard, 'Plugin', 'Plugin', 'manage_options', $this->menu_slug . 'install-required-plugins', array( $this, 'plugin' ) );
		if ( class_exists( 'OCDI_Plugin' ) && $this->token == '' ) {
			add_submenu_page( $this->menu_slug_dashboard, 'Import Demo Data', 'Import Demo Data', 'manage_options', $this->menu_slug . 'demo-content-install', array( $this, 'demo_content_install' ) );
		} elseif ( ! class_exists( 'OCDI_Plugin' ) ) {
			add_submenu_page( $this->menu_slug_dashboard, 'Import Demo Data', 'Import Demo Data', 'manage_options', $this->menu_slug . 'demo-content-install', array( $this, 'demo_content_install' ) );
		}
		add_submenu_page( $this->menu_slug_dashboard, 'Support', 'Support', 'manage_options', $this->menu_slug . 'support', array( $this, 'support' ) );
	}

	public function envato_theme_license_dashboard_style() {
		wp_enqueue_style( $this->menu_slug_dashboard . '-style', get_template_directory_uri() . '/framework/dashboard/admin/css/dashboard-style.css', '', null );
		wp_enqueue_script( $this->menu_slug_dashboard . '-js', get_template_directory_uri() . '/framework/dashboard/admin/js/dashboard-js.js', array( 'jquery', 'jquery-ui-tooltip' ), '', true );
		wp_localize_script( $this->menu_slug_dashboard . '-js', 'ajax_dashboard_js', array( 'copytext' => esc_html__( 'Copied!', 'loveicon' ) ) );
	}

	public function demo_content_install() {
		$this->envato_theme_license_dashboard_get_tabs( 'demo' );
		include get_template_directory() . '/framework/dashboard/admin/demo-content-install.php';
	}

	public function support() {
		$this->envato_theme_license_dashboard_get_tabs( 'support' );
		include get_template_directory() . '/framework/dashboard/admin/support.php';
	}
	public function plugin() {
		$this->envato_theme_license_dashboard_get_tabs( 'plugin' );
		include get_template_directory() . '/framework/dashboard/admin/plugin.php';
	}

	public function system_status() {
		$this->envato_theme_license_dashboard_get_tabs( 'systemstatus' );
		include get_template_directory() . '/framework/dashboard/admin/system-status.php';
	}

	public function envato_theme_license_dashboard_get_tabs( $activetab ) {

		$tabarray = array(
			'start'        => array(
				'title' => esc_html__( 'Getting Started', 'loveicon' ),
				'link'  => '?page=' . $this->menu_slug_dashboard,
			),
			'registration' => array(
				'title' => esc_html__( 'Registration', 'loveicon' ),
				'link'  => '?page=' . $this->menu_slug . 'product-registration',
			),
			'systemstatus' => array(
				'title' => esc_html__( 'System Status', 'loveicon' ),
				'link'  => '?page=' . $this->menu_slug . 'system-status',
			),
			'plugin'       => array(
				'title' => esc_html__( 'Plugins', 'loveicon' ),
				'link'  => '?page=' . $this->menu_slug . 'install-required-plugins',
			),
		);

		if ( class_exists( 'OCDI_Plugin' ) && $this->token != '' ) {
			$tabarray['demo'] = array(
				'title' => esc_html__( 'Demo Import', 'loveicon' ),
				'link'  => '?page=' . $this->menu_slug . 'one-click-demo-import',
			);
		} else {
			$tabarray['demo'] = array(
				'title' => esc_html__( 'Demo Import', 'loveicon' ),
				'link'  => '?page=' . $this->menu_slug . 'demo-content-install',
			);
		}
		if ( class_exists( 'iconmoonFontAdd' ) && $this->token != '' ) {
			$tabarray['icon'] = array(
				'title' => esc_html__( 'Icon Add', 'loveicon' ),
				'link'  => '?page=custom-icon-upload',
			);
		}
		$tabarray['support'] = array(
			'title' => esc_html__( 'Support', 'loveicon' ),
			'link'  => '?page=' . $this->menu_slug . 'support',
		);
		?>
		<h2 class="nav-tab-wrapper">
		<?php
		foreach ( $tabarray as $key => $tab ) {
			if ( $activetab == $key ) {
				?>
				<span class="nav-tab nav-tab-active"><?php echo sprintf( __( '%s', 'loveicon' ), $tab['title'] ); ?></span>
				<?php
			} else {
				?>
				<a href="<?php echo esc_url( $tab['link'] ); ?>" class="nav-tab"><?php echo sprintf( __( '%s', 'loveicon' ), $tab['title'] ); ?></a>
				<?php
			}
		}
		?>
		</h2>
		<?php

	}

	public function product_registration() {
		$this->envato_theme_license_dashboard_get_tabs( 'registration' );
		include get_template_directory() . '/framework/dashboard/admin/activation.php';
	}
	public function render() {
		?>
		<div class="wrap">
			<div id="envato-theme-license-dashboard">
				<div id="post-body" class="columns-2">
					<div id="post-body-content">
							<div class="about-wrap">
							<?php include get_template_directory() . '/framework/dashboard/admin/wellcome.php'; ?>
							<?php $this->envato_theme_license_dashboard_get_tabs( 'start' ); ?>
							<?php include get_template_directory() . '/framework/dashboard/admin/getting-started.php'; ?>
							</div>
					</div>
				</div>

			</div>
		</div>

		<?php
	}

}

new DashboardEssential();
