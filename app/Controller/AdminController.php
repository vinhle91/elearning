<?php
/**
*@copyright Copyright (c) 2013 mrhieusd
*/
App::uses('AuthComponent', 'Controller/Component');
class AdminController extends AppController {
	
	public $uses = array('User', 'Ip', 'Config', 'Transaction', 'Lesson', 'File', 'Msg');

	function beforeFilter() {
		$this->disableCache();
		$this->Auth->authenticate = array(
			'Form' => array(
				'userModel' => 'User',
				'fields' => array('username' => 'Username', 'password' => 'Password'),
				'scope' => array('Status' => 1, 'UserType' => 3),
			)
		);
		$this->Auth->loginAction = array('controller' => 'admin', 'action' => 'login');
		$this->Auth->loginRedirect = array('controller'=>'admin','action'=>'home');
		$this->Auth->loginError = 'ユーザー名又はパスワードが間違った。';
		$this->Auth->authError = 'このページを表示するために、ログインしてください。';


        $pageTitle = 'E-Learningシステム';
        $this->layout = 'admin';

        $status = array('削除', 'アクティブ', 'ペンディング', 'ブロック', '拒否');
		$status_label = array('default', 'success', 'info', 'warning', 'danger');
		$fa_label = array('1' => 'plus', '2' => 'bell-o');
		$msg_link = array('1' => '/elearning/admin/student', '2' => '/elearning/admin/lesson/');
		$this->set(compact('status'));
		$this->set(compact('status_label'));
		$this->set(compact('fa_label'));
		$this->set(compact('msg_link'));

		$msg = $this->Msg->find("all", array(
			'conditions' => array(
				'OR' => array(
					'Msg.UserId' => '',
					'User.UserType' => 3,
					)
				),
			'order' => 'Msg.created DESC',
			));
		$nmsg = $this->Msg->find("count", array(
			'conditions' => array(
				'OR' => array(
					'User.UserType' => 3,
					'Msg.UserId' => ''
					),
				'Msg.IsReaded' => 0,
				
				)
			));
		$this->set('nmsg', $nmsg);
		$this->set('notifs', $msg);
        // return parent::beforeFilter();
    }

    public function login() {
		$this->layout = null;
		if ($this->request->is('post')) {
            $data = $this->request->data;
            if(!empty($data['User']['Username']) && !empty($data['User']['Password']) ) {
            	$currentIpAddress = $this->request->clientIp();
            	if ($currentIpAddress == "::1") 
            		$currentIpAddress = '127.0.0.1';
            	$this->log("currentIp");
            	$this->log($currentIpAddress);
            	$user = $this->User->find('first', array(
            			"conditions" => array(
            				"User.Username" => $data['User']['Username'],
            				"User.Password" => Security::hash($data['User']['Username'].$data['User']['Password'], 'sha1', true),
            				),
            		));
            	if (empty($user)) {
            		$this->Session->setFlash("パスワードが正しくありません");
            	} else {
            		$ip_tble = [];
            		foreach ($user['Ip'] as $key => $ip) {
            			array_push($ip_tble, $ip['IpAddress']);
            		}
            		if (in_array($currentIpAddress, $ip_tble)) {
                		$this->request->data['User']['Password'] = $data['User']['Username'] . $data['User']['Password'];
            			$this->log($this->Auth->login());
            			$this->Session->write('User', $this->Auth->user());
            			$this->Session->write('User.currentIp', $currentIpAddress);
	            		$this->redirect(array('controller' => 'admin', 'action' => 'home'));
            		} else {
            			$this->Session->setFlash("IPアドレスが正しくありません");
            		}
            	}
            }
        }
	}

	public function logout() {

		session_destroy();
	    return $this->redirect($this->Auth->logout());
	}

   	public function test() {

	}

	public function index() {	

	}


