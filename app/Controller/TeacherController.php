<?php
/**
*@copyright Copyright (c) 2013 mrhieusd
*/

class TeacherController extends AppController {
	/**
	* index
	*/
	public $uses = array('User', 'StudentHistory', 'Lesson','File','Tag','Category','Test','Question','Answer','Comment');
	function beforeFilter() {
        $this->pageTitle = 'Home Teacher';
        $this->layout = 'template';
        $UserType = $this->Auth->user('UserType');
        if($UserType == 1){
        	$this->redirect(array('controller'=>'Student','action' => 'index'));
        }else if($UserType == 3){
        	$this->redirect(array('controller'=>'Admin','action' => 'home'));
        }else{

        }
        return parent::beforeFilter();
    }
	public function index() {
		$this->pageTitle = 'Home of Teacher';
		$userId = $this->Auth->user('UserId');
        $lessons = $this->Lesson->getLessonsByTeacher($userId);
        $this->set('lessons', $lessons);
        $cat = $this->Category->getCategories();
   		 // debug($cat);
        $Category = array();
        foreach ($cat as $key => $value) {
        	$Category[$key+1] = $value['Category']['CatName'];
        }
        //debug($Category);
        $this->set('Category', $Category);
        $allLessons = $this->Lesson->getAllLessons();
//	    debug($allLessons);
        $this->set('allLessons', $allLessons);
	}
	public function view_lesson($lesson_id = null) {
		$this->pageTitle = '授業';
		$allLessons = $this->Lesson->getAllLessons();
        $this->set('allLessons', $allLessons);
		$userId = $this->Auth->user('UserId');
		if(!isset($lesson_id)||empty($lesson_id)){
			$this->redirect(array('controller'=>'Teacher','action' => 'index'));
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
		            	$this->redirect(array('controller'=>'Teacher','action' => 'view_lesson',$lesson_id));
		            }
	        	}else{
	        		$this->Session->setFlash(__('Require is comment!.'));
	        		$this->redirect(array('controller'=>'Teacher','action' => 'view_lesson',$lesson_id));
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
					if($lesson['Lesson']['UserId']!= $userId){
						$this->Session->setFlash(__('You not allowed to acssess page.'));
						$this->redirect(array('controller'=>'Teacher','action' => 'index'));
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
					$this->redirect(array('controller'=>'Teacher','action' => 'index'));
				}
	        }
			
		}

	}
	public function make_lesson() {
		$this->pageTitle = 'Make Lesson';
		$params = array(
			'conditions' => array('Category.IsDeleted' => '0'),
			'fields' => array('CatId','CatName'),
			'order' => array('Category.CatId' => 'Asc'),
		);
		$cat = $this->Category->find('all',$params);
		$this->set(compact('cat'));
		if ($this->request->is('post')){
			$data= $this->request->data;
			debug($data);
			if($data['Lesson']['TermsOfService'] == 1) {				
				$this->Lesson->create();
				$userId = $this->Auth->user('UserId');
				//make lesson
				$this->Lesson->set('UserId', $userId);
				if ($this->Lesson->save($data, true)) {
					// Get lesson id
					$lesson= $this->Lesson->find('first', array(
       					 'conditions' => array('Lesson.UserId' => $userId),
       					 'fields' => array('Lesson.LessonId'),
       					 'order' => array('Lesson.created' => 'desc'),
       					 'contain'=> False,
    				));

    				$lesson_id = $lesson['Lesson']['LessonId'];
    				// Save Tag of lesson
     				$tag = $data['Lesson']['Tag'];
     				$tag = strtolower($tag);
     				$tag = explode(",", $tag);
     				if(isset($tag)&&!empty($tag)){
     					foreach ($tag as  $value) {
     						$value = trim($value);
     						$this->Tag->create();
     						$data1['Tag']['LessonId'] = $lesson_id;
     						$data1['Tag']['TagContent'] = $value;
     						if ($this->Tag->save($data1)) {
			                   
			                } else {
			                    $this->Session->setFlash(__('The tag could not be created. Please, try again.'));
			                }  
     					}
     				}
     				// Save file of lesson
					if(isset($data['File'])){
						foreach ($data['File'] as $key => $value) {
							$this->File->create();
							$param1['File']['File'] = $value['path'];
							$param1['File']['LessonId'] = $lesson_id;
							$param1['File']['FileType'] = '1';
							// debug($param1);
							if ($this->File->save($param1)) {
			                   
			                } else {
			                    $this->Session->setFlash(__('The file could not be saved. Please, try again.'));
			                }  
						}						
					}
					// Save test of lesson
					if(isset($data['TestFile'])){
						foreach ($data['TestFile'] as $key => $value) {
							$this->File->create();
							$param2['File']['TestFile'] = $value['path'];
							$param2['File']['LessonId'] = $lesson_id;
							$param2['File']['FileType'] = '2';
							if ($this->File->save($param2)) {
			                   $test_tmp= $this->File->find('first', array(
										 'conditions' => array('File.LessonId' => $lesson_id,'File.FileType'=>'2'),
										 'fields' => array('File.FileId','FileLink'),
										 'order' => array('File.FileId' => 'desc'),
										 'contain'=> False,
								));
			                    $link = $test_tmp['File']['FileLink'];
			                    $link = substr($link, 1);
			                    $excel = $this->Readtsv->loadFile($link);
								$test = array();
								$quest = array();
								$answer = array();
								$Answer = array();

								$test['Test']['Title'] = $this->Readtsv->getCell(1,2);
								$test['Test']['SubTitle'] = $this->Readtsv->getCell(2,2);
								$test['Test']['LessonId'] = $lesson_id;
								if ($this->Test->save($test)) {
						           
						        } else {
						            $this->Session->setFlash(__('The test could not be created. Please, try again.'));
						        } 

						        $Test= $this->Test->find('first', array(
										 'conditions' => array('Test.LessonId' => $lesson_id),
										 'fields' => array('Test.TestId'),
										 'order' => array('Test.created' => 'Asc'),
										 'contain'=> False,
								));
								$test_id = $Test['Test']['TestId'];

								$i =3;
								$num = 1;
								$Answer[$num]['Num'] = 0;
								while(strcmp($this->Readtsv->getCell($i,1),'End') != 0){

									if(strcmp($this->Readtsv->getCell($i,1),'#') == 0){
										$i++;
										continue;
									}
									if(strcmp($this->Readtsv->getCell($i,1),'Q('.$num.')') == 0&&$Answer[$num]['Num'] ==0 &&strcmp($this->Readtsv->getCell($i+1,1),'Q('.$num.')') == 0){
										$Answer[$num]['Start'] = $i;
										$Answer[$num]['Num'] = $Answer[$num]['Num'] +1;
										$i++;
										continue;
									}else if(strcmp($this->Readtsv->getCell($i,1),'Q('.$num.')') == 0&&$Answer[$num]['Num'] !=0&&strcmp($this->Readtsv->getCell($i+1,1),'Q('.$num.')') == 0){
										$Answer[$num]['Num'] = $Answer[$num]['Num'] +1;
										$i++;
										continue;
									}else if(strcmp($this->Readtsv->getCell($i,1),'Q('.$num.')') == 0&&$Answer[$num]['Num'] !=0&&strcmp($this->Readtsv->getCell($i+1,1),'Q('.$num.')') != 0){
										$Answer[$num]['Num'] = $Answer[$num]['Num'] +1;
										$num  = $num +1;
										$Answer[$num]['Num'] = 0;
										$i++;
										continue;
									}else{
										$i++;
										continue;
									}
								}

								foreach ($Answer as $key => $value) {
									if($value['Num']!=0){
										$quest['Question']['TestId'] = $test_id;
										$quest['Question']['QuesNumber'] = $key;
										$quest['Question']['QuesContent'] = $this->Readtsv->getCell($value['Start'],3);
										$quest['Question']['QuesAnswer'] = $this->Readtsv->getCell($value['Start']+$value['Num']-1,3);
										$quest['Question']['Point'] = $this->Readtsv->getCell($value['Start']+$value['Num']-1,4);
										$this->Question->create();
										if ($this->Question->save($quest)) {
									                   
						                } else {
						                    $this->Session->setFlash(__('The quest could not be created. Please, try again.'));
						                } 
						                $Quest= $this->Question->find('first', array(
												 'conditions' => array('Question.TestId' => $test_id,'Question.QuesNumber'=>$key),
												 'fields' => array('Question.QuesId'),
												 'contain'=> False,
										));
										$quest_id = $Quest['Question']['QuesId'];
										$h=1;
										for($j=$value['Start']+1;$j<$value['Start']+$value['Num']-1;$j++){
											$answer['Answer']['QuesId'] = $quest_id;
											$answer['Answer']['AnswerNumber'] = $h;
											$answer['Answer']['AnswerContent'] = $this->Readtsv->getCell($j,3);
											$this->Answer->create();
											if ($this->Answer->save($answer)) {
										                   
							                } else {
							                    $this->Session->setFlash(__('The answer could not be created. Please, try again.'));
							                }
							                $h++; 
										}

									}
								}
			                } else {
			                    $this->Session->setFlash(__('The file could not be saved. Please, try again.'));
			                }  
						}						
					}

					$this->redirect(array('controller'=>'Teacher','action' => 'view_lesson',$lesson_id));
				} else {
					$this->Session->setFlash(__('Could not make lesson. Please, try again.'));
				}
			}else {
	       		$this->Session->setFlash(__('Please confirm terms of service'));
	    	}
	    }  
	}

	public function view_test($lesson_id =null) {
		$this->pageTitle = 'テスト';
		$userId = $this->Auth->user('UserId');
		if(!isset($lesson_id)||empty($lesson_id)){
			$this->redirect(array('controller'=>'Teacher','action' => 'index'));
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
			// debug($test);
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
	public function edit_lesson() {
		$this->pageTitle = 'Edit Lesson';
	}
	public function transaction_history() {
        $this->pageTitle = 'Transaction History';
        $userId = $this->Auth->user('UserId');
        if (isset($this->request->data['months']) && isset($this->request->data['year'])) {
            $month = $this->request->data['months'];
            $year = $this->request->data['year'];
        } else {
            $month = 0;
            $year = 0;
        }
        $transactions = $this->StudentHistory->getTeacherTransactionHistory($userId, $month, $year);
        $this->set('transactions', $transactions);
        $total = 0;
        foreach ($transactions as $t) {
            $total = $total + $t['StudentHistory']['fee'];
        }
        $this->set('total', $total);
    }
	public function delete_lesson() {
	}
	public function view_category($catId) {
        $category = $this->Category->getCategory($catId);
        $this->set('cat', $category);
        
        $options = $this->Category->getPaginationOptions($catId);
        
        $this->paginate = $options;
        $lessons = $this->paginate('Category');
        // debug($lessons);
        $this->set('lessons', $lessons);
    }
	public function list_student() {
        $this->pageTitle = 'List Student';

		if ($this->request->is('get')) {

			$lessonId = $this->request->params['pass']['0'];
			$lesson = $this->Lesson->getLessonById($lessonId);

			$studentHistories = $this->StudentHistory->getStudentHistoryOfLesson($lessonId);

        	$this->set('studentHistories', $studentHistories);
        	$this->set('lessonTitle', $lesson['Lesson']['Title']);

        //	debug($studentHistories);
		}
	}

	public function block_student() {

		if ($this->request->is('get')) {

			$userId = $this->request->params['pass']['0'];
			$lessonId = $this->request->params['pass']['1'];

			$studentHistories = $this->StudentHistory->getStudentHistoryByUserIdAndLessonId($userId, $lessonId);
			$studentHistory = $studentHistories[0];

			$studentBlocks = $this->StudentBlock->getStudentBlockByUserIdAndLessonId($userId, $lessonId);
			debug($studentBlocks);
			if (count($studentBlocks) <= 0) {
				$this->StudentBlock->create();
				$this->StudentBlock->set('UserId', $userId);
				$this->StudentBlock->set('LessonId', $lessonId);
				$this->StudentBlock->save();

				$this->set('result', 'このユーザーブロックが成功です');
				$this->set('lessonId', $lessonId);

				$this->StudentHistory->updateAll(
    				array('StudentHistory.Blocked' => '1'),
    				array('StudentHistory.UserId' => $userId,
    					'StudentHistory.LessonId' => $lessonId)
				);

			} else {
				$this->redirect(array('action' => 'list_student/'.$lessonId));
			}
		}
	}

}	
?>