<div class="comments form">
<?php echo $form->create('Comment', array('url' => array('id' => $ticket_id))); ?>
	<fieldset>
 		<legend><?php __('Add Comment');?></legend>
	<?php
		echo $form->input('body');
		echo $form->select(
			'Ticket.state_id',
			$state,
			$comment['Ticket']['state_id'],
			array(), // attr
			false // show empty
			);
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Comments', true), array('action' => 'index'));?></li>
	</ul>
</div>
