<?php

if (!defined('AREA')) { die('Access denied'); }

if ($mode == 'get_info') {
    $ids = array_map('intval', explode(',', $_REQUEST['product_ids']));

    $products = array();

    foreach ($ids as $id) {
        $p_info = fn_get_product_data($id, $auth, CART_LANGUAGE, '', false, true, false, false);

        if ($p_info['product'] != null) {
            $p = Array(
                'name' => $p_info['product'],
                'url' => fn_url('products.view?product_id='.$id),
                'price' => round($p_info['base_price'], 2),
                'image_url' => $p_info['main_pair']['icon']['image_path']
            );

            if ($p['image_url'] == null) {
                $p['image_url'] = $p_info['main_pair']['detailed']['image_path'];
            }

            array_push($products, $p);
        }
    }

    header('Content-Type: application/json');
    die(json_encode(Array('products' => $products)));
}
