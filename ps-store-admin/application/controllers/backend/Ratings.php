<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ratings Controller
 */
class Ratings extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'RATINGS' );
	}

	/**
	 * List down the registered users
	 */
	function index() {
		
		// no publish filter
		$conds['no_publish_filter'] = 1;

		// get rows count
		$this->data['rows_count'] = $this->Rate->count_all_by( $conds );

		// get ratings
		$this->data['ratings'] = $this->Rate->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}
}