<h2>Editing <span class='muted'>Employee</span></h2>
<br>

<?php echo render('admin\employees/_form'); ?>
<p>
	<?php echo Html::anchor('admin/employees/view/'.$employee->id, 'View'); ?> |
	<?php echo Html::anchor('admin/employees', 'Back'); ?></p>
