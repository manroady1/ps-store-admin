<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for city table
 */
class City extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'mk_cities', 'id', 'city' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
	
		
		// default where clause
		if ( !isset( $conds['no_publish_filter'] )) {
			$this->db->where( 'status', 1 );
		}


		// country id condition
		if ( isset( $conds['country_id'] )) {
			
			if ($conds['country_id'] != "" || $conds['country_id'] != 0) {
				
				$this->db->where( 'country_id', $conds['country_id'] );	

			}			
		}

		// city id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );	
		}

		// city name condition
		if ( isset( $conds['name'] )) {
			$this->db->where( 'name', $conds['name'] );
		}

		// search_term
		if ( isset( $conds['searchterm'] )) {
			
			if ($conds['searchterm'] != "") {
				$this->db->group_start();
				$this->db->like( 'name', $conds['searchterm'] );
				$this->db->or_like( 'name', $conds['searchterm'] );
				$this->db->group_end();
			}
			
			}

		$this->db->order_by( 'added_date', 'desc' );

	}
}
	