	public function home() {
		//title cho trang
		$pageTitle = 'ホーム';
		$this->set(compact('pageTitle'));

		//sidebar
		$this->set('sidebar', array('home'));

		$this->getPaymentInfo();
		$this->getNewStudentInfo();
        $this->getNewTeacherInfo();
	}

	public function getNewStudentInfo() {
		$new_students = array(
			'Total' => $this->User->find("count", array(
				'conditions' => array(
					'AND' => array(
						'created >' => date('Y-m-d',strtotime("-1 months")),
						'UserType' => '1'						
					),
					'NOT' => array(
						'Status' => '0',
						)
					)
				)),
			'Data' => $this->User->find("all", array(
				'conditions' => array(
					'AND' => array(
						'created >' => date('Y-m-d',strtotime("-1 months")),
						'UserType' => '1'
						)
					)
				))
			);
		$this->set(compact('new_students'));
		// $this->log($new_students);
	}

    public function getNewTeacherInfo() {
        $new_teachers = array(
            'Total' => $this->User->find("count", array(
                    'conditions' => array(
                        'AND' => array(
                            'created >' => date('Y-m-d',strtotime("-1 months")),
                            'UserType' => '2'
                        ),
                        'NOT' => array(
                            'Status' => '0',
                        )
                    )
                )),
            'Data' => $this->User->find("all", array(
                    'conditions' => array(
                        'AND' => array(
                            'created >' => date('Y-m-d',strtotime("-1 months")),
                            'UserType' => '2'
                        )
                    )
                ))
        );
        $this->set(compact('new_teachers'));
    }

	public function payment($param = null) {

		if (!isset($param)) {
			//title cho trang
			$pageTitle = __('支払い概要');
			$this->set(compact('pageTitle'));

			//breadcrumb cho trang
			$page_breadcrumb = array();
			$page_breadcrumb['title'] = __('支払い概要');
			$page_breadcrumb['direct'] = array('ホーム', '支払い');
			$this->set(compact('page_breadcrumb'));
			//end breadcrumb cho trang

			//sidebar
			$this->set('sidebar', array('payment'));

			$this->getPaymentInfo();
		}

		else if ($param == "getTransInMonth") {
			
			$this->layout = null;
			$ret = array();
			if (!empty($this->request->data) && $this->request->is("post")) {
				$data = $this->request->data;
				try {
					$ret['data']  = $this->Transaction->getTransaction($data['Month'], $data['Year']);
					$ret['result'] = "Success";
					$ret['data']['Earn'] = $ret['data']['Total'] * $CONFIG_COURSE_FEE * $CONFIG_SHARING_RATE / 100;
				} catch (Exception $e) {
					$ret['data'] = null;
					$ret['result'] = "Fail";
					$ret['error'] = $e->getMessage();
				}
	
				echo json_encode($ret);
			}
			
			die;
		} else {
			die;
		}

	}

	public function getPaymentInfo(){
		$CONFIG_COURSE_FEE = $this->Config->getConfig("lesson_cost") ?  $this->Config->getConfig("lesson_cost") : 20000;
		$CONFIG_SHARING_RATE = $this->Config->getConfig("share_rate") ? $this->Config->getConfig("share_rate") : 40;
		$this->set(compact('CONFIG_SHARING_RATE'));
		$today = $this->Transaction->getTransactions("Today");
		$this->set(compact('today'));
		$lastweek = $this->Transaction->getTransactions("LastWeek");

		$total = $this->Transaction->find("all", array(
					'recursive' => '2',
					'conditions' => array(
						'Blocked' => '0'
						),
				));

		$total = $this->Transaction->getTransactions("All");
		$overview = array(
			'Today' => $today['Total'] * $CONFIG_COURSE_FEE,
			'Lastweek' => $lastweek['Total'] * $CONFIG_COURSE_FEE,
			'Total' => $total['Total'] * $CONFIG_COURSE_FEE,
			'Earn' => $total['Total'] * $CONFIG_COURSE_FEE * $CONFIG_SHARING_RATE / 100,
			);
		$this->set(compact('overview'));

		$payment_summary = $this->Transaction->getTransactions("LastMonth");
		$payment_summary['Earn'] = $payment_summary['Total'] * $CONFIG_COURSE_FEE * $CONFIG_SHARING_RATE / 100;
		// $this->log($payment_summary);
		$this->set(compact('payment_summary'));

	}

