@section('headerSettings')
<title>Control Panel -Index</title>

@stop

@section('externalFiles')
<script type="text/javascript" src="js/endpointlist.js"></script>
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
				<th>Service</th>
				<th>Http Method</th>
				<th>Http Headers</th>
				<th>Http Content Type</th>
				<th></th>
        <th></th>
        <th></th>
        <th></th>
      </tr>
    </thead> 
    <tbody data-bind="foreach: endPointList">
     <tr>
      <td data-bind="text:name"></td>
      <td data-bind="text:serviceName"></td>
      <td data-bind="text:httpMethods"></td>
      <td data-bind="text:httpHeaders"></td>
      <td data-bind="text:httpContentType"></td>
      
      <td>
        <button data-bind="visible: isEndpointUpdate, click: viewParameters"  class="btn btn-primary btn-xs" data-toggle="modal" data-target="#parametersModal">
         View Parameters
       </button></td>
       <td ><button  data-bind="click: edit" class="btn btn-success btn-xs" data-toggle="modal" data-target="#endpointModal">
         Edit
       </button></td>	
       <td><button data-bind="click: $parent.remove.bind($parent,$index())" class="btn btn-danger btn-xs">Remove</button></td>
     </tr>
   </tbody>
 </table>

 <button data-bind="click: resetEndPointDetails" class="btn btn-primary" data-toggle="modal" data-target="#endpointModal">
   Add New Endpoint
 </button>

 <!-- Modal -->
 <!-- Parameters Details-->
 <div class="modal fade" id="parametersModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
    <div data-bind="with : selectedEndPoint" class="modal-content parameters-modal-content">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title" id="myModalLabel">Parameters Details</h4>
    </div>
    <div   class="modal-body">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Default Value</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody data-bind=" foreach: parameterList">
          <tr>
            <td data-bind="validationElement: name"><input data-bind="value: name" type="text" class="form-control input-md"/></td>
            <td><select data-bind="options: Enum.parameterType, optionsText: 'name', optionsValue: 'value', value: type," class="form-control"></select></td>
            <td data-bind="validationElement: defaultValue"><input data-bind="value: defaultValue" type="text" class="form-control input-md"/></td>
            <td>               
             <div class="checkbox">
              <label>
                <input  data-bind="checked: required" type="checkbox" /><span>Required</span> 
              </label>
            </div>
          </td>
          <td><button data-bind="click: $parent.removeParameter.bind($parent, $index())" class="btn btn-danger btn-xs">Remove</button></td>
        </tr> 
      </tbody>
    </table>
    <a data-bind="click: addMoreParameters" href="">Add More</a>
  </div>
  <div class="modal-footer">
    <button data-bind="click : saveParameters" type="button" class="btn btn-success">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- EndPoint Details-->
<div class="modal fade" id="endpointModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div data-bind="with : selectedEndPoint" class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Endpoint Details</h4>
			</div>
			<div  class="modal-body">
        <!-- Start Of FORM ===================================================================================================-->
        <!-- Text input-->
        <div class="form-horizontal">

          <!-- Text input-->
          <div data-bind="validationElement: name" class="form-group">
            <label class="col-md-4 control-label" for="">Name</label>  
            <div class="col-md-6">
              <input data-bind="value : name"  id="" name="" type="text" placeholder="" class="form-control input-md" required="">
              
            </div>
          </div>

          <!-- Select Basic -->
          <div data-bind="validationElement: serviceId" class="form-group">
            <label class="col-md-4 control-label" for="">Service</label>
            <div class="col-md-6">
              <select data-bind="options: $parent.serviceList,
              optionsText: 'name',
              optionsValue: 'id',
              value: serviceId,
              optionsCaption: 'Choose...'" id="" name="" class="form-control">
            </select>
          </div>
        </div>

        <!-- Multiple Checkboxes (inline) -->
        <!-- <div class="form-group">
          <label class="col-md-4 control-label" for="">Http Methods</label>
          <div class="col-md-8">
            <label class="checkbox-inline" for="-0">
              <input data-bind='checked: httpMethods' type="checkbox" name="" id="-0" value="GET">
              GET
            </label>
            <label class="checkbox-inline" for="-1">
              <input data-bind='checked: httpMethods' type="checkbox" name="" id="-1" value="POST">
              POST
            </label>
            <label class="checkbox-inline" for="-2">
              <input data-bind='checked: httpMethods' type="checkbox" name="" id="-2" value="PUT">
              PUT
            </label>
            <label class="checkbox-inline" for="-3">
              <input data-bind='checked: httpMethods' type="checkbox" name="" id="-3" value="PATCH">
              PATCH
            </label>
            <label class="checkbox-inline" for="-4">
              <input data-bind='checked: httpMethods' type="checkbox" name="" id="-4" value="DELETE">
              DELETE
            </label>
          </div>
        </div> -->

        <!-- Multiple Radios (inline) -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="radios">Http Methods</label>
          <div class="col-md-8"> 
            <label class="radio-inline" for="radios-0">
              <input data-bind='checked: httpMethods' type="radio" name="radios" id="radios-0" value="GET" checked="checked">
              GET
            </label> 
            <label class="radio-inline" for="radios-1">
              <input data-bind='checked: httpMethods' type="radio" name="radios" id="radios-1" value="POST">
              POST
            </label> 
            <label class="radio-inline" for="radios-2">
              <input data-bind='checked: httpMethods' type="radio" name="radios" id="radios-2" value="PUT">
              PUT
            </label> 
            <label class="radio-inline" for="radios-3">
              <input data-bind='checked: httpMethods' type="radio" name="radios" id="radios-3" value="PATCH">
              PATCH
            </label>
            <label class="radio-inline" for="radios-4">
              <input  data-bind='checked: httpMethods'type="radio" name="radios" id="radios-4" value="DELETE">
              DELETE
            </label>
          </div>
        </div>


        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="">Http Header</label>
          <div class="col-md-6">
            <select data-bind="options: Enum.httpHeaders,
            optionsText: 'name',
            optionsValue: 'value',
            value: httpHeaders" id="" name="" class="form-control">
          </select>
        </div>
      </div>

      <!-- Select Basic -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="">Http Content</label>
        <div class="col-md-6">
          <select data-bind="options: Enum.httpContent,
          optionsText: 'name',
          optionsValue: 'value',
          value: httpContentType" id="" name="" class="form-control">
        </select>
      </div>
    </div>
    <!-- End Of FORM ===================================================================================================-->
  </div>
  <div class="modal-footer">
   <button  data-bind="click : save" type="button" class="btn btn-success">Save</button>
   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
@stop