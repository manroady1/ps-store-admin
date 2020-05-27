<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for News
 */
class Rates extends API_Controller
{

	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		parent::__construct( 'Rate' );

		// set the validation rules for create and update
		$this->validation_rules();
	}

	/**
	 * Determines if valid input.
	 */
	function validation_rules()
	{
		// validation rules for create
		$this->create_validation_rules = array(
			array(
	        	'field' => 'rating',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'title',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'description',
	        	'rules' => 'required'
	        )
        );
	}


	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		// call parent convert object
		parent::convert_object( $obj );

		$this->ps_adapter->convert_rating( $obj );

	}

}