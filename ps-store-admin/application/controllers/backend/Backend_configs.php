<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Likes Controller
 */

class Backend_configs extends BE_Controller {
		/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'BACKEND SETTING' );
	}

	/**
	 * Load About Entry Form
	 */

	function index( $id = "be1" ) {

		if ( $this->is_POST()) {
		// if the method is post

			// server side validation
			if ( $this->is_valid_input()) {

				// save user info
				$this->save( $id );
			}
		}

		//Get Backend_config Object
		$this->data['backend'] = $this->Backend_config->get_one( $id );

		$this->load_form($this->data);

	}

	/**
	 * Update the existing one
	 */
	function edit( $id = "be1") {


		// load user
		$this->data['backend'] = $this->Backend_config->get_one( $id );

		// call the parent edit logic
		parent::edit( $id );
	}

	/**
	 * Saving Logic
	 * 1) save about data
	 * 2) check transaction status
	 *
	 * @param      boolean  $id  The about identifier
	 */
	function save( $id = false ) {

		// start the transaction
		$this->db->trans_start();
		
		// prepare data for save
		$data = array();

		// sender_name
		if ( $this->has_data( 'sender_name' )) {
			$data['sender_name'] = $this->get_data( 'sender_name' );
		}

		// sender_email
		if ( $this->has_data( 'sender_email' )) {
			$data['sender_email'] = $this->get_data( 'sender_email' );
		}

		// receive_email
		if ( $this->has_data( 'receive_email' )) {
			$data['receive_email'] = $this->get_data( 'receive_email' );
		}

		// fcm_api_key
		if ( $this->has_data( 'fcm_api_key' )) {
			$data['fcm_api_key'] = $this->get_data( 'fcm_api_key' );
		}

		// smtp_host
		if ( $this->has_data( 'smtp_host' )) {
			$data['smtp_host'] = $this->get_data( 'smtp_host' );
		}

		// smtp_port
		if ( $this->has_data( 'smtp_port' )) {
			$data['smtp_port'] = $this->get_data( 'smtp_port' );
		}

		// smtp_user
		if ( $this->has_data( 'smtp_user' )) {
			$data['smtp_user'] = $this->get_data( 'smtp_user' );
		}

		// smtp_pass
		if ( $this->has_data( 'smtp_pass' )) {
			$data['smtp_pass'] = $this->get_data( 'smtp_pass' );
		}

		// if 'smtp_enable' is checked,
		if ( $this->has_data( 'smtp_enable' )) {
			$data['smtp_enable'] = 1;
		} else {
			$data['smtp_enable'] = 0;
		}
	
		// save backend config
		if ( ! $this->Backend_config->save( $data, $id )) {
		// if there is an error in inserting user data,	

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );
			
			return;
		}
		/** 
		 * Upload Image Records 
		 */
		if ( !$id ) {
			if ( ! $this->insert_images( $_FILES, 'backend_config', $data['id'])) {
				// if error in saving image

					// commit the transaction
					$this->db->trans_rollback();
					
					return;
				}
			}


		// commit the transaction
		if ( ! $this->check_trans()) {
        	
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
		} else {
			
			if ( $id ) {
			// if user id is not false, show success_add message
				
				$this->set_flash_msg( 'success', get_msg( 'success_backend_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_backend_add' ));
			}
		}

		
		redirect( site_url('/admin/backend_configs') );

	}

	 /**
	 * Determines if valid input.
	 *
	 * @return     boolean  True if valid input, False otherwise.
	 */
	function is_valid_input( $id = 0 ) {
 		return true;
	}
}