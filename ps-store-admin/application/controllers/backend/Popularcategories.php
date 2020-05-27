<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Popularcategories Controller
 */
class Popularcategories extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'Most Popular Categories' );
	}

	/**
	 * List down the registered users
	 */
	function index() {
		
		// no publish filter
		$conds['no_publish_filter'] = 1;

		// get rows count
		$this->data['rows_count'] = $this->Popularcategory->count_category_by($conds);
		
		// get categories
		$this->data['popularcategories'] = $this->Popularcategory->get_category_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}

	/**
	 * Searches for the first match.
	 */
	function search() {
		

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'popular_cat_search' );

		// condition with search term

		if ($this->input->post('submit') != NULL ) {
			$conds = array( 'search_term' => $this->searchterm_handler( $this->input->post( 'search_term' )) );

			// condition passing date
			$conds['date'] = $this->input->post( 'date' );

			if($this->input->post('search_term') != "") {
				$conds['search_term'] = $this->input->post('search_term');
				$this->data['search_term'] = $this->input->post('search_term');
				$this->session->set_userdata(array("search_term" => $this->input->post('search_term')));
			} else {
				
				$this->session->set_userdata(array("search_term" => NULL));
			}

			if($this->input->post('date') != "") {
				$conds['date'] = $this->input->post('date');
				$this->data['date'] = $this->input->post('date');
				$this->session->set_userdata(array("date" => $this->input->post('date')));
			} else {
				
				$this->session->set_userdata(array("date" => NULL));
			}


		} else {

			//read from session value
			if($this->session->userdata('search_term') != NULL){
				$conds['search_term'] = $this->session->userdata('search_term');
				$this->data['search_term'] = $this->session->userdata('search_term');
			}

			if($this->session->userdata('date') != NULL){
				$conds['date'] = $this->session->userdata('date');
				$this->data['date'] = $this->session->userdata('date');
			}


		}
		
		// no publish filter

		$conds['no_publish_filter'] = 1;

		// pagination
		$this->data['rows_count'] = $this->Popularcategory->count_category_by( $conds );
		//print_r($this->data['rows_count']); die;
		// search data
		$this->data['popularcategories'] = $this->Popularcategory->get_category_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::search();
	}
	/**
	 	* Update the existing one
		*/
		function edit( $id ) {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'popular_cat_view' );

		// load user
		$this->data['popularcategory'] = $this->Popularcategory->get_one( $id );

		// call the parent edit logic
		parent::edit( $id );
		}
}