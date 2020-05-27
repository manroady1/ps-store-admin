<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for touch table
 */
class Touch extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'mk_touches', 'id', 'tou' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	*/
	function custom_conds( $conds = array())
	{
		// touch_id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// type_id condition
		if ( isset( $conds['type_id'] )) {
			$this->db->where( 'type_id', $conds['type_id'] );
		}

		// user_id condition
		if ( isset( $conds['user_id'] )) {
			$this->db->where( 'user_id', $conds['user_id'] );
		}

	}
}