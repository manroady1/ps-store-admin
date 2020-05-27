<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Zones Controller
 */
class Zones extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'ZONES' );
	}

	/**
	 * List down the registered users
	 */
	function index() 
	{
		// no publish filter
		$conds['no_publish_filter'] = 1;

		// get rows count
		$this->data['rows_count'] = $this->Zone->count_all_by( $conds );
		// get categories
		$this->data['zones'] = $this->Zone->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}

	/**
	 * Searches for the first match.
	 */
	function search() 
	{
		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'zone_search' );
		
		// condition with search term
		$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )));

		// pagination
		$this->data['rows_count'] = $this->Zone->count_all_by( $conds );

		// search data
		$this->data['zones'] = $this->Zone->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load add list
		parent::search();
	}

	/**
	 * Create new one
	 */
	function add() 
	{

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'zone_add' );

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
		 * Insert Zone Records 
		 */
		$data = array();
		//print_r($_POST);die;

		// prepare Zone name
		if ( $this->has_data( 'name' )) {
			$data['name'] = $this->get_data( 'name' );

		}

		// if 'status' is checked,
		if ( $this->has_data( 'status' )) {
			$data['status'] = 1;
		} else {
			$data['status'] = 0;
		}

		$shop_obj = $this->Shop->get_all()->result();

		$shop_id = $shop_obj[0]->id;

		$data['shop_id'] = $shop_id;

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
		if ( ! $this->Zone->save( $data, $id )) {

		// if there is an error in inserting user data,	

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );
			
			return;
		}
		//print_r($data['id']);die;	

		//zone id

		if($id == "") {
			$zone_data['zone_id'] = $data['id'];

		} else {
			$zone_data['zone_id'] = $id;
			$this->Zone_junction->delete_by( $zone_data );
		}


		// country id
	    if ( $this->has_data( 'country_id' )) {
			$zone_data['country_id'] = $this->get_data( 'country_id' );

		}


		// city id
		if(count($this->input->post("city_id")) == 1) {
			$zone_data['city_id'] = $this->input->post("city_id")[0];
			$this->Zone_junction->save( $zone_data );

		} else {

			 	$city_arr = $this->input->post("city_id");
			 	for ($i=0; $i < count($city_arr) ; $i++) { 
			 		$zone_data['city_id'] = $city_arr[$i];
			 		$this->Zone_junction->save( $zone_data );
			 	}
			 
		}	
		
		// commit the transaction
		if ( ! $this->check_trans()) {
        	
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
		} else {

			if ( $id ) {
			// if user id is not false, show success_add message
				
				$this->set_flash_msg( 'success', get_msg( 'success_zone_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_zone_add' ));
			}
		}

		redirect( $this->module_site_url());
	}
	

	/**
	 * Delete the record
	 * 1) delete Zone
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

	    //print_r($id);die;

	    $zone_data['zone_id'] = $id;
		$this->Zone_junction->delete_by( $zone_data );

	    if ( ! $this->ps_delete->delete_zone( $id, $enable_trigger )) {
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
	           
	     $this->set_flash_msg( 'success', get_msg( 'success_zone_delete' ));
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
			if ( strtolower( $this->Zone->get_one( $id )->name ) == rtrim(strtolower( $name ))) {
			// if the name is existing name for that user id,
				return true;
			} else if ( $this->Zone->exists( ($conds ))) {
			// if the name is existed in the system,
				$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
				return false;
			}

			return true;
	}

	/**Zone
	 * Check Zone name via ajax
	 *
	 * @param      boolean  $Zone_id  The Zone identifier
	 */
	function ajx_exists( $id = false )
	{
		

		// get Zone name
		$name = $_REQUEST['name'];

		if ( $this->is_valid_name( $name, $id )) {
		// if the Zone name is valid,
			
			echo "true";
		} else {
		// if invalid Zone name,
			
			echo "false";
		}

		
	}


	/**
	 * Publish the record
	 *
	 * @param      integer  $Zone_id  The Zone identifier
	 */
	function ajx_publish( $zone_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$zone_data = array( 'status'=> 1 );
			
		// save data
		if ( $this->Zone->save( $zone_data, $zone_id )) {
			echo true;
		} else {
			echo false;
		}
	}
	
	/**
	 * Unpublish the records
	 *
	 * @param      integer  $Zone_id  The Zone identifier
	 */
	function ajx_unpublish( $zone_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$zone_data = array( 'status'=> 0 );
			
		// save data
		if ( $this->Zone->save( $zone_data, $zone_id )) {
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
		$this->data['action_title'] = get_msg( 'zone_edit' );

		// load user
		$this->data['zone'] = $this->Zone->get_one( $id );

		// call the parent edit logic
		parent::edit( $id );
		
	}

	function get_all_cities( $country_id )
    {
    	$conds['country_id'] = $country_id;
    	
    	//get all cities from zone_junctions table
		$cond_zone_jun['country_id'] = $country_id;
		$cities_from_zone_junctions = $this->Zone_junction->get_all_by( $cond_zone_jun )->result();

		$zj_array = array();

		foreach ( $cities_from_zone_junctions as $zj_city ) {
			$zj_array[] = $zj_city->city_id;
		}


    	$cities = $this->City->get_all_not_in_city($zj_array,false,false,$country_id);
		echo json_encode($cities->result());
    }

}