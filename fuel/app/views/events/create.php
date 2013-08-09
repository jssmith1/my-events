<?php //Alert the form view we are coming from create.
$data['create'] = $create;
?>

<?php echo render('events/_form', $data); ?>
<p><?php echo Html::anchor('events', 'Back'); ?></p>
