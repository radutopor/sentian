(function(){

	window.initServiceList = initServiceList;
	var unwrap = ko.utils.unwrapObservable;
	var vm = new ServiceListModel();

	//window.viewModel = vm;
	$(function(){
		initServiceList();
	})

	ServiceListModel.prototype.load = function(){
		callAjax({
			url : '/getEndpointsAndServices',
			dataType: 'json',
		}).done(function (data){
			if( data && data.success)
			{
				var srvList = [];
				for (var i = 0, length = data.services.length; i < length; i++) {
					srvList.push(new ServiceModel(data.services[i], this, i));
				};
				this.serviceList(srvList);

				var endpList = [];
				for (var i = 0, length = data.endpoints.length; i < length; i++) {
					endpList.push(new EndPointModel(data.endpoints[i], this, i));
				};
				this.endPointList(endpList);

			}else{
				bootstrapAlert("There was an error procesing your request", Enum.alertType.error, true);
			}
		}.bind(this));
	}

	ServiceListModel.prototype.remove = function(index){
		if(confirm('Are you sure you want to remove the EndPoint')){
			var data = {
				id: unwrap(this.endPointList()[index].id),
			};

			callAjax({
				url : '/removeEndpoint',
				data: data,
				type: 'POST', 
				dataType: 'json',
			}).done(function (data){
				if( data && data.success)
				{
					this.endPointList.splice(index,1);
					bootstrapAlert(data.message, Enum.alertType.success, true);

				}else{
					bootstrapAlert("There was an error procesing your request", Enum.alertType.error, true);
				}
			}.bind(this));
		}
	}

	ServiceListModel.prototype.resetEndPointDetails = function(){
		this.selectedEndPoint(new EndPointModel());
		
	}

	EndPointModel.prototype.save = function() {
		var data = {
			id: unwrap(this.id),
			name: unwrap(this.name),
			serviceId: unwrap(this.serviceId),
			httpMethods: unwrap(this.httpMethods),
			httpHeaders: unwrap(this.httpHeaders),
			httpHeaders: unwrap(this.httpHeaders),
			httpContentType: unwrap(this.httpContentType),
		};
		
		var endpointIndex = this.index;
		var isUpdate = unwrap(this.id) != -1;

		if (this.isValid())
		{
			callAjax({
				url : '/updateEndpoint',
				data : data,
				dataType: 'json',
				type: 'POST', 
			}).done(function (data){
				if( data && data.success)
				{
					if(isUpdate)
						vm.endPointList()[endpointIndex].updateEndPointDetails(data.endpoint);
					else
						vm.endPointList.push(new EndPointModel(data.endpoint, vm, vm.endPointList().length));

					bootstrapAlert(data.message, Enum.alertType.success, true);
					$('#endpointModal').modal('hide');
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

	EndPointModel.prototype.edit = function() {
		var data = {
			id: unwrap(this.id),
			name: unwrap(this.name),
			serviceId: unwrap(this.serviceId),
			httpMethods: unwrap(this.httpMethods),
			httpHeaders: unwrap(this.httpHeaders),
			httpHeaders: unwrap(this.httpHeaders),
			httpContentType: unwrap(this.httpContentType),
		};
		vm.selectedEndPoint(new EndPointModel(data, vm, this.index));
	}

	EndPointModel.prototype.updateEndPointDetails = function(data){
		this.id(data.id);
		this.name(data.name);
		this.serviceId(data.serviceId);
		this.httpMethods(data.httpMethods);
		this.httpHeaders(data.httpHeaders);
		this.httpHeaders(data.httpHeaders);
		this.httpContentType(data.httpContentType);	
	}

	return;

	function ServiceListModel(){
		this.endPointList = ko.observableArray();
		this.serviceList = ko.observableArray();
		this.selectedEndPoint = ko.observable();
	}

	function EndPointModel(data, parent, index){
		this.id = ko.observable(data && data.id || -1);
		this.name = ko.observable(data && data.name).extend({ required: true });
		this.serviceId = ko.observable(data && data.serviceId).extend({ required: true });
		this.httpMethods = ko.observable(data && data.httpMethods || 'POST');
		this.httpHeaders = ko.observable(data && data.httpHeaders || 'application/json');
		this.httpContentType = ko.observable(data && data.httpContentType || 'text/plain');
		this.parameterList = ko.observableArray([new ParameterModel({},this), new ParameterModel({},this)]);
		this.index = index;

		this.isEndpointUpdate = ko.computed(function(){
			return this.id != -1;
		},this);

		this.serviceName = ko.computed(function (){
			if(parent && parent.serviceList().length > 0)
			{
				var service = $.grep(parent.serviceList(), function (service, index){
					return unwrap(service.id) == unwrap(this.serviceId);
				}.bind(this));	
			}

			if(service && service.length > 0)
				return unwrap(service[0].name);

			return '';
		},this);

		this.limitTypeName = ko.computed(function (){
			var limit = $.grep(Enum.limitType, function (limitType, index){
				return limitType.value == unwrap(this.limitType);
			}.bind(this));	

			if(limit && limit.length > 0)
				return limit[0].name;
			return '';
		},this);

		var validationModel = ko.validatedObservable({
			name: this.name,
			serviceId: this.serviceId,
		});


		this.isValid = function(){
			if (!validationModel().isValid()) {
				validationModel.errors.showAllMessages();
				return;
			}
			return true;
		};


		this.addMoreParameters = function()	{
			this.parameterList.push(new ParameterModel({}, this));
		};

		
		this.viewParameters = function(){
			callAjax({
				url : '/getParameters',
				data: {
					id: unwrap(this.id),
				},
				dataType: 'json',
			}).done(function (data){
				if( data && data.success)
				{
					var parameters = [];
					for (var i = 0, length = data.parameters.length; i < length; i++) {
						parameters.push(new ParameterModel(data.parameters[i], this));
					};

					this.parameterList(parameters);
					vm.selectedEndPoint(this);		


				}else{
					bootstrapAlert("There was an error procesing your request", Enum.alertType.error, true);
				}
			}.bind(this));
		}

		this.saveParameters = function(){
			var selectedParameters = $.grep(this.parameterList(), function(parameter, index){	
				return parameter.mustBeChecked();
			});

			if(selectedParameters.length <= 0)
				bootstrapAlert('You must complete at least one parameter before saving!', Enum.alertType.warning, true);

			
			var parametersArray = $.map(selectedParameters, function (parameter, index) {
				var param = {
					name : unwrap(parameter.name),
					defaultValue: unwrap(parameter.defaultValue),
					type: unwrap(parameter.type),
					required: unwrap(parameter.required),
				};
				return param;
			});

			callAjax({
				url : '/updateParameters',
				data: {
					id: vm.selectedEndPoint().id,
					parameters: parametersArray,
				},
				type : 'POST',
				dataType: 'json',
			}).done(function (data){
				if( data && data.success)
				{
					$('#parametersModal').modal('hide');
					bootstrapAlert(data.message, Enum.alertType.success, true);
				}else{
					bootstrapAlert("There was an error procesing your request", Enum.alertType.error, true);
				}
			}.bind(this));
		}

		this.removeParameter = function (index){
			this.parameterList.splice(index,1);
		}
	}

	function ServiceModel(data, parent){
		this.id = ko.observable(data && data.id);
		this.name = ko.observable(data && data.name);
	}

	function ParameterModel(data, parent){
		this.id = ko.observable(data, data.id || -1);
		this.endpointId = ko.observable(data && data.endpointId);
		this.name = ko.observable(data && data.name).extend({required:true});
		this.defaultValue = ko.observable(data && data.defaultValue).extend({required:true});
		this.type = ko.observable(data && data.type);

		this.required = ko.observable(data && !!parseInt(data.required));


		this.mustBeChecked = ko.computed({
			read: function(){
				return (unwrap(this.name) || unwrap(this.defaultValue)) &&  (unwrap(this.name) != '' || unwrap(this.defaultValue) !='');

				return false;
			},
			owner : this
		});


		this.isValid = function(){
			var validationModel = ko.validatedObservable({
				name: this.name,
				defaultValue : this.defaultValue,
			});

			if(!validationModel().isValid()){
				validationModel.errors.showAllMessages();
				return false;
			}
			return true;
		}
	}

	function initServiceList(){

		var bindElement = $('#koContainer')[0];
		ko.applyBindings(vm, bindElement);

		vm.load();
	}
})();