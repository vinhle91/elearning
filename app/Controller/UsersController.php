<?php
/**
*@copyright Copyright (c) 2013 mrhieusd
*/
App::uses('AuthComponent', 'Controller/Component');
class UsersController extends AppController {
	/**
	* index
	*/
	function beforeFilter() {
        $this->pageTitle = 'Home';
        $this->layout = 'template';
        $this->Auth->allow(array('index','sign_up'));
        return parent::beforeFilter();
    }
	public function index() {
        if($this->Auth->user()){            
            $UserType = $this->Auth->user('UserType');
            if($UserType == 1){
                $this->redirect(array('controller'=>'Student','action' => 'index'));
            }
            if($UserType == 2){
                $this->redirect(array('controller'=>'Teacher','action' => 'index'));
            }
			if($UserType == 3){
                $this->redirect(array('controller'=>'admin','action' => 'home'));
            }
        };
	}
	public function login() {
		$this->layout = 'default';
		//if already logged-in, redirect
        if($this->Session->check('Auth.User')){
            $this->redirect(array('action' => 'index'));      
        }        
        // if we get the post information, try to authenticate
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if(!empty($data['User']['Username']) && !empty($data['User']['Password']) )
            {
                if ($this->Auth->login()) {
                    $UserType = NULL;
                    if($this->Auth->user()){            
                        $UserType = $this->Auth->user('UserType');
                        if($UserType == 1){
                            $this->redirect(array('controller'=>'Student','action' => 'index'));
                        }
                        if($UserType == 2){
                            $this->redirect(array('controller'=>'Teacher','action' => 'index'));
                        }
                    };
                } else {
                    $this->Session->setFlash($this->Auth->loginError);
                }
            }else{
                $this->Session->setFlash(__('Username or Password not empty'));
            }
        } 
	}
	public function sign_up() {
        $this->pageTitle = 'Sign up';
       if ($this->request->is('post')) {
            $data= $this->request->data;
            if($data['User']['TermsOfService'] == 1){
                $this->User->create();
                $birthday = $data['User']['Birthday']['year'].'-'.$data['User']['Birthday']['month'].'-'.$data['User']['Birthday']['day'];
                $data['User']['Birthday'] = $birthday;
                $data['User']['InitialPassword'] =  $data['User']['Password'];
                $data['User']['InitialCodeQuestion'] =  $data['User']['VerifyCodeQuestion'];
                $data['User']['InitialCodeAnswer'] =  $data['User']['VerifyCodeAnswer'];
                // debug($data);
                if ($this->User->save($data)) {
                    $this->Session->setFlash(__('ユーザが登録されました'));
                    $this->redirect(array('action' => 'login'));
                } else {
                    $this->Session->setFlash(__('The user could not be created. Please, try again.'));
                }   
            }else{
                $this->Session->setFlash(__('Please confirm terms of service'));
            }           
            
        }
		
	}
    public function view_profile($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__("無効リクエスト"));
        } else {
            $userInfo = $this->Auth->user();
            $profileInfo = array();
            $profileInfo['FullName'] = $userInfo['FullName'];
            $profileInfo['Birthday'] = $userInfo['Birthday'];
            $profileInfo['Gender'] = ($userInfo['Gender'] == 1 ? "Male" : "Female");
            $profileInfo['Phone'] = $userInfo['Phone'];
            $profileInfo['Email'] = $userInfo['Email'];
            $profileInfo['Address'] = $userInfo['Address'];
            $profileInfo['CreditCard'] = $userInfo['CreditCard'];
            $this->set('profileInfo', $profileInfo);
            $this->pageTitle = 'View Profile';
        }
    }

    public function update_security($id = null)
    {
        //ユーザIdをデータベースから取り出す
        $id = $this->Auth->user();
        //ユーザIdは存在かどうかチェック
        if ($id == null) {
            throw new NotFoundException(__("無効リクエスト"));
//            echo $id;
        } else {
            //リクエストの種類はポストの場合
            if ($this->request->is('post')) {
                //ユーザデータを取り出す
                $userData = $this->User->find('first', array(
                    'conditions' => array('User.UserId' => $id)
                ));
                //ユーザデータを取り出すのが成功かどうかチェック
                if ($userData == null) {
                    throw new NotFoundException('ユーザが存在しません');
                } else {
                    $isPassTab = false;
                    //リクエストのデータは3つのフィールドの場合
                    if (sizeof($this->request->data) == 3) {
                        $isPassTab = true;
                        //ユーザ画使用しているパースワードを取り出す
                        $password = $userData['User']['Password'];
                        //リクエストでの使用中のパースワードを取り出す
                        $currentPassword = AuthComponent::password($this->request->data['currentPassword']);
                        //リクエストでの新規のパースワードを取り出す
                        $newPassword = AuthComponent::password($this->request->data('newPassword'));
                        //リクエストでの使用中パースワードとユーザのパースワードが合わせるかどうかチェック
                        if ($currentPassword==$password) {
                            //ユーザのパースワードを更新する
                            if ($this->User->updateAll(array('Password' => "'$newPassword'"), array('UserId' => $id))) {
                                $this->Session->setFlash(__("パースワード変更するのが成功です."));
                                return $this->redirect(array('action' => 'index'));
                            } else {
                                $this->Session->setFlash(__("パースワード変更できません"));
                            }

                        }
                        //パースワードは合わせていません
                        else {

                            $this->Session->setFlash(__("パースワードは合わせていません"));
                        }
                    }
                    //リクエストのデータは4つのフィールドの場合
                    else if (sizeof($this->request->data) == 4) {
                        //ユーザの秘密の質問を取り出す
                        $verifyQuestion = $userData['User']['VerifyCodeQuestion'];
                        //ユーザの秘密の答えを取り出す
                        $verifyAnswer = $userData['User']['VerifyCodeAnswer'];
                        //ユーザの新規に秘密質問を取り出す
                        $newQuestion = trim($this->request->data['newQuestion']);
                        //ユーザの新規に秘密答えを取り出す
                        $newAnswer = trim($this->request->data['newAnswer']);
                        //新規の質問それとも新規の答えは使用中の質問と答えが合わせていない場合
                        if ($verifyQuestion != trim($this->request->data('currentQuestion')) || $verifyAnswer != trim($this->request->data('currentAnswer'))) {

                            $this->Session->setFlash(__("使用中の秘密質問と答えは合わせていません"));

                        } else {
                            //新規の質問それとも新規の答えは使用中の質問と答えが合わせる場合、新規の質問とか答えをデータベースに更新する
                            if ($this->User->updateAll(array('VerifyCodeQuestion' => "'$newQuestion'", 'VerifyCodeAnswer' => "'$newAnswer'"), array('UserId' => $id))) {
                                $this->Session->setFlash(__("秘密質問と答えを変更するのが成功です"));
                                return $this->redirect(array('action' => 'index'));
                            } else {
                                $this->Session->setFlash(__("秘密質問と答えが変更できません"));
                            }
                        }
                    }
//            debug($isPassTab);
                    //コントロールの変数をセット
                    $this->set("isPassTab", $isPassTab);
                }
            }
        }
    }

    public function edit_profile($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__("無効リクエスト"));

        } else {
            $userData = $this->User->find('first', array(
                'conditions' => array('User.UserId' => $id)
            ));
        }
        if ($userData == null) {
            throw new NotFoundException('Could not find that User');
        } else {
            if ($this->request->is('get')) {
//                print_r($userData);
                $profileInfo = array();
                $profileInfo['FullName'] = $userData['User']['FullName'];
                $profileInfo['Birthday'] = $userData['User']['Birthday'];
                $profileInfo['Gender'] = $userData['User']['Gender'];
                $profileInfo['Phone'] = $userData['User']['Phone'];
                $profileInfo['Email'] = $userData['User']['Email'];
                $profileInfo['Address'] = $userData['User']['Address'];
                $profileInfo['CreditCard'] = $userData['User']['CreditCard'];
                $profileInfo['BankInfo'] = $userData['User']['BankInfo'];
                $profileInfo['UserType'] = $userData['User']['UserType'];
                $profileInfo["Email"] = $userData['User']['Email'];

//            echo (date("d",strtotime($userData['User']['Birthday'])));
            } else if ($this->request->is('post')) {
                $profileInfo['FullName'] = $this->request->data["name"];
                $day = $this->request->data['day'];
                $year = $this->request->data['year'];
                $month = $this->request->data['months'];
                $profileInfo['Birthday']= $year."-".$month."-".$day;
                $profileInfo['Gender'] = $this->request->data['gender'];
                $profileInfo['Phone'] =  $this->request->data['phone'];
                $profileInfo['Address'] =  $this->request->data['address'];
                $profileInfo['CreditCard'] = $this->request->data['paymentInfo'];
                $profileInfo['BankInfo'] = $this->request->data['paymentInfo'];
                $profileInfo["Email"]=  $this->request->data['mail'];
                $profileInfo['UserType'] = $userData['User']['UserType'];
                $updateData = array('FullName'=> "'".$profileInfo['FullName']."'",
                    'Birthday'=> "'".$profileInfo['Birthday']."'",
                    'Gender'=> "'".$profileInfo['Gender']."'",
                    'Phone'=>"'".$profileInfo['Phone']."'",
                    'Address'=>"'".$profileInfo['Address']."'",
                    'CreditCard'=>"'".$profileInfo['CreditCard']."'",
                    'BankInfo'=> "'".$profileInfo['BankInfo']."'",
                    'UserType'=>"'".$profileInfo['UserType']."'",
                    'Email' => "'". $profileInfo["Email"]."'"
                );
                if ($this->User->updateAll($updateData, array('UserId' => $id))) {
                    $this->Session->setFlash(__("あなたの個人情報が変更されてしまいました"));
                }else{
                    $this->Session->setFlash(__("エラーがあるのであなたの個人情報が変更されていません"));
                }
//                $profileInfo['Email']
            }
            $this->set('profileInfo', $profileInfo);
        }
    }

    public function delete_account($id = null)
    {
//        echo "Id is ".$id;
        if ($id == null) {
            throw new NotFoundException(__("Invalid Request"));
        } else {
            if ($this->request->is('post')) {
                $userData = $this->User->find('first', array(
                    'conditions' => array('User.UserId' => $id)
                ));
                if ($userData == null) {
                    throw new NotFoundException('Could not find that User');
                } else {
//                    print_r($userData);
                    $question = trim($this->request->data['質問']);
                    $answer = trim($this->request->data['答え']);
                    if ($question != $userData['User']['VerifyCodeQuestion'] || $answer != $userData['User']['VerifyCodeAnswer']) {
                        $this->Session->setFlash(__("Your current question and answer not match"));
                    } else {
                        if ($this->User->updateAll(array('Status' => 0), array('UserId' => $id))) {
                            $this->Session->setFlash(__("Your account has been deleted."));
                            UsersController::logout();
//                            return $this->redirect(array('action' => 'index'));
                        }
                    }

                }
            }

        }
    }
	public function logout() {
	    return $this->redirect($this->Auth->logout());
	}
}	
?>