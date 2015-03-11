<?php

App::uses('AppHelper', 'View/Helper');

class SubscriberHelper extends AppHelper {
	
	public $components = array('Session','Cookie','RequestHandler');
	
	public $helpers = array('Html', 'Form', 'Session');
	
	
	
	
	public function renderform() {
		
		$url = Configure::read('Psd.url') .'/subscribers/subscribers/subscribeform';
		
		if (Configure::read('Subscribers.includeJquery')) 
		echo $this->Html->script('/subscribers/js/jquery.js') ."\r\n";
		
		?>
        <script type="text/javascript">
		
		$(document).keypress(function(e) {
			
			if (e.which == 13) {
				sendSubscribers();
			}

		});
		
		function isValidEmail(email) {
		if (email.search(/^\w+((-\w+)|(\.\w+))*\@\w+((\.|-)\w+)*\.\w+$/) != -1)
		return true;
		else
		return false;
		}

		function sendSubscribers() {
			
			$('#emailHelp').hide();
			$('#subscribeSuccess').hide();
			$('#inlist').hide();
			
			var goSubmit = true;
			var name = $('#name').val();
			var email = $('#email').val();
			
			if (email=="") {
				goSubmit = false;
				$('#emailHelp').fadeIn(400);
			}
			
			if (!isValidEmail(email)) {
				goSubmit = false;
				$('#emailHelp').fadeIn(400);
			}
			
			if (goSubmit) {
				
				$('#name').attr('disabled', 'disabled');
				$('#email').attr('disabled', 'disabled');
				
				$.ajax({
				type: "POST",
				url: "<?php echo $url; ?>",
				data: { name: name, email: email }
				})
				.done(function( response ) {
					$('#name').attr('disabled', false);
					$('#name').val('');
					$('#email').attr('disabled', false);
					$('#email').val('');
					if (response=="ok") {
						$('#subscribeSuccess').fadeIn(400);	
					}
					if (response=="inlist") {
						$('#inlist').fadeIn(400);
					}
				});
				
			}
			
		}
		
		</script>
        <?php
		
		echo '<div class="row">';
		echo '<div class="col-lg-12">';
		echo '<div class="form-group">';
		echo $this->Form->input('name',array(
			'autofocus'=>'autofocus',
			'id'=>'name',
			'placeholder' => 'Enter name',
			'class' => 'form-control'
		));
		echo '</div>';
		echo '<div class="form-group">';
		echo $this->Form->input('email',array(
			'id'=>'email',
			'placeholder' => 'Enter email',
			'class' => 'form-control'
		));
		echo '</div>';
		echo '<div class="form-group">';
		echo '<div id="emailHelp" class="alert alert-warning" style="display:none">Insert a valid email.</div>';
		echo '<div id="subscribeSuccess" class="alert alert-success" style="display:none">Subscription completed.</div>';
		echo '<div id="inlist" class="alert alert-success" style="display:none">You are in list.</div>';
		echo $this->Form->button('Subscribe',array(
			'type'=>'button',
			'onclick'=>'javascript:sendSubscribers();',
			'class'=>'btn btn-default'
		));
		echo '</div>';
		echo '</div>';
		echo '</div>';
		
	}
	
	
	
	
}

?>