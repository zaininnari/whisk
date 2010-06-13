<div class="states index">
<h2><?php __('States');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<?php
$i = 0;
$jsId = $jsColorPicker = $jsTypeArr = $jsIdArr = array();
$jsType = '';
foreach ($states as $state):
?>
	<tr style="width:100%">
		<td class="sortable" style="width:40px;">
			<?php
			echo $html->tag(
				'span',
				'#',
				array(
					'id' => $jsIdArr[] = 'StateId' . $state['State']['id'],
					'class' => 'ui-icon ui-icon-arrowthick-2-n-s',
					'style' => 'display:block;margin-left: auto; margin-right: auto;'
				)
			);
			?>
		</td>
		<td>
			<?php
			echo $html->tag(
				'span',
				$state['State']['name'],
				array(
					'id' => $jsId[] = 'StateName' . $state['State']['id'],
					'class' => $state['State']['type'] ? 'close' : 'open',
					'style' => 'color:#'. $state['State']['hex'] . ';display:block;'
				)
			);
			?>
		</td>
		<td>
			<?php
			echo $html->tag(
				'span',
				$state['State']['hex'],
				array(
					'id' => $jsId[] = $jsColorPicker[] = 'StateHex' . $state['State']['id'],
					'style' => 'color:#'. $state['State']['hex']
				)
			);
			?>
		</td>
		<td>
			<?php
			$jsType = 'StateType';
			echo $html->tag(
				'span',
				'Open',
				array(
					'id' => $jsId[] = $jsTypeArr[] = $jsType . $state['State']['id'] . 'Open',
					'class' => $state['State']['type'] === '1' ? 'ac' : 'nonac'
				)
			);
			?>
			<?php
			echo $html->tag(
				'span',
				'Close',
				array(
					'id' => $jsTypeArr[] = $jsType . $state['State']['id'] . 'Close',
					'class' => $state['State']['type'] === '0' ? 'ac' : 'nonac'
				)
			);
			?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $state['State']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $state['State']['id'])); ?>
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
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New State', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<?php
$_base = '/' . JS_URL;
//
$html->css(
	array(
		$_base . 'jquery/plugin/colorPicker/css/colorpicker',
		$_base . 'jquery/themes/base/jquery.ui.all'
	),
	null,
	array(),
	false // inline
);
$javascript->link(
	array( // path
		'jquery.min',

		$_base . 'jqueryPlugin/editInPlace/js/editInPlace',
		$_base . 'jquery/jquery.ui.core.min',
		$_base . 'jquery/jquery.effects.core.min',
		$_base . 'jquery/jquery.effects.highlight.min',
		$_base . 'jquery/jquery.ui.core.min',
		$_base . 'jquery/jquery.ui.widget.min',
		$_base . 'jquery/jquery.ui.mouse.min',
		$_base . 'jquery/jquery.ui.sortable.min',

		$_base . 'jquery/plugin/colorPicker/js/colorpicker',
		$_base . 'jquery/plugin/editInPlace/js/editInPlace',
	),
	false // inline
);

$editable = array('name', 'hex');
foreach ($editable as &$v) $v = '\''.$v.'\'';
foreach ($jsColorPicker as &$v) $v = '\''.$v.'\'';
foreach ($jsTypeArr as &$v) $v = '\''.$v.'\'';
foreach ($jsIdArr as &$v) $v = '\''.$v.'\'';
foreach ($jsId as &$v) $v = '#'.$v;
unset($v);

