<div id="gMenu" style="background-color:#FFF">
<?php
$links = array(
	'home'    => array(),//array('controller' => null),
	'tickets' => array('controller' => 'tickets'),
	'states'  => array('controller' => 'states'),
);
/*$links = array(
	'home'    => '/',
	'tickets' => '/tickets',
	'states'  => '/states',
);*/
foreach ($links as $title => $url) {
	echo $html->link($title, $url);
	echo ' ';
}

?>
</div>