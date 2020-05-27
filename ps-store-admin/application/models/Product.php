<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for product table
 */
class Product extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'mk_products', 'id', 'prd' );
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
		
		// order by
		if ( isset( $conds['order_by'] )) {

			$order_by_field = $conds['order_by_field'];
			$order_by_type = $conds['order_by_type'];
			
			$this->db->order_by( 'mk_products.'.$order_by_field, $order_by_type);
		}

		// product id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );	
		}

		// category id condition
		if ( isset( $conds['cat_id'] )) {
			
			if ($conds['cat_id'] != "") {
				if($conds['cat_id'] != '0'){
				
					$this->db->where( 'cat_id', $conds['cat_id'] );	
				}

			}			
		}

		//  sub category id condition 
		if ( isset( $conds['sub_cat_id'] )) {
			
			if ($conds['sub_cat_id'] != "") {
				if($conds['sub_cat_id'] != '0'){
				
					$this->db->where( 'sub_cat_id', $conds['sub_cat_id'] );	
				}

			}			
		}

		// product unit condition
		if ( isset( $conds['product_unit'] )) {
			$this->db->where( 'product_unit', $conds['product_unit'] );
		}

		// product measurement condition
		if ( isset( $conds['product_measurement'] )) {
			$this->db->where( 'product_measurement', $conds['product_measurement'] );
		}

		// rating condition
		if ( isset( $conds['rating_value'] ) ) {
			// For Rating value with comma 3,4,5
			// $rating_value = explode(',', $conds['rating_value']);
			// $this->db->where_in( 'overall_rating', $rating_value);

			// For single rating value
			$this->db->where( 'overall_rating >=', $conds['rating_value'] );
		}

		// product_name condition
		if ( isset( $conds['name'] )) {
			$this->db->where( 'name', $conds['name'] );
		}

		if ( isset( $conds['desc'] )) {
			$this->db->where( 'description', $conds['desc'] );
		}

		// product keywords
		if ( isset( $conds['search_tag'] )) {
			$this->db->where( 'search_tag', $conds['search_tag'] );
		}

		// product highlight information condition
		if ( isset( $conds['info'] )) {
			$this->db->where( 'highlight_information', $conds['info'] );
		}

		// product code
		if ( isset( $conds['code'] )){
			$this->db->where( 'code', $conds['code'] );
		}

		// product shipping_cost
		if ( isset( $conds['shipping_cost'] )){
			$this->db->where( 'shipping_cost', $conds['shipping_cost'] );
		}

		// product minimum_order
		if ( isset( $conds['minimum_order'] )){
			$this->db->where( 'minimum_order', $conds['minimum_order'] );
		}

		// point condition
		if ( isset( $conds['price_min'] ) || isset( $conds['price_max'] )) {
			$this->db->where( 'unit_price >= ', $conds['price_min'] );
			$this->db->where( 'unit_price <= ', $conds['price_max'] );
		}

		// feature products
		if ( isset( $conds['is_featured'] )) {
			$this->db->where( 'is_featured', $conds['is_featured'] );
		}

		// feature products
		if ( isset( $conds['is_discount'] )) {
			$this->db->where( 'is_discount', $conds['is_discount'] );
		}

		// point condition
		if ( isset( $conds['rating_min'] ) ) {
			$this->db->where( 'overall_rating >= ', $conds['rating_min'] );
		}

		if ( isset( $conds['rating_max'] ) ) {
			$this->db->where( 'overall_rating <= ', $conds['rating_max'] );
		}
		
		// // discount products
		// if ( $this->is_filter_discount( $conds )) {
		// 	$this->db->where( 'is_discount', '1' );	
		// }

		// available products
		if ( isset( $conds['is_available'] )) {
			$this->db->where( 'is_available', $conds['is_available'] );
		}

		// searchterm
		if ( isset( $conds['searchterm'] )) {
			$this->db->like( 'name', $conds['searchterm'] );
		}


		if( isset($conds['min_price'])) {

			
			if( $conds['min_price'] != 0 ) {
				$this->db->where( 'unit_price >=', $conds['min_price'] );
			}

		}

		if( isset($conds['max_price'])) {
			if( $conds['max_price'] != 0 ) {
				$this->db->where( 'unit_price <=', $conds['max_price'] );
			}	

		}

		$this->db->order_by( 'added_date', 'desc' );

	}

	// /**
	//  * Determines if filter discount.
	//  *
	//  * @return     boolean  True if filter discount, False otherwise.
	//  */
	// function is_filter_discount( $conds )
	// {
	// 	return ( isset( $conds['discount'] ) && $conds['discount'] == 1 );
	// }


}