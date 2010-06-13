<div class="tickets form">
<?php echo $form->create('Ticket');?>
	<fieldset>
 		<legend><?php __('Add Ticket');?></legend>
	<?php
		echo $form->input('title');
		echo $form->input('Comment.body');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Tickets', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Comments', true), array('controller' => 'comments', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Comment', true), array('controller' => 'comments', 'action' => 'add')); ?> </li>
	</ul>
</div>
