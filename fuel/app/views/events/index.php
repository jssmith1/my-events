<h2>Listing Events <?php if (isset($employee)) echo "for $employee->first $employee->last";?>
</h2>
<br>

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

		input = '<input type="text" name="start" value="' + date.toString("yyyy-MM-ddTHH:mm") + '">'

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

<?php if (!$events){
	echo "<p>No Events.</p>";
}
?>

<div>

<span class="pull-left;">
	<?php echo Html::anchor('events/create', 'Add new Event', array('class' => 'btn btn-success')); ?>
</span>

<?php
	$employees = array('-1' => 'View All') + $employees; 
?>


<div class="filter pull-right">

	<?php echo Form::open(array("action" => Uri::create('events/index'),
							"method" => "get",
							"class"=>"form-horizontal",
							"id" => "filterForm")); ?>

		<div class="control-group controls">
			<?php echo Form::label('Employee Filter:', 'employeeId'); ?>
			<?php echo Form::select('employeeId', isset($employee)?$employee->id:null, $employees, array('class' => 'span4')); ?>
			<?php echo Form::submit('submit', 'Filter', array('class' => 'btn btn-primary')); ?>	
		</div>

	<?php echo Form::close(); ?>		
</div>

</div>


<div class='clearfix'> </div>

<div id='calendar' class="fc fc-ltr"></div>

<br>
