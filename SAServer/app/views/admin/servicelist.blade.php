@section('headerSettings')
<title>Control Panel -Index</title>


@stop

@section('externalFiles')
<script type="text/javascript" src="js/servicelist.js"></script>
@stop


@section('welcomeMessage')
Welcome admin!
@stop

@section('content')
<div id="koContainer" data-bind="with: $data">	
	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Root</th>
				<th>Limit Type</th>
				<th>Current no of Calls</th>
				<th>Max no of Calls</th>
				<th>Last Date</th>
				<th></th>
				<th></th>
			</tr>
		</thead> 
		<tbody data-bind="foreach: serviceList">
			<tr>
				<td data-bind="text:name"></td>
				<td data-bind="text:root"></td>
				<td data-bind="text:limitTypeName"></td>
				<td data-bind="text:currentNoOfCalls"></td>
				<td data-bind="text:maxNoOfCalls"></td>
				<td data-bind="text:lastDate"></td>
				<td ><button  data-bind="click: edit" class="btn btn-success btn-xs" data-toggle="modal" data-target="#serviceModal">
					Edit
				</button></td>	
				<td><button data-bind="click: $parent.remove.bind($parent,$index())" class="btn btn-danger btn-xs">Remove</button></td>
			</tr>
		</tbody>
	</table>


	<button data-bind="click: resetServiceModel"class="btn btn-primary" data-toggle="modal" data-target="#serviceModal">
		Add New Service
	</button>
	<!-- Modal -->
	<!-- Service Details-->
	<div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div data-bind="with : selectedService" class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Service Details</h4>
				</div>
				<div   class="modal-body">
					<!-- Service Details Form Start  ======================================================================-->
					<div class="form-horizontal">

						<!-- Text input-->
						<div data-bind="validationElement: name" class="form-group">
							<label class="col-md-4 control-label" for="">Name</label>  
							<div class="col-md-6">
								<input data-bind="value:name" id="" name="" type="text" placeholder="" class="form-control input-md" required="">

							</div>
						</div>

						<div data-bind="validationElement: root" class="form-group ">
							<label class="col-md-4 control-label" for="">Root</label>  
							<div class="col-md-6">
								<input data-bind="value:root" id="" name="" type="text" placeholder="" class="form-control input-md" required="">

							</div>
						</div>

						<!-- Select Basic -->
						<div class="form-group">
							<label class="col-md-4 control-label" for="">Limit Type</label>
							<div class="col-md-6">
								<select  data-bind="options: Enum.limitType,
								optionsText: 'name',
								optionsValue: 'value',
								value: limitType," id="" name="" class="form-control">
							</select>
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-4 control-label" for="">Max No Of Calls</label> 
						<div class="col-md-6">
							<input data-bind="value : maxNoOfCalls" id="" name="" type="text" placeholder="ex 500" class="form-control input-md" required="">
							<span class="help-block">(default)0 = Inifinite no of calls</span>  
						</div>
					</div>


				</div>
				<!-- Service Details Form END  ======================================================================-->
			</div>
			<div class="modal-footer">
				<button data-bind="click : save" type="button" class="btn btn-success">Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div>

	@stop