<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller','File','Utility');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array('Auth', 'Session', 'RequestHandler','Readtsv');
	public $uses = array('User','Category','Test','Question','Answer','Comment');
	public function beforeFilter() {
		$this->disableCache();
		$this->Auth->authenticate = array(
			'Form' => array(
				'userModel' => 'User',
				'fields' => array('username' => 'Username', 'password' => 'Password'),
				'scope' => array('Status' => 1),
			)
		);
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Auth->loginError = 'ユーザー名又はパスワードが間違った。';
		$this->Auth->authError = 'このページを表示するために、ログインしてください。';
		$this->set('categories', $this->Category->getCategories());
        $this->set('userType', $this->Auth->user('UserType'));

	}
	function _loggedIn(){
		$logged_in = FALSE;
		if($this->Auth->user()){
			if( $this->Auth->user('nv_del_flg') == 0){
				$logged_in = TRUE;
			}			
		}
		return $logged_in;
	}
 
	//Lay gia tri username hien tai
	function _usersUsername(){
		$users_username=NULL;
		if($this->Auth->user()){
			// debug($this->Auth->user());
			$users_username['FullName'] = $this->Auth->user('FullName');
			$users_username['UserId'] = $this->Auth->user('UserId');
            $users_username['Username'] = $this->Auth->user('Username');
		}
		return $users_username;
	}
	function _usersType(){
		$UserType = NULL;
		if($this->Auth->user()){	      	
			$UserType = $this->Auth->user('UserType');
		};
		return $UserType;
	}
	function beforeRender() {
        $this->set('pageTitle', $this->pageTitle);
        $this->set('logged_in',$this->_loggedIn());
     	$this->set('users_username',$this->_usersUsername());
     	$this->set('user_type',$this->_usersType());
    }
}