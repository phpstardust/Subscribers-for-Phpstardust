<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class SubscribersController extends AppController {
	
	public $uses = array('Subscribers.Subscriber');
	
	public $components = array(
		'Session','Cookie','RequestHandler','Paginator', 'Phpstardust.Psd',
		'Auth' => array(
			'loginRedirect' => array(
				'controller' => 'users',
				'action' => 'login'
			),
			'logoutRedirect' => array(
				'controller' => 'users',
				'action' => 'login'
			),
			'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish',
					'scope' => array('status' => 1)
                )
            ),
			'flash' => array(
				'key'=>'auth',
				'element'=>'authError'
			  ),
			'loginAction' => array('controller' => 'users', 'action' => 'login')
		)
	);
	
	public $helpers = array('Html', 'Form', 'Session');
	
	
	
	
	public function install() {
		
		$db = ConnectionManager::getDataSource('default');
		
		$dbVars = $db->config;
		$prefix = $dbVars["prefix"];
	
		if (count($db->query('SHOW TABLES LIKE "' .$prefix .'subscribers"'))==1) {
			if (AuthComponent::user('id')) $this->redirect('/dashboard');
			else $this->redirect('/login');
			exit;
		} else {
			
			$sql = 'CREATE TABLE IF NOT EXISTS `' .$prefix .'subscribers` (
			  `id` bigint(64) NOT NULL auto_increment,
			  `name` varchar(255) collate utf8_unicode_ci default NULL,
			  `email` varchar(255) collate utf8_unicode_ci default NULL,
			  `created` datetime NOT NULL,
			  `modified` datetime NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;';
			
			$db->query($sql);
			
			echo "Installation complete.";
			
			exit;
			
		}
		
	}
	
	
	
	
	public function index() {
		
		$data = NULL;
		
		if (!isset($this->request->data["Subscriber"]["q"])) {
			
			$this->Paginator->settings = array(
				'limit' => Configure::read('Psd.per_page'),
				'order' => array('Subscriber.name' => 'ASC' )
			);
			
			$data = $this->Paginator->paginate('Subscriber');
			
		} else {
		
			$this->Paginator->settings = array(
				'limit' => Configure::read('Psd.per_page'),
				'order' => array('Subscriber.name' => 'ASC' ),
				'conditions' => array("OR" => array(
					"Subscriber.name LIKE '%" .$this->request->data["Subscriber"]["q"] ."%'",
					"Subscriber.email LIKE '%" .$this->request->data["Subscriber"]["q"] ."%'"
				))
			);
			
			$data = $this->Paginator->paginate(
				'Subscriber',
				array("OR" => array(
					"Subscriber.name LIKE '%" .$this->request->data["Subscriber"]["q"] ."%'",
					"Subscriber.email LIKE '%" .$this->request->data["Subscriber"]["q"] ."%'"
				))
			);
			
		}
		
		$this->set('rows', $data);
		$this->set('count', $this->Subscriber->find('count'));
		
	}
	
	
	
	
	public function add() {
		
        if ($this->request->is('post')) {
			
            $this->Subscriber->create();
			
            if ($this->Subscriber->save($this->request->data)) {
				
				$this->Session->setFlash(
					__d('phpstardust', 'Subscriber has been saved.'), 'flash_success'
				);
				
                return $this->redirect(array('action' => 'index'));
				
            }
			else $this->Subscriber->validationErrors = $this->Psd->translateValidationMessages($this->Subscriber->validationErrors);
			
        }
		
    }
	
	
	
	
	public function edit($id = NULL) {
		
		if (!$id) {
			throw new NotFoundException(__d('phpstardust','Element not found.'));
		}
	
		$subscriber = $this->Subscriber->findById($id);
		
		if (!$subscriber) {
			throw new NotFoundException(__d('phpstardust','Element not found.'));
		}
	
		if ($this->request->is(array('post', 'put'))) {
			
			$this->Subscriber->id = $id;
			
			if ($this->Subscriber->save($this->request->data)) {
				 
				 $this->Session->setFlash(
					__d('phpstardust', 'Subscriber has been modified.'), 'flash_success'
				);
				
				return $this->redirect(array('action' => 'edit', $id));
				
			}
			else $this->Subscriber->validationErrors = $this->Psd->translateValidationMessages($this->Subscriber->validationErrors);
			
		}
	
		if (!$this->request->data) $this->request->data = $subscriber;
		
	}
	
	
	
	
	public function delete($id = NULL) {
		
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException(__d('phpstardust','Element not found.'));
		}
	
		if ($this->Subscriber->delete($id)) {
			
			$this->Session->setFlash(
				__d('phpstardust', 'Subscriber has been deleted.'), 'flash_success'
			);
			
			return $this->redirect(array('action' => 'index'));
		}
		
	}
	
	
	
	
	public function subscribeform() {
		
		$this->autoRender = false;
		
        if ($this->request->is('post') && $this->request->is('ajax')) {
			
			$data = array();
			
			$name = $this->request->data["name"];
			$email = $this->request->data["email"];
			
			if ($name!="") $data["name"] = $name;
			if ($email!="") $data["email"] = $email;
			
			$name = $this->cleanVars($name);
			$email = $this->cleanVars($email);
			
			$subscriber = $this->Subscriber->find('first', array(
				'conditions' => array('Subscriber.email' => $email)
			));
			
			if (isset($subscriber["Subscriber"])) echo "inlist";
			else {
				
				$name = filter_var($name, FILTER_SANITIZE_STRING);
				$email = filter_var($email, FILTER_VALIDATE_EMAIL);
				
				$this->Subscriber->create();
				$this->Subscriber->save($data);
			
				$Email = new CakeEmail();
				$Email->config('default');
				$Email->emailFormat('html');
				$Email->from(array(Configure::read('Psd.email') => Configure::read('Psd.name')));
				$Email->to($email);
				$Email->subject(Configure::read('Subscribers.subject'));
				$Email->send(Configure::read('Subscribers.message'));
				
				echo "ok";
			
			}
			
        }
		
    }
	
	
	
	
	public function cleanVars($data) {
		
		if (is_array($data)) {
			
		foreach ($data as $key => $var) {
			$data[$key] = $this->cleanVars($var);
		}
		} else {
			$data = strip_tags($data);
		}
		
		return $data;
	
	}
	
	
	
	
	public function beforeFilter() {
		
		$this->theme = Configure::read('Psd.themeBackend');
		
		$this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
    	$this->Cookie->httpOnly = true;
		
		$this->Auth->allow(Configure::read('publicPages'));
		
		if ($this->Psd->isOffline($this->params["action"])) exit(Configure::read('Psd.maintenanceMessage'));
		
		if (!$this->Psd->checkUserPermission($this->params["controller"], $this->params["action"])) 
		{
			
			$this->Session->setFlash(
				__d('phpstardust', 'Access denied!'), 'flash_warning'
			);
			
			$this->redirect(array(
				'plugin'=>'phpstardust',
				'controller'=>'pages',
				'action' => 'dashboard'
			));
		
		}
		
		$this->Psd->setTimezone();
		
		$this->Psd->setLanguage();
		
	}
	
	
	
	
}

?>