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
		</div>
		<div id="content">
			<div id="main">
				<?php $session->flash(); ?>
				<?php echo $content_for_layout; ?>
			</div>
			<div id="side">
				<div class="actions">
					<ul>
						<li><?php echo $html->link(__('List Project', true), array('controller' => 'projects')); ?></li>
						<li><?php echo $html->link(__('New Project', true), array('controller' => 'projects', 'action' => 'add')); ?></li>
						<li><?php echo $html->link(__('List Users', true), array('controller' => 'users')); ?> </li>
						<li><?php echo $html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
					</ul>
				</div>
			</div>

		</div>
		<div id="footer">
			<?php
				echo $html->link(
					$html->image('cake.power.gif', array('alt'=> __("CakePHP: the rapid development php framework", true), 'border'=>"0")),
					'http://www.cakephp.org/',
					array(
						'target'=>'_blank',
						'escape' => false
					)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>