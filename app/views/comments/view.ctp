<div class="comments view">
<h2><?php  __('Comment');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $comment['Comment']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Body'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $comment['Comment']['body']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ticket Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $comment['Comment']['ticket_id']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Comment', true), array('action' => 'edit', $comment['Comment']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Comment', true), array('action' => 'delete', $comment['Comment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $comment['Comment']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Comments', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Comment', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