	public function lesson($lesson = null) {
		$this->set('sidebar', array('lesson'));

		if (!isset($lesson)) {
			//title cho trang
			$pageTitle = "admin/lessons";
			$this->set(compact('pageTitle'));
			//end title cho trang
			
			//breadcrumb cho trang
			$page_breadcrumb = array();
			$page_breadcrumb['title'] = 'Lessons';
			$page_breadcrumb['direct'] = array('ホーム', 'Lessons');
			$this->set(compact('page_breadcrumb'));
			//end breadcrumb cho trang

			//lay du lieu tu database cho bang All lessons
			$all_lessons = array(
				'Total' => $this->Lesson->find("count", array(
					'conditions' => array(
						),
					)),
				'Data' => $this->Lesson->find('all', array(
					'limit' => 10,
					'conditions' => array(
						),
					))
				);
			$this->set(compact('all_lessons'));

		} else {
			$lessonInfo = $this->Lesson->getLessonInfo($lesson);

			//title cho trang
			$pageTitle = "lesson/" . $lessonInfo['Title'];
			$this->set(compact('pageTitle'));
			//end title cho trang
			
			//breadcrumb cho trang
			$page_breadcrumb = array();
			$page_breadcrumb['title'] = $lessonInfo['Title'];
			$page_breadcrumb['direct'] = array('ホーム', 'Lessons', $lessonInfo['FullName']);
			$this->set(compact('page_breadcrumb'));
			//end breadcrumb cho trang

			$this->set('lessonInfo', $lessonInfo);
		}
			
	}

	public function file() {
		$this->set('sidebar', array('file'));

		//title cho trang
		$pageTitle = "管理者/ファイル";
		$this->set(compact('pageTitle'));
		//end title cho trang
		
		//breadcrumb cho trang
		$page_breadcrumb = array();
		$page_breadcrumb['title'] = 'ファイル';
		$page_breadcrumb['direct'] = array('ホーム', 'Files');
		$this->set(compact('page_breadcrumb'));
		//end breadcrumb cho trang

		//lay du lieu tu database cho bang All files
		$all_files = array(
			'Total' => $this->File->find("count", array(
				'conditions' => array(
					),
				)),
			'Data' => $this->File->find('all', array(
				'limit' => 10,
				'conditions' => array(
					),
				))
			);

		$this->set(compact('all_files'));
	}

	public function student($username = null) {
		$this->set('sidebar', array('user', 'student'));

		if (!isset($username)) {

			//title cho trang
			$pageTitle = "管理者/学生";
			$this->set(compact('pageTitle'));
			//end title cho trang
			
			//breadcrumb cho trang
			$page_breadcrumb = array();
			$page_breadcrumb['title'] = '学生';
			$page_breadcrumb['direct'] = array('ホーム', '学生');
			$this->set(compact('page_breadcrumb'));
			//end breadcrumb cho trang

			//lay du lieu tu database cho bang All students
			$all_students = array(
				'Total' => $this->User->find("count", array(
					'conditions' => array(
						'UserType' => 1,
						),
					)),
				'Data' => $this->User->find('all', array(
					'limit' => 10,
					'conditions' => array(
						'UserType' => 1
						),
					))
				);
			$this->set(compact('all_students'));

			//lay du lieu tu database cho bang new students
			$this->getNewStudentInfo();

		} else {
			$studentInfo = $this->User->getUserInfo($username);
			//title cho trang
			$pageTitle = "学生/" . $studentInfo['FullName'];
			$this->set(compact('pageTitle'));
			//end title cho trang
			
			//breadcrumb cho trang
			$page_breadcrumb = array();
			$page_breadcrumb['title'] = $studentInfo['FullName'];
			$page_breadcrumb['direct'] = array('ホーム', '学生', $studentInfo['FullName']);
			$this->set(compact('page_breadcrumb'));
			//end breadcrumb cho trang

			$this->log($studentInfo);
			$this->set('studentInfo', $studentInfo);
		}
	} 

