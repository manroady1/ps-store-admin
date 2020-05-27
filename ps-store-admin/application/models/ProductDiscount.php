<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for category table
 */
class ProductDiscount extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'mk_products_discount', 'id', 'prd_dis' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		
		// color 
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );
		}

		// product 
		if ( isset( $conds['product_id'] )) {
			$this->db->where( 'product_id', $conds['product_id'] );
		}

		// discount
		if ( isset( $conds['discount_id'] )) {
			$this->db->where( 'discount_id', $conds['discount_id'] );
		}

	}

}