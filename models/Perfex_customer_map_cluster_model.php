<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Perfex_customer_map_cluster_model extends App_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param  none
     * @return object
     * Get all 
     */
    public function get_all_entries(){
        $this->db->select('latitude as lat, longitude as lng, company as info');
        $cluster = $this->db->get(db_prefix().'clients')->result_array();
        return $cluster;
    }

}
