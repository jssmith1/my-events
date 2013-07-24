<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css(array(
		'bootstrap.css',
		'fullcalendar.css',
		'jquery-ui-1.10.3.custom.css',
		'jquery-ui-timepicker-addon.css',
		'app.css'
		)); ?>
	<style>
		body { margin: 50px; }
	</style>
	<?php echo Asset::js(array(
		'http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js',
		'bootstrap.js',
		'fullcalendar.js',
		'date.js',
		'jquery.validate.js'));

	
	echo Asset::render('app');

	echo Asset::js(array(
		'jquery-ui-1.10.3.custom.min.js',
		'jquery-ui-timepicker-addon.js'
	)); 


	 ?>
	
	<script type="text/jquery">
		$(function(){ $('.topbar').dropdown(); });
	</script>

</head>
<body>

	<?php if ($current_user): ?>
	<div class="navbar navbar-fixed-top">
	    <div class="navbar-inner">
	        <div class="container">
	            <a href="#" class="brand">My Calendar</a>
	            <ul class="nav">
					<?php
						$files = new GlobIterator(APPPATH.'classes/controller/admin/*.php');
						foreach($files as $file)
						{
							$section_segment = $file->getBasename('.php');
							$section_title = Inflector::humanize($section_segment);
							?>
							<li class="<?php echo Uri::segment(2) == $section_segment ? 'active' : '' ?>">
								<?php echo Html::anchor('admin/'.$section_segment, $section_title) ?>
							</li>
							<?php
						}
					?>
	          </ul>

	          <ul class="nav pull-right">
	          	<li class="dropdown">
	              <a data-toggle="dropdown" class="dropdown-toggle" href="#">Key <b class="caret"></b></a>
	              <ul class="dropdown-menu">
	               <li><?php
 						//Create Color Key 
						$types = Model_Event::get_enum_values('type');
						if($types):
						?>
							<table id='key' style="background-color:white;">
								<tr>
									<th>Event Type</th>
									<th>Color</th>
								</tr>
							
						<?php endif;

						foreach($types as $type): ?>
							<tr>
								<td> <?php echo $type?> </td>
								<td <?php echo 'style="background-color:'. Model_Event::get_type_color($type).'"'?>></td>
							</tr>

						<?php endforeach;
						if($types) {
							echo "</table>";
						} ?>
					</li>
	              </ul>
	            </li>

	            <li class="dropdown">
	              <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $current_user->username ?> <b class="caret"></b></a>
	              <ul class="dropdown-menu">
	               <li><?php echo Html::anchor('admin/logout', 'Logout') ?></li>
	              </ul>
	            </li>
	          </ul>
	        </div>
	    </div>
	</div>
	<?php endif; ?>

	<div class="container">
		<div class="row">
			<div class="span12">
				<h1><?php echo $title; ?></h1>
				<hr>
<?php if (Session::get_flash('success')): ?>
				<div class="alert alert-success">
					<button class="close" data-dismiss="alert">×</button>
					<p><?php echo implode('</p><p>', (array) Session::get_flash('success')); ?></p>
				</div>
<?php endif; ?>
<?php if (Session::get_flash('error')): ?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert">×</button>
					<p><?php echo implode('</p><p>', (array) Session::get_flash('error')); ?></p>
				</div>
<?php endif; ?>
			</div>
			<div class="span12">
<?php echo $content; ?>
			</div>
		</div>
		<hr/>

		<footer>
		<!--	<p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
			<p>
				<a href="http://fuelphp.com">FuelPHP</a> is released under the MIT license.<br>
				<small>Version: <?php echo e(Fuel::VERSION); ?></small>
		-->	</p>
		</footer>
	</div>
</body>
</html>