<div class="tickets view">
<h2><?php  __('Ticket');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ticket['Ticket']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ticket['Ticket']['title']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="related">
	<h3><?php __('Related Comments');?></h3>
	<?php if (!empty($ticket['Comment'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Body'); ?></th>
		<th><?php __('Ticket Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($ticket['Comment'] as $comment):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $comment['id'];?></td>
			<td><?php echo $html->wiki($comment['body']);?></td>
			<td><?php echo $comment['ticket_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'comments', 'action' => 'view', $comment['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'comments', 'action' => 'edit', $comment['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'comments', 'action' => 'delete', $comment['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $comment['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>


<div class="comments form">
<?php echo $form->create('Comment', array('url' => array('id' => $id)));?>
	<fieldset>
 		<legend><?php __('Add Comment');?></legend>
	<?php
		echo $form->input('body');
		echo $form->select(
			'Ticket.state_id',
			$state,
			$ticket['Ticket']['state_id'],
			array(), // attr
			false // show empty
			);
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>


<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Ticket', true), array('action' => 'edit', $ticket['Ticket']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Ticket', true), array('action' => 'delete', $ticket['Ticket']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ticket['Ticket']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Tickets', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Ticket', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Comments', true), array('controller' => 'comments', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Comment', true), array('controller' => 'comments', 'action' => 'add')); ?> </li>
	</ul>
</div>

