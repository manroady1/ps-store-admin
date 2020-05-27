<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for shop table
 */
class Shop extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'mk_shops', 'id', 'shop' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// about_id condition
		if ( isset( $conds['no_publish_filter'] )) {
			$this->db->where( 'status', $conds['no_publish_filter'] );
		}
	
		// about_id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// standard_shipping_enable condition
		if ( isset( $conds['standard_shipping_enable'] )) {
			$this->db->where( 'standard_shipping_enable', $conds['standard_shipping_enable'] );
		}

		// zone_shipping_enable condition
		if ( isset( $conds['zone_shipping_enable'] )) {
			$this->db->where( 'zone_shipping_enable', $conds['zone_shipping_enable'] );
		}

		// no_shipping_enable condition
		if ( isset( $conds['no_shipping_enable'] )) {
			$this->db->where( 'no_shipping_enable', $conds['no_shipping_enable'] );
		}

		// searchterm
		if ( isset( $conds['searchterm'] )) {
			$this->db->group_start();
			$this->db->like( 'name', $conds['searchterm'] );
			$this->db->or_like( 'name', $conds['searchterm'] );
			$this->db->group_end();
		}
	}
	
}
?>