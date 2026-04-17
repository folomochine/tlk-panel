<?php
if (!defined('BASEPATH')) {
  die('Direct access to the script is not allowed');
}

/**
 * ACL par action pour admin/ajax_data : en plus de admin_access, certaines actions
 * exigent la même permission que le module concerné.
 */
function ajax_data_require_action_access($action, array $admin) {
  static $map = null;
  if ($map === null) {
    $map = [
      'secret_user' => 'users', 'new_user' => 'users', 'new_user_v2' => 'users', 'edit_user' => 'users',
      'pass_user' => 'users', 'alert_user' => 'users', 'export_user' => 'users', 'price_user' => 'users',
      'reffered_users' => 'users',
      'new_service' => 'services', 'edit_service' => 'services', 'edit_service_name' => 'services',
      'edit_description' => 'services', 'edit_time' => 'services', 'new_category' => 'services',
      'edit_category' => 'services', 'category_disable' => 'services', 'category_enable' => 'services',
      'bulkGetCategories' => 'services', 'service-sortable' => 'services', 'category-sortable' => 'services',
      'import_services' => 'services', 'import_services_list' => 'services', 'import_services_last' => 'services',
      'import_service' => 'services', 'price_providerCal' => 'services', 'set_discount_percentage' => 'services',
      'download_category_icon_images' => 'services',
      'new_ticket' => 'tickets', 'edit_ticket' => 'tickets',
      'new_bankaccount' => 'bank_accounts', 'edit_bankaccount' => 'bank_accounts',
      'new_paymentbonus' => 'payments_bonus', 'edit_paymentbonus' => 'payments_bonus',
      'new_provider' => 'providers', 'edit_provider' => 'providers', 'providers_list' => 'providers',
      'paymentmethod-sortable' => 'general_settings',
      'new_news' => 'news', 'edit_news' => 'news',
      'menu-sortable' => 'menu', 'allmenu-sortable' => 'menu',
      'add_internal' => 'inte', 'edit_internal' => 'inte', 'add_external' => 'inte', 'edit_external' => 'inte',
      'edit_code' => 'pages',
      'new_subscriptions' => 'subscriptions', 'subscriptions_expiry' => 'subscriptions',
      'yeni_kupon' => 'coupon',
      'payment_bankedit' => 'payments', 'payment_banknew' => 'payments', 'payment_edit' => 'payments',
      'payment_new' => 'payments', 'payment_detail' => 'payments',
      'order_errors' => 'orders', 'order_details' => 'orders', 'order_orderurl' => 'orders',
      'order_startcount' => 'orders', 'order_partial' => 'orders', 'next_order_id' => 'orders',
      'details' => 'orders',
      'earn_note' => 'videop',
      'edit_admin_password' => 'super_admin', 'edit_admin' => 'super_admin', 'add_admin' => 'super_admin',
      'site-add-currency' => 'currency', 'add_currency' => 'currency', 'edit_currency' => 'currency',
      'update_inr_rate' => 'currency-manager', 'update_inr_rate_manual' => 'currency-manager',
      'capture_description' => 'services',
    ];
  }
  if (!isset($map[$action])) {
    return;
  }
  $key = $map[$action];
  if (empty($admin['access'][$key]) || (int) $admin['access'][$key] !== 1) {
    http_response_code(403);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => false, 'error' => 'Forbidden']);
    exit;
  }
}
