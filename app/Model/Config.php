<?php 
class Config extends AppModel {
	public $useTable = 'configs';

	public function getConfig($param){
		$buff = $this->find("all", array(
			"conditions" => array(
				"ConfigName" => $param,
				),
			'fields' => 'ConfigValue'
			));
		$ret = isset($buff[0]['Config']['ConfigValue']) ? $buff[0]['Config']['ConfigValue'] : null;
		return $ret;
	}
}
?>