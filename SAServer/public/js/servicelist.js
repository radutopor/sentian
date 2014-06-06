(function(){

	window.initServiceList = initServiceList;
	var unwrap = ko.utils.unwrapObservable;
	var vm = new ServiceListModel();

	window.viewModel = vm;

	// call init  on document ready
	$(function(){
		initServiceList();
	})

	ServiceListModel.prototype.load = function(){
		callAjax({
			url : '/getServices',
			dataType: 'json',
		}).done(function (data){
			if( data && data.success)
			{
				var srvList = [];
				for (var i = 0, data =  data.services, length = data.length; i < length; i++) {
					srvList.push(new ServiceModel(data[i], this, i));
				};

				this.serviceList(srvList);
			}else{
				bootstrapAlert("There was an error procesing your request", Enum.alertType.error, true);
			}
		}.bind(this));
	}

	ServiceListModel.prototype.remove = function(index){
		if(confirm('Are you sure you want to remove the EndPoint')){
			var data = {
				id: unwrap(this.serviceList()[index].id),
			}

			callAjax({
				url : '/removeService',
				data: data,
				type: 'POST', 
				dataType: 'json',
			}).done(function (data){
				if( data && data.success)
				{
					this.serviceList.splice(index,1);
				}else{
					bootstrapAlert("There was an error procesing your request", Enum.alertType.error, true);
				}
			}.bind(this));
		}
	}

	ServiceListModel.prototype.resetServiceModel = function(){
		var newServiceModel = new ServiceModel();
		this.selectedService(newServiceModel);
	}

	ServiceModel.prototype.edit = function() {
		var data = {
			id : unwrap(this.id),
			name: unwrap(this.name),
			root: unwrap(this.root),
			limitType: unwrap(this.limitType),
			maxNoOfCalls: unwrap(this.maxNoOfCalls),
		};
		vm.selectedService(new ServiceModel(data, vm, this.index));
	}

	ServiceModel.prototype.save = function() {
		var data = {
			id: unwrap(this.id),
			name: unwrap(this.name),
			root: unwrap(this.root),
			limitType: unwrap(this.limitType),
			maxNoOfCalls: unwrap(this.maxNoOfCalls) || 0,
		};
		
		var serviceIndex = this.index;
		var isUpdate = unwrap(this.id) != -1;

		if (this.isValid())
		{
			callAjax({
				url : '/updateService',
				data : data,
				dataType: 'json',
				type: 'POST', 
			}).done(function (data){
				if( data && data.success)
				{
					if(isUpdate)
						vm.serviceList()[serviceIndex].updateSericeModel(data.service);
					else
						vm.serviceList.push(new ServiceModel( data.service, vm, vm.serviceList().length));

					bootstrapAlert(data.message, Enum.alertType.success, true);
					$('#serviceModal').modal('hide');
				}else{
					bootstrapAlert("There was an error procesing your request", Enum.alertType.error, true);
				}
			});
		}
		else
		{
			bootstrapAlert("Please check that all the fields are completed correctly!", Enum.alertType.error, true);
		}
	}

	return;

	function ServiceListModel(){
		this.serviceList = ko.observableArray();
		this.selectedService = ko.observable();
	}

	function ServiceModel(data, parent, index){
		this.id = ko.observable(data && data.id || -1);
		this.name = ko.observable(data && data.name).extend({ required: true });
		this.root = ko.observable(data && data.root).extend({ required: true });
		this.limitType = ko.observable(data && data.limitType);
		this.currentNoOfCalls = ko.observable(data && data.currentNoOfCalls);
		this.maxNoOfCalls = ko.observable(data && data.maxNoOfCalls);
		this.lastDate = ko.observable(data && data.lastDate);
		this.index = index;

		this.limitTypeName = ko.computed(function (){
			var limit = $.grep(Enum.limitType, function (limitType, index){
				return limitType.value == unwrap(this.limitType);
			}.bind(this));	

			if(limit && limit.length > 0)
				return limit[0].name;
			return '';
		},this);

		this.updateSericeModel = function(data){
			this.name(data.name);
			this.root(data.root);
			this.limitType(data.limitType);
			this.maxNoOfCalls(data.maxNoOfCalls);
		}

		var validationModel = ko.validatedObservable({
			name : this.name,
			root : this.root,
		});
		
		this.isValid = function(){
			if (!validationModel().isValid()) {
				validationModel.errors.showAllMessages();
				return false;
			};
			return true;
		};
	}


	function initServiceList(){

		var bindElement = $('#koContainer')[0];
		ko.applyBindings(vm, bindElement);

		vm.load();
	}
})();