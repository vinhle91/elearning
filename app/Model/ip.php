<?php
class Ip extends AppModel {
    public $useTable = "ips";
    public $primaryKey = "IpId";
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'UserId',
            'fields' => array(
                'User.Username',
            )
        ),
    );

    public function removeIp($addr) {
    	$ip = $this->find('all', array(
    		'conditions' => array(
    			'Ip.IpAddress' => $addr,
    			),
    		));
    	return $this->delete($ip[0]['Ip']['IpId']);
    }
}?>