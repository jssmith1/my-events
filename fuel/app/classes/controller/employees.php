<?php
class Controller_Employees extends Controller_Admin{

	public function action_index()
	{
		$data['employees'] = Model_Employee::find('all');
		$this->template->title = "Employees";
		$this->template->content = View::forge('employees/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('employees');

		if ( ! $data['employee'] = Model_Employee::find($id))
		{
			Session::set_flash('error', 'Could not find employee #'.$id);
			Response::redirect('employees');
		}

		$this->template->title = "Employee";
		$this->template->content = View::forge('employees/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Employee::validate('create');
			
			if ($val->run())
			{
				$employee = Model_Employee::forge(array(
					'first' => Input::post('first'),
					'last' => Input::post('last'),
				));

				if ($employee and $employee->save())
				{
					Session::set_flash('success', 'Added '.$employee->first.' '.$employee->last.'.');

					Response::redirect('employees');
				}

				else
				{
					Session::set_flash('error', 'Could not save employee.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Employees";
		$this->template->content = View::forge('employees/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('employees');

		if ( ! $employee = Model_Employee::find($id))
		{
			Session::set_flash('error', 'Could not find employee #'.$id);
			Response::redirect('employees');
		}

		$val = Model_Employee::validate('edit');

		if ($val->run())
		{
			$employee->first = Input::post('first');
			$employee->last = Input::post('last');

			if ($employee->save())
			{
				Session::set_flash('success', 'Updated employee #' . $id);

				Response::redirect('employees');
			}

			else
			{
				Session::set_flash('error', 'Could not update employee #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$employee->first = $val->validated('first');
				$employee->last = $val->validated('last');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('employee', $employee, false);
		}

		$this->template->title = "Employees";
		$this->template->content = View::forge('employees/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('employees');

		if ($employee = Model_Employee::find($id, array('related' => array('employeeeventlink'))))
		{
			$employee->delete();

			Session::set_flash('success', 'Deleted employee #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete employee #'.$id);
		}

		Response::redirect('employees');

	}


}
