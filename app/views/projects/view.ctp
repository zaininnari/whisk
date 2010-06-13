<div class="projects view">
<h2><?php  __('Project');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $projects['Project']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $projects['Project']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $projects['Project']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $projects['Project']['type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('License'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $projects['Project']['license']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($projects['User']['id'], array('controller' => 'users', 'action' => 'view', $projects['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Project', true), array('action' => 'edit', $projects['Project']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Project', true), array('action' => 'delete', $projects['Project']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $projects['Project']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Projects', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Project', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Tickets', true), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Ticket', true), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Tickets');?></h3>
	<?php if (!empty($projects['Ticket'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Body'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Project Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($projects['Ticket'] as $ticket):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $ticket['id'];?></td>
			<td><?php echo $ticket['title'];?></td>
			<td><?php echo $ticket['body'];?></td>
			<td><?php echo $ticket['user_id'];?></td>
			<td><?php echo $ticket['project_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'tickets', 'action' => 'view', $ticket['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'tickets', 'action' => 'edit', $ticket['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'tickets', 'action' => 'delete', $ticket['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ticket['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Ticket', true), array('controller' => 'tickets', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
