<div class="tickets form">
<?php echo $form->create('Ticket');?>
	<fieldset>
		<legend><?php __('Edit Ticket');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('title');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Ticket.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Ticket.id'))); ?></li>
		<li><?php echo $html->link(__('List Tickets', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Comments', true), array('controller' => 'comments', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Comment', true), array('controller' => 'comments', 'action' => 'add')); ?> </li>
	</ul>
</div>
