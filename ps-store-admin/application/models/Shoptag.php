<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for about table
 */
class Shoptag extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'mk_shops_tags', 'id', 'shoptags' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// tag_id condition
		if ( isset( $conds['tag_id'] )) {
			$this->db->where( 'tag_id', $conds['tag_id'] );
		}

	}
}