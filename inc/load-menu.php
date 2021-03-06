<?php
/**
 * Pre-load the navigation menu as a JSON object
 *
 * @package Foxhound
 */

/**
 * Class wrapper for menu loading
 */
class Foxhound_LoadMenu {
	/**
	 * Set up actions
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_json_data' ), 25 );
	}

	/**
	 * Dumps the current menu as a JSON Object on the react script
	 */
	public function add_json_data() {
		wp_localize_script( FOXHOUND_APP, 'FoxhoundMenu', array(
			'data' => $this->get_menu_data(),
		) );
	}

	/**
	 * Gets menu data from the JSON API server
	 *
	 * @return array
	 */
	public function get_menu_data() {
		$menu = array();

		$request = new \WP_REST_Request();
		$request['context'] = 'view';
		$request['location'] = 'primary';

		if ( class_exists( 'WP_REST_Menus' ) ) {
			$menu_api = new WP_REST_Menus();
			$menu = $menu_api->get_menu_location( $request );
		}

		return $menu;
	}
}
new Foxhound_LoadMenu();
