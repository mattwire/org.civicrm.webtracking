<?php
/* https://civicrm.org/licensing */

return [
  'webtracking_report_id' => [
    'admin_group' => 'webtracking_general',
    'group_name' => 'Web Tracking',
    'group' => 'webtracking',
    'name' => 'webtracking_report_id',
    'type' => 'String',
    'html_type' => 'Text',
    'default' => NULL,
    'add' => '4.6',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => 'Client ID for Google Analytic Embed API',
    'help_text' => 'Client ID for Google Analytic Embed API',
    'html_attributes' => [
      'size' => 60,
    ],
  ],
  'webtracking_tracking_id' => [
    'admin_group' => 'webtracking_general',
    'admin_grouptitle' => 'General Settings',
    'admin_groupdescription' => 'General settings for google analytics web tracking.',
    'group_name' => 'Web Tracking',
    'group' => 'webtracking',
    'name' => 'webtracking_tracking_id',
    'type' => 'String',
    'html_type' => 'Text',
    'default' => NULL,
    'add' => '5.13',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => 'Google Analytics tracking ID (eg. UA-000000-2)',
    'html_attributes' => [],
  ],

];