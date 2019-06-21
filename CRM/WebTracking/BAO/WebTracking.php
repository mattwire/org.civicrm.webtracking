<?php
/* https://civicrm.org/licensing */

/**
 * BAO object for civicrm_webtracking table
 */
class CRM_WebTracking_BAO_WebTracking extends CRM_WebTracking_DAO_WebTracking {

  /**
   * Takes an associative array and creates a webtracking object.
   *
   * @param array $params
   *   (reference) an assoc array of name/value pairs.
   *
   * @return object
   *   $webtracking CRM_Core_DAO_WebTracking object
   */
  public static function &add(&$params) {
    $webtracking = new CRM_WebTracking_DAO_WebTracking();
    $webtracking->copyValues($params);
    $webtracking->save();
    return $webtracking;
  }

 /**
   * Fetch object based on array of properties.
   *
   * @param array $params
   *   (reference ) an assoc array of name/value pairs.
   * @param array $defaults
   *   (reference ) an assoc array to hold the flattened values.
   *
   * @return \CRM_WebTracking_BAO_WebTracking
   */
  public static function retrieve(&$params, &$defaults) {   
    $webtracking = new CRM_WebTracking_BAO_WebTracking();
    $webtracking->copyValues($params);
    if ($webtracking->find(TRUE)) {
      CRM_Core_DAO::storeValues($webtracking, $defaults);
      return $webtracking;
    }
    return NULL;
  }

  /**
   * Delete the webtracking entry.
   *
   * @param int $page_id
   * @param string $page_category
   *
   * @return void
   */
  public static function del($page_id, $page_category) {
    $webtracking = new CRM_WebTracking_DAO_WebTracking();
    $webtracking->page_id = $page_id;
    $webtracking->page_category = $page_category;
    $webtracking->find();
    $webtracking->delete();
    $webtracking->free();
  }

}
