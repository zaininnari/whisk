<div class="projects form">
<?php echo $form->create('Project');?>
	<fieldset>
 		<legend><?php __('Add Project');?></legend>
	<?php
		echo $form->input('name', array('type' => 'text'));
		echo $form->input('description');
		echo $form->input('type');
		echo $form->input('license');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Projects', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Tickets', true), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Ticket', true), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
	</ul>
</div>