	public function teacher($username = null) {
		//sidebar
		$this->set('sidebar', array('user', 'teacher'));

		if (!isset($username)) {
			//title cho trang
			$pageTitle = __("admin/teachers");
			$this->set(compact('pageTitle'));
			//end title cho trang
			
			//breadcrumb cho trang
			$page_breadcrumb['title'] = '先生';
			$page_breadcrumb['direct'] = array('ホーム', '先生');
			$this->set(compact('page_breadcrumb'));
			//end breadcrumb cho trang

			//lay du lieu tu database cho bang All teacher
			$all_teachers = array(
				'Total' => $this->User->find("count", array(
					'conditions' => array(
						'UserType' => 2,
						),
					)),
				'Data' => $this->User->find('all', array(
					'limit' => 10,
					'conditions' => array(
						'UserType' => 2
						),
					))
				);
			$this->set(compact('all_teachers'));

			//lay du lieu tu database cho bang new teacher
			$new_teachers = array(
				'Total' => $this->User->find("count", array(
					'conditions' => array(
						'AND' => array(
							'created >' => date('Y-m-d',strtotime("-1 days")),
							'UserType' => '2'
							)
						)
					)),
				'Data' => $this->User->find("all", array(
					'conditions' => array(
						'AND' => array(
							'created >' => date('Y-m-d',strtotime("-1 days")),
							'UserType' => '2'
							)
						)
					))
				);
			$this->set(compact('new_teachers'));

		} else {
			$teacherInfo = $this->User->getUserInfo($username);

			//title cho trang
			$pageTitle = "teacher/" . $teacherInfo['FullName'];
			$this->set(compact('pageTitle'));
			//end title cho trang
			
			//breadcrumb cho trang
			$page_breadcrumb = array();
			$page_breadcrumb['title'] = $teacherInfo['FullName'];
			$page_breadcrumb['direct'] = array('ホーム', '先生', $teacherInfo['FullName']);
			$this->set(compact('page_breadcrumb'));
			//end breadcrumb cho trang

			
			$this->set('teacherInfo', $teacherInfo);
		}
	}

	public function moderator($username = null) {
		$this->set('sidebar', array('user', 'moderator'));

		if (!isset($username)) {

			//title cho trang
			$pageTitle = __("管理者/管理者");
			$this->set(compact('pageTitle'));
			//end title cho trang
			
			//breadcrumb cho trang
			$page_breadcrumb = array();
			$page_breadcrumb['title'] = __('管理者');
			$page_breadcrumb['direct'] = array('ホーム', '管理者');
			$this->set(compact('page_breadcrumb'));
			//end breadcrumb cho trang

			//lay du lieu tu database cho bang All moderators
			$all_moderators = array(
				'Total' => $this->User->find("count", array(
					'conditions' => array(
						'UserType' => '3',
						'Status <>' => '0'
						),
					)),
				'Data' => $this->User->find('all', array(
					'limit' => 10,
					'conditions' => array(
						'UserType' => '3',
						'Status <>' => '0'
						),
					))
				);
			$this->set(compact('all_moderators'));

		} else {
			$moderatorInfo = $this->User->getUserInfo($username);

			//title cho trang
			$pageTitle = "管理者/" . $moderatorInfo['FullName'];
			$this->set(compact('pageTitle'));
			//end title cho trang
			
			//breadcrumb cho trang
			$page_breadcrumb = array();
			$page_breadcrumb['title'] = $moderatorInfo['FullName'];
			$page_breadcrumb['direct'] = array('ホーム', '管理者', $moderatorInfo['FullName']);
			$this->set(compact('page_breadcrumb'));
			//end breadcrumb cho trang

			
			$this->set('moderatorInfo', $moderatorInfo);
		}
	}

