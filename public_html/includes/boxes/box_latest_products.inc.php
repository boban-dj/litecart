<?php
  if (!settings::get('box_latest_products_num_items')) return;

  functions::draw_lightbox();

  $box_latest_products_cache_token = cache::token('box_latest_products', array('language', 'currency', 'prices'), 'file');
  if (cache::capture($box_latest_products_cache_token)) {

    $products_query = functions::catalog_products_query(array(
      'sort' => 'date',
      'limit' => settings::get('box_latest_products_num_items'),
    ));

    if (database::num_rows($products_query)) {

      $box_latest_products = new ent_view();

      $box_latest_products->snippets['products'] = array();
      while ($listing_product = database::fetch($products_query)) {
        $box_latest_products->snippets['products'][] = $listing_product;
      }

      echo $box_latest_products->stitch('views/box_latest_products');
    }

    cache::end_capture($box_latest_products_cache_token);
  }
