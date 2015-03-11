<?php

Configure::write(
    'Subscribers',
    array(
		'subject' => 'Subscription completed',
		'message' => 'Thank you for your subscription.',
		'includeJquery' => false
	)
);


?>