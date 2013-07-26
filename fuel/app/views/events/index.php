<h2>Listing Events <?php if (isset($employee)) echo "for $employee->first $employee->last";?>
</h2>
<br>
<?php if ($events): ?>

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
<div style="float:left;">
	<?php echo Html::anchor('events/create', 'Add new Event', array('class' => 'btn btn-success')); ?>
</div>

<?php
	$options = Model_Employee::getOptions();
	$options = array('-1' => 'View All') + $options; 
?>

<div class="filter" style="float:right; position:relative; top:-30px">

<?php echo Form::open(array("action" => Uri::create('events/index'),
							"method" => "get",
							"class"=>"form-horizontal",
							"id" => "filterForm")); ?>

	<div class="control-group">
		<?php echo Form::label('Employee Filter:', 'employeeId', array('class'=>'control-label', 'style' =>"float:right; position:relative; bottom:-15px")); ?>
	</div>

	<div class="control-group" style:"width:375px">
		<div class="controls" style="width:325px; float:left">
			<?php echo Form::select('employeeId', null, $options, array('class' => 'span4')); ?>
		</div>

		<div class="ccontrols" style="width:50px; float:right;">
			<?php echo Form::submit('submit', 'Filter', array('class' => 'btn btn-primary')); ?>	
		</div>
	</div>
</div>
</div>

<?php echo Form::close(); ?>

<div id='calendar' style="clear:both"></div>

<br>
