var $j = jQuery.noConflict();

$j(document).ready(function() {

// page is ready, initialize the calendar...
	$j('#calendar').fullCalendar({
		events: events_array,
		dayClick: dayClicked,
		editable:false,
		
	
     })
});


