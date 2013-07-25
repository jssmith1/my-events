<h2>Editing Event</h2>
<br>

<?php echo render('events/_form'); ?>
<p>
	<?php echo Html::anchor('events/view/'.$event->id, 'View'); ?> |
	<?php echo Html::anchor('events', 'Back'); ?></p>
