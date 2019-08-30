<?php

use CRM_WebTracking_ExtensionUtil as E;
/**
 * BatchSettings.create API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRM/API+Architecture+Standards
 */
function _civicrm_api3_web_tracking_create_spec(&$spec) {
  // $spec['some_parameter']['api.required'] = 1;
}

/**
 * BatchSettings.create API
 *
 * @param array $params
 * @return array API result descriptor
 * @throws API_Exception
 */
function civicrm_api3_web_tracking_create($params) {
  return _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * BatchSettings.delete API
 *
 * @param array $params
 * @return array API result descriptor
 * @throws API_Exception
 */
function civicrm_api3_web_tracking_delete($params) {
  return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * BatchSettings.get API
 *
 * @param array $params
 * @return array API result descriptor
 * @throws API_Exception
 */
function civicrm_api3_web_tracking_get($params) {
  return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

function civicrm_api3_web_tracking_getfields($params) {
  $fields =  CRM_WebTracking_DAO_WebTracking::fields();
  return civicrm_api3_create_success($fields);
}

function _civicrm_api3_web_tracking_DAO() {
  return 'CRM_WebTracking_DAO_WebTracking';
}
