<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
		<legend><?php __('Add User');?></legend>
	<?php
		echo $form->input('username');
		echo $form->input('password', array('type' => 'password', 'div' => 'input password required'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<?php
echo $html->div('error', $form->error('Param::password_len','パスワードは4～8文字の範囲で入力して下さい。'));
echo $form->error('Param::password_len','パスワードは4～8文字の範囲で入力して下さい。');
echo $form->error('Param::password','パスワードは半角の英数字で入力して下さい。');

?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Users', true), array('action' => 'index'));?></li>
	</ul>
</div>
