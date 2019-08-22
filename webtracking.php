<?php

require_once 'webtracking.civix.php';
use CRM_WebTracking_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function webtracking_civicrm_config(&$config) {
  _webtracking_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function webtracking_civicrm_xmlMenu(&$files) {
  _webtracking_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function webtracking_civicrm_install() {
  _webtracking_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function webtracking_civicrm_uninstall() {
  _webtracking_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function webtracking_civicrm_enable() {
  _webtracking_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function webtracking_civicrm_disable() {
  _webtracking_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function webtracking_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _webtracking_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function webtracking_civicrm_managed(&$entities) {
  _webtracking_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function webtracking_civicrm_caseTypes(&$caseTypes) {
  _webtracking_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function webtracking_civicrm_angularModules(&$angularModules) {
_webtracking_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function webtracking_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _webtracking_civix_civicrm_alterSettingsFolders($metaDataFolders);
}


/**
 * Adds a new tab for configuring web tracking parameters
 */
function webtracking_civicrm_tabset($tabsetName, &$tabs, $context) {
  // Check if the tab set is event manage
  if ($tabsetName == 'civicrm/event/manage') {
    if (!empty($context)) {
      $eventID = $context['event_id'];
      $trackingParams = ['page_id' => $eventID, 'page_category' => "civicrm_event"];
      CRM_WebTracking_BAO_WebTracking::retrieve($trackingParams,$trackingValues);

      $url = CRM_Utils_System::url( 'civicrm/event/manage/webtracking',
        "reset=1&snippet=5&force=1&id=$eventID&action=update&component=event" );
      // Add a new WebTracking tab along with url
      $tab['webtracking'] = [
        'title' => E::ts('Google Analytics'),
        'link' => $url,
        'valid' => $trackingValues['enable_tracking'],
        'active' => 1,
        'current' => false,
      ];
    }
    else {
      $tab['webtracking'] = [
        'title' => E::ts('Google Analytics'),
        'url' => 'civicrm/event/manage/webtracking', // putting CRM_Utils_System::url("", 'reset=1', TRUE); leads to a broken link?
        'field' => 'enable_tracking',
      ];
    }

    //Insert this tab in the end
    $tabs = array_merge($tabs,$tab);
  }
  else if ($tabsetName == 'civicrm/event/manage/rows') {
    if (!empty($context)) {
      $eventID = $context['event_id'];
      $trackingParams = ['page_id' => $eventID, 'page_category' => "civicrm_event"];
      CRM_WebTracking_BAO_WebTracking::retrieve($trackingParams,$trackingValues);
      $tabs[$eventID]['enable_tracking'] = $trackingValues['enable_tracking'];
    }
  }
  else if ($tabsetName == 'civicrm/admin/contribute') {
    if (!empty($context['contribution_page_id'])) {
      $contribPageId = $context['contribution_page_id'];
      $trackingParams = ['page_id' => $contribPageId, 'page_category' => "civicrm_contribution"];
      CRM_WebTracking_BAO_WebTracking::retrieve($trackingParams,$trackingValues);

      $url = CRM_Utils_System::url( 'civicrm/admin/contribute/webtracking',
        "reset=1&snippet=5&force=1&id=$contribPageId&action=update&component=contribute" );
      // Add a new WebTracking tab along with url
      $tab['webtracking'] = [
        'name' => E::ts('Google Analytics'),
        'title' => E::ts('Google Analytics'),
        'link' => $url,
        'valid' => $trackingValues['enable_tracking'],
        'uniqueName' => 'webTracking',
        'active' => 1,
        'current' => false,
      ];
    }
    else if(!empty($context['urlString']) && !empty($context['urlParams'])) {
      $tab[] = [
        'name' => E::ts('Google Analytics'),
        'title' => E::ts('Google Analytics'),
        'url' => $context['urlString'] . 'webtracking',
        'qs' => $context['urlParams'],
        'uniqueName' => 'webTracking'
      ];
    }
    else {
      $tab['webtracking'] = [
        'title' => E::ts('Google Analytics'),
        'url' => CRM_Utils_System::url('civicrm/admin/contribute/webtracking', 'reset=1', TRUE),
        'field' => 'enable_tracking',
      ];
    }

    //Insert this tab into position 4
    $tabs = array_merge(array_slice($tabs, 0, 4), $tab, array_slice($tabs, 4));
  }
  else if ($tabsetName == 'civicrm/admin/contribute/rows') {
    if (!empty($context)) {
      $contribPageId = $context['contrib_page_id'];
      $trackingParams = ['page_id' => $contribPageId, 'page_category' => "civicrm_contribution"];
      CRM_WebTracking_BAO_WebTracking::retrieve($trackingParams,$trackingValues);
      $tabs[$contribPageId]['enable_tracking'] = $trackingValues['enable_tracking'];
    }
  }
}

/**
 * This hook is invoked when the event page is rendered
 * Based on the web tracking parameters it invokes certain javascript/jquery functions which talk to google analytics
 */
function webtracking_civicrm_pageRun(&$page) {
  $pageName = $page->getVar('_name');
  if ($pageName == 'CRM_Event_Page_EventInfo') {
    $trackingParams = ['page_id' => $page->getVar('_id'), 'page_category' => "civicrm_event"];
    CRM_WebTracking_BAO_WebTracking::retrieve($trackingParams,$trackingValues);

    if ($trackingValues['enable_tracking'] == 1) {
      // General script for web tracking
      CRM_Core_Resources::singleton()->addVars('WebTracking', ['tracking_id' => $trackingValues['tracking_id']]);
      CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/WebTracking.js', 10, 'html-header');
      $page->assign('enable_tracking',1);

      if ($trackingValues['is_experiment'] == 1) {
        // Script for the experiment
        CRM_Core_Resources::singleton()->addVars('WebTracking', ['experiment_id' => $trackingValues['experiment_id']]);
        CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/Experiment.js', 11, 'html-header');
        CRM_Core_Resources::singleton()->addScript("utmx('url','A/B');",12,'html-header');
        CRM_Core_Resources::singleton()->addScript("ga('send', 'pageview');", 13, 'html-header');
      }
      else {
        CRM_Core_Resources::singleton()->addScript("ga('send', 'pageview');",11,'html-header');
      }

      // Appropriate js function call if track_info is enabled and event tracking is enabled
      if ($trackingValues['track_info'] == 1 && $trackingValues['ga_event_tracking'] == 1) {
        CRM_Core_Resources::singleton()->addScript("ga('send', 'event', 'Info Page', 'Viewed')");
      }

      // Saving the utm source in the session variable if track_ecommerce is enabled
      if($trackingValues['track_ecommerce'] == 1) {
        $session = CRM_Core_Session::singleton();
        if(isset($_GET['utm_source'])) {
          $session->set('utm_source',$_GET['utm_source']);
        }
        else {
          $session->set('utm_source','general');
        }
      }
    }
    else {
      $page->assign('enable_tracking',0);
    }
  }
}

/**
* This hook is invoked when the 'confirm register' and 'thank you' form is rendered
* Based on the web tracking parameters it invokes certain javascript/jquery functions which talk to google analytics
*/
function webtracking_civicrm_buildForm($formName, &$form) {

  $contribFormNames = ['CRM_Contribute_Form_Contribution_Main', 'CRM_Contribute_Form_Contribution_ThankYou', 'CRM_Contribute_Form_Contribution_Confirm'];
  $eventFormNames = ['CRM_Event_Form_Registration_Register', 'CRM_Event_Form_Registration_ThankYou', 'CRM_Event_Form_Registration_Confirm'];
  $category = 'None';

  if (in_array($formName, $eventFormNames)) {
    $category = 'Event';
  }
  else if (in_array($formName, $contribFormNames)) {
    $category = 'Contribution';
  }

  if ($category == 'Event') {
    $trackingParams = ['page_id' => $form->_eventId, 'page_category' => "civicrm_event"];

    CRM_WebTracking_BAO_WebTracking::retrieve($trackingParams,$trackingValues);

    if ($trackingValues['enable_tracking'] == 1) {
      // General script for web tracking
      CRM_Core_Resources::singleton()->addVars('WebTracking', ['tracking_id' => $trackingValues['tracking_id']]);
      CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/WebTracking.js',10,'html-header');

      // Script for event tracking
      CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/EventTracking.js');
    }
    else {
      return;
    }

    if ($formName == 'CRM_Event_Form_Registration_Register' && $trackingValues['ga_event_tracking'] == 1) {
      if ($trackingValues['track_register'] == 1) {
        CRM_Core_Resources::singleton()->addScript('trackViewRegistration();');
      }
      if($form->_values['event']['is_monetary'] == 1 && $trackingValues['track_price_change'] == 1) {
        CRM_Core_Resources::singleton()->addScript('trackPriceChange();');
      }
    }
    else if ($formName == 'CRM_Event_Form_Registration_ThankYou') {
      if ($trackingValues['track_ecommerce'] == 1 && !empty($form->_values['event']['is_monetary'])) {
        // Fetching the source from the session and adding it as a variable.
        $session = CRM_Core_Session::singleton();
        CRM_Core_Resources::singleton()->addVars('WebTracking', ['utm_source' => $session->get('utm_source')]);

        $ecommerceVars = CRM_WebTracking_Utils::getEcommerceTrackingData($form);
        CRM_Core_Resources::singleton()->addVars('WebTracking', $ecommerceVars);
        CRM_Core_Resources::singleton()->addScript('trackEcommerce();');
      }
      if ($trackingValues['track_thank_you'] == 1 && $trackingValues['ga_event_tracking'] == 1) {
        CRM_Core_Resources::singleton()->addScript("ga('send', 'event', 'Thank You Page', 'Viewed')");
      }
    }
    else if ($formName == 'CRM_Event_Form_Registration_Confirm') {
      if ($trackingValues['track_confirm_register'] == 1) {
        CRM_Core_Resources::singleton()->addScript("ga('send', 'event', 'Confirmation Page', 'Viewed')");
      }
    }
  }
  else if ($category == 'Contribution') {
    $trackingParams = ['page_id' => $form->_id, 'page_category' => "civicrm_contribution"];
    CRM_WebTracking_BAO_WebTracking::retrieve($trackingParams,$trackingValues);

    if ($trackingValues['enable_tracking'] == 1) {

      // General script for web tracking
      CRM_Core_Resources::singleton()->addVars('WebTracking', ['tracking_id' => $trackingValues['tracking_id']]);
      CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/WebTracking.js',10,'html-header');
      $form->assign('enable_tracking',1);

      if ($formName == 'CRM_Contribute_Form_Contribution_Main') {
        if ($trackingValues['is_experiment'] == 1) {
          // Script for the experiment
          CRM_Core_Resources::singleton()->addVars('WebTracking', ['experiment_id' => $trackingValues['experiment_id']]);
          CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/Experiment.js', 11, 'html-header');
          CRM_Core_Resources::singleton()->addScript("utmx('url','A/B');",12,'html-header');
          CRM_Core_Resources::singleton()->addScript("ga('send', 'pageview');", 13, 'html-header');
        }
        else {
          CRM_Core_Resources::singleton()->addScript("ga('send', 'pageview');",11,'html-header');
          // Script for event tracking
          CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/EventTracking.js');
          if ($trackingValues['track_register'] == 1 && $trackingValues['ga_event_tracking'] == 1) {
            CRM_Core_Resources::singleton()->addScript('trackViewRegistration();');
          }
          if($form->_values['is_monetary'] == 1 && $trackingValues['track_price_change'] == 1 && $trackingValues['ga_event_tracking'] == 1) {
            CRM_Core_Resources::singleton()->addScript('trackPriceChange();');
          }
        }

        // Saving the utm source in the session variable if track_ecommerce is enabled
        if($trackingValues['track_ecommerce'] == 1) {
          $session = CRM_Core_Session::singleton();
          if(isset($_GET['utm_source'])) {
            $session->set('utm_source',$_GET['utm_source']);
          }
          else {
            $session->set('utm_source','general');
          }
        }
      }
      else if ($formName == 'CRM_Contribute_Form_Contribution_Confirm' && $trackingValues['ga_event_tracking'] == 1) {
        CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/EventTracking.js');
        if ($trackingValues['track_confirm_register'] == 1) {
          CRM_Core_Resources::singleton()->addScript("ga('send', 'event', 'Confirmation Page', 'Viewed')");
        }
      }
      else if ($formName == 'CRM_Contribute_Form_Contribution_ThankYou') {
        CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/EventTracking.js');
        if ($trackingValues['track_ecommerce'] == 1) {
          // Fetching the source from the session and adding it as a variable.
          $session = CRM_Core_Session::singleton();
          CRM_Core_Resources::singleton()->addVars('WebTracking', ['utm_source' => $session->get('utm_source')]);

          $ecommerceVars = CRM_WebTracking_Utils::getEcommerceTrackingData($form);
          CRM_Core_Resources::singleton()->addVars('WebTracking', $ecommerceVars);
          CRM_Core_Resources::singleton()->addScript('trackEcommerce();');
        }
        if ($trackingValues['track_thank_you'] == 1 && $trackingValues['ga_event_tracking'] == 1) {
          CRM_Core_Resources::singleton()->addScript("ga('send', 'event', 'Thank You Page', 'Viewed')");
        }
      }
    }
    else {
      $form->assign('enable_tracking',0);
    }
  }
}

/**
* This hook is used to add the web tracking report link to the navigation menu
*
*/
function webtracking_civicrm_navigationMenu(&$menu) {
  $item[] =  [
    'label' => E::ts('Google Analytics Report'),
    'name' => 'web_tracking_report',
    'url' => CRM_Utils_System::url('civicrm/report/webtracking', 'reset=1', TRUE),
    'permission' => 'access CiviReport,access CiviEvent',
    'operator' => 'OR',
    'separator' => 1,
    'active' => 1
  ];
  _webtracking_civix_insert_navigation_menu($menu, 'Reports', $item[0]);

  $item[] = [
    'label' => E::ts('Google Analytics Settings'),
    'name'       => 'web_tracking_settings',
    'url'        => CRM_Utils_System::url('civicrm/admin/webtracking/settings', 'reset=1', TRUE),
    'permission' => 'administer CiviCRM',
    'operator'   => NULL,
    'separator'  => NULL,
  ];
  _webtracking_civix_insert_navigation_menu($menu, 'Administer', $item[1]);
  _webtracking_civix_navigationMenu($menu);
}
