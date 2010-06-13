<div class="projects index">
<h2><?php __('Projects');?></h2>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th><?php echo $paginator->sort('type');?></th>
	<th><?php echo $paginator->sort('license');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($projects as $project):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php
			echo $html->link(
				$project['Project']['name'],
				//array('controller' => '', 'project' => $project['Project']['name'])
				'/' . WHISK_PROJECT_URL . '/' . $project['Project']['name']
			);
			?>
		</td>
		<td>
			<?php echo $project['Project']['description']; ?>
		</td>
		<td>
			<?php echo $project['Project']['type']; ?>
		</td>
		<td>
			<?php echo $project['Project']['license']; ?>
		</td>
		<td>
			<?php echo $project['Project']['created']; ?>
		</td>
		<td>
			<?php echo $project['Project']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $project['Project']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $project['Project']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $project['Project']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Project', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Tickets', true), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Ticket', true), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
	</ul>
</div>
