<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Zones Controller
 */
class Shipping_zones extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'Shipping Zones' );
	}

	/**
	 * List down the registered users
	 */
	function index() 
	{
		// no publish filter
		$conds['no_publish_filter'] = 1;

		// get rows count
		$this->data['rows_count'] = $this->Shipping_zone->count_all_by( $conds );
		// get shipping_zones
		$this->data['shipping_zones'] = $this->Shipping_zone->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}

	/**
	 * Searches for the first match.
	 */
	function search() {
		

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'shipping_zone_search' );
		
		// condition with search term
		$conds = array( 'zone_id' => $this->searchterm_handler( $this->input->post( 'zone_id' )) );
		// no publish filter
		$conds['no_publish_filter'] = 1;

		// pagination
		$this->data['rows_count'] = $this->Shipping_zone->count_all_by( $conds );

		// search data

		$this->data['shipping_zones'] = $this->Shipping_zone->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::search();
	}

	/**
	 * Create new one
	 */
	function add() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'shipping_zone_add' );

		// call the core add logic
		parent::add();
	}

	
	/**
	 * Saving Logic
	 * 1) upload image
	 * 2) save Shipping_zone
	 * 3) save image
	 * 4) check transaction status
	 *
	 * @param      boolean  $id  The user identifier
	 */
	function save( $id = false ) {
		//print_r($_POST);
		// start the transaction
		$this->db->trans_start();
		$logged_in_user = $this->ps_auth->get_user_info();
		
		/** 
		 * Insert Shipping_zone Records 
		 */
		$data = array();



		$shop_obj = $this->Shop->get_all()->result();

		$shop_id = $shop_obj[0]->id;

		$data['shop_id'] = $shop_id;

		// prepare name
		if ( $this->has_data( 'name' )) {
			$data['name'] = $this->get_data( 'name' );
		}

		// prepare zone_id
		if ( $this->has_data( 'zone_id' )) {
			$data['zone_id'] = $this->get_data( 'zone_id' );
		}

		// if 'per_order_based_enabled' is checked,
		if ($this->input->post('colorRadio') == 'per_order_based_enabled') {
			$data['per_order_based_enabled'] = 1;
			$data['per_item_based_enabled'] = 0;
			$data['free_enabled'] = 0;
		}

		// if 'per_item_based_enabled' is checked,	
		if ($this->input->post('colorRadio') == 'per_item_based_enabled') {
			$data['per_item_based_enabled'] = 1;
			$data['per_order_based_enabled'] = 0;
			$data['free_enabled'] = 0;
		}

		// if 'free_enabled' is checked,	
		if ($this->input->post('colorRadio') == 'free_enabled') {
			$data['free_enabled'] = 1;
			$data['per_item_based_enabled'] = 0;
			$data['per_order_based_enabled'] = 0;
		}

		// prepare per_order_based_cost
		if ( $this->has_data( 'per_order_based_cost' )) {
			$data['per_order_based_cost'] = $this->get_data( 'per_order_based_cost' );
		}

		// prepare per_item_based_cost
		if ( $this->has_data( 'per_item_based_cost' )) {
			$data['per_item_based_cost'] = $this->get_data( 'per_item_based_cost' );
		}
		

		// if 'per_item_based_from_product_cost_enable' is checked,
		if ( $this->input->post('per_item_based_from_product_cost_enable') == "on" ) {
			$data['per_item_based_from_product_cost_enable'] = 1;
		} else {
			$data['per_item_based_from_product_cost_enable'] = 0;
		}


		// prepare delivery_increment_of_zone
		if ( $this->has_data( 'delivery_increment_of_zone' )) {
			$data['delivery_increment_of_zone'] = $this->get_data( 'delivery_increment_of_zone' );
		}


		if ( $this->has_data( 'existing_zone_id' )) {
			$data['existing_zone_id'] = $this->get_data( 'existing_zone_id' );
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



		if ($id == "") {
			// print_r($shipping_zone_id);die;
			if ($shipping_zone_id == $data['zone_id']) {
				// echo "1";die;
				// zone id is already exist in shipping zone
				$this->set_flash_msg( 'error', get_msg( 'dup_zone_name' ));
			} else {
				// echo "2";die;
				$conds['zone_id'] = $data['zone_id'];
				$shipping_zone_id = $this->Shipping_zone->get_one_by($conds)->zone_id;

				if($shipping_zone_id == "") {
					//New Shipping Zone
					unset($data['existing_zone_id']);
					if ( ! $this->Shipping_zone->save( $data, $id )) {
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
							
							$this->set_flash_msg( 'success', get_msg( 'success_shipping_zone_edit' ));
						} else {
						// if user id is false, show success_edit message

							$this->set_flash_msg( 'success', get_msg( 'success_shipping_zone_add' ));
						}
					}

					redirect( $this->module_site_url());
				} else {

					$this->set_flash_msg( 'error', get_msg( 'zone_from_other_package' ));

				}

			}

			
		} else {
		

			if(trim($data['existing_zone_id']) == trim($data['zone_id'])) {
				//able to change the name and update

				unset($data['existing_zone_id']);
				if ( ! $this->Shipping_zone->save( $data, $id )) {
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
						
						$this->set_flash_msg( 'success', get_msg( 'success_shipping_zone_edit' ));
					} else {
					// if user id is false, show success_edit message

						$this->set_flash_msg( 'success', get_msg( 'success_shipping_zone_add' ));
					}
				}

				redirect( $this->module_site_url());
			} else {
				//Need to check that select zone is already exist or not?
				$conds['zone_id'] = $data['zone_id'];
				$shipping_zone_id = $this->Shipping_zone->get_one_by($conds)->zone_id;


				if($shipping_zone_id == "") {

					//ok to update
					unset($data['existing_zone_id']);
					if ( ! $this->Shipping_zone->save( $data, $id )) {
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
							
							$this->set_flash_msg( 'success', get_msg( 'success_shipping_zone_edit' ));
						} else {
						// if user id is false, show success_edit message

							$this->set_flash_msg( 'success', get_msg( 'success_shipping_zone_add' ));
						}
					}

					redirect( $this->module_site_url());

				} else {

					//not allow show error
					$this->set_flash_msg( 'error', get_msg( 'zone_from_other_package' ));
			
				}

			}

			
			
		}
		
	}

	/**
 	* Update the existing one
	*/
	function edit( $id ) 
	{

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'shipping_zone_edit' );

		// load user
		$this->data['shipping_zone'] = $this->Shipping_zone->get_one( $id );

		// call the parent edit logic
		parent::edit( $id );

	}

	/**
	 * Delete the record
	 * 1) delete Shipping_zone
	 * 2) delete image from folder and table
	 * 3) check transactions
	 */
	function delete( $shipping_zone_id ) {

		// start the transaction
		$this->db->trans_start();

		// check access
		$this->check_access( DEL );

		// delete shipping_zones and images
		$enable_trigger = true; 
		
		// delete shipping_zones and images
		$type = "shipping_zone";

		if ( !$this->ps_delete->delete_shipping_zone( $shipping_zone_id, $type, $enable_trigger )) {

			// set error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));

			// rollback
			$this->trans_rollback();

			// redirect to list view
			redirect( $this->module_site_url());
		}
			
		/**
		 * Check Transcation Status
		 */
		if ( !$this->check_trans()) {

			$this->set_flash_msg( 'error', get_msg( 'err_model' ));	
		} else {
        	
			$this->set_flash_msg( 'success', get_msg( 'success_shipping_zone_delete' ));
		}
		
		redirect( $this->module_site_url());
	}

	/**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input( $id = 0 ) 
	{
		
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
		return true;
	}

	
	/**
	 * Publish the record
	 *
	 * @param      integer  $Shipping_zone_id  The Shipping_zone identifier
	 */
	function ajx_publish( $shipping_zone_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$shipping_zone_data = array( 'status'=> 1 );
			
		// save data
		if ( $this->Shipping_zone->save( $shipping_zone_data, $shipping_zone_id )) {
			echo true;
		} else {
			echo false;
		}
	}
	
	/**
	 * Unpublish the records
	 *
	 * @param      integer  $Shipping_zone_id  The Shipping_zone identifier
	 */
	function ajx_unpublish( $shipping_zone_id = 0 )
	{
		// check access
		$this->check_access( PUBLISH );
		
		// prepare data
		$shipping_zone_data = array( 'status'=> 0 );
			
		// save data
		if ( $this->Shipping_zone->save( $shipping_zone_data, $shipping_zone_id )) {
			echo true;
		} else {
			echo false;
		}
	}



}