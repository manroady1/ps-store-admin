<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Likes Controller
 */
class Likes extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'LIKES' );
	}

	/**
	 * List down the registered users
	 */
	function index() {
		
		// no publish filter
		$conds['no_publish_filter'] = 1;

		// get rows count
		$this->data['rows_count'] = $this->Like->count_all_by( $conds );

		// get likes
		$this->data['likes'] = $this->Like->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}
}