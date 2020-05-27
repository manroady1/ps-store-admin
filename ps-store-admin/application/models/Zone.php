<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for zone table
 */
class Zone extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'mk_zones', 'id', 'zone' );
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
	
		// zone id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );	
		}

		// zone name condition
		if ( isset( $conds['name'] )) {
			$this->db->where( 'name', $conds['name'] );
		}

		// shop id condition
		if ( isset( $conds['shop_id'] )) {
			
			if ($conds['shop_id'] != "" || $conds['shop_id'] != 0) {
				
				$this->db->where( 'shop_id', $conds['shop_id'] );	

			}			
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
	