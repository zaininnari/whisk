<div class="states form">
<?php echo $form->create('State');?>
	<fieldset>
		<legend><?php __('Add State');?></legend>
	<?php
		echo $form->input('name', array('after' => 'Within 20 characters'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List States', true), array('action' => 'index'));?></li>
	</ul>
</div>
