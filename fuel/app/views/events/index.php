<h2>Listing Events <?php if (isset($employee)) echo "for $employee->first $employee->last";?>
</h2>
<br>
<?php if ($events): ?>

<?php /*LISTING EVENTS	
<table class="table table-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th>Description</th>
			<th>Start</th>
			<th>End</th>
			<th>User id</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($events as $event): ?>		<tr>

			<td><?php echo $event->title; ?></td>
			<td><?php echo $event->description; ?></td>
			<td><?php echo $event->start; ?></td>
			<td><?php echo $event->end; ?></td>
			<td><?php echo $event->user_id; ?></td>
			<td>
				<?php echo Html::anchor('events/view/'.$event->id, 'View'); ?> |
				<?php echo Html::anchor('events/edit/'.$event->id, 'Edit'); ?> |
				<?php echo Html::anchor('events/delete/'.$event->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>
*/ ?>

<script type="text/javascript">
	//set up the events to be displayed on the calendar
	
	var events_array = [
	   <?php foreach ($events as $event): ?>
	    
	    {title: <?php echo'"'.$event->association.'"'; ?>,
	    //Reformat the dates
	    start: <?php 
	    	echo '"'.join('T', explode(' ', $event->start)).'"';
	    	 ?>,
	    end: <?php 
	    	echo '"'.join('T', explode(' ', $event->end)).'"';
	    	 ?>,
	   	url: <?php echo '"'.Uri::create('events/view/'.$event->id).'"'; ?>,
	   	color: <?php echo '"'.Model_Event::get_type_color($event->type).'"'; ?> 
	    },
	 	
	    <?php endforeach; ?>
	];

	//Click a day to pull up add event form
	function dayClicked(date, allDay, jsEvent, view) {

		var $jq = jQuery.noConflict();

		input = '<input type="text" name="start" value="' + date.toISOString() + '">'

		$jq('body')
	        .append('<form id="startForm"></form>'); 
	    $jq('#startForm') //set the form attributes
	        .attr("action",<?php echo '"'.Uri::create('events/create').'"'; ?>)
	        .attr("method","get") 
	        .attr("type", "hidden")
	        //add in the input
	       	.append(input)
	 	//Submit the form take us to event creation page
	    document.forms['startForm'].submit();
};

</script>

<?php else: ?>
<p>No Events.</p>

<?php endif; ?>

<div>
<p style="float:left">
	<?php echo Html::anchor('events/create', 'Add new Event', array('class' => 'btn btn-success')); ?>
</p>

<?php
$employees = Model_Employee::find('all');
		foreach ($employees as $employee){
			$ids[] = $employee->id;
			$names[] = $employee->first.' '.$employee->last;
		}
		$options = array_combine($ids, $names);
		$options["-1"] = "View All"; 
?>

<div class="filter" style="float:right">

<?php echo Form::open(array("action" => Uri::create('events/index'),
							"method" => "get",
							"class"=>"form-horizontal",
							"id" => "filterForm")); ?>

<div class="control-group">
	<?php echo Form::label('Employee Filter', 'employeeId', array('class'=>'control-label')); ?>

	<div class="controls">
		<?php echo Form::select('employeeId', null, $options, array('class' => 'span4')); 
		?>

	</div>
</div>


<div class="control-group" >
			<div class='controls'>
				<?php echo Form::submit('submit', 'Filter', array('class' => 'btn btn-primary')); ?>	
			</div>
</div>
</div>
</div>

<?php echo Form::close(); ?>

<div id='calendar' style="clear:both"></div>

<br>
