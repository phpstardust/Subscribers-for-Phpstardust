<div class="panel panel-default">
	  <div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-plus"></i> <?php echo __d('phpstardust', 'Add'); ?></h3>
	  </div>
	  <div class="panel-body">
		
		<div class="row">
		
			<div class="col-lg-12">
			
            <?php echo $this->Form->create('Subscriber', array('role' => 'form')); ?>
			  <div class="form-group">
                <?php
                
				echo $this->Form->input('name',array(
					'autofocus'=>'autofocus',
					'placeholder' => 'Enter name',
					'class' => 'form-control',
					'error' => array('attributes' => array('wrap' => 'div','class' => 'alert alert-warning help-block'))
				));
				
				?>
			  </div>
			  <div class="form-group">
                <?php
                
				echo $this->Form->input('email',array(
					'placeholder' => 'Enter email',
					'class' => 'form-control',
					'error' => array('attributes' => array('wrap' => 'div','class' => 'alert alert-warning help-block'))
				));
				
				?>
			  </div>
              <?php
			  echo $this->Form->button('<i class="fa fa-check"></i> ' .__d('phpstardust', 'Save'),array(
					'type'=>'submit',
					'class'=>'btn btn-psd'
				));
			  ?>
            <?php echo $this->Form->end(); ?>
				
			</div>

		</div>

	  </div>

</div>