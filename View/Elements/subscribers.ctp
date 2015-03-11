<div class="panel panel-default">
  <div class="panel-heading" role="tab" id="headingFive">
	<h4 class="panel-title">
	  <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive"><i class="fa fa-envelope"></i> <?php echo __d('phpstardust', 'Subscribers'); ?></a>
	</h4>
  </div>
  <div id="collapseFive" class="panel-collapse collapse <?php if ($this->params['controller']=="subscribers") echo "in"; ?>" role="tabpanel" aria-labelledby="headingFive">
	<div class="panel-body">
	  <ul class="list-unstyled">
		  <li><i class="fa fa-list"></i> <?php 
	
		echo $this->Html->link(
			__d('phpstardust', 'List'),
			array('plugin' => 'subscribers', 'controller' => 'subscribers', 'action' => 'index')
		); 
		
		?></li>
		  <li><i class="fa fa-plus"></i> <?php 
	
		echo $this->Html->link(
			__d('phpstardust', 'Add'),
			array('plugin' => 'subscribers', 'controller' => 'subscribers', 'action' => 'add')
		); 
		
		?></li>
	  </ul>
	</div>
  </div>
</div>