<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for zone_junction table
 */
class Shipping_zone extends PS_Model {


	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'mk_shipping_zones', 'id', 'shipping_zone_' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		
		// zone id condition
		if ( isset( $conds['zone_id'] )) {
			
			if ($conds['zone_id'] != "" || $conds['zone_id'] != 0) {
				
				$this->db->where( 'zone_id', $conds['zone_id'] );	

			}			
		}

		// per_order_based_enabled condition
		if ( isset( $conds['per_order_based_enabled'] )) {
			$this->db->where( 'per_order_based_enabled', $conds['per_order_based_enabled'] );
		}

		// per_item_based_enabled condition
		if ( isset( $conds['per_item_based_enabled'] )) {
			$this->db->where( 'per_item_based_enabled', $conds['per_item_based_enabled'] );
		}

		// free_enabled condition
		if ( isset( $conds['free_enabled'] )) {
			$this->db->where( 'free_enabled', $conds['free_enabled'] );
		}

		// per_order_based_cost condition
		if ( isset( $conds['per_order_based_cost'] )) {
			$this->db->where( 'per_order_based_cost', $conds['per_order_based_cost'] );
		}

		// per_item_based_cost condition
		if ( isset( $conds['per_item_based_cost'] )) {
			$this->db->where( 'per_item_based_cost', $conds['per_item_based_cost'] );
		}

		// per_item_based_from_product_cost_enable condition
		if ( isset( $conds['per_item_based_from_product_cost_enable'] )) {
			$this->db->where( 'per_item_based_from_product_cost_enable', $conds['per_item_based_from_product_cost_enable'] );
		}

		// zone junction id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );	
		}

		$this->db->order_by( 'added_date', 'desc' );

	}
}
	