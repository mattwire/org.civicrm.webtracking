<?php
/* https://civicrm.org/licensing */

use CRM_WebTracking_ExtensionUtil as E;

class CRM_WebTracking_Form_Report extends CRM_Core_Form {

  /**
   * Set variables up before form is built.
   */
  public function preProcess() {
    if (empty(civicrm_api3('setting', 'getValue', ['group' => 'Web Tracking', 'name' => 'webtracking_report_id']))) {
      CRM_Core_Session::setStatus(E::ts('You need to configure the analytics embed API client ID before accessing reports'), 'Configuration error', 'alert');
      CRM_Utils_System::redirect(CRM_Utils_System::url('civicrm/admin/webtracking/settings', 'reset=1'));
    }
    CRM_Core_Resources::singleton()->addStyleFile(E::LONG_NAME, 'css/web-tracking-report-form.css');

    CRM_Core_Resources::singleton()->addStyleFile(E::LONG_NAME, 'css/EmbedAPI/main.css');
    CRM_Core_Resources::singleton()->addStyleFile(E::LONG_NAME, 'css/EmbedAPI/components/flex-grid.css');
    CRM_Core_Resources::singleton()->addStyleFile(E::LONG_NAME, 'css/EmbedAPI/components/dashboard.css');
    CRM_Core_Resources::singleton()->addStyleFile(E::LONG_NAME, 'css/EmbedAPI/components/titles.css');
    CRM_Core_Resources::singleton()->addStyleFile(E::LONG_NAME, 'css/EmbedAPI/components/active-users.css');
    CRM_Core_Resources::singleton()->addStyleFile(E::LONG_NAME, 'css/EmbedAPI/components/view-selector.css');
    CRM_Core_Resources::singleton()->addStyleFile(E::LONG_NAME, 'css/EmbedAPI/components/date-range-selector.css');

    CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/Report/GaApiMain.js', 6, 'page-body');
    CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/Report/ActiveUsers.js', 7, 'page-body');
    CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/Report/DateRangeSelector.js', 8, 'page-body');
    CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/Report/Dashboard.js', 9, 'page-body');
    parent::preProcess();
  }

  /**
   * Set default values for the form
   */
  public function setDefaultValues() {
    $defaults = [];
    $defaults['web_tracking_report_id'] = civicrm_api3('setting', 'getValue', ['group' => 'Web Tracking', 'name' => 'webtracking_report_id']);
    CRM_Core_Resources::singleton()->addVars('WebTracking', ['web_tracking_report_id' => $defaults['web_tracking_report_id']]);
    return $defaults;
  }

  /**
   * Build the form object.
   *
   * @return void
   */
  public function buildQuickForm() {
    // Text field to input the client ID
    $this->add('text', 'web_tracking_report_id', E::ts('Client ID'));

    $this->addFormRule(['CRM_WebTracking_Form_Report', 'formRule']);

    $buttons = [
      [
        'type' => 'upload',
        'name' => E::ts('Save'),
        'isDefault' => TRUE,
      ]
    ];
    $this->addButtons($buttons);

    parent::buildQuickForm();
  }

  /**
   * Global validation rules for the form.
   *
   * @param array $values
   *
   * @return array
   *   list of errors to be posted back to the form
   */
  public static function formRule($values) {
    $errors = [];
    if (!(isset($values['web_tracking_report_id']) && strlen($values['web_tracking_report_id']) > 0)) {
      $errors['web_tracking_report_id'] = "Please enter a valid client id";
    }
    return $errors;
  }

  /**
   * Process the form submission.
   */
  public function postProcess() {
    $params = $this->controller->exportValues($this->_name);
    $params['web_tracking_report_id'] = CRM_Utils_Array::value('web_tracking_report_id', $params, NULL);

    civicrm_api3('setting', 'create', ['webtracking_report_id' => $params['web_tracking_report_id']]);

    $url = 'civicrm/report/webtracking';
    $urlParams = 'action=update&reset=1';
    CRM_Utils_System::redirect(CRM_Utils_System::url($url, $urlParams));
  }

  /**
   * Return a descriptive name for the page, used in wizard header
   *
   * @return string
   */
  public function getTitle() {
    return E::ts('Google Analytics Report');
  }

}
