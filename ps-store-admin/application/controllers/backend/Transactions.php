<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Transactions Controller
 */
class Transactions extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'TRANSACTIONS' );

		// load the mail library
		$this->load->library( 'PS_Mail' );
	}

	/**
	 * List down the registered users
	 */
	function index() {
		
		// no publish filter
		$conds['no_publish_filter'] = 1;

		// get rows count
		$this->data['rows_count'] = $this->Transactionheader->count_all_by( $conds );

		// get transactions
		$this->data['transactions'] = $this->Transactionheader->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}
	/**
	 * Searches for the first match.
	 */
	function search($status_id = 0) {
		

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'trans_search' );
		
		// condition with search term
		if($this->input->post('submit') != NULL ){

			$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )));

			// condition passing date
			$conds['date'] = $this->input->post( 'date' );

			// no publish filter
			$conds['no_publish_filter'] = 1;

			if($this->input->post('searchterm') != "") {
				$conds['searchterm'] = $this->input->post('searchterm');
				$this->data['searchterm'] = $this->input->post('searchterm');
				$this->session->set_userdata(array("searchterm" => $this->input->post('searchterm')));
			} else {
				
				$this->session->set_userdata(array("searchterm" => NULL));
			}

			if($this->input->post('date') != "") {
				$conds['date'] = $this->input->post('date');
				$this->data['date'] = $this->input->post('date');
				$this->session->set_userdata(array("date" => $this->input->post('date')));
			} else {
				
				$this->session->set_userdata(array("date" => NULL));
			}
		
			if($this->input->post('trans_status_id') != "") {
				$conds['trans_status_id'] = $this->input->post('trans_status_id');
				$this->data['trans_status_id'] = $this->input->post('trans_status_id');
				$this->session->set_userdata(array("trans_status_id" => $this->input->post('trans_status_id')));
			} else {
				
				$this->session->set_userdata(array("trans_status_id" => NULL));
			}
		
		
		} else {
			//$conds['no_publish_filter'] = 1;
			
			if($this->session->userdata('trans_status_id') != NULL){
				
				$this->data['trans_status_id'] = $this->session->userdata('trans_status_id');
				$conds['trans_status_id'] = $this->session->userdata('trans_status_id');

			} 

			//read from session value
			if($this->session->userdata('searchterm') != NULL){
				//echo "7";die;
				$conds['searchterm'] = $this->session->userdata('searchterm');
				$this->data['searchterm'] = $this->session->userdata('searchterm');
			}
			if($this->session->userdata('date') != NULL){
				$conds['date'] = $this->session->userdata('date');
				$this->data['date'] = $this->session->userdata('date');
			}


		}

			// pagination
			$this->data['rows_count'] = $this->Transactionheader->count_all_by( $conds );

			// search data
			$this->data['transactions'] = $this->Transactionheader->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
			
			// load add list
			parent::search();
	}

	/**
	* Update the existing one
	*/
	function edit( $id ) {

		// load user
		$this->data['transaction'] = $this->Transactionheader->get_one( $id );

		redirect(site_url('admin/transactions/'));
	}

	/**
	 	* Update the existing one
		*/
	function update() {
		

		$id = $this->input->post('trans_header_id');
		$status_id = $this->input->post('trans_status_id');
		$user_id = $this->Transactionheader->get_one( $id )->user_id;

		//get device token from user
		$device_token = $this->User->get_one($user_id)->device_token;

		
		$device_tokens[] = $device_token;
		$title = $this->Transactionstatus->get_one($status_id)->title;
		$message = "Order status has been changed to " . $title;

		$status = $this->send_android_fcm( $device_tokens, array( "message" => $message ));
		if ( !$status ) $error_msg .= "Fail to push all android devices <br/>";

		// load user
		$this->data['transaction'] = $this->Transactionheader->get_one( $id );

		parent::status_edit($id,$status_id);
	}

	/**
	* Sending Message From FCM For Android
	*/
	function send_android_fcm( $registatoin_ids, $message) 
    {
    	//Google cloud messaging GCM-API url
    	$url = 'https://fcm.googleapis.com/fcm/send';
    	$fields = array(
    	    'registration_ids' => $registatoin_ids,
    	    'data' => $message,
    	);
    	// Update your Google Cloud Messaging API Key
    	//define("GOOGLE_API_KEY", "AIzaSyCCwa8O4IeMG-r_M9EJI_ZqyybIawbufgg");
    	define("GOOGLE_API_KEY", $this->Backend_config->get_one('be1')->fcm_api_key);  	
    		
    	$headers = array(
    	    'Authorization: key=' . GOOGLE_API_KEY,
    	    'Content-Type: application/json'
    	);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);	
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    	$result = curl_exec($ch);				
    	if ($result === FALSE) {
    	    die('Curl failed: ' . curl_error($ch));
    	}
    	curl_close($ch);

    	return $result;
    }

	/**
	* View transaction Detail
	*/
	function detail($id)
	{
		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'trans_detail' );

		$detail = $this->Transactionheader->get_one( $id );
		$this->data['transaction'] = $detail;

		$this->load_detail( $this->data );
	}
	/**
	 * Saving Logic
	 * 1) upload image
	 * 2) save attribute
	 * 3) save image
	 * 4) check transaction status
	 *
	 * @param      boolean  $id  The user identifier
	 */
		function save( $id  = false, $status_id = 0 ) {

		// save Transaction

		$data['trans_status_id'] = $status_id;

		if ( ! $this->Transactionheader->save( $data, $id )) {
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
					
					$this->set_flash_msg( 'success', get_msg( 'success_trans_edit' ));
				}
			}


			redirect(site_url() . "/admin/transactions/detail/" . $id);
	}

	function filter_from_dashboard($status_id) {
		
		$this->session->set_userdata("trans_status_id", $status_id);

		redirect(site_url() . "/admin/transactions/search");

	}

}