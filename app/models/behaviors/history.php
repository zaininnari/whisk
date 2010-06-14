<?php
class HistoryBehavior extends ModelBehavior
{

	var $__settings = array();

	function setup(&$Model, $settings = array())
	{
		$default = array('saveto' => 'ChangeLog');

		if (!isset($this->__settings[$Model->alias]))
		{
			$this->__settings[$Model->alias] = $default;
		}
//$logFields;
		$this->__settings[$Model->alias] = am($this->__settings[$Model->alias], ife(is_array($settings), $settings, array()));

	}

	function beforeSave(&$Model)
	{
		$id = $Model->id;
		$data = $Model->data;


		return true;
		/*$id = $Model->id;
		$new_value = $new_data = $Model->data;
		$old_value = array();
		$mode = "insert";
		if($id)
		{
			$mode = "update";
			$Model->recursive = -1;
			$old_value = $Model->find(
				'first',
				array('conditions' => array($Model->alias . "." . $Model->primaryKey => $id))
			);
		}
		$diff_array = array();
		if(is_array(@$old_value[$Model->alias]) && is_array(@$new_value[$Model->alias]))
		{
			$diff_array = array_diff_assoc(@$old_value[$Model->alias], @$new_value[$Model->alias]);
			$diff_keys = array_keys($diff_array);
		}
		else
		{
			$diff_keys = array_keys($new_value[$Model->alias]);
		}
		$reserved_keys = array('created', 'updated', 'modified');
		if(is_array(@$old_value[$Model->alias]))
		{
			foreach($old_value[$Model->alias] as $k => $v)
			{
				if($k != $Model->primaryKey && (!in_array($k, $diff_keys) || in_array($k, $reserved_keys)))
				{
					unset($old_value[$Model->alias][$k]);
				}
			}
		}
		if(is_array(@$new_value[$Model->alias]))
		{
			foreach($new_value[$Model->alias] as $k => $v)
			{
				if($k != $Model->primaryKey && (!in_array($k, $diff_keys) || in_array($k, $reserved_keys)))
				{
					unset($new_value[$Model->alias][$k]);
				}
			}
		}
		$change["mode"] = $mode;
		$change["name"] = $Model->alias;
		$change["old_value"] = serialize($old_value);
		$change["new_value"] = serialize($new_value);
		$result = $this->saveLog($Model, $change);

		$Model->data = $new_data;
		return $result;*/
	}

	function beforeDelete(&$Model)
	{
		/*$Model->recursive = -1;
		$old_value = $Model->find('first', array('conditions' => array($Model->alias . "." . $Model->primaryKey => $Model->id)));
		$new_value = array();
		$change["mode"] = "delete";
		$change["name"] = $Model->alias;
		$change["old_value"] = serialize($old_value);
		$change["new_value"] = serialize($new_value);
		return $this->saveLog($Model, $change);*/
		return true;
	}

	private function saveLog(&$Model, $change)
	{
		$m = $this->__settings[$Model->alias]["saveto"];
		$t = ClassRegistry::init($m);
		$t->create();
		return $t->save($change);
	}
}