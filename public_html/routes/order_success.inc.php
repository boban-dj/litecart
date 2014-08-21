<?php
  header('X-Robots-Tag: noindex');
  
  $order = new ctrl_order('resume');
  
  $payment = new mod_payment();
  
  $order_success = new mod_order_success();
  
  if (empty($order->data['id'])) die('Error: Missing session order object');
  
  document::$snippets['head_tags']['noindex'] = '<meta name="robots" content="noindex" />';
  
  document::$snippets['title'][] = language::translate('title_order_success', 'Order Success');
  //document::$snippets['keywords'] = '';
  //document::$snippets['description'] = '';
  
  breadcrumbs::add(language::translate('title_checkout', 'Checkout'), document::ilink('checkout'));
  breadcrumbs::add(language::translate('title_order_success', 'Order Success'));
  
  cart::reset();
  
  functions::draw_fancybox('a.fancybox', array(
    'type'          => 'iframe',
    'padding'       => '40',
    'width'         => 600,
    'height'        => 800,
    'titlePosition' => 'inside',
    'transitionIn'  => 'elastic',
    'transitionOut' => 'elastic',
    'speedIn'       => 600,
    'speedOut'      => 200,
    'overlayShow'   => true
  ));

  $page = new view();
  
  $page->snippets = array(
    'description' => document::ilink('printable_order_copy', array('order_id' => $order->data['id'], 'checksum' => functions::general_order_public_checksum($order->data['id']), 'media' => 'print')),
    'order_success_modules_output' => $order_success->process(),
    'payment_reciept' => $payment->run('receipt'),
  );
  
  echo $page->stitch('box_order_success's);
?>