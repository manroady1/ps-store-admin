<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for about table
 */
class Shipping extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'mk_shipping_method', 'id', 'shp' );
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
			$this->db->where( 'is_published', 1 );
		}
		
		// about_id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// name condition
		if ( isset( $conds['name'] )) {
			$this->db->where( 'name', $conds['name'] );
		}

		// price condition name
		if ( isset( $conds['price'] )) {
			$this->db->where( 'price', $conds['price'] );
		}

		// days condition
		if ( isset( $conds['days'] )) {
			$this->db->where( 'days', $conds['days'] );
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