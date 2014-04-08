<?php
/**
*@copyright Copyright (c) 2013 mrhieusd
*/
class StudentController extends AppController {
	/**
	* index
	*/
	public $uses = array(
		'User',
		'StudentHistory',
		'StudentBlock',
		'Lesson',
		'Category',
		'Test',
		'Tag',
		'Quest',
		'Answer',
		'Config',
		'File'
		);
	function beforeFilter() {
        $this->pageTitle = '学生';
        $this->layout = 'template';
        $UserType = $this->Auth->user('UserType');
        if($UserType == 2){
        	$this->redirect(array('controller'=>'Teacher','action' => 'index'));
        }else if($UserType == 3){
        	$this->redirect(array('controller'=>'Admin','action' => 'home'));
        }else{
        	
        }
        return parent::beforeFilter();
    }
	public function index() {
		$this->pageTitle = '学生';
        $this->StudentHistory->recursive = -1;
        $today = new DateTime();
        $userId = $this->Auth->user('UserId');
        if (isset($this->request->query['sortBy'])) {
            $sortBy = $this->request->query['sortBy'];
        } else {
            $sortBy = 'time';
        }
        $options = $this->StudentHistory->getPaginationOptions($userId, $sortBy);
        
        $this->paginate = $options;
        $histories = $this->paginate('StudentHistory');
        $this->set('histories', $histories);
        $cat = $this->Category->getCategories();
        $Category = array();
        foreach ($cat as $key => $value) {
        	$Category[$key+1] = $value['Category']['CatName'];
        }
        //debug($Category);
        $this->set('Category', $Category);
        $topLessons = $this->Lesson->getTopLessons();
		foreach ($topLessons as $key => $value) {
			$isStudying = false;
	        $study_history = $this->StudentHistory->find('first', array(
	        	'conditions' => array(
	        		'StudentHistory.LessonId' => $value['Lesson']['LessonId'],
	        		'StudentHistory.UserId' => $userId
	        		),
	        	'order' => array('StudentHistory.StartDate' => 'DESC'),
	        	)
	        );
	        if ($study_history) {
	            $expiryDay = new DateTime($study_history['StudentHistory']['ExpiryDate']);
	           if ($today < $expiryDay) {
	                $isStudying = true;
	            }
	        }
	        $topLessons[$key]['Lesson']['isStudying'] =  $isStudying;
		}
		// debug($topLessons);
        $this->set('topLessons', $topLessons);
	}
	public function view_lesson($lesson_id = null) {
		$this->pageTitle = '授業';
		$userId = $this->Auth->user('UserId');
		$today = new DateTime();
		//top lesson
		$allLessons = $this->Lesson->getAllLessons();
        $this->set('allLessons', $allLessons);

		if(!isset($lesson_id)||empty($lesson_id)){
			$this->Session->setFlash(__('Error. Please try it again'));
			$this->redirect(array('controller'=>'student','action' => 'index'));
		}else{
			if($this->request->is('post')){
	            $userInfo = $this->Auth->user();
	            $userId = $userInfo['UserId'];
	            $comment = trim($this->request->data("comment"));
	            if(!empty($comment)){
		            $this->Comment->create();
		            $data['Comment']['UserId'] = $userId;
		            $data['Comment']['LessonId'] = $lesson_id;
		            $data['Comment']['Content']= $comment;
		            if($this->Comment->save($data)){
		            	$this->Session->setFlash(__('Comments successful!'));
		            	$this->redirect(array('controller'=>'student','action' => 'view_lesson',$lesson_id));
		            }else{
		            	$this->Session->setFlash(__('Error! Please try it again'));
		            	$this->redirect(array('controller'=>'student','action' => 'view_lesson',$lesson_id));
		            }
	        	}else{
	        		$this->Session->setFlash(__('Require is comment!.'));
	        		$this->redirect(array('controller'=>'student','action' => 'view_lesson',$lesson_id));
	        	}
	        }else{
	        	$params = array(
				'conditions' =>array(
					'Lesson.LessonId' =>$lesson_id,
					'IsDeleted'=>'0'
					),
				'contain'=>array(
					'File' => array(
						'conditions'=> array('File.FileType'=>'1','File.IsDeleted'=>'0')
						),
					'Tag',
					'User',
					)
				);
				$lesson = $this->Lesson->find('first',$params);
				$com = $this->Comment->find('all', array(
					'conditions'=>array(
						'IsDeleted'=>'0'
						),
					'contain'=>array(
						'User'=> array(
							'conditions'=>array('$User.Status'=>'1'),
							'fields' => 'User.FullName',
						)
					)
				));
				if(!empty($com)){
					$this->set(compact('com'));
				}
				// debug($com);
				if(!empty($lesson)){
					$isStudying = false;
			        $study_history = $this->StudentHistory->find('first', array(
			        	'conditions' => array(
			        		'StudentHistory.LessonId' => $lesson_id,
			        		'StudentHistory.UserId' => $userId)
			        	)
			        );
			        if ($study_history) {
			            $expiryDay = new DateTime($study_history['StudentHistory']['ExpiryDate']);
			           if ($today < $expiryDay) {
			                $isStudying = true;
			            }
			        }
					if(!$isStudying){
						$this->Session->setFlash(__('You not allowed to acssess page.'));
						$this->redirect(array('controller'=>'Student','action' => 'index'));
					}else{
						$this->set(compact('lesson'));
						$cat = $this->Category->find('first', array(
							'conditions' => array('Category.CatID'=>$lesson['Lesson']['Category'],'IsDeleted'=>'0'),
							'fields'=> array('CatName'),
							)
						);
						if(!empty($cat)){
							$this->set(compact('cat'));
						}
					}
				}else{
					$this->Session->setFlash(__('Error! Please try it again'));
					$this->redirect(array('controller'=>'teacher','action' => 'index'));
				}
	        }
			
		}


	}
	public function test($lesson_id =null) {
		$this->pageTitle = 'テスト';
		$userId = $this->Auth->user('UserId');
		$today = new DateTime();
		if(!isset($lesson_id)){
			$this->Session->setFlash(__('Error.Please try it again'));
			$this->redirect(array('controller'=>'student','action' => 'index'));
		}else{
			$isStudying = false;
	        $study_history = $this->StudentHistory->find('first', array(
	        	'conditions' => array(
	        		'StudentHistory.LessonId' => $lesson_id,
	        		'StudentHistory.UserId' => $userId)
	        	)
	        );
	        if ($study_history) {
	            $expiryDay = new DateTime($study_history['StudentHistory']['ExpiryDate']);
	           if ($today < $expiryDay) {
	                $isStudying = true;
	            }
	        }
			if(!$study_history){
				$this->Session->setFlash(__('You not allowed to do this test.'));
				$this->redirect(array('controller'=>'student','action' => 'view_lesson',$lesson_id));
			}else{
				$this->set(compact('lesson_id'));
				$test = $this->Test->find('all', array(
					'conditions'=>array(
						'Test.LessonId'=>$lesson_id,
						'IsDeleted'=>'0',
						),
					'order' => array('Test.TestId' => 'Asc'),
					)
				);
				$data_test = array();
				foreach ($test as $key => $value) {
					$data_test['Title'] = $value['Test']['Title'];
					$data_test['SubTitle'] = $value['Test']['SubTitle'];
					if(isset($value['Question'])&&!empty($value['Question'])){
						$i=0;
						$j=0;
						foreach ($value['Question'] as $key => $value) {
							$i++;
							$data_test['Question'][$i]['Content'] = $value['QuesContent'];
							$data_test['Question'][$i]['QuesNum'] = $value['QuesNumber'];
							$j = $j+$value['Point'];
							$tmp = strstr($value['QuesAnswer'], ')', true);
							$tmp = substr($tmp,2);
							$tmp = (int)$tmp;
							$data_test['Question'][$i]['Answer'] = $tmp;
							$data_test['Question'][$i]['Point'] = $value['Point'];	
							$data_test['Question'][$i]['An'] = $this->Answer->find('all',array(
								'conditions' => array('Answer.QuesId' =>$value['QuesId']),
								'order' => array('Answer.AnswerNumber' => 'Asc'),
								)
							);		
						}
						$data_test['Total'] = $i;
						$data_test['TotalPoint'] = $j;
					}
				}
				$this->set(compact('data_test'));
				// debug($data_test);
			}
		}
	}
	public function view_result() {
		$this->pageTitle = 'View Test Result';
	}
	public function review_test() {
		$this->pageTitle = 'Review Test';
	}
	public function transaction_history($id = null) {        
        $this->pageTitle = 'Transaction History';
        if (isset($this->request->data['months']) && isset($this->request->data['year'])) {
            $month = $this->request->data['months'];
            $year = $this->request->data['year'];
        } else {
            $month = 0;
            $year = 0;
        }

        $transactions = $this->StudentHistory->getStudentTransactionHistory($this->Auth->user('UserId'), $month, $year);
        $this->set('transactions', $transactions);
        $total = 0;
        foreach ($transactions as $t) {
            $total = $total + $t['StudentHistory']['CourseFee'];
        }
        $this->set('Total', $total);
    }
    public function view_category($catId) {
        $category = $this->Category->getCategory($catId);
        $this->set('cat', $category);
        $userId = $this->Auth->user('UserId');
        $today = new DateTime();
        $options = $this->Category->getPaginationOptions($catId);
        $this->paginate = $options;
        $lessons = $this->paginate('Category');
		foreach ($lessons as $key => $value) {
			$isStudying = false;
	        $study_history = $this->StudentHistory->find('first', array(
	        	'conditions' => array(
	        		'StudentHistory.LessonId' => $value['Lesson']['LessonId'],
	        		'StudentHistory.UserId' => $userId
	        		),
	        	'order' => array('StudentHistory.StartDate' => 'DESC'),
	        	)
	        );
	        if ($study_history) {
	            $expiryDay = new DateTime($study_history['StudentHistory']['ExpiryDate']);
	           if ($today < $expiryDay) {
	                $isStudying = true;
	            }
	        }
	        $lessons[$key]['Lesson']['isStudying'] =  $isStudying;
		}
        $this->set('lessons', $lessons);
    }
    public function buy_lesson($lessonId = null) {
		if(empty($lessonId)){
			$this->Session->setFlash(__('Error. Please try it again'));
	        $this->redirect(array('controller'=>'Student','action' => 'index'));
		}else{
			$userInfo = $this->Auth->user();
	        $today = new DateTime();
	        $userId = $userInfo['UserId'];
	        //check if user is blocked to view this lesson
	        $isBlocked = $this->StudentBlock->find('first', array(
	                'conditions' => array(
	                    'StudentBlock.UserId' => $userId,
	                    'StudentBlock.LessonId' => $lessonId
	                )
	            )
	        );
	        if ($isBlocked) {
	        	$this->Session->setFlash(__('You are not allowed to view this lesson'));
	            $this->redirect(array('controller'=>'Student','action' => 'index'));
	        }
	        $isStudying = false;
	        $study_history = $this->StudentHistory->find('first', array(
	        	'conditions' => array(
	        		'StudentHistory.LessonId' => $lessonId,
	        		'StudentHistory.UserId' => $userId
	        		),
	        	'order' => array('StudentHistory.StartDate' => 'DESC'),
	        	)
	        );
	        // debug($study_history);
	        //if the studying records the student has been studying this lesson
	        if ($study_history) {
	            $expiryDay = new DateTime($study_history['StudentHistory']['ExpiryDate']);
	           	if ($today < $expiryDay) {
	                $isStudying = true;
	            }
	        }

	        //the student hasn't been studying this lesson
	        if (!$isStudying) {
	            $config = $this->Config->find('first', array('conditions' => array('Config.ConfigName' => 'CourseFee')));
	            $fee = $config['Config']['ConfigValue'];
	            if (!is_numeric($fee)) {
	                $this->Session->setFlash(__('You are not allowed to view this lesson'));
	            	$this->redirect(array('controller'=>'Student','action' => 'index'));
	            } else {
	                $lesson= $this->Lesson->find('first',
	                    array(
	                        'conditions' => array(
	                          'Lesson.LessonId'=>$lessonId,
	                          'Lesson.IsDeleted'=>'0',
	                        ),
	                        'contain'=>false,
	                    )
	                );
	                if(empty($lesson)){
	                	$this->Session->setFlash(__('Error. Please try it again'));
	            		$this->redirect(array('controller'=>'Student','action' => 'index'));
	                }else{
		                $updateViewNumber = $lesson['Lesson']['ViewNumber'] + 1;
		                //update view number

		                $this->StudentHistory->create();
		                $data['StudentHistory']['UserId'] = $userId;
		                $data['StudentHistory']['LessonId'] = $lessonId;
		                $data['StudentHistory']['StartDate'] = $today->format('Y-m-d H:i:s');
		                $data['StudentHistory']['ExpiryDate'] = date('Y-m-d H:i:s',strtotime( "+1 week" ));
		                $data['StudentHistory']['CourseFee'] = $fee;
		                if ($this->StudentHistory->save($data)) {
		                	$this->Lesson->updateAll(array("ViewNumber" => $updateViewNumber), array('Lesson.LessonId' => $lessonId));
		                	$this->Session->setFlash(__('You bought this lesson'));
	            			$this->redirect(array('controller'=>'Student','action' => 'view_lesson',$lessonId));
		                } else {
		                    $this->Session->setFlash(__('Error. Please try it again'));
	            			$this->redirect(array('controller'=>'Student','action' => 'index'));
		                }
		            }
	            }
	        }
	        else {
	        	$this->Session->setFlash(__('You have bought this lesson already'));
	            $this->redirect(array('controller'=>'Student','action' => 'index'));
	        }
		}
       
	}

}	
?>