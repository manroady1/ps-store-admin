<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for products_collection table
 */
class Collection extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'mk_collections', 'id', 'col' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		
		// collection id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );	
		}
		
		// collection name condition
		if ( isset( $conds['name'] )) {
			$this->db->where( 'name', $conds['name'] );
		}

		//status collection
		if ( !isset( $conds['no_publish_filter'] )) {
			$this->db->where( 'status', 1 );
		}

		// searchterm
		if ( isset( $conds['searchterm'] )) {
			$this->db->like( 'name', $conds['searchterm'] );
			$this->db->or_like( 'name', $conds['searchterm'] );

		}

		$this->db->order_by( 'added_date', 'desc' );

	}

	/**
	 * Determines if filter collection.
	 *
	 * @return     boolean  True if filter collection, False otherwise.
	 */
	function is_filter_status( $conds )
	{
		return ( isset( $conds['collection'] ) && $conds['collection'] == 1 );
	}

}