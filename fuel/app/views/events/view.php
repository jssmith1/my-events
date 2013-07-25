<?php echo $event->title; ?>
<?php if($event->association){
	echo " - ($event->association)";
}?>
</h2>

<p><h4>Description:</h4>
	<pre><?php echo $event->description; ?></pre>
</p>

<?php if($event->issues):?> 
	<p><h4>Known Issues</h4>
		<pre><?php echo $event->issues; ?></pre>
	</p>
<?php endif; ?>

<p><h4>Start:</h4>
	<?php echo date('l jS \of F Y h:i A', strtotime($event->start)); ?>
</p>

<p><h4>End:</h4>
	<?php echo date('l jS \of F Y h:i A', strtotime($event->end)); ?></p>
<p>

<p><h4>Event Type:</h4>
	<?php echo ucfirst($event->type)?>
</p>

<div style="position:fixed; float:left"><h4>Tech Support:</h4>
<ul>
<?php $techEmployees = Model_EmployeeEventLink::find('all', array('where' => array('eventId' => $event->id,
																						'role' => 'techSupport'))); 
	foreach ($techEmployees as $techEmployee){
			$employee = Model_Employee::find($techEmployee->employeeID);
			echo "<li> $employee->first $employee->last </li>";
		}
?>
</ul>
</div>

<div style="margin-left:200px"><h4>Assigned Employees:</h4>
<ul>
<?php $assignedEmployees = Model_EmployeeEventLink::find('all', array('where' => array('eventId' => $event->id,
																						'role' => 'assigned'))); 
	foreach ($assignedEmployees as $assignedEmployee){
			$employee = Model_Employee::find($assignedEmployee->employeeID);
			echo "<li> $employee->first $employee->last </li>";
		}
?>
</ul>
</div>
</br>
<div style="clear:both; margin-top: 50px">
<?php echo Html::anchor('events/edit/'.$event->id, 'Edit'); ?> |
<?php echo Html::anchor('events/delete/'.$event->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?> |
<?php echo Html::anchor('events', 'Back'); ?>
</div>