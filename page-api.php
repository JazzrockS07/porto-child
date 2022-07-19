<?php
/*
 * Template Name: 1688-api
 */
require_once ($_SERVER['DOCUMENT_ROOT'] . "/wp-load.php");

if (isset($_POST['action']) && $_POST['action'] == "checkExist") {
    $return = array();
    $pid = $_POST['pid'];
    $args = array(
        'post_type' => 'product',
        'meta_key' => '1688id',
        'meta_value' => $pid,
        'meta_compare' => '='
    );
    $products = wc_get_products($args);
    if (count($products)) {
        $return['code'] = "100";
        $return['pid'] = $products[0]->get_id();
        for ($i = 0; $i < count($products); $i ++) {
            if ($i != 0) {
                wp_delete_post($products[$i]->get_id());
            }
        }
    } else {
        $return['code'] = "200";
    }
    echo json_encode($return);
} else if (isset($_POST['action']) && $_POST['action'] == "getproductsbycategory") {
    $return = array();
    $category = $_POST['category'];
    $products = wc_get_products(array(
        'post_status' => 'publish',
        'limit' => 1000,
        'orderby' => 'id',
        'order' => 'desc',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category, /*category name*/
                'operator' => 'IN'
            )
        )
    ));
    for ($i = 0; $i < count($products); $i ++) {

        $meta1688 = get_post_meta($products[$i]->get_id(), '1688id');
        if (count($meta1688)) {
            $return[] = $meta1688[0];
        }
        // echo print_r($meta1688);
    }
    echo json_encode($return);
}

?>		 