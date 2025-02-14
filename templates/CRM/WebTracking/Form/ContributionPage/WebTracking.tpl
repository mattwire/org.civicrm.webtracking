{* https://civicrm.org/licensing *}

<div class="crm-block crm-form-block crm-event-manage-webtracking-form-block">

  <div class="crm-submit-buttons">
      {include file="CRM/common/formButtons.tpl" location="top"}
  </div>

  <table class="form-table-webtracking">

    <tr class="crm-event-manage-webtracking-form-block-enable_tracking" id="enable-tracking">
      <td>{$form.enable_tracking.label}</td>
      <td>{$form.enable_tracking.html}</td>
    </tr>

    <table class="form-table-webtracking" id="webtracking-params">
      <tr class="crm-event-manage-webtracking-form-block-tracking_id">
        <td>{$form.tracking_id.label} {help id="tracking-id"}</td>
        <td>{$form.tracking_id.html}</td>
      </tr>
      <tr class="crm-event-manage-eventinfo-form-block-ga_event_tracking">
        <td>{$form.ga_event_tracking.label} {help id="ga-event-tracking"}</td>
        <td>{$form.ga_event_tracking.html}</td>
      </tr>
      <tr>
        <td> </td>
        <td>
          <div id="eventtracking-params" class="row even-row">
            <div>{$form.track_register.html} {$form.track_register.label}</div>
            <div>{$form.track_confirm_register.html} {$form.track_confirm_register.label}</div>
            <div>{$form.track_thank_you.html} {$form.track_thank_you.label}</div>
            <div>{$form.track_price_change.html} {$form.track_price_change.label}</div>
          </div>
        </td>
      </tr>
      <tr class="crm-event-manage-eventinfo-form-block-track_ecommerce">
        <td>{$form.track_ecommerce.label} {help id="track-ecommerce"}</td>
        <td>{$form.track_ecommerce.html}</td>
      </tr>
      <tr class="crm-event-manage-eventinfo-form-block-is_experiment">
        <td>{$form.is_experiment.label} {help id="is-experiment"}</td>
        <td>{$form.is_experiment.html}</td>
      </tr>
      <tr class="crm-event-manage-eventinfo-form-block-experiment_id" id="experiment-id">
        <td>{$form.experiment_id.label} {help id="experiment-id"}</td>
        <td>{$form.experiment_id.html}</td>
      </tr>
    </table>
  </table>

  <div class="crm-submit-buttons">
      {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>

</div>

{literal}
  <script type="text/javascript">

    CRM.$(function($) {

      if (!$('#is_experiment').is(':checked')) {
        $('#experiment-id').hide();
      }

      if (!$('#ga_event_tracking').is(':checked')) {
        $('#eventtracking-params').hide();
      }

      if (!$('#enable_tracking').is(':checked')) {
        $('#webtracking-params').hide();
      }

      $('#is_experiment').on('click', function() {
        $('#experiment-id').toggle();
      });

      $('#ga_event_tracking').on('click', function() {
        $('#eventtracking-params').toggle();
      });

      $('#enable_tracking').on('click', function() {
        $('#webtracking-params').toggle();
      });

    });

  </script>
{/literal}

