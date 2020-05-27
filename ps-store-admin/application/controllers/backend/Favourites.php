<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Favourites Controller
 */
class Favourites extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'FAVOURITES' );
	}

	/**
	 * List down the registered users
	 */
	function index() {
		
		// no publish filter
		$conds['no_publish_filter'] = 1;

		// get rows count
		$this->data['rows_count'] = $this->Favourite->count_all_by( $conds );

		// get favourites
		$this->data['favourites'] = $this->Favourite->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}
}