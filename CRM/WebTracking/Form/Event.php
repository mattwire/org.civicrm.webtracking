<?php
/* https://civicrm.org/licensing */

use CRM_WebTracking_ExtensionUtil as E;

/**
 * This class generates form components for processing Event Web Tracking
 */
class CRM_WebTracking_Form_Event extends CRM_Event_Form_ManageEvent {

  const PAGE_CATEGORY = 'civicrm_event';

  /**
   * Set variables up before form is built.
   */
  public function preProcess() {
    CRM_Core_Resources::singleton()->addStyleFile(E::LONG_NAME, 'css/web-tracking-form.css');
    parent::preProcess();
  }

  /**
   * Set default values for the form
   *
   * @return array
   */
  public function setDefaultValues() {
    $params['page_id'] = $this->_id;
    $params['page_category'] = self::PAGE_CATEGORY;
    $defaults = [];
    CRM_WebTracking_BAO_WebTracking::retrieve($params, $defaults);
    $defaults['tracking_id'] = CRM_WebTracking_Settings::getValue('tracking_id');

    return $defaults;
  }

  /**
   * Build the form object.
   */
  public function buildQuickForm() {
    // Checkbox to ask whether or not to enable web tracking
    $this->add('checkbox', 'enable_tracking', E::ts('Enable Tracking'));

    // Text field to input the tracking id
    $element = $this->add('text', 'tracking_id', E::ts('Tracking ID'));
    $element->freeze();

    // Checkbox to ask whether or not to enable event tracking
    $this->add('checkbox', 'ga_event_tracking', E::ts('Enable event tracking'));

    // Checkbox to ask whether or not to track when the user visits the info page
    $this->add('checkbox', 'track_info', E::ts('Track visit to info page'));

    // Checkbox to ask whether or not to track when the user visits the registration page
    $this->add('checkbox', 'track_register', E::ts('Track visit to registration page'));

    // Checkbox to ask whether or not to track when the user visits the confirmation page
    $this->add('checkbox', 'track_confirm_register', E::ts('Track visit to confirmation page'));

    // Checkbox to ask whether or not to track when the user visits the thank you page
    $this->add('checkbox', 'track_thank_you', E::ts('Track visit to thank you page'));

    // Checkbox to ask whether or not to track when the user changes default price option
    $this->add('checkbox', 'track_price_change', E::ts('Track price change'));

    // Checkbox to ask whether or not to enable ecommerce tracking
    $this->add('checkbox', 'track_ecommerce', E::ts('Enable ecommerce tracking'));

    // Checkbox to ask whether the page is the primary page of the experiment
    $this->add('checkbox', 'is_experiment', E::ts('Primary page of experiment'));

    // Text field to input the experiment key
    $this->add('text', 'experiment_id', E::ts('Experiment key'));

    $this->addFormRule(['CRM_WebTracking_Form_Event', 'formRule']);

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

    if (isset($values['enable_tracking']) && $values['enable_tracking'] == 1) {
      // Checking that UAID provided by the customer has the string 'UA-' as its prefix
      $pos = strpos($values['tracking_id'],'UA-');
      if ($pos===false || $pos!==0) {
        form_set_error('tracking_id', E::ts('Please configure a valid Tracking ID (in Administer->Google Analytics Settings'));
        $errors['tracking_id'] = true;
      }
    }

    if (isset($values['is_experiment']) && $values['is_experiment'] == 1) {
      if ($values['experiment_id'] == '') {
        form_set_error('experiment_id', E::ts('Please provide a valid Experiment Key'));
        $errors['experiment_id'] = true;
      }
    }

    return $errors;
  }

  /**
   * Process the form submission.
   *
   * @return void
   */
  public function postProcess() {
    // TODO:: is this required?
    $params = $this->controller->exportValues($this->_name);

    $existParams = [
      'page_id' => $this->_id,
      'page_category' => self::PAGE_CATEGORY,
    ];
    $existingEntry = [];

    CRM_WebTracking_BAO_WebTracking::retrieve($existParams, $existingEntry);

    // Setting up the params array with the values obtained from the form
    if (!empty($existingEntry)) {
       $params['id'] = $existingEntry['id'];
    }

    $params['page_id'] = $this->_id;
    $params['page_category']=self::PAGE_CATEGORY;

    $params['enable_tracking'] = CRM_Utils_Array::value('enable_tracking', $params, FALSE);
    $params['tracking_id'] = CRM_Utils_Array::value('tracking_id', $params, NULL);
    $params['ga_event_tracking'] = CRM_Utils_Array::value('ga_event_tracking', $params, FALSE);
    $params['track_info'] = CRM_Utils_Array::value('track_info', $params, FALSE);
    $params['track_register'] = CRM_Utils_Array::value('track_register', $params, FALSE);
    $params['track_confirm_register'] = CRM_Utils_Array::value('track_confirm_register', $params, FALSE);
    $params['track_thank_you'] = CRM_Utils_Array::value('track_thank_you', $params, FALSE);
    $params['track_price_change'] = CRM_Utils_Array::value('track_price_change', $params, FALSE);

    $params['track_ecommerce'] = CRM_Utils_Array::value('track_ecommerce', $params, FALSE);

    $params['is_experiment'] = CRM_Utils_Array::value('is_experiment', $params, FALSE);
    $params['experiment_id'] = CRM_Utils_Array::value('experiment_id', $params, NULL);

    // Updating the database with the new entry
    CRM_WebTracking_BAO_WebTracking::add($params);

    parent::endPostProcess();
  }

  /**
   * Return a descriptive name for the page, used in wizard header
   *
   * @return string
   */
  public function getTitle() {
    return E::ts('Event Google Analytics Settings');
  }

}
