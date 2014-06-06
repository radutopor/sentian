function callAjax(options){
	return $.ajax(options).fail(function(){
		if(options && $.isFunction(options.error)){
			options.error();
		}else
		{
			bootstrapAlert("We are sorry! There was an error processing your request!", Enum.alertType.error, true);
		}
	});
}
var bootstrapAlertTimeout;

// bootstrap alert
function bootstrapAlert(message, type, autoFadeIn){
	clearTimeout(bootstrapAlertTimeout);

	if(type === undefined)
		type = Enum.alertType.success;

	if(autoFadeIn)
		bootstrapAlertTimeout = setTimeout(function(){
			hideBoostrapAlert();
		}, 5000);
	
	$('div.divAlert > div.alert').addClass(type);
	$('div.alert > div.message').text(message);
	$('div.divAlert').show();
}

function hideBoostrapAlert(){
	$('div.divAlert').hide();
	$('div.divAlert > div.alert').removeClass(Enum.alertType.success)
								.removeClass(Enum.alertType.info)
								.removeClass(Enum.alertType.warning)
								.removeClass(Enum.alertType.error);

}


// $(function(){
// 	    $('.button-checkbox').each(function(){
// 		var $widget = $(this),
// 			$button = $widget.find('button'),
// 			$checkbox = $widget.find('input:checkbox'),
// 			color = $button.data('color'),
// 			settings = {
// 					on: {
// 						icon: 'glyphicon glyphicon-check'
// 					},
// 					off: {
// 						icon: 'glyphicon glyphicon-unchecked'
// 					}
// 			};

// 		$button.on('click', function () {
// 			$checkbox.prop('checked', !$checkbox.is(':checked'));
// 			$checkbox.triggerHandler('change');
// 			updateDisplay();
// 		});

// 		$checkbox.on('change', function () {
// 			updateDisplay();
// 		});

// 		function updateDisplay() {
// 			var isChecked = $checkbox.is(':checked');
// 			// Set the button's state
// 			$button.data('state', (isChecked) ? "on" : "off");

// 			// Set the button's icon
// 			$button.find('.state-icon')
// 				.removeClass()
// 				.addClass('state-icon ' + settings[$button.data('state')].icon);

// 			// Update the button's color
// 			if (isChecked) {
// 				$button
// 					.removeClass('btn-default')
// 					.addClass('btn-' + color + ' active');
// 			}
// 			else
// 			{
// 				$button
// 					.removeClass('btn-' + color + ' active')
// 					.addClass('btn-default');
// 			}
// 		}
// 		function init() {
// 			updateDisplay();
// 			// Inject the icon if applicable
// 			if ($button.find('.state-icon').length == 0) {
// 				$button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
// 			}
// 		}
// 		init();
// 	});
// });