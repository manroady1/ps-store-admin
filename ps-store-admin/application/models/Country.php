<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for country table
 */
class Country extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'mk_countries', 'id', 'country' );
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

		// country name condition
		if ( isset( $conds['name'] )) {
			$this->db->where( 'name', $conds['name'] );
		}
		
		// searchterm
		if ( isset( $conds['searchterm'] )) {
			$this->db->group_start();
			$this->db->like( 'name', $conds['searchterm'] );
			$this->db->or_like( 'name', $conds['searchterm'] );
			$this->db->group_end();
		}

		$this->db->order_by( 'added_date', 'desc' );
	}
}