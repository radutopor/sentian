<?php

/**
*	Class that controlls the configuration of the rest api (Admin Panel)
*/
class ConfigController extends BaseController 
{
	protected $layout = 'layouts.master';

	/*
		Initialize the ConfigController
	*/
		
		
		public function endpointlist(){
			if(LoginController::checkIfUserIsAuthentificated())
				$this->layout->content = View::make('admin.endpointlist');
			else
				return Redirect::to('/');
		}

		public function servicelist(){
			if(LoginController::checkIfUserIsAuthentificated())
				$this->layout->content = View::make('admin.servicelist');
			else
				return Redirect::to('/');
		}


		public function init(){
			
		}

		
		public function getServices(){
			$computedServices = array();
			$services = Service::all();

			foreach ($services as $service) {
				$computedService = static::GetComputedService($service);
				array_push($computedServices, (object)$computedService);
			}
			
			return Response::json(array("success" => true,
				"services" => $computedServices));
		}

		public function updateService(){
			$success = true;
			$message = "Successfully added service";

			$data = Input::get();
			$serv = new Service();
			$limit = new Limit();

			if($data['id'] != -1){
				$serv = Service::find($data['id']);

				$limit = Limit::where('service_id', '=', $serv->id)->first();
				$message = "Successfully updated service";
			}

			$limit->type = $data['limitType'];
			$limit->max_hits = $data['maxNoOfCalls'];

			$serv->name = $data['name'];
			$serv->root = $data['root'];

			$serv->save();
			$limit = $serv->limits()->save($limit);

			$computedService = static::GetComputedService($serv);
			return Response::json(array("success" => $success,
				"message" => $message,
				"service" => $computedService));
		}

		public function removeService(){
			$data = Input::get();
			$serv = Service::find($data['id']);
			$limit = Limit::where('service_id', '=', $serv->id)->delete();
			$endpoints = EndPoint::where('service_id', '=', $serv->id)->delete();
			$serv->delete();

			return Response::json(array("success" => true, 'message' => 'Successfully removed service!'));
		}

		public function getEndpointsAndServices(){
			$services = Service::all()->toArray();
			$endpoints = EndPoint::all();

			$computedEndpoints = array();
			foreach ($endpoints as $endpoint)
			{
				$computedEndpoint = static::GetComputedEndpoint($endpoint);
				array_push($computedEndpoints, (object)$computedEndpoint);
			}
			
			return Response::json(array("success" => true,
				"services" => $services,
				"endpoints" => $computedEndpoints));

		}

		public function updateEndpoint(){
			$success = true;
			$message = "Successfully added service";

			$data = Input::get();
			$endpoint = new EndPoint();

			$service = Service::find($data['serviceId']);

			if($data['id'] != -1){
				$endpoint = EndPoint::find($data['id']);
				$message = "Successfully updated service";
			}

			$endpoint->service_id = $data['serviceId'];
			$endpoint->name = $data['name'];
			$endpoint->httpMethod = $data['httpMethods'];
			$endpoint->httpHeaders = $data['httpHeaders'];
			$endpoint->httpContentType = $data['httpContentType'];

			$endpoint->save();
			$endpoint = $service->endpoints()->save($endpoint);

			$computedEndpoint = static::GetComputedEndpoint($endpoint);
			return Response::json(array("success" => $success,
				"message" => $message,
				"endpoint" => $computedEndpoint));
		}

		public function removeEndpoint(){
				$data = Input::get();
				$endpoint = EndPoint::find($data['id']);	
				$parameters = Parameter::where('endpoint_id', '=', $endpoint->id)->delete();
				$endpoint->delete();


			return Response::json(array("success" => true, 'message' => 'Successfully removed endpoint!'));
		}

		public function getParameters(){
			$data = Input::get();
			$endpoint = EndPoint::find($data['id']);

			$parameters = Parameter::where('endpoint_id', '=', $endpoint->id)->get()->toArray();
			return Response::json(array("success" => true, 
										'parameters' => $parameters));
		}

		public function updateParameters(){
			$data = Input::get();
			$endpoint = EndPoint::find($data['id']);

			$parameters = Parameter::where('endpoint_id', '=', $endpoint->id)->delete();;
			
			$newParameterList = $data['parameters'];
			foreach ($newParameterList as $param)
			{
				$parmeter = new Parameter();
				$parmeter->endpoint_id = $endpoint->id;
				$parmeter->name = $param['name'];
				$parmeter->defaultValue = $param['defaultValue'];
				$parmeter->type = $param['type'];
				$parmeter->required = $param['required'] === 'true'? TRUE: FALSE;
	
				$parmeter->save();
				$parmeter = $endpoint->parameters()->save($parmeter);
			}
			return Response::json(array("success" => true, 
										'message' => 'Successfully modified parameters!'));
		}

		private static function GetComputedService($service){

				$limit = $service->limits()->first();
				$computedService = array();
				$computedService['id'] = $service->id;
				$computedService['name'] = $service->name;
				$computedService['root'] =$service->root;
				$computedService['limitType'] = $limit->toArray()['type'];
				$computedService['currentNoOfCalls'] = $limit->toArray()['current_hits'];
				$computedService['maxNoOfCalls'] = $limit->toArray()['max_hits'];
				$computedService['lastDate'] = $limit->toArray()['first_call_date'];

				return $computedService;
		}

		private  static function GetComputedEndpoint($endpoint){
				$computedEndpoint = array();
				$computedEndpoint['id'] = $endpoint->id;
				$computedEndpoint['name'] = $endpoint->name;
				$computedEndpoint['serviceId'] =$endpoint->service_id;
				$computedEndpoint['httpMethods'] =$endpoint->httpMethod;
				$computedEndpoint['httpHeaders'] =$endpoint->httpHeaders;
				$computedEndpoint['httpContentType'] =$endpoint->httpContentType;

				return $computedEndpoint;
		}
	}