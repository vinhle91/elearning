<?php
/**
*@copyright Copyright (c) 2013 mrhieusd
*/
App::uses('AppController', 'Controller');
class MessageController extends AppController {
    function beforeFilter() {
        $this->pageTitle = 'Message';
        $this->layout = 'report';
        return parent::beforeFilter();
    }

    public function index(){
        $this->redirect(array('action' => 'error'));
    }

    public function error() {

    }  

}	
?>