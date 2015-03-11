<?php

Router::connect('/subscribeform', array(
	'plugin'=>'subscribers', 
	'controller' => 'subscribers', 
	'action' => 'subscribeform'
));

Router::connect('/subscribers/install', array(
	'plugin'=>'subscribers', 
	'controller' => 'subscribers', 
	'action' => 'install'
));

Router::connect('/phpstardust/subscribers', array(
	'plugin'=>'subscribers', 
	'controller' => 'subscribers', 
	'action' => 'index'
));

Router::connect('/subscribers', array(
	'plugin'=>'subscribers', 
	'controller' => 'subscribers', 
	'action' => 'index'
));

Router::promote();

?>