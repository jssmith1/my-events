<?php echo Form::open(array("class"=>"form-horizontal",
							"id" => "eventForm")); ?>

	<fieldset>
		<!--Title-->
		<div class="control-group">
			<?php echo Form::label('Title', 'title', array('class'=>'control-label')); ?>

			<div class="controls">
				<?php echo Form::input('title', Input::post('title', isset($event) ? $event->title : ''), array('class' => 'span4', 'placeholder'=>'Title')); ?>

			</div>
		</div>

		<?php //Start time
			$startValue = '';
			if (isset($event)){
				//Start value in the DB
				$startValue = join('T', explode(' ', $event->start));
			}
			else if (array_key_exists('start', $_GET)){
				//GET the start value from a calendar click 
				$startValue = substr($_GET['start'], 0 , -5);
			} 
		?>
		
		<!--Association-->
		<div class="control-group">
			<?php echo Form::label('Association', 'association', array('class'=>'control-label')); ?>

			<div class="controls">
				<?php echo Form::input('association', Input::post('association', isset($event) ? $event->association : ''), array('class' => 'span4', 'placeholder'=>'Association')); ?>

			</div>
		</div>

		<div class="control-group">
			<?php echo Form::label('Start', 'start', array('class'=>'control-label')); ?>

			<div class="controls">
				<?php echo Form::input('start', Input::post('start', $startValue), array('class' => 'span4', 'type' => 'datetime-local')); ?>

			</div>
		</div>

		<!--End time-->
		<div class="control-group">
			<?php echo Form::label('End', 'end', array('class'=>'control-label')); ?>

			<div class="controls">
				<?php echo Form::input('end', Input::post('end', isset($event) ? join('T', explode(' ', $event->end)) : ''), array('class' => 'span4', 'type' => 'datetime-local')); ?>

			</div>
		</div>

		<script>
		//Use jQuery time picker if datetime-local isn't supported for input
			if(jQuery('#form_start')[0].type!=='datetime-local'){
				jQuery('#form_start').datetimepicker({
					separator:"T",
					dateFormat:"yy-mm-dd",
					timeFormat:"HH:mm:ss",
					pickerTimeFormat:"hh:mm tt",
					showSecond:false,
					stepMinute:5,
				});
				
			}
			if(jQuery('#form_end')[0].type!=='datetime-local'){
				jQuery('#form_end').datetimepicker({
					separator:"T",
					dateFormat:"yy-mm-dd",
					timeFormat:"HH:mm:ss",
					pickerTimeFormat:"hh:mm tt",
					showSecond:false,
					stepMinute:5,
				});
			}
		</script>

		<!--Description Field-->
		<div class="control-group">
			<?php echo Form::label('Description', 'description', array('class'=>'control-label')); ?>

			<div class="controls">
				<?php echo Form::textarea('description', Input::post('description', isset($event) ? $event->description : ''), array('class' => 'span8', 'rows' => 8, 'placeholder'=>'Description')); ?>

			</div>
		</div>

		<!--Known Issues-->
		<div class="control-group">
			<?php echo Form::label('Known Issues', 'issues', array('class'=>'control-label')); ?>

			<div class="controls">
				<?php echo Form::textarea('issues', Input::post('issues', isset($event) ? $event->issues : ''), array('class' => 'span8', 'rows' => 8, 'placeholder'=>'Known issues...')); ?>

			</div>
		</div>

		<div class="control-group">
		<?php //Form for getting the type of event
			echo Form::label('Type', '', array('class' => 'control-label')); ?>

			<div class="controls">
				<?php
					
					//List of possible button types
					$options = Model_Event::get_enum_values('type');

					//Make each button
					$i=1;
					foreach ($options as $option){
						//Generate the form. Check to see if type is set for a default
						//Select button by default if it is in the post array or the event is already set (editing an event)
					
						echo "<label class='radio'>";
						echo Form::radio('type', $option, ((isset($event) and $event->type == $option) or (Input::post('type') == $option)), array("id" => "form_type_".$i));
						echo ' '.Inflector::words_to_upper($option)."<br>";
						echo "</label>";
						$i++;
					}
				?>

			</div>
		</div>

		<?php 
		//Set up options for tech support
		$options = Model_Employee::getOptions();
		
		$techDefaults = $assignedDefaults = array();
		if (isset($event)){
			$techEmployees = Model_EmployeeEventLink::find('all', array('where' => array('eventId' => $event->id,
																						'role' => 'techSupport')));
			foreach ($techEmployees as $techEmployee){
				$techDefaults[] = $techEmployee->employeeID;
			}
			
			$assignedEmployees = Model_EmployeeEventLink::find('all', array('where' => array('eventId' => $event->id,
																						'role' => 'assigned')));
			foreach ($assignedEmployees as $assignedEmployee){
				$assignedDefaults[] = $assignedEmployee->employeeID;
			}
		}
		
		if (Input::post('techSupport')){ //Check for set post data from previous submission.
			$techDefaults = Input::post('techSupport'); //If found, check those boxes on the form
		}
		if (Input::post('assigned')){
			$assignedDefaults = Input::post('assigned');
		}
		?>

		<!--Tech Support-->
		<div class="control-group" style="float:left">
			<?php echo Form::label('Tech Support', '', array('class'=>'control-label')); ?>

			<div class="controls">
				<?php echo Form::select('techSupport[]', $techDefaults, $options, array('multiple' => 'multiple',
																						'class' => 'multiselect',
																						'id' => 'techSupportForm')); 
				?>
				
			</div>
		</div>

		<!--Assigned-->
		<div class="control-group" style="float:left">
			<?php echo Form::label('Assigned', '', array('class'=>'control-label')); ?>

			<div class="controls">
				<?php echo Form::select('assigned[]', $assignedDefaults, $options, array('multiple' => 'multiple',
																						 'class' => 'multiselect',
																						 'id' => 'assignedForm')); 
				?>
				
			</div>
		</div>

		<!--User ID (Hidden Form)-->
		<div class="control-group">
			<?php echo Form::label('', '', array('class'=>'control-label')); ?>

			<div class="controls">
				<?php //Grab the user ID from the logged in admin (1) 
				echo Form::input('user_id', Input::post('id', $current_user->id), array('type' => 'hidden', 'class' => 'span4')); ?>
			</div>
		</div>

		<!--Submit button-->
		<div class="control-group">
			<label class='control-label'>&nbsp;</label>
			<div class='controls'>
				<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>			</div>
		</div>
	</fieldset>

<script>
//Validation of Start/End dates
$(document).ready(function() {
	//custom validation method
	$.validator.addMethod('endAfterStart', function (value, element){
		//input comes in 2 forms
		var startStr = $('#form_start').val();
		var start = Date.parse(startStr);
		if (!start){
			start = Date.parse(startStr + ":00");
		}
		//var end = Date.parse($('#form_end').val());
		var end = Date.parse(value);
		if (!end){
			end = Date.parse(value + ":00");
		}
		if (!end || !start){
			return false;
		}
//		console.log(start, end, value)
		return (end.compareTo(start) > 0);
		},
		'End date and time must occur after start date.');
	//
	$('#eventForm').validate({
		rules:{
			end:{
				endAfterStart:true
			}
		},
	});
});
</script>

<?php echo Form::close(); ?>
