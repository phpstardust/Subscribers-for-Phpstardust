<div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title"><i class="fa fa-envelope"></i> <?php echo __d('phpstardust', 'Subscribers'); ?> <span class="badge"><?php echo $count; ?></span></h3>
	</div>
	<div class="panel-body">
	  
	  <div class="row">
	  
		  <div class="col-lg-6">
			  <?php 
			  echo $this->Html->link(
				  '<i class="fa fa-plus"></i> ' .__d('phpstardust', 'Add'),
				  array('plugin' => 'subscribers', 'controller' => 'subscribers', 'action' => 'add'),
				  array('class'=>'btn btn-psd', 'escape' => false)
			  ); 
			  ?>
		  </div>
		  
		  <div class="col-lg-6">
			  <?php echo $this->Form->create('Subscriber', array('action' => 'index', 'class' => 'navbar-form searchform', 'role' => 'search')); ?>
			  <div class="input-group searchbox">
                  <?php
                  echo $this->Form->input('q',array(
						'type'=>'text',
						'autofocus'=>'autofocus',
						'label'=>false,
						'div'=>false,
						'class' => 'form-control',
						'placeholder' => 'Search'
					));
					?>
				  <div class="input-group-btn">
                      <?php
					  echo $this->Form->button('<i class="fa fa-search"></i> ' .__d('phpstardust', 'Search'),array(
							'type'=>'submit',
							'class' => 'btn btn-psd'
						));
						?>
				  </div>
			  </div>
              <?php echo $this->Form->end(); ?>
		  </div>
		  
	  </div>
	  
	  <div class="row">
	  
		  <div class="col-lg-12">
		  
			  <table class="table table-responsive hidden-xs">
				<caption></caption>
				<thead>
				  <tr>
					<th>#</th>
					<th><?php echo __d('phpstardust', 'Name'); ?></th>
					<th><?php echo __d('phpstardust', 'Email'); ?></th>
                    <th><?php echo __d('phpstardust', 'Created'); ?></th>
					<th><?php echo __d('phpstardust', 'Actions'); ?></th>
				  </tr>
				</thead>
				<tbody>
                  <?php foreach ($rows as $row): ?>
				  <tr>
					<td><?php echo $row['Subscriber']['id']; ?></td>
					<td><?php echo $row['Subscriber']['name']; ?></td>
					<td><?php echo $row['Subscriber']['email']; ?></td>
                    <td><?php echo $this->Time->format('Y/m/d H:i:s' , $row['Subscriber']['created']); ?></td>
                    <td>
                      <?php 
					  echo $this->Html->link(
						  '<i class="fa fa-pencil"></i> ' .__d('phpstardust', 'Edit'),
						  array('action' => 'edit', $row['Subscriber']['id']),
						  array('class'=>'btn btn-psd', 'escape' => false)
					  ); 
					  ?>
                      <?php
							echo $this->Form->postLink(
								'<i class="fa fa-remove"></i> ' .__d('phpstardust', 'Delete'),
								array('action' => 'delete', $row['Subscriber']['id']),
								array('class'=>'btn btn-psd', 'escape' => false, 'confirm' => __d('phpstardust', 'Are you sure?'))
							);
						?>
					</td>
				  </tr>
                  <?php endforeach; ?>
				</tbody>
			  </table>
			  
			  <ul class="list-group visible-xs-block mobiletable">
              	<?php foreach ($rows as $row): ?>
				<li class="list-group-item">
				  <p><strong><?php echo $row['Subscriber']['name']; ?></strong></p>
				  <div class="btn-group btn-group-justified" role="group">
					<?php 
					  echo $this->Html->link(
						  '<i class="fa fa-pencil"></i> ' .__d('phpstardust', 'Edit'),
						  array('action' => 'edit', $row['Subscriber']['id']),
						  array('class'=>'btn btn-psd', 'escape' => false)
					  ); 
					  ?>
                      <?php
							echo $this->Form->postLink(
								'<i class="fa fa-remove"></i> ' .__d('phpstardust', 'Delete'),
								array('action' => 'delete', $row['Subscriber']['id']),
								array('class'=>'btn btn-danger', 'escape' => false, 'confirm' => __d('phpstardust', 'Are you sure?'))
							);
						?>
				  </div>
				</li>
                <?php endforeach; ?>
    			<?php unset($row); ?>
			  </ul>
		  
		  </div>
	  
	  </div>
	  
	</div>
	
	<div class="panel-footer">
	  <?php echo $this->element('pagination'); ?>
    </div>

</div>