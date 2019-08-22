<?php
/*
 * http://civicrm.org/licensing
 */

use CRM_WebTracking_ExtensionUtil as E;

/**
 * WebTracking Utils class.
 *
 * @since 1.2
 */
class CRM_WebTracking_Utils {

  /**
   * Get necessary data for GA Ecommerce tracking.
   *
   * @since 1.2
   * @return array
   */
  public static function getEcommerceTrackingData($form) {
    $ecommerceVars = [
      'totalAmount' => !empty($form->_totalAmount) ? $form->_totalAmount : $form->_amount,
    ];

    // use transaction id for live transactions
    if (!empty($form->_trxnId)) {
      $ecommerceVars['trnx_id'] = $form->_trxnId;
    } elseif (
      !empty($form->_values['params']['is_pay_later']) && !empty($form->_values['contributionId'])
    ) {
      // for event pay later use the invoice id
      $contribution = civicrm_api3('Contribution', 'getsingle', [
        'id' => $form->_values['contributionId'],
        'return' => ['invoice_id'],
      ]);
      $ecommerceVars['trnx_id'] = $contribution['invoice_id'];
    } else {
      // for pay later contributions and memberships we don't have
      // a contribution id, use a prefixed random transaction id instead
      $prefix = "contribution_page_id_{$form->_values['id']}_";
      $ecommerceVars['trnx_id'] = $prefix . rand();
    }

    // add line items for recording transaction items
    // see https://developers.google.com/analytics/devguides/collection/analyticsjs/ecommerce#addItem
    if (!empty($form->_lineItem)) {
      $ecommerceVars['lineItems'] = array_reduce(
        $form->_lineItem,
        function($items, $lineItem) use ($ecommerceVars) {
          $item = reset($lineItem);
          $items[] = [
            'id' => $ecommerceVars['trnx_id'],
            'name' => "{$item['field_title']} - {$item['label']}",
            'price' => $item['unit_price'],
            'quantity' => $item['qty'],
          ];
          return $items;
        },
        []
      );
    }

    return $ecommerceVars;

  }

}
