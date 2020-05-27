<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Shop Controller
 */
class Shops extends BE_Controller {

	/**
	 * set required variable and libraries
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'SHOPS' );
	}

	/**
	 * Home page for the shops controller
	 */
	function index( $id = "shop0b69bc5dbd68bbd57ea13dfc5488e20a" ) {

		if ( $this->is_POST()) {
		// if the method is post

			// server side validation
			if ( $this->is_valid_input()) {

				// save user info
				$this->save( $id );
			}
		}


		$logged_in_user = $this->ps_auth->get_user_info();
		 
	 	$conds['status'] = 1;

		$this->data['shop'] = $this->Shop->get_one( $id );
		 
		$this->load_form($this->data);

	}

	

	function edit( $shop_id = "", $current_tab = "" )
	{
		
		$shops = $this->Shop->get_all()->result(); 
		$shop_id = $shops[0]->id;
		$this->data['shop'] = $this->Shop->get_one( $shop_id );
		$this->data['current_tab'] = $this->uri->segment(5);

		// call the parent edit logic
		parent::edit( $shop_id );

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
		//$this->db->trans_start();
		

		// prepare data for save
		$data = array();
		$logged_in_user = $this->ps_auth->get_user_info();
		// prepare shop id
		if ( $this->has_data( 'id' )) {
			$data['id'] = $this->get_data( 'id' );
		}

		// prepare shipping_id
		if ( $this->has_data( 'shipping_id' )) {
			$data['shipping_id'] = $this->get_data( 'shipping_id' );
		}

		// prepare shop name
		if ( $this->has_data( 'name' )) {
			$data['name'] = $this->get_data( 'name' );
		}

		// prepare shop description
		if ( $this->has_data( 'description' )) {
			$data['description'] = $this->get_data( 'description' );
		}

		// prepare shop email
		if ( $this->has_data( 'email' )) {
			$data['email'] = $this->get_data( 'email' );
		}

		// prepare shop lat
		if ( $this->has_data( 'lat' )) {
			$data['lat'] = $this->get_data( 'lat' );
		}

		// prepare shop lng
		if ( $this->has_data( 'lng' )) {
			$data['lng'] = $this->get_data( 'lng' );
		}

		// prepare shop address1
		if ( $this->has_data( 'address1' )) {
			$data['address1'] = $this->get_data( 'address1' );
		}

		// prepare shop address2
		if ( $this->has_data( 'address2' )) {
			$data['address2'] = $this->get_data( 'address2' );
		}

		// prepare shop address3
		if ( $this->has_data( 'address3' )) {
			$data['address3'] = $this->get_data( 'address3' );
		}

		// prepare shop about_phone1
		if ( $this->has_data( 'about_phone1' )) {
			$data['about_phone1'] = $this->get_data( 'about_phone1' );
		}

		// prepare shop about_phone2
		if ( $this->has_data( 'about_phone2' )) {
			$data['about_phone2'] = $this->get_data( 'about_phone2' );
		}

		// prepare shop about_phone2
		if ( $this->has_data( 'about_phone3' )) {
			$data['about_phone3'] = $this->get_data( 'about_phone3' );
		}

		// prepare shop about_website
		if ( $this->has_data( 'about_website' )) {
			$data['about_website'] = $this->get_data( 'about_website' );
		}

		// prepare shop facebook
		if ( $this->has_data( 'facebook' )) {
			$data['facebook'] = $this->get_data( 'facebook' );
		}

		// prepare shop google_plus
		if ( $this->has_data( 'google_plus' )) {
			$data['google_plus'] = $this->get_data( 'google_plus' );
		}

		// prepare shop instagram
		if ( $this->has_data( 'instagram' )) {
			$data['instagram'] = $this->get_data( 'instagram' );
		}

		// prepare shop youtube
		if ( $this->has_data( 'youtube' )) {
			$data['youtube'] = $this->get_data( 'youtube' );
		}

		// prepare shop pinterest
		if ( $this->has_data( 'pinterest' )) {
			$data['pinterest'] = $this->get_data( 'pinterest' );
		}

		// prepare shop twitter
		if ( $this->has_data( 'twitter' )) {
			$data['twitter'] = $this->get_data( 'twitter' );
		}

		// prepare shop messenger
		if ( $this->has_data( 'messenger' )) {
			$data['messenger'] = $this->get_data( 'messenger' );
		}

		// prepare shop stripe_publishable_key
		if ( $this->has_data( 'stripe_publishable_key' )) {
			$data['stripe_publishable_key'] = $this->get_data( 'stripe_publishable_key' );
		}

		// prepare shop stripe_secret_key
		if ( $this->has_data( 'stripe_secret_key' )) {
			$data['stripe_secret_key'] = $this->get_data( 'stripe_secret_key' );
		}

		// prepare shop bank_account
		if ( $this->has_data( 'paypal_environment' )) {
			$data['paypal_environment'] = $this->get_data( 'paypal_environment' );
		}

		// prepare shop bank_name
		if ( $this->has_data( 'paypal_merchant_id' )) {
			$data['paypal_merchant_id'] = $this->get_data( 'paypal_merchant_id' );
		}

		// prepare shop bank_code
		if ( $this->has_data( 'paypal_public_key' )) {
			$data['paypal_public_key'] = $this->get_data( 'paypal_public_key' );
		}

		// prepare shop branch_code
		if ( $this->has_data( 'paypal_private_key' )) {
			$data['paypal_private_key'] = $this->get_data( 'paypal_private_key' );
		}

		// prepare shop bank_account
		if ( $this->has_data( 'bank_account' )) {
			$data['bank_account'] = $this->get_data( 'bank_account' );
		}

		// prepare shop bank_name
		if ( $this->has_data( 'bank_name' )) {
			$data['bank_name'] = $this->get_data( 'bank_name' );
		}

		// prepare shop bank_code
		if ( $this->has_data( 'bank_code' )) {
			$data['bank_code'] = $this->get_data( 'bank_code' );
		}

		// prepare shop branch_code
		if ( $this->has_data( 'branch_code' )) {
			$data['branch_code'] = $this->get_data( 'branch_code' );
		}

		// prepare shop swift_code
		if ( $this->has_data( 'swift_code' )) {
			$data['swift_code'] = $this->get_data( 'swift_code' );
		}

		// prepare shop cod_email
		if ( $this->has_data( 'cod_email' )) {
			$data['cod_email'] = $this->get_data( 'cod_email' );
		}

		// prepare shop currency_symbol
		if ( $this->has_data( 'currency_symbol' )) {
			$data['currency_symbol'] = $this->get_data( 'currency_symbol' );
		}

		// prepare shop currency_short_form
		if ( $this->has_data( 'currency_short_form' )) {
			$data['currency_short_form'] = $this->get_data( 'currency_short_form' );
		}

		// prepare shop sender_email
		if ( $this->has_data( 'sender_email' )) {
			$data['sender_email'] = $this->get_data( 'sender_email' );
		}

		// prepare shop overall_tax_label
		if ( $this->has_data( 'overall_tax_label' )) {
			$data['overall_tax_label'] = $this->get_data( 'overall_tax_label' );
			$data['overall_tax_value'] = $this->get_data( 'overall_tax_label' ) / 100;
		}

		// prepare shop shipping_tax_label
		if ( $this->has_data( 'shipping_tax_label' )) {
			$data['shipping_tax_label'] = $this->get_data( 'shipping_tax_label' );
			$data['shipping_tax_value'] = $this->get_data( 'shipping_tax_label' ) / 100;
		}

		// prepare shop whapsapp_no
		if ( $this->has_data( 'whapsapp_no' )) {
			$data['whapsapp_no'] = $this->get_data( 'whapsapp_no');
		}

		// prepare shop refund_policy_label
		if ( $this->has_data( 'refund_policy' )) {
			$data['refund_policy'] = $this->get_data( 'refund_policy');
		}

		// if 'banktransfer_enabled' is checked,
		if ( $this->has_data( 'banktransfer_enabled' )) {
			$data['banktransfer_enabled'] = 1;
		} else {
			$data['banktransfer_enabled'] = 0;
		}

		// prepare shop privacy_policy_label
		if ( $this->has_data( 'privacy_policy' )) {
			$data['privacy_policy'] = $this->get_data( 'privacy_policy');
		}

		// prepare shop terms_label
		if ( $this->has_data( 'terms' )) {
			$data['terms'] = $this->get_data( 'terms');
		}


		// if 'status' is checked,
		if ( $this->has_data( 'status' )) {
			$data['status'] = 1;
		} else {
			$data['status'] = 0;
		}

		// if 'stripe_enabled' is checked,
		if ( $this->has_data( 'stripe_enabled' )) {
			$data['stripe_enabled'] = 1;
		} else {
			$data['stripe_enabled'] = 0;
		}

		// if 'paypal_enabled' is checked,
		if ( $this->has_data( 'paypal_enabled' )) {
			$data['paypal_enabled'] = 1;
		} else {
			$data['paypal_enabled'] = 0;
		}

		// if 'code_enabled' is checked,
		if ( $this->has_data( 'cod_enabled' )) {
			$data['cod_enabled'] = 1;
		} else {
			$data['cod_enabled'] = 0;
		}

		// if 'standard_shipping_enabled' is checked,	
		if ($this->input->post('shipping') == 'standard_shipping_enable') {
			$data['standard_shipping_enable'] = 1;
			$data['zone_shipping_enable'] = 0;
			$data['no_shipping_enable'] = 0;
		}

		// if 'zone_shipping_enabled' is checked,	
		if ($this->input->post('shipping') == 'zone_shipping_enable') {
			$data['zone_shipping_enable'] = 1;
			$data['standard_shipping_enable'] = 0;
			$data['no_shipping_enable'] = 0;
		}

		// if 'no_shipping_enabled' is checked,	
		if ($this->input->post('shipping') == 'no_shipping_enable') {
			$data['no_shipping_enable'] = 1;
			$data['zone_shipping_enable'] = 0;
			$data['standard_shipping_enable'] = 0;
		}

		// save about
		if ( ! $this->Shop->save( $data, $id )) {
		
			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model');
			
			return;
		}

		/** 
		 * Upload Image Records 
		 */
		if ( !$id ) {
			if ( ! $this->insert_images_icon_and_cover( $_FILES, 'shop', $data['id'], "cover" )) {
				// if error in saving image

				// commit the transaction
				$this->db->trans_rollback();
				
				return;
			}
			if ( ! $this->insert_images_icon_and_cover( $_FILES, 'shop-icon', $data['id'], "icon" )) {
				// if error in saving image

				// commit the transaction
				$this->db->trans_rollback();
				
				return;
			}	
		}
		
		
		$id = ( !$id )? $data['id']: $id ;
				// prepare shop tag multiple select
		if ( $id ) {
			
			if($this->get_data( 'tagselect' ) != "") {
				$data['prdselect'] = explode(",", $this->get_data( 'tagselect' ));
			} else {
				$data['prdselect'] = explode(",", $this->get_data( 'existing_tagselect' ));
			}
			
			if(!$this->ps_delete->delete_shop_tag( $id )) {
				//loop
				for($i=0; $i<count($data['prdselect']);$i++) {
					if($data['prdselect'][$i] != "") {
						$select_data['tag_id'] = $data['prdselect'][$i];
						$select_data['shop_id'] = $id;
						$select_data['added_date'] = date("Y-m-d H:i:s");
						$select_data['added_user_id'] = $logged_in_user->user_id;

						$this->Shoptag->save($select_data);
					}

				}
			}
		}

		// commit the transaction
		if ( ! $this->check_trans()) {
        	
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
		} else {

			if ( $id ) {
			// if user id is not false, show success_add message
				
				$this->set_flash_msg( 'success', get_msg( 'success_shop_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_shop_add' ));
			}
		}
		
		$this->data['current_tab'] = $this->get_data( 'current_tab');
		redirect( site_url('/admin/shops/edit/' . $id ."/". $this->get_data( 'current_tab')) );

	}



	function exports()
	{
		// Load the DB utility class
		$this->load->dbutil();
		
		// Backup your entire database and assign it to a variable
		$export = $this->dbutil->backup();
		
		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download('ps_news.zip', $export);
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