	public function config() {
		//title cho trang
		$pageTitle = __('システム設定');
		$this->set(compact('pageTitle'));

		//breadcrumb cho trang
		$page_breadcrumb = array();
		$page_breadcrumb['title'] = __('システム設定');
		$page_breadcrumb['direct'] = array('ホーム', '設定');
		$this->set(compact('page_breadcrumb'));
		//end breadcrumb cho trang

		//sidebar
		$this->set('sidebar', array('config'));

		//lay du lieu tu db 
		$ip_addrs = $this->Ip->find('all');
		$this->set(compact('ip_addrs'));

		$configs = $this->Config->find('all');
		$this->set(compact('configs'));

		$list_user = $this->User->find("all", array(
						'conditions' => array(
							'User.UserType' => '3',
							'User.Status' => '1'
							),
						'fields' => array(
							'User.Username'
							),
						));
		$this->set(compact('list_user'));
	}

	public function updateUserInfo($param) {

		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->layout = null;

			$data = $this->request->data;
			$this->log($data);
			$ret = array();

			if ($param == "update") {
				if ($this->User->updateAll($data, array('UserId' => $data['UserId'])) == 1) {
					$ret['result'] = "Success";
				} else {
					$ret['result'] = "Fail";
				}
			}

			if ($param == "block") {
				$buff = array(
					"Status" => "3",
					);
				if ($this->User->updateAll($buff, array('UserId' => $data['UserId'])) == 1) {
					$ret['result'] = "Success";
				} else {
					$ret['result'] = "Fail";
				}				
			}

			if ($param == "remove") {
				$this->log($data);
				$user = $this->User->getUserByUsername($data);
				$userId = $user['User']['UserId'];
				if ($this->User->delete($userId) == 1) {
					$ret['result'] = "Success";
				} else {
					$ret['result'] = "Fail";
				}				
			}

			if ($param == "delete") {
				$buff = array(
					"Status" => "0",
					);
				if ($this->User->deleteAll(array('UserId' => $data['UserId']),true) == 1) {
					$ret['result'] = "Success";
				} else {
					$ret['result'] = "Fail";
				}				
			}

			if ($param == "active") {
				$buff = array(
					"Status" => "1",
					);
				if ($this->User->updateAll($buff, array('UserId' => $data['UserId'])) == 1) {


					$ret['result'] = "Success";
				} else {
					$ret['result'] = "Fail";
				}				
			}

			if ($param == "deny") {
				$buff = array(
					"Status" => "4",
					);
				if ($this->User->updateAll($buff, array('UserId' => $data['UserId'])) == 1) {
					$ret['result'] = "Success";
				} else {
					$ret['result'] = "Fail";
				}				
			}

			if ($param == "insert") {
				$conditions = array(
					'User.Username' => $data['Username'],
					);
				if ($this->User->hasAny($conditions)) {
					$ret['result'] = "Fail";
					$ret['msg'] = "ユーザー '".$data['Username']."'' があった!!!";
				} else {
					$this->User->create();

					if ($this->User->save($data)) {
						$ret['result'] = "Success";
					} else {
						$ret['result'] = "Fail";
					}
				}

				
			}

			if ($param == "msg") {
				if ($this->Msg->updateAll(array("IsReaded" => "1"), array('MsgId' => $data)) == 1) {
					$ret['result'] = "Success";
				} else {
					$ret['result'] = "Fail";
				}
			}

			$log = $this->User->getDataSource()->getLog(false, false);       
			$this->log($log);

			$this->log($ret);
			echo json_encode($ret);
			die;
		}

	}

	public function resetPassword() {
		$this->layout = null;

		if ($this->request->is('post') && !empty($this->request->data)) {
			$data = $this->request->data;
			$ret = array();
			$userinfo = $this->User->getUserInfo($data['Username']);

			$buff = array(
				"Password" => "'".$userinfo["InitialPassword"]."'",
				);
			if ($this->User->updateAll($buff, array('UserId' => $data['UserId'])) == 1) {
				$ret['result'] = "Success";
			} else {
				$ret['result'] = "Fail";
			}

			$log = $this->User->getDataSource()->getLog(false, false);       
			$this->log($log);

			echo json_encode($ret);
			die;
		}
	}

	public function resetVerifyCode() {
		$this->layout = null;

		if ($this->request->is('post') && !empty($this->request->data)) {
			$data = $this->request->data;
			$ret = array();
			$userinfo = $this->User->getUserInfo($data['Username']);

			$buff = array(
				"VerifyCodeQuestion" => "'".$userinfo["InitialCodeQuestion"]."'",
				"VerifyCodeAnswer" => "'".$userinfo["InitialCodeAnswer"]."'",
				);
			if ($this->User->updateAll($buff, array('UserId' => $data['UserId'])) == 1) {
				$ret['result'] = "Success";
			} else {
				$ret['result'] = "Fail";
			}

			$log = $this->User->getDataSource()->getLog(false, false);       
			$this->log($log);

			echo json_encode($ret);
			die;
		}
	}

	public function updateConfig($param = null) {
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->layout = null;
			$data = $this->request->data;
			$this->log($data);
			$ret = array();

			if ($param == "ip") {
				$this->Ip->create();
				$data['UserId'] = $this->User->getUserByUsername($data['Username'])['User']['UserId'];
				if ($this->Ip->save($data)) {
					$ret['result'] = "Success";
				} else {
					$ret['result'] = "Fail";
				}
			}

			if ($param == "changeIp") {
				$submit_data['IpId'] = $data['IpId'];
				$submit_data['IpAddress'] = $data['IpAddress'];
				if ($this->Ip->updateAll($submit_data, array('Ip.IpId' => $data['IpId']))) {
					$ret['result'] = "Success";
				} else {
					$ret['result'] = "Fail";
				}
			}

			if ($param == "removeIp") {
				
				if ($this->Ip->removeIp($data['IpAddress']) == 1)
					$ret['result'] = "Success";
				else 
					$ret['result'] = "Fail";
			}

			if ($param == "config") {
				$this->log($data);
				foreach ($data as $key => $config) {
					$this->Config->updateAll(array('ConfigValue' => $config), array('ConfigId' => $key));
				}
				$ret['result'] = "Success";
				
			}
			
			// $log = $this->User->getDataSource()->getLog(false, false);       
			// $this->log($log);
			echo json_encode($ret);
			die;
		}

	}

	public function updateLesson($param = null) {
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->layout = null;
			$data = $this->request->data;
			$ret = array();
			

			if ($param == "block") {
				$this->Lesson->blockLesson($data);
				$ret['result'] = "Success";
			} 

			if ($param == "active") {
				$this->Lesson->activeLesson($data);
				$ret['result'] = "Success";
			}

			if ($param == "report") {
				foreach ($data as $key => $lesson) {
		            $lesson_info = $this->Lesson->find(	'first', array(
												            'recursive' => '2',
												            'conditions' => array(
												                'Lesson.LessonId' => $lesson,
												            ),
												        ));
		            $submit_data = array();
		            $submit_data['Content'] = "Lesson ".$lesson_info['Title']." has been reported!";
		            $submit_data['UserId'] = $lesson_info['Author']['UserId'];
		            $submit_data['MsgType'] = 2;
		            $submit_data['IsReaded'] = 0;
		            $this->Msg->create();
		            $this->Msg->save($submit_data);
		        }
			}

			
			// $log = $this->User->getDataSource()->getLog(false, false);       
			// $this->log($log);
			echo json_encode($ret);
			die;
		}
	}

	public function updateFile($param = null) {
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->layout = null;
			$data = $this->request->data;
			$ret = array();
			$this->log($data);

			if ($param == "block") {
				$this->File->blockFile($data);
				$ret['result'] = "Success";
			} 

			if ($param == "active") {
				$this->File->activeFile($data);
				$ret['result'] = "Success";
			}

			
			// $log = $this->User->getDataSource()->getLog(false, false);       
			// $this->log($log);
			echo json_encode($ret);
			die;
		}
	}

	public function exportPayment() {
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->layout = null;
			$data = $this->request->data;
			$this->log($data);
			$this->log(ROOT . DS . 'app' . DS . 'webroot' . DS . 'files' .DS .'exportTSV' . DS . date('Y-m-d').'.txt');
			$file = ROOT . DS . 'app' . DS . 'webroot' . DS . 'files' .DS .'exportTSV' . DS .$data['year']."-".$data['month'].'.txt';
			$fh = fopen($file, 'w');
                        if($fh) {
			fwrite($fh, $data['0']);
			fclose($fh);
			die;
                        }
		}
	}

	public function getUserList($param = null) {
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->layout = null;
			$data = $this->request->data;
			$ret = array();

			if ($param == "admin") {
				$user = $this->User->find("all", array(
					'conditions' => array(
						'User.UserType' => '3',
						'User.Status' => '1'
						),
					'fields' => array(
						'User.Username'
						),
					));

				if (!empty($user)) {
					$ret['result'] = "Success";
					$ret['_data'] = $user;
				} else {
					$ret['result'] = "Fail";
				}
			} 

			echo json_encode($ret);
			die;
		}
	}

	public function changePassword($param=null) {
		$this->layout = null;
		$userid = $param;
		$this->set(compact('userid'));
		if ($this->request->is('post') && !empty($this->request->data)) {

			$data = $this->request->data;
			$ret = array();
			$user = $this->User->getUserById($data['UserId']);
			$this->log($user);
			$this->log(Security::hash($user['User']['Username'].trim($data['old_password']), 'sha1', true));
			$this->log($user['User']['Password']);
			if (Security::hash($user['User']['Username'].trim($data['old_password']), 'sha1', true) != $user['User']['Password']) {
				$ret['result'] = "Fail";
				$ret['msg'] = "不正なパスワード";
			} else {
				$submit_data['Password'] = "'".Security::hash($user['User']['Username'].trim($data['new_password']), 'sha1', true)."'";
				$submit_data['UserId'] = $data['UserId'];
	            $this->log($submit_data);

	            if ($this->User->updateAll($submit_data, array('UserId' => $data['UserId'])) == 1) {
					$ret['result'] = "Success";
				} else {
					$ret['result'] = "Fail";
				}
			}

			echo json_encode($ret);
			die;
		}
	}

    public function backup() {
        $this->layout = null;

        $dbname ='e-learning';
        $filename = $dbname.'_backup.sql';
        $command = 'mysqldump.exe '.$dbname.' --password= --user=root --host=localhost --single-transaction > ./backups/'.$filename;
        $result=exec($command, $output);

        $this->recurse_copy('uploads', 'backups');
    }

    public function restore() {
        $this->layout = null;

        $dbname ='e-learning';
        $filename = $dbname.'_backup.sql';
        $command = 'mysql.exe '.$dbname.' --password= --user=root --host=localhost --single-transaction < ./backups/'.$filename;
        $result=exec($command, $output);

        $this->recurse_copy('backups', 'uploads');
    }

    function recurse_copy($src,$dst) { 
	    $dir = opendir($src); 
	    @mkdir($dst); 
	    while(false !== ( $file = readdir($dir)) ) { 
	        if (( $file != '.' ) && ( $file != '..' )) { 
	            if ( is_dir($src . '/' . $file) ) { 
	                $this->recurse_copy($src . '/' . $file,$dst . '/' . $file); 
	            } 
	            else { 
	                copy($src . '/' . $file,$dst . '/' . $file); 
	            } 
	        } 
	    } 
	    closedir($dir); 
	} 
}	
?>