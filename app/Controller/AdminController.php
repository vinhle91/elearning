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

	public function getPaymentInfo(){
		$CONFIG_COURSE_FEE = $this->Config->getConfig("CourseFee") ?  $this->Config->getConfig("CourseFee") : 20000;
		$CONFIG_SHARING_RATE = $this->Config->getConfig("SharingRate") ? $this->Config->getConfig("SharingRate") : 40;
		$this->set(compact('CONFIG_SHARING_RATE'));
		$today = $this->Transaction->getTransactions("Today");
		$this->set(compact('today'));
		$this->log($today);
		$lastweek = $this->Transaction->getTransactions("LastWeek");
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

	public function payment() {
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

		//lay du lieu tu db 
		
		$this->getPaymentInfo();

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
		$this->layout = null;
		$this->User->set($data);
		$this->User->save();



		if ($this->request->is('post') && !empty($this->request->data)) {
			$data = $this->request->data;
			$this->log($data);
			$ret = array();

			if ($param == "update") {

				if ($this->User->updateAll($data, array('UserId' => $data['UserId'])) == 1) {
					$ret['Status'] = "Success";
				} else {
					$ret['Status'] = "Fail";
				}

				$log = $this->User->getDataSource()->getLog(false, false);       
				$this->log($log);
			}

			if ($param == "insert") {

				$this->User->set($data);
				if ($this->User->save() == 1) {
					$ret['Status'] = "Success";
				} else {
					$ret['Status'] = "Fail";
				}

				$log = $this->User->getDataSource()->getLog(false, false);       
				$this->log($log);
			}

			echo json_encode($ret);
			die;
		}
	}

	public function saveUserInfo() {

	}

}	
?>