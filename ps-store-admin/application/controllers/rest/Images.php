<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for News
 */
class Images extends API_Controller
{

	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		parent::__construct( 'Image' );
	}

	function upload_post()
	{
		
		$platform_name = $this->post('platform_name');
		if ( !$platform_name ) {
			$this->custom_response( get_msg('require_platform') ) ;
		}
		
		$user_id = $this->post('user_id');

		if($platform_name == "ios") {
			
			
			if ( !$user_id ) {
				$this->custom_response( get_msg('require_user_id') );
			}
			
			$uploaddir = 'uploads/';
			
			$path_parts = pathinfo( $_FILES['pic']['name'] );
			$filename = $path_parts['filename'] . date( 'YmdHis' ) .'.'. $path_parts['extension'];
			
			if (move_uploaded_file($_FILES['pic']['tmp_name'], $uploaddir . $filename)) {
			   $user_data = array( 'user_profile_photo' => $filename );
				   if ( $this->User->save( $user_data, $user_id ) ) {
					   	
					   	$user = $this->User->get_one( $user_id );

					   	$this->ps_adapter->convert_user( $user );
					   	
					   	$this->custom_response( $user );
				   } else {
					   	$this->error_response( get_msg('file_na') );
				   }
			   
			} else {
			   $this->error_response( get_msg('file_na') );
				
			}
			
		} else {
			
			$uploaddir = 'uploads/';
			
			$path_parts = pathinfo( $_FILES['file']['name'] );
			$filename = $path_parts['filename'] . date( 'YmdHis' ) .'.'. $path_parts['extension'];
			
			if (move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir . $filename)) {
			   $user_data = array( 'user_profile_photo' => $filename );
				   if ( $this->User->save( $user_data, $user_id ) ) {

					   	$user = $this->User->get_one( $user_id );

					   	$this->ps_adapter->convert_user( $user );
					   	
					   	$this->custom_response( $user );

				   } else {
					   	$this->error_response( get_msg('file_na') );
				   }
			   
			} else {
			   $this->error_response( get_msg('file_na') );
				
			}
		}
		
	}
}