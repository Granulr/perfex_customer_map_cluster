<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Perfex_customer_map_cluster_model extends App_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    /**
     * Fetch clients within the provided map bounds.
     *
     * @param float $south
     * @param float $west
     * @param float $north
     * @param float $east
     * @param int   $limit
     * @return array
     */
    public function get_entries_for_bounds($south, $west, $north, $east, $limit = 2000)
    {
        $limit = (int) $limit;
        if ($limit < 1) {
            $limit = 2000;
        }

        $this->db->select('userid as id, latitude as lat, longitude as lng, company as info');
        $this->db->from(db_prefix() . 'clients');
        $this->db->where('latitude IS NOT NULL');
        $this->db->where('longitude IS NOT NULL');
        $this->db->where('latitude !=', '');
        $this->db->where('longitude !=', '');
        $this->db->where('latitude >=', $south);
        $this->db->where('latitude <=', $north);

        // Handle date line crossing where west longitude is greater than east.
        if ($west <= $east) {
            $this->db->where('longitude >=', $west);
            $this->db->where('longitude <=', $east);
        } else {
            $this->db->group_start();
            $this->db->where('longitude >=', $west);
            $this->db->or_where('longitude <=', $east);
            $this->db->group_end();
        }

        $this->db->limit($limit);

        return $this->db->get()->result_array();
    }

}
