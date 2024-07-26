<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Perfex_customer_map_cluster extends AdminController
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('perfex_customer_map_cluster_model');

        // Load our custom assets
        $this->app_css->add('perfex-customer-map-cluster-css', module_dir_url('perfex_customer_map_cluster', 'assets/css/perfex_customer_map_cluster.css'), 'admin', ['app-css']);
    }

    public function index()
    {

        // Set the title
        $data['title'] = _l('customer_map_cluster');
        $data['google_api_key'] = get_option('google_api_key');
        $data['cluster'] = json_encode($this->perfex_customer_map_cluster_model->get_all_entries(), JSON_NUMERIC_CHECK);
        $this->load->view('customer_map_cluster', $data);

    }

}
