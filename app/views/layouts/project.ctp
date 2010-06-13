<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php __('CakePHP: the rapid development php framework:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $html->meta('icon');

		echo $html->css(array('base', 'layout'));

		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $html->link(__('CakePHP', true), '/'); ?></h1>
			<?php
			if ($session->check('Auth.User')) {
				echo $html->link(
					__('logout', true),
					array(
						'base' => '',
						'controller' => 'users',
						'action' => 'logout'
					),
					array('style' => 'color:#FFF')
				);
			} else {
				echo $html->link(
					__('login', true),
					array(
						'base' => '',
						'controller' => 'users',
						'action' => 'logout'
					),
					array('style' => 'color:#FFF')
				);
			}

			?>
		</div>

		<?php echo $this->element('mainMenu'); ?>
		<div id="content">
			<div id="main">
				<?php $session->flash(); ?>
				<?php echo $content_for_layout; ?>
			</div>
			<div id="side">
				<?php
				echo $html->image('icon/32x32/icon-19.png', array('alt'=> __('Create new ticket', true), 'border'=>"0"));
				echo $html->link(__('Create new ticket', true), array(
					'controller' => 'tickets',
					'action' => 'add'
				));
				?>
			</div>

		</div>
		<div id="footer">
			<?php echo $html->link(
					$html->image('cake.power.gif', array('alt'=> __("CakePHP: the rapid development php framework", true), 'border'=>"0")),
					'http://www.cakephp.org/',
					array('target'=>'_blank'), null, false
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>