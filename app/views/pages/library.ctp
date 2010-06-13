<?php
$libraryLists = array(
	array(
		'libraryName' => 'CakePHP',
		'website' => 'http://cakephp.org/',
		'useVersion' => '1.3.x',
		'license' => array('MIT license', 'http://www.opensource.org/licenses/mit-license.php')
	),
	array(
		'libraryName' => 'jQuery',
		'website' => 'http://jquery.com/',
		'useVersion' => '1.4.x',
		'license' => array('the MIT License or the GNU General Public License (GPL) Version 2.','http://jquery.org/license')
	),
	array(
		'libraryName' => 'COLOR PICKER - JQUERY PLUGIN',
		'website' => 'http://www.eyecon.ro/colorpicker/',
		'useVersion' => '23.05.2009',
		'license' => array('Dual licensed under the MIT and GPL licenses.','http://www.eyecon.ro/colorpicker/')
	),
);
?>
<h3>Use library list</h3>
<?php
foreach ($libraryLists as $libraryList) {
	echo "<h4 class='libraryName'>{$html->link($libraryList['libraryName'], $libraryList['website'])}</h4>";
	echo '<dl>';
	echo "<dt>useVersion</dt><dd>{$libraryList['useVersion']}</dd>";
	echo "<dt>license</dt><dd>{$html->link($libraryList['license'][0], $libraryList['license'][1])}</dd>";
	echo '</dl>';
}