$js = "
$(function(){
	var selector = '".join(',', $jsId)."';
	var editable = [".join(',', $editable)."];
	var typeArr = [".join(',', $jsTypeArr)."];
	var idArr = [".join(',', $jsIdArr)."];
	var type = '{$jsType}';
	var defaultStyle;
	var ucfirst = function(str) {
		return str.substr(0,1).toUpperCase() + str.substr(1, str.length);
	};
	var createId = function(str, match) {
		return '#'+match[1]+ucfirst(str)+match[3];
	};

	$(selector).parent().mouseover(function(){
		if(!defaultStyle) {
			defaultStyle = $(this).css('outline') ? $(this).css('outline') : 'none';
		}
		$(this).css('outline', '1px solid #FFCC99');
	});
	$(selector).parent().mouseout(function(){
		$(this).css('outline', defaultStyle);
	});
	$(selector).click(function(){
		var match = $(this).attr('id').match(/^([A-Z][a-z]*)([A-Z][a-z]*)(\d+)/);
		var editElm = editable.indexOf(match[2].toLowerCase());
		if (!$(this).hasClass('on')
			&& match.length === 4
			&& editElm !== -1
		) {
			$(this).addClass('on');
			var id = '#' + $(this).attr('id');
			var data = {
				name : $(createId('name', match)).text(),
				hex  : $(createId('hex', match)).text(),
				type : $(createId('type', match)+'Open').hasClass('ac') ? 1 : 0
			};
			var txt = $(this).text();
			var _this = this;
			$(this).text('').append('<input id=\'colorPicker-' + match[0] + '\' type=\"text\" value=\"'+txt+'\" style=\"width:auto;display:inline;\" />');

			var event = function(){
				var inputVal = $(this).val();
				if (inputVal === '') {
					inputVal = this.defaultValue;
				} else if (inputVal != this.defaultValue) {
					data[editable[editElm]] = inputVal;
					$.ajax(
						{
							url :'/p/whisk/states/ajax_edit/' + match[3],
							type : 'POST',
							dataType : 'json',
							data: data,
							success : function(data, textStatus, XMLHttpRequest) {
								var insertClass = 'class-' + match[0];
								$('.' + insertClass).remove();
								$(id).parent().append('<p class=\'' + insertClass + '\'>'+ data.message +'</p>');
								$('.' + insertClass).fadeIn(1500).delay(2000).fadeOut(1000);
							},
							complete : function(XMLHttpRequest, textStatus) {}
						}
					);
				}
				$(this).parent().removeClass('on').text(inputVal);
			};

			/*
			 * color picker
			 */
			var targetArr = [".join(',', $jsColorPicker)."];
			var colorPicker = function() {
				if (targetArr.indexOf(match[0]) !== -1) {
					var target = '#colorPicker-' + match[0];
					var fontSize = $(target).css('font-size');
					$(target).css('color', '#' + $(target).val());
					$(target).ColorPicker({

						onSubmit: function(hsb, hex, rgb, el) {
							$(id + ' > input').val(hex);
							$(id).css('color', '#' + $(id + ' > input').val());
							$(id + ' > input').triggerHandler('event');
							$('.colorpicker').hide();
						},
						onChange: function(hsb, hex, rgb) {
							$(target).val(hex);
							$('#'+ match[1]+'Name'+ match[3]).css('color', '#' + $(id + ' > input').val());
							$(target).css('color', '#' + hex);
						},
						onBeforeShow: function () {
							$(this).ColorPickerSetColor(this.value);
							$(target).css('color', '#' + $(id + ' > input').val());
						},

						onHide: function (colpkr) {
							if ($(id + ' > input').val()) {
								$(id).css('color', '#' + $(id + ' > input').val());
								$(id + ' > input').triggerHandler('event');
							}
							$('.colorpicker').hide();
							return false;
						}
					}).bind('keyup', function(){
						$(this).ColorPickerSetColor(this.value);
					});
				}
			}

			if (targetArr.indexOf(match[0]) !== -1) {
				$(id + ' > input').focus(colorPicker);
				$(id + ' > input').bind('event', event);
			} else {
				$(id + ' > input').focus().blur(event);
			}

			$(id + ' > input').keypress(function (e) {
				if (e.keyCode == 13) { // enter
					$(id + ' > input').trigger('blur');
				}
			});
		};
	});

	/*
	 * edit open/close
	 */

	var typeArrSelc = [];
	for(var i=0;i<typeArr.length;i++) {
		typeArrSelc[i] = '#' + typeArr[i];
	}

	$(typeArrSelc.join(',')).click(function(){
		// {{{ Init
		var ac = 'ac',
			nonac = 'nonac',
			open = 'Open',
			close = 'Close',
			nameClassOpen = 'open',
			nameClassClose = 'close',
			colName = 'name',
			colHex = 'hex',
			match = $(this).attr('id').match(
				new RegExp('^([A-Z][a-z]*)([A-Z][a-z]*)(\\\d+)(' + open + '|' + close + ')$')
			),
			defaultData = {
				name : $(createId(colName, match)).text(),
				hex  : $(createId(colHex, match)).text()
			},
			_this = this;
		// }}}
		if ($(this).hasClass(ac) && match.length === 5) {
			$.ajax({
				url :'/p/whisk/states/ajax_edit/' + match[3],
				type : 'POST',
				dataType : 'json',
				data: $.extend({}, defaultData, {type: match[4] === open ? '0' : '1'}),
				success : function(data, textStatus, XMLHttpRequest) {
					if (data.error === false) {
						$(_this).removeClass(ac).addClass(nonac);
						$('#'+match[1]+match[2]+match[3]+(match[4]===open?close:open)).removeClass(nonac).addClass(ac);
						if (match[4] === open) {
							$(createId(colName, match)).removeClass(nameClassClose).addClass(nameClassOpen);
						} else {
							$(createId(colName, match)).removeClass(nameClassOpen).addClass(nameClassClose);
						}
					}
				},
				complete : function(XMLHttpRequest, textStatus) {}
			});
		}
	});


	var idArrSelc = [];
	for(var i=0;i<idArr.length;i++) {
		idArrSelc[i] = '#' + idArr[i];
	}

	$('.states tbody').sortable({
		axis: 'y',
		cursor: 'move',

		stop : function(){
			var html = [];
			$(idArrSelc.join(',')).each(function(i,v){
				var match = $(this).attr('id').match(
					new RegExp('^([A-Z][a-z]*)([A-Z][a-z]*)(\\\d+)$')
				);
				html.push(match[3]);
			});
			$.ajax({
				url :'/p/whisk/states/ajax_sort',
				type : 'POST',
				dataType : 'json',
				data: {sort : html.join(',')},
				success : function(data, textStatus, XMLHttpRequest) {},
				complete : function(XMLHttpRequest, textStatus) {}
			});
		},
		update : function(){}
	}).disableSelection();

});
";
$javascript->codeBlock($js, array('inline' => false));
$javascript->blockEnd();
