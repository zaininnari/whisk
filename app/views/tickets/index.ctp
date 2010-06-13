<div class="tickets index">
<h2><?php __('Tickets');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th>state</th>
	<th><?php echo $paginator->sort('title');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
foreach ($tickets as $ticket):
$title = isset($ticket['Comment'][0]['body']) ? ' title="' . $ticket['Comment'][0]['body'] . '"' : '';
?>
	<tr<?php echo $title;?>>
		<td>
			<?php echo $ticket['Ticket']['id']; ?>
		</td>
		<td>
			<?php
			echo $html->tag(
				'span',
				isset($ticket['State']['name']) ? $ticket['State']['name'] : 'new',
				array(
					'style' => 'color: #' . $ticket['State']['hex'],
					'class' => $ticket['State']['type'] === '0' ? 'open' : 'close',
				)
			);
			?>
		</td>
		<td>
			<?php
			echo $html->link(
				$ticket['Ticket']['title'],
				array('action' => 'view', $ticket['Ticket']['id']),
				array('style' => 'text-decoration: ' . ($ticket['State']['type'] ? 'line-through' : 'none'))
			);
			?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $ticket['Ticket']['id'])); ?>
			<?php
			if ($session->check('Auth.User')) {
				echo $html->link(__('Edit', true), array('action' => 'edit', $ticket['Ticket']['id']));
				echo $html->link(__('Delete', true), array('action' => 'delete', $ticket['Ticket']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ticket['Ticket']['id']));
			}
			?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | <?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
