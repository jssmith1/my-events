<?php
return array(
	'_root_'  => 'events/index',  // The default route
//	'_404_'   => 'welcome/404',    // The main 404 route
	
	'login'	  =>  'admin/login',

	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);