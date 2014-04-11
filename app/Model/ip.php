<?php
class Ip extends AppModel {
    public $useTable = "ips";
    public $primaryKey = "IpId";

    public function removeIp($addr) {
    	$ip = $this->find('all', array(
    		'conditions' => array(
    			'IpAddress' => $addr,
    			),
    		));
    	return $this->delete($ip[0]['Ip']['IpId']);
    }
}?>