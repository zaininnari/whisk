<div class="settings form">
<?php echo $form->create('Setting');?>
	<fieldset>
 		<legend><?php __('Edit Setting');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('description');
		echo $form->input('type');
		echo $form->input('license');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete'), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Setting.id'))); ?></li>
	</ul>
</div>
