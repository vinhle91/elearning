<?php
/**
*@copyright Copyright (c) 2013 mrhieusd
*/
class AdminController extends AppController {
	
	public $uses = array('User', 'Ip', 'Config', 'Transaction', 'Lesson', 'File');

	function beforeFilter() {
		$UserType = $this->Auth->user('UserType');
		if($UserType == 1){
        	$this->redirect(array('controller'=>'Student','action' => 'index'));
        }else if($UserType == 2){
        	$this->redirect(array('controller'=>'Teacher','action' => 'index'));
        }else{
        	
        }
        $pageTitle = 'E-Learningシステム';
        $this->layout = 'admin';
        $status = array('Deleted', 'Active', 'Pending', 'Blocked', 'Denied');
		$status_label = array('default', 'success', 'info', 'warning', 'danger');
		$this->set(compact('status'));
		$this->set(compact('status_label'));
        return parent::beforeFilter();

    }

    public function img() {
    	//khong biet tai sao luon co log bao thieu adminController::img(), them vao cho k bao loi
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
		$this->log($new_students);
	}

	public function payment($param = null) {
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

		if ($param == "getTransInMonth") {
			$this->layout = null;
			$ret = array();
			if (!empty($this->request->data) && $this->request->is("post")) {
				$data = $this->request->data;
				$ret['data']  = $this->Transaction->getTransaction($data['Month'], $data['Year']);
				if (!$ret['data']) {
					$ret['result']  = "Fail";
					$ret['data'] = null;
				} else {
					$ret['result'] = "Success";
				}

				echo json_encode($ret);
			}
			
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

		$total = $this->Transaction->getTransactions("All");
		$overview = array(
			'Today' => $today['Total'] * $CONFIG_COURSE_FEE,
			'Lastweek' => $lastweek['Total'] * $CONFIG_COURSE_FEE,
			'Total' => $total['Total'] * $CONFIG_COURSE_FEE,
			'Earn' => $total['Total'] * $CONFIG_COURSE_FEE * $CONFIG_SHARING_RATE / 100,
			);
		$this->set(compact('overview'));

		$payment_summary = $this->Transaction->getTransactions("LastWeek");
		$payment_summary['Earn'] = $payment_summary['Total'] * $CONFIG_COURSE_FEE * $CONFIG_SHARING_RATE / 100;
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

	public function login() {
		
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

	public function moderator() {
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
						),
					)),
				'Data' => $this->User->find('all', array(
					'limit' => 10,
					'conditions' => array(
						'UserType' => '3'
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
		$this->log($configs);
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

				$log = $this->User->getDataSource()->getLog(false, false);       
				$this->log($log);
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
				$this->User->create();
				$this->User->set($data);
				if ($this->User->save()) {
					$ret['result'] = "Success";
				} else {
					$ret['result'] = "Fail";
				}

				$log = $this->User->getDataSource()->getLog(false, false);       
				$this->log($log);
			}

			echo json_encode($ret);
			die;
		}

		if ($param = "test") {
			$this->layout = "default";
			$this->User->create();
			$data = array(
				'User' => array(
						"Username" => "fappy",
						"Password" => "12345678",
						"InitialPassword" => "12345678",
						"UserType" => "1",
						"FullName" => "Khuc Anh Minh Luong",
						"Birthday" => "1991-10-12",
						"VerifyCodeQuestion" => "ban sinh nam bao nhieu",
						"InitialCodeQuestion" => "ban sinh nam bao nhieu",
						"VerifyCodeAnswer" => "2323232",
						"InitialCodeAnswer" => "1991",
						"Gender" => "1",
						"Address" => "No 19 204/174 Le Thanh Nghi Hai Ba Trung, Ha Noi",
						"Phone" => "",
						"Email" => "",
						"ImageProfile" => "",
						"IsOnline" => "",
						"created" => "2014-03-03 03:03:31",
						"modified" => "",
						"Status" => "2",
						"Violated" => "",
						"BankInfo" => "Techcombank",
						"CreditCard" => "",
					)
					
				);
			$this->User->save($data);
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

}	
?>