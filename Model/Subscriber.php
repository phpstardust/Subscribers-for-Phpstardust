<?php

class Subscriber extends AppModel {
	
	
	
	
	public $validate = array(
        'name' => array(
			  'minLength' => array(
				'rule' => array('minLength', '3'),
				'message' => 'Name must be min 3 characters.'
			  )
		),
		'email' => array(
			  'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Email already exists.'
			  ),
			  'email' => array(
				'rule' => 'email',
				'message' => 'Insert a valid email.'
			  )
		)
    );
	
	
	
	
	public function cleanVars($data) {
		if (is_array($data)) {
			foreach ($data as $key => $var) {
				$data[$key] = $this->cleanVars($var);
			}
		} else {
			$data = strip_tags($data, Configure::read('Psd.allowedHtmlTags'));
		}
		
		return $data;
	}
	
	
	
	
	public function beforeSave($options = array()) {
		
		if (!empty($this->data)) {
			$this->data = $this->cleanVars($this->data);
		}
		
		return true;
		
	}


	

}

?>