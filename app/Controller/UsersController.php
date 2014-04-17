<?php

/**
 * @copyright Copyright (c) 2013 mrhieusd
 */
App::uses('AuthComponent', 'Controller/Component');

class UsersController extends AppController {

    /**
     * index
     */
    public $components = array('Paginator', 'RequestHandler');
    public $helpers = array('Js');
    public $uses = array(
        'User',
        'Lesson',
        'Category',
        'Config'
    );

    public function beforeFilter() {
        $this->pageTitle = 'Home';
        $this->layout = 'template';
        $this->Auth->allow(array('index', 'sign_up'));
        return parent::beforeFilter();
    }

    public function index() {
        if ($this->Auth->user()) {
            $UserType = $this->Auth->user('UserType');
            if ($UserType == 1) {
                $this->redirect(array('controller' => 'Student', 'action' => 'index'));
            }
            if ($UserType == 2) {
                $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
            }
            if ($UserType == 3) {
                $this->redirect(array('controller' => 'admin', 'action' => 'home'));
            }
        };
        $cat = $this->Category->getCategories();
        $Category = array();
        foreach ($cat as $key => $value) {
            $Category[$key + 1] = $value['Category']['CatName'];
        }
        $this->set('Category', $Category);
        //Get top lesson 
        if (isset($this->request->query['top']) && $this->request->query['top'] == 'lesson') {
            $this->Paginator->settings = array(
                'conditions' => array('IsDeleted' => '0'),
                'limit' => 15,
            );
            $topLessons = $this->Paginator->paginate('Lesson');
            $this->set('topLessons', $topLessons);
        } else {
            //get top teacher
            $this->User->virtualFields = array(
                'totalLesson' => 'Count(Lesson.LessonId)',
                'totalLike' => 'Sum(Lesson.LikeNumber)',
                'totalView' => 'Sum(Lesson.ViewNumber)'
            );
            $this->Paginator->settings = array(
                'fields' => array(
                    'User.*', 'User.totalLesson', 'User.totalLike', 'User.totalView',
                    'Lesson.*'
                ),
                'conditions' => array('Status' => '1', 'UserType' => '2', 'Lesson.IsDeleted' => '0'),
                'limit' => 15,
                'group' => array('User.UserId'),
                'contain' => array('User', 'Lesson'),
                'joins' => array(
                    array(
                        'alias' => 'Lesson',
                        'table' => 'lessons',
                        'conditions' => array('User.UserId = Lesson.UserId')
                    )
                ),
            );
            $topTeachers = $this->Paginator->paginate('User');
            $this->set('topTeachers', $topTeachers);
        }
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
                //ALTER TABLE users ADD COLUMN IpAddress varchar(20)
                //get the current ip address
                // $currentIpAddress = $this->request->clientIp();
                // debug($currentIpAddress);
                //for test
                $this->request->data['User']['Password']= $data['User']['Username']. $data['User']['Password'];
                // debug($data['User']['Password']);
                $currentIpAddress = '123.1.1.124';
                $username = $data['User']['Username'];
                $user = $this->User->getUserByUsername($username);
                // debug($user);
                // die;
                if (empty($user)) {
                    $this->Session->setFlash($this->Auth->loginError);
                    return;
                }
                if(isset($user)&&$user['User']['Status'] ==2){
                    $this->Session->setFlash(__('このアカウントは、管理者が受け入れるために保留状態である。'));
                    $this->redirect(array('action' => 'login')); 
                }               
                $ipAddress = $user['User']['IpAddress'];
                //debug($user);

                //check remaining blocking time
                $remainBlockTime = $this->remainBlockTime($user['User']['Username']);

                if ($remainBlockTime > 0 && $user['User']['UserType'] == 2) {
                    $this->set('userIsBlocked', true);
                } else {
                    $this->set('userIsBlocked', false);
                }

                // debug($remainBlockTime);
                // debug($this->getNumberOfFailedLogin($user['User']['Username']));
                //if ip adress field is null, set the ip address
                if ((is_null($ipAddress) || $ipAddress == $currentIpAddress || array_key_exists('VerifyCodeAnswer', $data['User']))
                    && $remainBlockTime <= 0 || $user['User']['UserType'] == 1)
                {
                    if (is_null($ipAddress)) {
                        $this->User->id = $user['User']['UserId'];
                        $this->User->saveField('IpAddress', $currentIpAddress);
                    }
                    //if valid verifycode answer, allow to login
                    $isValidVerifyCode = false;
                    $flag = false;
                    if (!array_key_exists('VerifyCodeAnswer', $data['User']) || $user['User']['UserType'] == 1) {
                        $isValidVerifyCode = true;
         
                    } else {
                        $username = $user['User']['Username'];
                        $verifyCodeQuestion = $username . $data['User']['VerifyCodeQuestion'];
                        $verifyCodeAnswer = $username . $data['User']['VerifyCodeAnswer'];

                        $verifyCodeQuestionHash = Security::hash($verifyCodeQuestion, 'sha1', true);
                        $verifyCodeAnswerHash = Security::hash($verifyCodeAnswer, 'sha1', true);
                        debug($verifyCodeQuestionHash);
                        debug($user['User']['VerifyCodeQuestion']);
                        debug($verifyCodeAnswerHash);
                        debug($user['User']['VerifyCodeAnswer']);
                        if ($user['User']['VerifyCodeQuestion'] == $verifyCodeQuestionHash
                            && $user['User']['VerifyCodeAnswer'] == $verifyCodeAnswerHash) {
                            $isValidVerifyCode = true;
                            $flag = true;
                        }
                    }

                    if ($isValidVerifyCode) {
                        //login here
                        if ($this->Auth->login()) {
                            //if login success, save the ip
                            $notLogin = false;
                            if ($this->isUserBlocked($user['User']['Username']) && $user['User']['UserType'] == 2) {
                                // $this->Session->setFlash(__('セキュリティコードを入力してください。'));
                                $this->set('allowVerifyCode', true);
                                $this->set('user', $user);
                                $notLogin = true;
                            }
                            $this->User->id = $user['User']['UserId'];
                            $this->User->saveField('IpAddress', $currentIpAddress);
                            $this->unBlockUser($user['User']['Username']);
                            $this->setNumberOfFailedLogin(0, $user['User']['Username']);
                            if (!$notLogin) {
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
                            }
  
                        } else {
                            $this->Session->setFlash($this->Auth->loginError);

                            //if users enter invalid password m times, prevent them from logging in p minutes
                            $this->setNumberOfFailedLogin($this->getNumberOfFailedLogin($user['User']['Username']) + 1, $user['User']['Username']);
                            $numberFailedLogin = $this->getNumberOfFailedLogin($user['User']['Username']);
                            //debug($numberFailedLogin);
                            $maxFailed = (int)$this->Config->getConfig('FailNumber');

                            if ($numberFailedLogin >= $maxFailed - 1) {
                                //block user
                                $this->setNumberOfFailedLogin(0, $user['User']['Username']);
                                $this->blockUserLogin($user['User']['Username']);
                                $this->blockUser($user['User']['Username']);
                            }

                        }
                    } else {
                        $this->Session->setFlash(__('セキュリティコードが間違った。'));

                        $this->set('allowVerifyCode', true);
                        $this->set('user', $user);
                    }

                } else {

                    if ($remainBlockTime > 0) {
                        $this->Session->setFlash(__('３回に間違ったパスワードが入力されます。１分間待ってログインします。'));
                        $this->blockUser($user['User']['Username']);

                    } else {
                        //else request user the verify code
                        if ($user['User']['UserType'] == 2) {
                            $this->set('allowVerifyCode', true);
                            $this->set('user', $user);
                            $this->Session->setFlash(__('異なる IP Address にアクセスして、セキュリティコードを入力してください。'));

                        }
                    }
                }
            } else {
                $this->Session->setFlash(__('ユーザ名またはパスワードが空である。'));
            }
        } 
    }

    public function sign_up($userType = null) {
        $this->pageTitle = 'Sign up';
        if(isset($userType)){
            $this->set(compact('userType'));
        }
        // debug($userType);
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $userType = $data['User']['UserType'];
            // debug($data);
            if ($data['User']['TermsOfService'] == 1) {
                $this->User->create();
                $birthday = $data['User']['Birthday']['year'] . '-' . $data['User']['Birthday']['month'] . '-' . $data['User']['Birthday']['day'];
                $data['User']['Birthday'] = $birthday;
                $initialPassword = $data['User']['Username'] . $data['User']['Password'];
                $data['User']['InitialPassword'] = $data['User']['Password'];
                $data['User']['Status'] = 2;

                if($data['User']['UserType'] == 2){
                    if(empty($data['User']['BankInfo'])){
                        $this->Session->setFlash(__('A bank infor is required'));
                        $this->redirect(array('action' => 'sign_up',$userType));
                    }
                    if(empty($data['User']['VerifyCodeAnswer'])){
                        $this->Session->setFlash(__('A VerifyCodeAnswer infor is required'));
                        $this->redirect(array('action' => 'sign_up',$userType));
                    }
                    if(empty($data['User']['VerifyCodeQuestion'])){
                        $this->Session->setFlash(__('A VerifyCodeQuestion infor is required'));
                        $this->redirect(array('action' => 'sign_up',$userType));
                    }
                    $initialCodeQuestion = $data['User']['Username'] . $data['User']['VerifyCodeQuestion'];
                    $initialCodeAnswer = $data['User']['Username'] . $data['User']['VerifyCodeAnswer'];
                    $data['User']['InitialCodeQuestion'] = Security::hash($initialCodeQuestion, 'sha1', true);
                    $data['User']['VerifyCodeQuestion'] = $data['User']['InitialCodeQuestion'];
                    $data['User']['InitialCodeAnswer'] = Security::hash($initialCodeAnswer, 'sha1', true);
                    $data['User']['VerifyCodeAnswer'] = $data['User']['InitialCodeAnswer'];
                }else{
                    if(empty($data['User']['CreditCard'])){
                        $this->Session->setFlash(__('A CreditCard infor is required'));
                        $this->redirect(array('action' => 'sign_up',$userType));
                    }
                }
                // debug($data);
                if ($this->User->save($data)) {
                    $this->Session->setFlash(__('ユーザが登録されました'));
                    $this->redirect(array('action' => 'login'));
                } else {
                    $this->Session->setFlash(__('ユーザーは作成できません。'));
                }
            } else {
                $this->Session->setFlash(__('サービス条件とプライバシー方針に賛成してください。'));
            }
        }
    }

    public function view_profile($id = null) {
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

    public function update_security()
    {
        //ユーザIdをデータベースから取り出す
//        $id = $this->Auth->user();
        $id = $this->_usersUsername()['UserId'];
        $UserType = $this->Auth->user()['UserType'];
        $this->set(compact('UserType'));
        $userName = $this->_usersUsername()['Username'];
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
                        $currentPassword = $userName . trim($this->request->data['currentPassword']);
                        //リクエストでの使用中のパースワードを取り出す
                        $currentPassword = Security::hash($currentPassword, 'sha1', true);
                        //リクエストでの新規のパースワードを取り出す
                        $newPassword = $userName . trim($this->request->data['newPassword']);
                        $newPassword = Security::hash($newPassword, 'sha1', true);
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
                        $currentQuestion = Security::hash($userName . trim($this->request->data('currentQuestion')), 'sha1', true);
                        $currentAnswer = Security::hash($userName . trim($this->request->data('currentAnswer')), 'sha1', true);
                        //ユーザの秘密の質問を取り出す
                        $verifyQuestion = $userData['User']['VerifyCodeQuestion'];
                        //ユーザの秘密の答えを取り出す
                        $verifyAnswer = $userData['User']['VerifyCodeAnswer'];
                        //ユーザの新規に秘密質問を取り出す
                        $newQuestion = Security::hash($userName . trim($this->request->data['newQuestion']), 'sha1', true);
                        //ユーザの新規に秘密答えを取り出す
                         $newAnswer = Security::hash($userName . trim($this->request->data['newAnswer']), 'sha1', true);
                        //新規の質問それとも新規の答えは使用中の質問と答えが合わせていない場合
                        if ($verifyQuestion != $currentQuestion|| $verifyAnswer != $currentAnswer) {

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

    public function edit_profile($id = null) {
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
                $profileInfo['Birthday'] = $year . "-" . $month . "-" . $day;
                $profileInfo['Gender'] = $this->request->data['gender'];
                $profileInfo['Phone'] = $this->request->data['phone'];
                $profileInfo['Address'] = $this->request->data['address'];
                $profileInfo['CreditCard'] = $this->request->data['paymentInfo'];
                $profileInfo['BankInfo'] = $this->request->data['paymentInfo'];
                $profileInfo["Email"] = $this->request->data['mail'];
                $profileInfo['UserType'] = $userData['User']['UserType'];
                $updateData = array('FullName' => "'" . $profileInfo['FullName'] . "'",
                    'Birthday' => "'" . $profileInfo['Birthday'] . "'",
                    'Gender' => "'" . $profileInfo['Gender'] . "'",
                    'Phone' => "'" . $profileInfo['Phone'] . "'",
                    'Address' => "'" . $profileInfo['Address'] . "'",
                    'CreditCard' => "'" . $profileInfo['CreditCard'] . "'",
                    'BankInfo' => "'" . $profileInfo['BankInfo'] . "'",
                    'UserType' => "'" . $profileInfo['UserType'] . "'",
                    'Email' => "'" . $profileInfo["Email"] . "'"
                );
                if ($this->User->updateAll($updateData, array('UserId' => $id))) {
                    $this->Session->setFlash(__("あなたの個人情報が変更されてしまいました"));
                } else {
                    $this->Session->setFlash(__("エラーがあるのであなたの個人情報が変更されていません"));
                }
//                $profileInfo['Email']
            }
            $this->set('profileInfo', $profileInfo);
        }
    }

    public function delete_account() {
//        echo "Id is ".$id;
        $id = $this->_usersUsername()['UserId'];
        $UserType = $this->Auth->user()['UserType'];
        $this->set(compact('UserType'));
        $userName = $this->_usersUsername()['Username'];
        if ($id == null) {
            throw new NotFoundException(__("無効リクエスト"));
        } else {
            if ($this->request->is('post')) {
                $userData = $this->User->find('first', array(
                    'conditions' => array('User.UserId' => $id)
                ));
                if ($userData == null) {
                    throw new NotFoundException('そのユーザーを見つけることができませんでした');
                } else {
//                    print_r($userData);
                    $question = Security::hash($userName . trim($this->request->data['質問']), 'sha1', true);
                    $answer = Security::hash($userName . trim($this->request->data['答え']), 'sha1', true);
                    if ($question != $userData['User']['VerifyCodeQuestion'] || $answer != $userData['User']['VerifyCodeAnswer']) {
                        $this->Session->setFlash(__("使用中の秘密質問と答えが合わせていません"));
                    } else {
                        if ($this->User->updateAll(array('Status' => 0), array('UserId' => $id))) {
                            $this->Session->setFlash(__("あなたのアカウントは削除されています。"));
                            UsersController::logout();
//                            return $this->redirect(array('action' => 'index'));
                        } else {
                            $this->Session->setFlash(__("エラーがあるので、あなたのアカウントが削除されていません"));
                        }
                    }
                }
            }
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function blockUserLogin($username) {
        $today = new DateTime();
        $blockTime = $today->add(new DateInterval('PT1M'));
        $this->Session->write('Block' . $username, $blockTime);
    }

    public function remainBlockTime($username) {
        $today = new DateTime();
        $blockTime = $this->Session->read('Block' . $username);
        if (is_null($blockTime) || $today > $blockTime) {
            return 0;
        }
        $diff = $today->diff($blockTime);
        return (int) $diff->s;
    }

    public function getNumberOfFailedLogin($username) {
        $n = $this->Session->read('NumberOfFailedLogin' . $username);
        if (is_null($n)) {
            return 1;
        }
        return $n;
    }

    public function setNumberOfFailedLogin($number, $username) {
        $n = $this->Session->read('NumberOfFailedLogin' . $username);
        if (is_null($n)) {
            $this->Session->write('NumberOfFailedLogin' . $username, 0);
        } else {
            $this->Session->write('NumberOfFailedLogin' . $username, $number);
        }
    }
     public function isUserBlocked($username) {
        $n = $this->Session->read('IsBlocked'.$username);
        if (is_null($n) || $n == 0) {
            return false;
        }
        return true;
    }

    public function blockUser($username) {
        $this->Session->write('IsBlocked'.$username, 1);
    }

    public function unBlockUser($username) {
        $this->Session->write('IsBlocked'.$username, 0);
    }

}

?>