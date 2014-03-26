<?php

/*
 * To use ELog,
 * 1. config in app/config/bootstrap.php
 * example: 
 *   CakeLog::config('operation', array( // name the config
 *   'engine' => 'ELog', // don't change this
 *   'types' => array('operation'), // specify log type
 *   'file' => "operation", // log file name 
 *   'path' => "opr", //folder name to store log file
 *   ));
 * 
 * 2. write log in code
 *  just add some code
 *  CakeLog::write($type, $message); //$type: log type
 */
App::uses('CakeLogInterface', 'Log');
App::uses('Folder', 'Utility');
App::uses('CakeTime', 'Utility');

Class ELog implements CakeLogInterface {

    /**
     * Engine config
     *
     * @var array
     */
    protected $_config = array();

    /**
     * Path to save log files on.
     *
     * @var string
     */
    protected $_path = null;

    /**
     * Path to save log files on.
     *
     * @var string
     */
    protected $_file = null;

    /**
     * __construct method
     *
     * @return void
     */
    public function __construct($config = array()) {
        $this->config($config);
    }

    public function config($config = array()) {
        if (!empty($config)) {
            if (isset($config['types']) && is_string($config['types'])) {
                $config['types'] = array($config['types']);
            }
            if (isset($config['path']) && is_string($config['path'])) {
                $config['path'] = LOGS . $config['path'] . DS;
                $this->_path = $config['path'];
            }
            if (isset($config['file']) && is_string($config['file'])) {
                $this->_file = $config['file'];
                if (!preg_match('/\.log$/', $this->_file)) {
                    $this->_file .= '.log';
                }
            }
            $this->_config = $config;
        }
        return $this->_config;
    }

    /**
     * Implements writing to log files.
     *
     * @param string $type The type of log you are making.
     * @param string $message The message you want to log.
     * @return boolean success of write.
     */
    public function write($type, $message) {
        $types = $this->_config['types'];
        if (in_array($type, $types) && !empty($this->_path)) {
            new Folder($this->_path, true);
            $filename = $this->_path . $this->_file;
            $output = date('Y-m-d H:i:s') . ' ' . ucfirst($type) . ': ' . $message . "\n";
            if ($this->needRewrite($filename)) {
                file_put_contents($filename, $output);
            } else {
                file_put_contents($filename, $output, FILE_APPEND);
            }
        }
    }

    public function needRewrite($filename) {
        $result = true;
        if (file_exists($filename)) {
            $lastTime = filemtime($filename);
            if (CakeTime::wasWithinLast("12 months", $lastTime)) {
                $result = false;
            }
        }
        return $result;
    }

}
