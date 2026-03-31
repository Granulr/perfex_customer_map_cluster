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
        if (!has_permission('customers', '', 'view')) {
            access_denied('customers');
        }

        // Set the title
        $data['title'] = _l('customer_map_cluster');
        $data['google_api_key'] = get_option('google_api_key');
        $data['markers_endpoint'] = admin_url('perfex_customer_map_cluster/markers');
        $this->load->view('customer_map_cluster', $data);

    }

    public function markers()
    {
        if (!has_permission('customers', '', 'view')) {
            ajax_access_denied();
        }

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $south = (float) $this->input->get('south');
        $west  = (float) $this->input->get('west');
        $north = (float) $this->input->get('north');
        $east  = (float) $this->input->get('east');

        $hasAllBounds = $this->input->get('south') !== null
            && $this->input->get('west') !== null
            && $this->input->get('north') !== null
            && $this->input->get('east') !== null;

        if (!$hasAllBounds || $south > $north) {
            echo json_encode([
                'success' => false,
                'data'    => [],
            ]);
            die;
        }

        $limit = 2000;
        $data = $this->perfex_customer_map_cluster_model->get_entries_for_bounds($south, $west, $north, $east, $limit);

        echo json_encode([
            'success' => true,
            'data'    => $data,
            'limit'   => $limit,
        ]);
        die;
    }

}
