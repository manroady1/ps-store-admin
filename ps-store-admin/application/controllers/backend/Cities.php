<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cities Controller
 */
class Cities extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'CITIES' );
	}

	/**
	 * List down the registered users
	 */
	function index() 
	{
		// no publish filter
		$conds['no_publish_filter'] = 1;

		// get rows count
		$this->data['rows_count'] = $this->City->count_all_by( $conds );
		// get categories
		$this->data['cities'] = $this->City->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}

	/**
	 * Searches for the first match.
	 */
	function search() 
	{

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'city_search' );
		
		// condition with search term
		$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )),
						'country_id' => $this->searchterm_handler( $this->input->post('country_id')) );
		
		// pagination
		$this->data['rows_count'] = $this->City->count_all_by( $conds );

		// search data
		$this->data['cities'] = $this->City->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load add list
		parent::search();
	}

	/**
	 * Create new one
	 */
	function add() 
	{
		
		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'city_add' );

		// call the core add logic
		parent::add();
		
	}

	/**
	 * Saving Logic
	 * 1) upload image
	 * 2) save category
	 * 3) save image
	 * 4) check transaction status
	 *
	 * @param      boolean  $id  The user identifier
	 */
	function save( $id = false ) 
	{

		// start the transaction
		$this->db->trans_start();
		$logged_in_user = $this->ps_auth->get_user_info();
		
		/** 
		 * Insert City Records 
		 */
		$data = array();

	    // country id
	    if ( $this->has_data( 'country_id' )) {
			$data['country_id'] = $this->get_data( 'country_id' );

		}
		// prepare city name
		if ( $this->has_data( 'name' )) {
			$data['name'] = $this->get_data( 'name' );

		}

		// if 'status' is checked,
		if ( $this->has_data( 'status' )) {
			$data['status'] = 1;
		} else {
			$data['status'] = 0;
		}

		// set timezone
		$data['added_user_id'] = $logged_in_user->user_id;

		if($id == "") {
			//save
			$data['added_date'] = date("Y-m-d H:i:s");
		} else {
			//edit
			unset($data['added_date']);
			$data['updated_date'] = date("Y-m-d H:i:s");
			$data['updated_user_id'] = $logged_in_user->user_id;
		}

		// save category
		if ( ! $this->City->save( $data, $id )) {

		// if there is an error in inserting user data,	

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );
			
			return;
		}

		
		
		// commit the transaction
		if ( ! $this->check_trans()) {
        	
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
		} else {

			if ( $id ) {
			// if user id is not false, show success_add message
				
				$this->set_flash_msg( 'success', get_msg( 'success_city_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_city_add' ));
			}
		}

		redirect( $this->module_site_url());
	}
	

	/**
	 * Delete the record
	 * 1) delete City
	 * 2) delete image from folder and table
	 * 3) check transactions
	 */
	 /**
  	* Delete the record
  	* 1) delete Country
  	* 2) check transactions
  	*/
  	function delete( $id ) {

	    // start the transaction
	    $this->db->trans_start();

	    // check access
	    $this->check_access( DEL );

	    // enable trigger to delete all products related data
	    $enable_trigger = true;

	    if ( ! $this->ps_delete->delete_city( $id, $enable_trigger )) {
	    // if there is an error in deleting countries,

	     // rollback
	     $this->trans_rollback();

	     // error message
	     $this->set_flash_msg( 'error', get_msg( 'err_model' ));
	     redirect( $this->module_site_url());
	    }
	    /**
	    * Check Transcation Status
	    */
	  	if ( !$this->check_trans()) {

	     $this->set_flash_msg( 'error', get_msg( 'err_model' )); 
	    } else {
	           
	     $this->set_flash_msg( 'success', get_msg( 'success_city_delete' ));
	    }

	    redirect( $this->module_site_url());
	}
	/**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input( $id = 0 ) {
		
		$rule = 'required|callback_is_valid_name['. $id  .']';

		$this->form_validation->set_rules( 'name', get_msg( 'city_name' ), $rule);

		if ( $this->form_validation->run() == FALSE ) {
		// if there is an error in validating,

			return false;
		}

		return true;
	}

	/**
	 * Determines if valid name.
	 *
	 * @param      <type>   $name  The  name
	 * @param      integer  $id     The  identifier
	 *
	 * @return     boolean  True if valid name, False otherwise.
	 */
	function is_valid_name( $name, $id = 0 )
	{		
		$conds['name'] = $name;

			if ( strtolower( $this->City->get_one( $id )->name ) == strtolower( $name )) {
			// if the name is existing name for that user id,
				return true;
			} else if ( $this->City->exists( ($conds ))) {
			// if the name is existed in the system,
				$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
				return false;
			}

			return true;
	}

	/**City
	 * Check City name via ajax
	 *
	 * @param      boolean  $City_id  The City identifier
	 */
	function ajx_exists( $id = false )
	{
		

		// get City name
		$name = $_REQUEST['name'];

		if ( $this->is_valid_name( $name, $id )) {
		// if the City name is valid,
			
			echo "true";
		} else {
		// if invalid City name,
			
			echo "false";
		}

		
	}


	/**
	 * Publish the record
	 *
	 * @param      integer  $city_id  The city identifier
	 */
	function ajx_publish( $city_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$city_data = array( 'status'=> 1 );
			
		// save data
		if ( $this->City->save( $city_data, $city_id )) {
			echo true;
		} else {
			echo false;
		}
	}
	
	/**
	 * Unpublish the records
	 *
	 * @param      integer  $city_id  The city identifier
	 */
	function ajx_unpublish( $city_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$city_data = array( 'status'=> 0 );
			
		// save data
		if ( $this->City->save( $city_data, $city_id )) {
			echo true;
		} else {
			echo false;
		}
	}


	/**
 	* Update the existing one
	*/
	function edit( $id ) 
	{

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'city_edit' );

		// load user
		$this->data['city'] = $this->City->get_one( $id );

		// call the parent edit logic
		parent::edit( $id );
		
	}

}