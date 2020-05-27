<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Shippings Controller
 */
class Shippings extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'SHIPPINGS' );
	}

	/**
	 * List down the registered users
	 */
	function index() {
		
		// no delete flag
		// no publish filter
		$conds['no_publish_filter'] = 1;

		// get rows count
		$this->data['rows_count'] = $this->Shipping->count_all_by( $conds );

		// get shippings
		$this->data['shippings'] = $this->Shipping->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}

	/**
	 * Searches for the first match.
	 */
	function search() {
		

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'shipping_search' );
		
		// condition with search term
		$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )) );
		// no publish filter
		$conds['no_publish_filter'] = 1;

		// pagination
		$this->data['rows_count'] = $this->Shipping->count_all_by( $conds );

		// search data

		$this->data['shippings'] = $this->Shipping->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::search();
	}

	/**
	 * Create new one
	 */
	function add() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'shipping_add' );

		// call the core add logic
		parent::add();
	}

	
	/**
	 * Saving Logic
	 * 1) upload image
	 * 2) save Shipping
	 * 3) save image
	 * 4) check transaction status
	 *
	 * @param      boolean  $id  The user identifier
	 */
	function save( $id = false ) {

		// start the transaction
		$this->db->trans_start();
		$logged_in_user = $this->ps_auth->get_user_info();
		
		/** 
		 * Insert Shipping Records 
		 */
		$data = array();

		// prepare cat name
		if ( $this->has_data( 'name' )) {
			$data['name'] = $this->get_data( 'name' );
		}

		// prepare Shipping price
		if ( $this->has_data( 'price' )) {
			$data['price'] = $this->get_data( 'price' );
		}

		// prepare Shipping days
		if ( $this->has_data( 'days' )) {
			$data['days'] = $this->get_data( 'days' );
		}


		if ( $this->has_data( 'is_published' )) {
			$data['is_published'] = 1;
		} else {
			$data['is_published'] = 0;
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
		//save Shipping
		if ( ! $this->Shipping->save( $data, $id )) {
		// if there is an error in inserting user data,	

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );
			
			return;
		}

		
		/** 
		 * Check Transactions 
		 */

		// commit the transaction
		if ( ! $this->check_trans()) {
        	
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
		} else {

			if ( $id ) {
			// if user id is not false, show success_add message
				
				$this->set_flash_msg( 'success', get_msg( 'success_shipping_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_shipping_add' ));
			}
		}

		redirect( $this->module_site_url());
	}

	/**
 	* Update the existing one
	*/
	function edit( $id ) 
	{

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'shipping_edit' );

		// load user
		$this->data['shipping'] = $this->Shipping->get_one( $id );

		// call the parent edit logic
		parent::edit( $id );

	}

	/**
	 * Delete the record
	 * 1) delete Shipping
	 * 2) delete image from folder and table
	 * 3) check transactions
	 */
		
  	function delete( $id ) {

	    // start the transaction
	    $this->db->trans_start();

	    // check access
	    $this->check_access( DEL );

	    // enable trigger to delete all products related data
	    $enable_trigger = true;

	    if ( ! $this->ps_delete->delete_shipping( $id, $enable_trigger )) {
	    // if there is an error in deleting products,

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
	           
	     $this->set_flash_msg( 'success', get_msg( 'success_shipping_delete' ));
	    }

	    redirect( $this->module_site_url());
	}

	/**
	/**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input( $id = 0 ) 
	{
		
		$rule = 'required|callback_is_valid_name['. $id  .']';

		$this->form_validation->set_rules( 'name', get_msg( 'name' ), $rule);
		
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

			if ( strtolower( $this->Shipping->get_one( $id )->name ) == strtolower( $name )) {
			// if the name is existing name for that user id,
				return true;
			} else if ( $this->Shipping->exists( ($conds ))) {
			// if the name is existed in the system,
				$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
				return false;
			}
			return true;
	}

	/**
	 * Check Shipping name via ajax
	 *
	 * @param      boolean  $cat_id  The cat identifier
	 */
	function ajx_exists( $id = false )
	{
		// get Shipping name
		$cat_name = $_REQUEST['name'];

		if ( $this->is_valid_name( $cat_name, $id )) {
		// if the Shipping name is valid,
			
			echo "true";
		} else {
		// if invalid Shipping name,
			
			echo "false";
		}
	}

	/**
	 * Publish the record
	 *
	 * @param      integer  $shipping_id  The Shipping identifier
	 */
	function ajx_publish( $shipping_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$shipping_data = array( 'is_published'=> 1 );
			
		// save data
		if ( $this->Shipping->save( $shipping_data, $shipping_id )) {
			echo true;
		} else {
			echo false;
		}
	}
	
	/**
	 * Unpublish the records
	 *
	 * @param      integer  $shipping_id  The Shipping identifier
	 */
	function ajx_unpublish( $shipping_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$shipping_data = array( 'is_published'=> 0 );
			
		// save data
		if ( $this->Shipping->save( $shipping_data, $shipping_id )) {
			echo true;
		} else {
			echo false;
		}
	}
}