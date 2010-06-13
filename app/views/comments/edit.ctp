<div class="comments form">
<?php echo $form->create('Comment');?>
	<fieldset>
 		<legend><?php __('Edit Comment');?></legend>
	<?php
		echo $form->input('body');
		echo $form->input('ticket_id', array('type' => 'hidden'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Comment.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Comment.id'))); ?></li>
		<li><?php echo $html->link(__('List Comments', true), array('action' => 'index'));?></li>
	</ul>
</div>
