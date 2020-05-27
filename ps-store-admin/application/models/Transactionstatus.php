<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for Transactionstatus table
 */
class Transactionstatus extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'mk_transactions_status', 'id', 'trans_sts' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// about_id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}
		if ( isset( $conds['title'] )) {
			$this->db->where( 'title', $conds['title'] );
		}
	}
}