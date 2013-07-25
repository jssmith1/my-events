<h2>Viewing <span class='muted'>#<?php echo $employee->id; ?></span></h2>

<p>
	<strong>First:</strong>
	<?php echo $employee->first; ?></p>
<p>
	<strong>Last:</strong>
	<?php echo $employee->last; ?></p>

<?php echo Html::anchor('employees/edit/'.$employee->id, 'Edit'); ?> |
<?php echo Html::anchor('employees', 'Back'); ?>