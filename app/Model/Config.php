<?php

class Config extends AppModel {

    public $useTable = 'configs';
    //cac config va id config tuong ung trong csdl
    public $configName = array(
        'session' => 1,
        'backup' => 2,
        'fail_login' => 3,
        'log' => 4,
        'lesson_fee' => 5,
        'study_limit' => 6,
        'sharing_rate' => 7
    );

    public function getConfig($param) {
        $buff = $this->find("all", array(
            "conditions" => array(
                "ConfigName" => $param,
            ),
            'fields' => 'ConfigValue'
        ));
        $ret = isset($buff[0]['Config']['ConfigValue']) ? $buff[0]['Config']['ConfigValue'] : null;
        return $ret;
    }

    public function getSharingRateConfig() {
        $rate = $this->find('first', array(
            'conditions' => array(
                'ConfigId =' => $this->configName['sharing_rate']
            ),
            'fields' => 'ConfigValue'
        ));
        return $rate['Config']['ConfigValue'];
    }
    
    public function getLessonFee() {
        $rate = $this->find('first', array(
            'conditions' => array(
                'ConfigId =' => $this->configName['lesson_fee']
            ),
            'fields' => 'ConfigValue'
        ));
        return $rate['Config']['ConfigValue'];
    }

}

?>