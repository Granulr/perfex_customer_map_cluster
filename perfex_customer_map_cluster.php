<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Perfex Customer Map Cluster
Description: See how all your customers locations fall under a single map feature.
Version: 1.0.1
Author: Granulr Ltd
Author URI: https://granulr.uk
Requires at least: 2.7.*
*/

define('PERFEX_CUSTOMER_MAP_CLUSTER', 'perfex_customer_map_cluster');

// Setup our hooks
hooks()->add_action('admin_init', 'perfex_customer_map_cluster_module_init_menu_items');


/**
* Register activation module hook
*/
register_activation_hook(PERFEX_CUSTOMER_MAP_CLUSTER, 'perfex_customer_map_cluster_module_activation_hook');

function perfex_customer_map_cluster_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(PERFEX_CUSTOMER_MAP_CLUSTER, [PERFEX_CUSTOMER_MAP_CLUSTER]);


/**
 * Init vault module menu items in setup in admin_init hook
 * @return null
 */
function perfex_customer_map_cluster_module_init_menu_items()
{
    $CI = &get_instance();

    $CI->app_menu->add_sidebar_children_item('utilities', [
        'slug'      => 'perfex_customer_map_cluster',
        'name'      => _l('map_cluster'), // The name if the item
        'href'      => admin_url('perfex_customer_map_cluster'),
        'position'  => 16, // The menu position
    ]);

}
