<h2>Editing <span class='muted'>Employee</span></h2>
<br>

<?php echo render('employees/_form'); ?>
<p>
	<?php echo Html::anchor('employees/view/'.$employee->id, 'View'); ?> |
	<?php echo Html::anchor('employees', 'Back'); ?></p>
