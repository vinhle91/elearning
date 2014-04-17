<?php

/**
 * @copyright Copyright (c) 2013 mrhieusd
 */
class TeacherController extends AppController {

    /**
     * index
     */
    public $components = array('Paginator', 'RequestHandler');
    public $helpers = array('Js');
    public $uses = array(
        'User',
        'StudentHistory',
        'Lesson',
        'File',
        'Tag',
        'Category',
        'Test',
        'Question',
        'Answer',
        'Comment',
        'StudentBlock'
    );

    public function beforeFilter() {
        $this->pageTitle = '先生';
        $this->layout = 'template';
        $UserType = $this->Auth->user('UserType');
        if ($UserType == 1) {
            $this->redirect(array('controller' => 'Student', 'action' => 'index'));
        } else if ($UserType == 3) {
            $this->redirect(array('controller' => 'Admin', 'action' => 'home'));
        } else {
            
        }
        return parent::beforeFilter();
    }

    public function index() {
        $this->pageTitle = 'ホームページ';
        $userId = $this->Auth->user('UserId');
        $lessons = $this->Lesson->getLessonsByTeacher($userId);
        foreach ($lessons as $key => $value) {
            $file = $this->File->find('first', array(
                'conditions' => array(
                    'File.LessonId' => $value['Lesson']['LessonId'],
                    'File.IsDeleted' => '0',
                    'File.FileType' => '1',
                ),
                'contain' => false,
                'order' => array('File.FileId' => 'Asc'),
                )
            );
            if (!empty($file)) {
                $lessons[$key]['FileId'] = $file['File']['FileId'];
            } else {
                $lessons[$key]['FileId'] = 0;
            }
        }
        $this->set('lessons', $lessons);
        $cat = $this->Category->getCategories();
        $Category = array();
        foreach ($cat as $key => $value) {
            $Category[$key + 1] = $value['Category']['CatName'];
        }
        $this->set('Category', $Category);
        
        //Get top lesson
        if (isset($this->request->query['top']) && $this->request->query['top'] == 'lesson') {
            $this->Lesson->virtualFields = array(
                'Author' => 'User.Username'
            );
            $this->Paginator->settings = array(
                'conditions' => array('Lesson.IsDeleted' => '0','User.Status'=>'1'),
                'limit' => 15,
                'fields'=> array(
                    'Lesson.*','Lesson.Author'
                ),
                'contain' => array('User'),
            );
            $topLessons = $this->Paginator->paginate('Lesson');
            $this->set('topLessons', $topLessons);
        } else {
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
                'contain' => array('Lesson'),
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

    public function view_lesson($lesson_id = null, $file_id = null) {
        $this->pageTitle = '授業';
        //top teacher
        $allLessons = $this->Lesson->getAllLessons();
        $this->set('allLessons', $allLessons);
        $userId = $this->Auth->user('UserId');
        if (!isset($lesson_id) || empty($lesson_id)) {
            $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
            $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
        } else {
            if ($this->request->is('post')) {
                $userInfo = $this->Auth->user();
                $userId = $userInfo['UserId'];
                $comment = trim($this->request->data("comment"));
                if (!empty($comment)) {
                    $this->Comment->create();
                    $data['Comment']['UserId'] = $userId;
                    $data['Comment']['LessonId'] = $lesson_id;
                    $data['Comment']['Content'] = $comment;
                    if ($this->Comment->save($data)) {
                        $this->Session->setFlash(__('コメント成功！'));
                        $this->redirect($this->referer());
                    } else {
                        $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
                        $this->redirect($this->referer());
                    }
                } else {
                    $this->Session->setFlash(__('Require is comment!.'));
                    $this->redirect($this->referer());
                }
            } else {
                $this->set(compact('lesson_id'));
                $test = $this->Test->find('first', array(
                    'conditions' => array(
                        'Test.LessonId' => $lesson_id,
                        'IsDeleted' => '0',
                    ),
                    'contain' => false,
                    'order' => array('Test.TestId' => 'Asc'),
                        )
                );
                if (!empty($test)) {
                    $test_id = $test['Test']['TestId'];
                } else {
                    $test_id = 0;
                }
                $this->set(compact('test_id'));
                if (!isset($file_id)) {
                    $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
                    $this->redirect(array('controller' => 'teacher', 'action' => 'index'));
                } elseif ($file_id == 0) {
                    $this->Session->setFlash(__('ファイルは存在しません。'));
                    $this->redirect(array('controller' => 'teacher', 'action' => 'index'));
                } else {
                    $file = $this->File->find('first', array(
                        'conditions' => array(
                            'File.FileId' => $file_id,
                            'File.IsDeleted' => '0',
                            'File.FileType' => '1',
                        ),
                        'order' => array('File.FileId' => 'Asc'),
                            )
                    );
                    if (empty($file)) {
                        $this->Session->setFlash(__('ページにアクセスすることはできません'));
                        $this->redirect(array('controller' => 'teacher', 'action' => 'index'));
                    }
                    if ($file['File']['LessonId'] != $lesson_id) {
                        $this->Session->setFlash(__('ページにアクセスすることはできません'));
                        $this->redirect(array('controller' => 'teacher', 'action' => 'index'));
                    }
                    // debug($test);
                    $this->set(compact('file_id'));
                    $list_file = $this->File->find('all', array(
                        'conditions' => array(
                            'File.LessonId' => $lesson_id,
                            'File.IsDeleted' => '0',
                            'File.FileType' => '1',
                        ),
                        'contain' => false,
                        'order' => array('File.FileId' => 'Asc'),
                            )
                    );
                    $this->set(compact('list_file'));
                    $params = array(
                        'conditions' => array(
                            'Lesson.LessonId' => $lesson_id,
                            'Lesson.IsDeleted' => '0'
                        ),
                        'contain' => array(
                            'File' => array(
                                'conditions' => array('File.FileType' => '1', 'File.IsDeleted' => '0', 'FileId' => $file_id)
                            ),
                            'Tag',
                            'User',
                        )
                    );
                    $lesson = $this->Lesson->find('first', $params);
                    $com = $this->Comment->find('all', array(
                        'conditions' => array(
                            'IsDeleted' => '0',
                            'LessonId' => $lesson_id,
                        ),
                        'order' => array('Comment.created' => 'Asc'),
                        'contain' => array(
                            'User' => array(
                                'conditions' => array('User.Status' => '1'),
                                'fields' => 'User.FullName',
                            )
                        )
                    ));
                    if (!empty($com)) {
                        $this->set(compact('com'));
                    }
                    // debug($com);
                    if (!empty($lesson)) {
                        if ($lesson['Lesson']['UserId'] != $userId) {
                            $this->Session->setFlash(__('このページにアクセスすることはできません'));
                            $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
                        } else {
                            $this->set(compact('lesson'));
                            $cat = $this->Category->find('first', array(
                                'conditions' => array('Category.CatID' => $lesson['Lesson']['Category'], 'IsDeleted' => '0'),
                                'fields' => array('CatName'),
                                    )
                            );
                            if (!empty($cat)) {
                                $this->set(compact('cat'));
                            }
                        }
                    } else {
                        $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
                    }
                }
            }
        }
    }

    public function make_lesson($userId = null) {
        $this->pageTitle = 'Make Lesson';
        // Check UserId
        if ($userId != $this->Auth->user('UserId')) {
            $userId = $this->Auth->user('UserId');
            $this->redirect(array('controller' => 'teacher', 'action' => 'make_lesson', $userId));
        }
        // Get list category 
        $params = array(
            'conditions' => array('Category.IsDeleted' => '0'),
            'fields' => array('CatId', 'CatName'),
            'order' => array('Category.CatId' => 'Asc'),
        );
        $cat = $this->Category->find('all', $params);
        $this->set(compact('cat'));
        if ($this->request->is('post')) {
            $data = $this->request->data;
            // debug($data);
            // die;
            if ($data['Lesson']['TermsOfService'] == 1) {
                $this->Lesson->create();
                $userId = $this->Auth->user('UserId');
                //make lesson
                $this->Lesson->set('UserId', $userId);
                if ($this->Lesson->save($data, true)) {
                    // Get lesson id
                    $lesson = $this->Lesson->find('first', array(
                        'conditions' => array('Lesson.UserId' => $userId),
                        'fields' => array('Lesson.LessonId'),
                        'order' => array('Lesson.created' => 'desc'),
                        'contain' => False,
                    ));
                    $lesson_id = $lesson['Lesson']['LessonId'];
                    // Save Tag of lesson
                    $tag = $data['Lesson']['Tag'];
                    $tag = strtolower($tag);
                    $tag = explode(",", $tag);
                    if (isset($tag) && !empty($tag)) {
                        foreach ($tag as $value) {
                            $value = trim($value);
                            $this->Tag->create();
                            $data1['Tag']['LessonId'] = $lesson_id;
                            $data1['Tag']['TagContent'] = $value;
                            if ($this->Tag->save($data1)) {
                                
                            } else {
                            	$this->Lesson->delete($lesson_id);
                            	$this->Session->setFlash(__('タグは作成できませんでした。 、もう一度お試しください。'));
                            	$this->redirect(array('controller' => 'teacher', 'action' => 'make_lesson', $userId));
                            }
                        }
                    }
                    // Save file of lesson
                    $num_file = 0 ;
                    foreach ($data['File'] as $key => $value) {
		            	if(!empty($value['path']['name'])){
		            		//check duplicate file name 
		            		$options['conditions'] = array(
				                'File.FileName' => $value['path']['name'],
				                'File.IsDeleted' => '0',
				  				'Lesson.IsDeleted' => '0',
				  				'Lesson.UserId' =>$userId,
				            );
		            		$options['fields'] = array('Lesson.UserId', 'File.*');
		            		$file_name = $this->File->find('all',$options);
		            		// debug($file_name);
		            		// die;
		            		if(!empty($file_name)){
		            			$this->Lesson->delete($lesson_id);
		            			$this->Tag->deleteAll(array('Tag.LessonId' => $lesson_id), false);
		            			$this->Session->setFlash(__('このファイルはすでに存在しています。あなたがアップロードすることはできません。'));
                            	$this->redirect(array('controller' => 'teacher', 'action' => 'make_lesson', $userId));
		            		}
		            		$data['File'][$key]['path']['old_name'] = $value['path']['name'];
		            		$num_file ++;
		            		$type =  explode("/", $value['path']['type']);
		            		$type = $type['1'];
		            		//formatName LessonId_FileNum_Size.Type
		            		$name = 'File'.'_'.$lesson_id.'_'.$num_file.'_'.$value['path']['size'].'.'.$type;
		            		$data['File'][$key]['path']['name'] = $name;
		            	}            
		            }
		            // debug($data);
                    if ($num_file!=0) {
                        foreach ($data['File'] as $key => $value) {
                            $this->File->create();
                            $param1['File']['File'] = $value['path'];
                            $param1['File']['LessonId'] = $lesson_id;
                            $param1['File']['FileType'] = '1';
                            $param1['File']['FileName'] = $value['path']['old_name'];
                            // debug($param1);
                            if ($this->File->save($param1)) {
                                $File = $this->File->find('first', array(
			                            'conditions' => array('File.LessonId' => $lesson_id),
			                            'fields' => array('File.FileId'),
			                            'order' => array('File.created' => 'Asc'),
			                            'contain' => False,
			                        ));
			                 	if(!empty($File)){
			                    	$file_id = $File['File']['FileId'];
			                    }
                            } else {
                            	$this->Lesson->delete($lesson_id);
                            	$this->Tag->deleteAll(array('Tag.LessonId' => $lesson_id), false);
                            	$this->Session->setFlash(__('ファイルは保存できませんでした。 、もう一度お試しください。'));
                            	$this->redirect(array('controller' => 'teacher', 'action' => 'make_lesson', $userId));         
                            }
                        }
                    }
                    // Save test of lesson
                    $num_test = 0 ;
                    foreach ($data['TestFile'] as $key => $value) {
		            	if(!empty($value['path']['name'])){
		            		$file_name = $this->File->find('first',array(
		            			'conditions' => array('File.LessonId' => $lesson_id,'File.FileName' => $value['path']['name']),
	                            'fields' => array('File.FileId'),
	                            'order' => array('File.created' => 'Asc'),
	                            'contain' => False,
		            			)
		            		);
		            		if(!empty($file_name)){
		            			$this->Session->setFlash(__('このファイルはすでに存在しています。あなたがアップロードすることはできません。'));
                            	$this->redirect(array('controller' => 'teacher', 'action' => 'make_lesson', $userId));
		            		}
		            		$data['TestFile'][$key]['path']['old_name'] = $value['path']['name'];
		            		$num_test ++;
		            		$type =  explode("/", $value['path']['type']);
		            		$type = $type['1'];
		            		//formatName LessonId_FileNum_Size_Type
		            		$name = 'Test'.'_'.$lesson_id.'_'.$num_test.'_'.$value['path']['size'].'.'.$type;
		            		$data['TestFile'][$key]['path']['name'] = $name;
		            	}            
		            }
                    if ($num_test!=0) {
                        foreach ($data['TestFile'] as $key => $value) {
                            $this->File->create();
                            $param2['File']['TestFile'] = $value['path'];
                            $param2['File']['LessonId'] = $lesson_id;
                            $param2['File']['FileType'] = '2';
                            $param2['File']['FileName'] = $value['path']['old_name'];
                            if ($this->File->save($param2)) {
                                $test_tmp = $this->File->find('first', array(
                                    'conditions' => array('File.LessonId' => $lesson_id, 'File.FileType' => '2'),
                                    'fields' => array('File.FileId', 'FileLink'),
                                    'order' => array('File.FileId' => 'desc'),
                                    'contain' => False,
                                ));
                                $link = $test_tmp['File']['FileLink'];
                                $link = substr($link, 1);
                                $excel = $this->Readtsv->loadFile($link);
                                $test = array();
                                $quest = array();
                                $answer = array();
                                $Answer = array();
                                $test['Test']['Title'] = $this->Readtsv->getCell(1, 2);
                                $test['Test']['SubTitle'] = $this->Readtsv->getCell(2, 2);
                                $test['Test']['LessonId'] = $lesson_id;
                                if ($this->Test->save($test)) {
                                    $Test = $this->Test->find('first', array(
	                                    'conditions' => array('Test.LessonId' => $lesson_id),
	                                    'fields' => array('Test.TestId'),
	                                    'order' => array('Test.created' => 'Asc'),
	                                    'contain' => False,
	                                ));
	                                $test_id = $Test['Test']['TestId'];
	                                $i = 3;
	                                $num = 1;
	                                $Answer[$num]['Num'] = 0;
	                                while (strcmp($this->Readtsv->getCell($i, 1), 'End') != 0) {

	                                    if (strcmp($this->Readtsv->getCell($i, 1), '#') == 0) {
	                                        $i++;
	                                        continue;
	                                    }
	                                    if (strcmp($this->Readtsv->getCell($i, 1), 'Q(' . $num . ')') == 0 && $Answer[$num]['Num'] == 0 && strcmp($this->Readtsv->getCell($i + 1, 1), 'Q(' . $num . ')') == 0) {
	                                        $Answer[$num]['Start'] = $i;
	                                        $Answer[$num]['Num'] = $Answer[$num]['Num'] + 1;
	                                        $i++;
	                                        continue;
	                                    } else if (strcmp($this->Readtsv->getCell($i, 1), 'Q(' . $num . ')') == 0 && $Answer[$num]['Num'] != 0 && strcmp($this->Readtsv->getCell($i + 1, 1), 'Q(' . $num . ')') == 0) {
	                                        $Answer[$num]['Num'] = $Answer[$num]['Num'] + 1;
	                                        $i++;
	                                        continue;
	                                    } else if (strcmp($this->Readtsv->getCell($i, 1), 'Q(' . $num . ')') == 0 && $Answer[$num]['Num'] != 0 && strcmp($this->Readtsv->getCell($i + 1, 1), 'Q(' . $num . ')') != 0) {
	                                        $Answer[$num]['Num'] = $Answer[$num]['Num'] + 1;
	                                        $num = $num + 1;
	                                        $Answer[$num]['Num'] = 0;
	                                        $i++;
	                                        continue;
	                                    } else {
	                                        $i++;
	                                        continue;
	                                    }
	                                }
	                                foreach ($Answer as $key => $value) {
	                                    if ($value['Num'] != 0) {
	                                        $quest['Question']['TestId'] = $test_id;
	                                        $quest['Question']['QuesNumber'] = $key;
	                                        $quest['Question']['QuesContent'] = $this->Readtsv->getCell($value['Start'], 3);
	                                        $quest['Question']['QuesAnswer'] = $this->Readtsv->getCell($value['Start'] + $value['Num'] - 1, 3);
	                                        $quest['Question']['Point'] = $this->Readtsv->getCell($value['Start'] + $value['Num'] - 1, 4);
	                                        $this->Question->create();
	                                        if ($this->Question->save($quest)) {
	                                            $Quest = $this->Question->find('first', array(
		                                            'conditions' => array('Question.TestId' => $test_id, 'Question.QuesNumber' => $key),
		                                            'fields' => array('Question.QuesId'),
		                                            'contain' => False,
		                                        ));
		                                        $quest_id = $Quest['Question']['QuesId'];
		                                        $h = 1;
		                                        for ($j = $value['Start'] + 1; $j < $value['Start'] + $value['Num'] - 1; $j++) {
		                                            $answer['Answer']['QuesId'] = $quest_id;
		                                            $answer['Answer']['AnswerNumber'] = $h;
		                                            $answer['Answer']['AnswerContent'] = $this->Readtsv->getCell($j, 3);
		                                            $this->Answer->create();
		                                            if ($this->Answer->save($answer)) {
		                                                
		                                            } else {
		                                            	$this->Lesson->delete($lesson_id);
		                            					$this->Tag->deleteAll(array('Tag.LessonId' => $lesson_id), false);
		                            					$this->File->deleteAll(array('File.LessonId' => $lesson_id), false);
		                            					$this->Test->deleteAll(array('Test.LessonId' => $lesson_id), false);
		                            					$this->Question->deleteAll(array('Question.TestId' => $test_id), false);
		                            					$this->Session->setFlash(__('答えは作成できませんでした。 、もう一度お試しください。'));
		                            					$this->redirect(array('controller' => 'teacher', 'action' => 'make_lesson', $userId));
		                                                
		                                            }
		                                            $h++;
		                                        }
	                                        } else {
	                                        	$this->Lesson->delete($lesson_id);
                            					$this->Tag->deleteAll(array('Tag.LessonId' => $lesson_id), false);
                            					$this->File->deleteAll(array('File.LessonId' => $lesson_id), false);
                            					$this->Test->deleteAll(array('Test.LessonId' => $lesson_id), false);
                            					$this->Session->setFlash(__('クエストは作成できませんでした。 、もう一度お試しください。'));
                            					$this->redirect(array('controller' => 'teacher', 'action' => 'make_lesson', $userId));
	                                            
	                                        }
	                                    }
	                                }
                                } else {
                                	$this->Lesson->delete($lesson_id);
                            		$this->Tag->deleteAll(array('Tag.LessonId' => $lesson_id), false);
                            		$this->File->deleteAll(array('File.LessonId' => $lesson_id), false);
                            		$this->Session->setFlash(__('テストは作成できませんでした。 、もう一度お試しください。'));
                            		$this->redirect(array('controller' => 'teacher', 'action' => 'make_lesson', $userId));
                                    
                                }
                            } else {
                                $this->Session->setFlash(__('ファイルは保存できませんでした。 、もう一度お試しください。'));
                            }
                        }
                    }

                    $this->redirect(array('controller' => 'teacher', 'action' => 'view_lesson', $lesson_id,$file_id));
                } else {
                	$this->Session->setFlash(__('レッスンを作ることができなかった。もう一度やり直してください。'));        
                	// $this->redirect(array('controller' => 'teacher', 'action' => 'make_lesson', $userId));
                }
                    
            } else {
                $this->Session->setFlash(__('利用規約をご確認ください'));
            }
        }
    }

    public function view_test($lesson_id = null, $test_id = null) {
        $this->pageTitle = 'テスト';
        $userId = $this->Auth->user('UserId');
        if (!isset($lesson_id) || empty($lesson_id)) {
            $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
            $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
        } else {
            $params = array(
                'conditions' => array(
                    'Lesson.LessonId' => $lesson_id,
                    'Lesson.IsDeleted' => '0'
                ),
                'contain' => array(
                    'User',
                )
            );
            $lesson = $this->Lesson->find('first', $params);
            if (!empty($lesson)) {
                if ($lesson['Lesson']['UserId'] != $userId) {
                    $this->Session->setFlash(__('このページにアクセスすることはできません'));
                    $this->redirect(array('controller' => 'teacher', 'action' => 'index'));
                } else {
                    $this->set(compact('lesson_id'));
                    if (!isset($test_id)) {
                        $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
                        $this->redirect(array('controller' => 'teacher', 'action' => 'index'));
                    } elseif ($test_id == 0) {
                    	$file = $this->File->find('first', array(
			                'conditions' => array(
			                    'File.LessonId' => $lesson_id,
			                    'File.IsDeleted' => '0',
			                    'FileType' => '1',
			                ),
			                'contain' => false,
			                'order' => array('File.FileId' => 'Asc'),
			            ));
                        $this->Session->setFlash(__('テストは存在しません。'));
                        $this->redirect(array('controller' => 'teacher', 'action' => 'view_lesson', $lesson_id,$file['File']['FileId']));
                    } else {
                        $test = $this->Test->find('first', array(
                            'conditions' => array(
                                'Test.TestId' => $test_id,
                                'Test.IsDeleted' => '0',
                            ),
                            'order' => array('Test.TestId' => 'Asc'),
                                )
                        );
                        // debug($test);
                        if (empty($test)) {
                            $this->Session->setFlash(__('ページにアクセスすることはできません'));
                            $this->redirect(array('controller' => 'Student', 'action' => 'index'));
                        }
                        if ($test['Test']['LessonId'] != $lesson_id) {
                            $this->Session->setFlash(__('ページにアクセスすることはできません'));
                            $this->redirect(array('controller' => 'Student', 'action' => 'index'));
                        }
                        $this->set(compact('test_id'));
                        $list_test = $this->Test->find('all', array(
                            'conditions' => array(
                                'Test.LessonId' => $lesson_id,
                                'Test.IsDeleted' => '0',
                            ),
                            'contain' => false,
                            'order' => array('Test.TestId' => 'Asc'),
                                )
                        );
                        $this->set(compact('list_test'));
                        $data_test = array();
                        $data_test['Title'] = $test['Test']['Title'];
                        $data_test['SubTitle'] = $test['Test']['SubTitle'];
                        if (isset($test['Question']) && !empty($test['Question'])) {
                            $i = 0;
                            $j = 0;
                            foreach ($test['Question'] as $key => $value) {
                                $i++;
                                $data_test['Question'][$i]['Content'] = $value['QuesContent'];
                                $data_test['Question'][$i]['QuesNum'] = $value['QuesNumber'];
                                $j = $j + $value['Point'];
                                $tmp = strstr($value['QuesAnswer'], ')', true);
                                $tmp = substr($tmp, 2);
                                $tmp = (int) $tmp;
                                $data_test['Question'][$i]['Answer'] = $tmp;
                                $data_test['Question'][$i]['Point'] = $value['Point'];
                                $data_test['Question'][$i]['An'] = $this->Answer->find('all', array(
                                    'conditions' => array('Answer.QuesId' => $value['QuesId']),
                                    'order' => array('Answer.AnswerNumber' => 'Asc'),
                                        )
                                );
                            }
                            $data_test['Total'] = $i;
                            $data_test['TotalPoint'] = $j;
                        }
                        $this->set(compact('data_test'));
                        // debug($data_test);
                    }
                }
            } else {
                $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
            }
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

    public function delete_lesson($lesson_id = null) {
        $this->pageTitle = '授業';
        $userId = $this->Auth->user('UserId');
        if ($this->request->is('post')) {
            if (isset($this->request->data['submit']) && isset($this->request->data['User']['lesson_id'])) {
                $lesson_id = $this->request->data['User']['lesson_id'];
                if ($this->request->data['submit'] == 'はい') {
                    $lesson = $this->Lesson->find('first', array(
                        'conditions' => array('LessonId' => $lesson_id),
                    ));
                    if ($lesson != null) {
                        if ($lesson['Lesson']['UserId'] == $userId) {
                            if ($lesson['Author']['Status'] == 1) {
                                if($this->Lesson->updateAll(array('IsDeleted'=>'1'),array('LessonId'=>$lesson_id))){
                                    $this->Session->setFlash('授業削除できました');
                                } else {
                                    $this->Session->setFlash('エラーが発生された、授業削除できなかった。もう一度やってみてください');
                                }
                            } else {
                                $this->Session->setFlash('今のアカウントの状態で授業削除できない');
                            }
                        } else {
                            $this->Session->setFlash('授業のオーナーしか授業削除できない');
                        }
                    } else {
                        $this->Session->setFlash('授業が見つけない');
                    }
                    $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
                } else {
                    $this->redirect($this->Session->read('referer'));
                }
            } else {
                $this->Session->setFlash('授業削除失敗');
                $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
            }
        } else {
            if ($lesson_id != null) {
                $this->Session->write('referer', $this->referer());
                $this->set('lesson_id', $lesson_id);
            } else {
                $this->Session->setFlash('授業IDがありません。授業削除できない');
                $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
            }
        }
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
            //debug($studentBlocks);
            if (count($studentBlocks) <= 0) {
                $this->StudentBlock->create();
                $this->StudentBlock->set('UserId', $userId);
                $this->StudentBlock->set('LessonId', $lessonId);
                $this->StudentBlock->save();

                $this->set('result', 'このユーザーブロックが成功です');
                $this->set('lessonId', $lessonId);

                $this->StudentHistory->updateAll(
                        array('StudentHistory.Blocked' => '1'), array('StudentHistory.UserId' => $userId,
                    'StudentHistory.LessonId' => $lessonId)
                );
            } else {
                $this->redirect(array('action' => 'list_student/' . $lessonId));
            }
        }
    }

}

?>