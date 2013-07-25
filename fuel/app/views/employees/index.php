<h2>Listing <span class='muted'>Employees</span></h2>
<br>
<?php if ($employees): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>First</th>
			<th>Last</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($employees as $employee): ?>		<tr>

			<td><?php echo $employee->first; ?></td>
			<td><?php echo $employee->last; ?></td>
			<td>
				<?php echo Html::anchor('employees/view/'.$employee->id, '<i class="icon-eye-open" title="View"></i>'); ?> |
				<?php echo Html::anchor('employees/edit/'.$employee->id, '<i class="icon-wrench" title="Edit"></i>'); ?> |
				<?php echo Html::anchor('employees/delete/'.$employee->id, '<i class="icon-trash" title="Delete"></i>', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Employees.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('employees/create', 'Add new Employee', array('class' => 'btn btn-success')); ?>

</p>
