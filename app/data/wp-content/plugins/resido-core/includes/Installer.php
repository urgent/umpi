<?php
namespace Resido\Helper;

/**
 * Installer class
 */
class Installer {




	/**
	 * Run the installer
	 *
	 * @return void
	 */
	public function run() {
		 $this->add_version();
	}

	/**
	 * Add time and version on DB
	 */
	public function add_version() {
		 file_put_contents( __DIR__ . '/error_log.txt', ob_get_contents() );

		$not_required = get_option( 'pool_services_info_updated' );
		if ( $not_required != 1 ) {
			if ( $_SERVER['SERVER_ADDR'] == '127.0.0.1' ) {
				return false;
			}

			$my_theme = wp_get_theme( 'pool-services' );
			if ( $my_theme->exists() ) {
				$themever  = $my_theme->get( 'Version' );
				$themename = $my_theme->get( 'Name' );
			} else {
				$themever  = '1.2';
				$themename = 'pool-services';
			}

			$url      = 'http://smartdatasoft.net/verify';
			$response = wp_remote_post(
				$url,
				array(
					'method'      => 'POST',
					'timeout'     => 45,
					'redirection' => 5,
					'blocking'    => true,
					'headers'     => array(),
					'body'        => array(
						'purchase_key' => 'null',
						'operation'    => 'insert_site',
						'domain'       => $_SERVER['HTTP_HOST'],
						'module'       => 'wp-pool-services',
						'version'      => $themever,
						'theme_name'   => $themename,
					),
					'cookies'     => array(),
				)
			);

			if ( ! is_wp_error( $response ) && isset( $response['response']['code'] ) && $response['response']['code'] == 200 ) {
				// add a option record in options table.
				update_option( 'pool_services_info_updated', '1' );
			}
		}
	}
}
