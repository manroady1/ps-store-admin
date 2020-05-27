<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for touch table
 */
class Favourite extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'mk_favourites', 'id', 'fav' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// fav_id condition
		if ( isset( $conds['fav_id'] )) {
			$this->db->where( 'id', $conds['fav_id'] );
		}

		// product_id condition
		if ( isset( $conds['product_id'] )) {
			$this->db->where( 'product_id', $conds['product_id'] );
		}

		// user_id condition
		if ( isset( $conds['user_id'] )) {
			$this->db->where( 'user_id', $conds['user_id'] );
		}

	}
	
}