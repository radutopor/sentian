$(function(){
	ko.validation.configure({
		errorElementClass: 'has-error',
		errorMessageClass: 'help-block',
		registerExtenders: true,
		messagesOnModified: true,
		decorateElement: true,
		parseInputAttributes: true
	});

});

