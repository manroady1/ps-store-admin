<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for zone_junction table
 */
class Zone_junction extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'mk_zones_junction', 'id', 'zone_jun' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		
		// country id condition
		if ( isset( $conds['country_id'] )) {
			
			if ($conds['country_id'] != "" || $conds['country_id'] != 0) {
				
				$this->db->where( 'country_id', $conds['country_id'] );	

			}			
		}

		// city id condition
		if ( isset( $conds['city_id'] )) {
			
			if ($conds['city_id'] != "" || $conds['city_id'] != 0) {
				
				$this->db->where( 'city_id', $conds['city_id'] );	

			}			
		}

		// zone id condition
		if ( isset( $conds['zone_id'] )) {
			
			if ($conds['zone_id'] != "" || $conds['zone_id'] != 0) {
				
				$this->db->where( 'zone_id', $conds['zone_id'] );	

			}			
		}

		// zone junction id condition
		if ( isset( $conds['id'] )) {
			$this->db->where( 'id', $conds['id'] );	
		}

		$this->db->order_by( 'added_date', 'desc' );

	}
}
	