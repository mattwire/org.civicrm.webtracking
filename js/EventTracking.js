
function trackPriceChange() {
	CRM.$(function($) {
		$("div[class^='price-set-row']").on('click', function(event) {
			var id = event.target.id;
			if ($("#"+ id).is(':checked')) {
				var eventString = $("#"+id).attr('data-amount') + " " + $("#"+id).attr('data-currency');
				ga('send', 'event', eventString, 'Selected');
			}
		});
	});
}

function trackEcommerce() {
	var trnxId = CRM.vars.WebTracking.trnx_id;
	var totalAmount = CRM.vars.WebTracking.totalAmount;
	var source = CRM.vars.WebTracking.utm_source;
	var lineItems = CRM.vars.WebTracking.lineItems;

	ga('require', 'ecommerce');
	ga('ecommerce:addTransaction', {
			'id': trnxId,                     // Transaction ID. Required.
			'affiliation': source,   		  // Affiliation or store name.
			'revenue': totalAmount,           // Grand Total.
			'shipping': '0',                  // Shipping.
			'tax': '0'                     	  // Tax.
	});
	// add items for this transaction
	if (lineItems && lineItems.length) {
		lineItems.map(function(item) {
			ga('ecommerce:addItem', item);
		});
	}
	ga('ecommerce:send');
}

function trackViewRegistration() {
	CRM.$(function($) {
		if ($("#errorList li").length == 0) {
			ga('send', 'event', 'Registration Page', 'Viewed');
		}
	});
}
