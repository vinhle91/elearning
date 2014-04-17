<?php
/**
*@copyright Copyright (c) 2013 mrhieusd
*/
App::uses('AuthComponent', 'Controller/Component');
class AdminController extends AppController {
	
	public $uses = array('User', 'Ip', 'Config', 'Transaction', 'Lesson', 'File', 'Msg');

	function beforeFilter() {
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

        $status = array('Deleted', 'Active', 'Pending', 'Blocked', 'Denied');
		$status_label = array('default', 'success', 'info', 'warning', 'danger');
		$fa_label = array('1' => 'plus', '2' => 'bell-o');
		$msg_link = array('1' => '/elearning/admin/student', '2' => '/elearning/admin/teacher/');
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
				)
			));
		$nmsg = $this->Msg->find("count", array(
			'conditions' => array(
				'OR' => array(
					array(
						'User.UserType' => 3,
						'Msg.IsReaded' => 0,
						),
					'Msg.UserId' => ''

					)
					
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
            	if ($this->Auth->login()) {
            		$this->Session->write('User', $this->Auth->user());
            		$this->redirect(array('controller' => 'admin', 'action' => 'home'));
            	}
            	else {
            		$this->Session->setFlash("パスワードが正しくありません");
            	}
            }
        }
	}

	public function logout() {
	    return $this->redirect($this->Auth->logout());
	}

   	public function test() {

	}

	public function index() {	

	}


	public function home() {
		//title cho trang
		$pageTitle = 'Home';
		$this->set(compact('pageTitle'));

		//sidebar
		$this->set('sidebar', array('home'));

		$this->getPaymentInfo();
		$this->getNewStudentInfo();
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

	public function payment($param = null) {
		$CONFIG_COURSE_FEE = $this->Config->getConfig("CourseFee") ?  $this->Config->getConfig("CourseFee") : 20000;
		$CONFIG_SHARING_RATE = $this->Config->getConfig("SharingRate") ? $this->Config->getConfig("SharingRate") : 40;
		if (!isset($param)) {
			//title cho trang
			$pageTitle = __('Payment Summary');
			$this->set(compact('pageTitle'));

			//breadcrumb cho trang
			$page_breadcrumb = array();
			$page_breadcrumb['title'] = __('Payment Summary');
			$page_breadcrumb['direct'] = array('Home', 'Payment');
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
		$CONFIG_COURSE_FEE = $this->Config->getConfig("CourseFee") ?  $this->Config->getConfig("CourseFee") : 20000;
		$CONFIG_SHARING_RATE = $this->Config->getConfig("SharingRate") ? $this->Config->getConfig("SharingRate") : 40;
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
			$this->log($all_lessons);

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
		$pageTitle = "admin/files";
		$this->set(compact('pageTitle'));
		//end title cho trang
		
		//breadcrumb cho trang
		$page_breadcrumb = array();
		$page_breadcrumb['title'] = 'Files';
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
			$pageTitle = "admin/students";
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
			$pageTitle = "student/" . $studentInfo['FullName'];
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
			$pageTitle = __("admin/moderators");
			$this->set(compact('pageTitle'));
			//end title cho trang
			
			//breadcrumb cho trang
			$page_breadcrumb = array();
			$page_breadcrumb['title'] = __('Moderators');
			$page_breadcrumb['direct'] = array('Home', 'Moderator');
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
			$pageTitle = "moderator/" . $moderatorInfo['FullName'];
			$this->set(compact('pageTitle'));
			//end title cho trang
			
			//breadcrumb cho trang
			$page_breadcrumb = array();
			$page_breadcrumb['title'] = $moderatorInfo['FullName'];
			$page_breadcrumb['direct'] = array('Home', 'Moderator', $moderatorInfo['FullName']);
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
	}

	public function updateUserInfo($param) {

		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->layout = null;

			$data = $this->request->data;
			$this->log($data);
			$ret = array();

			if ($param == "update") {
				if (isset($data['Password'])) {
                        $data['Password'] = "'".Security::hash($data['Password'], 'sha1', true)."'";
				}

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

			if ($param == "delete") {
				$buff = array(
					"Status" => "0",
					);
				if ($this->User->updateAll($buff, array('UserId' => $data['UserId'])) == 1) {
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
				if ($this->Ip->save($data)) {
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
			
			$log = $this->User->getDataSource()->getLog(false, false);       
			$this->log($log);
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

			
			$log = $this->User->getDataSource()->getLog(false, false);       
			$this->log($log);
			echo json_encode($ret);
			die;
		}
	}

	public function updateFile($param = null) {
		if ($this->request->is('post') && !empty($this->request->data)) {
			$this->layout = null;
			$data = $this->request->data;
			$ret = array();
			

			if ($param == "block") {
				$this->File->blockFile($data);
				$ret['result'] = "Success";
			} 

			if ($param == "active") {
				$this->File->activeLesson($data);
				$ret['result'] = "Success";
			}

			
			$log = $this->User->getDataSource()->getLog(false, false);       
			$this->log($log);
			echo json_encode($ret);
			die;
		}
	}


}	
?>