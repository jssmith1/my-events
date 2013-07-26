<?php
class Controller_Events extends Controller_Admin 
{

	public function action_index()
	{
		//Check to see if an employee has been specified
		 if (array_key_exists('employeeId', $_GET)){
		 	//Basic sanitization

		 	$employeeId = $_GET['employeeId'];
		 	settype($employeeId, 'integer');

		 	$data['employee'] = Model_Employee::find($employeeId);

		 	if ($data['employee']){ //if the employee exists
			
				$links = Model_EmployeeEventLink::find('all', array('where' => array('employeeId' => $employeeId)));
				$eventIDs = array();

				foreach($links as $link){
					//Find all associated events
					$eventIDs[] = $link->eventID;
				}
				$eventIDs = array_unique($eventIDs);
				
				//If the given employee has been assigned to any event, find all assigned events
				if($eventIDs){
					$data['events'] = Model_Event::query()->where('id', 'in', $eventIDs)->get();
				}
				//The employee hasn't been assigned to any events
				else $data['events'] = array();
			}
			else { //The employee doesn't exist
				//Just display all events
				$data['events'] = Model_Event::find('all');
			}	
		}
		else{
			//No employee specified (list all events)
			$data['events'] = Model_Event::find('all');

		}
		$this->template->title = "Events";
		//Only render the calendar for event index
		Asset::js(array('app.js'), array(), 'app');
		$this->template->content = View::forge('events/index', $data);

	}

	public function action_view($id = null)
	{
		$data['event'] = Model_Event::find($id);

		$this->template->title = "Event";
		$this->template->content = View::forge('events/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Event::validate('create');

			if ($val->run())
			{
				$event = Model_Event::forge(array(
					'title' => Input::post('title'),
					'description' => Input::post('description'),
					'start' => Input::post('start'),
					'end' => Input::post('end'),
					'user_id' => Input::post('user_id'),
					'type' => Input::post('type'),
					'issues' => Input::post('issues'),
					'association' => Input::post('association'),
				));

				if ($event and $event->save())
				{
					Session::set_flash('success', e('Added event #'.$event->id.'.'));

					//Created the event, now link the employees
					//First tech support
			
					foreach(Input::post('techSupport', array()) as $employee){
						if ($employee != 0){ //Don't create a link for select all
							$link = Model_EmployeeEventLink::forge(array(
								'employeeID' => $employee,
								'eventID' => $event->id,
								'role' => 'techSupport'
								)
							);
							if (!$link or !$link->save()){
								//Notify of the error but keep linking
								Session::set_flash('error', e('Added event #'.$event->id.'. Error Linking Employees (Contact the administrator).'));
							}
						}
					}
						
					foreach(Input::post('assigned', array()) as $employee){
						if ($employee != 0){
							$link = Model_EmployeeEventLink::forge(array(
								'employeeID' => $employee,
								'eventID' => $event->id,
								'role' => 'assigned'
								)
							);
							if (!$link or !$link->save()){
								//Log the error, but keep trying to link
								Session::set_flash('error', e('Added event #'.$event->id.'. Error Linking Employees. (Contact the administrator)'));
							}
						}
						
					}
				
					Response::redirect('events');
				}

				else
				{
					Session::set_flash('error', e('Could not save event.'));
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Events";
		$this->template->content = View::forge('events/create');

	}

	public function action_edit($id = null)
	{
		$event = Model_Event::find($id);
		$val = Model_Event::validate('edit');

		if ($val->run())
		{
			$event->title = Input::post('title');
			$event->description = Input::post('description');
			$event->start = Input::post('start');
			$event->end = Input::post('end');
			$event->user_id = Input::post('user_id');
			$event->type = Input::post('type');
			$event->issues = Input::post('issues');
			$event->association = Input::post('association');

			//Update the employeeEventLinks
			//Delete all old links
			DB::delete('employeeEventLinks')->where('eventId', '=', $id)->execute();
			//Model_EmployeeEventLink::find('all', array("where" => array("eventId" => $id)))->delete();

			//And link new employees
			foreach(Input::post('techSupport', array()) as $employee){
				if ($employee != 0){
					$link = Model_EmployeeEventLink::forge(array(
						'employeeID' => $employee,
						'eventID' => $event->id,
						'role' => 'techSupport'
						)
					);
					if (!$link or !$link->save()){
						//Notify of the error but keep linking
						Session::set_flash('error', e('Added event #'.$event->id.'. Error Linking Employees (Contact the administrator).'));
					}
				}
			}

			foreach(Input::post('assigned', array()) as $employee){
				if ($employee != 0) {
					$link = Model_EmployeeEventLink::forge(array(
						'employeeID' => $employee,
						'eventID' => $event->id,
						'role' => 'assigned'
						)
					);
					if (!$link or !$link->save()){
						//Notify of the error but keep linking
						Session::set_flash('error', e('Added event #'.$event->id.'. Error Linking Employees (Contact the administrator).'));
					}				
				}
			}


			if ($event->save())
			{
				Session::set_flash('success', e('Updated event #' . $id));

				Response::redirect('events');
			}

			else
			{
				Session::set_flash('error', e('Could not update event #' . $id));
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$event->title = $val->validated('title');
				$event->description = $val->validated('description');
				$event->start = $val->validated('start');
				$event->end = $val->validated('end');
				$event->user_id = $val->validated('user_id');
				$event->type = $val->validated('type');
				$event->issues = $val->validated('issues');
		
				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('event', $event, false);
		}

		$this->template->title = "Events"; 
		$this->template->content = View::forge('events/edit');

	}

	public function action_delete($id = null)
	{
		if ($event = Model_Event::find($id, array('related' => array('employeeEventLink'))))
		{
			$event->delete();

			Session::set_flash('success', e('Deleted event #'.$id));
		}

		else
		{
			Session::set_flash('error', e('Could not delete event #'.$id));
		}

		Response::redirect('events');

	}


}