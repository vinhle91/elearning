<?php

/**
 * @copyright Copyright (c) 2013 mrhieusd
 */
class StudentController extends AppController {

    /**
     * index
     */
    public $components = array('Paginator', 'RequestHandler');
    public $helpers = array('Js');
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
        'File',
        'Report'
    );

    function beforeFilter() {
        $this->pageTitle = '学生';
        $this->layout = 'template';
        $UserType = $this->Auth->user('UserType');
        if ($UserType == 2) {
            $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
        } else if ($UserType == 3) {
            $this->redirect(array('controller' => 'Admin', 'action' => 'home'));
        } else {
            
        }
        return parent::beforeFilter();
    }

    public function index() {
        $this->pageTitle = '学生';
        $userId = $this->Auth->user('UserId');
        $today = new DateTime();
        //Get history of student
        if (isset($this->request->query['sortBy']) && isset($this->request->query['direction'])) {
            $sortBy = $this->request->query['sortBy'];
            $direction = $this->request->query['direction'];
        } else {
            $sortBy = 'time';
            $direction = 'DESC';
        }
        $this->StudentHistory->virtualFields = array(
            'LikeNumber' => 'Lesson.LikeNumber',
            'ViewNumber' => 'Lesson.ViewNumber'
        );
        switch ($sortBy) {
            case 'like':
                $order = 'StudentHistory.LikeNumber ' . $direction;
                break;
            case 'view':
                $order = 'StudentHistory.ViewNumber ' . $direction;
                break;
            default:
                $order = 'StudentHistory.ExpiryDate ' . $direction;
                break;
        }
        if ($direction == 'DESC') {
            $direction = 'ASC';
        } else {
            $direction = 'DESC';
        }
        $histories = $this->StudentHistory->find('all', array(
            'conditions' => array(
                'StudentHistory.UserId' => $userId,
                'CURDATE() BETWEEN DATE(StudentHistory.StartDate) AND DATE(StudentHistory.ExpiryDate)'
            ),
            'order' => $order,
        ));
        foreach ($histories as $key => $value) {
            $test = $this->Test->find('first', array(
                'conditions' => array(
                    'Test.LessonId' => $value['Lesson']['LessonId'],
                    'Test.IsDeleted' => '0',
                ),
                'contain' => false,
                'order' => array('Test.TestId' => 'Asc'),
                    )
            );
            if (!empty($test)) {
                $histories[$key]['TestId'] = $test['Test']['TestId'];
            } else {
                $histories[$key]['TestId'] = 0;
            }
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
                $histories[$key]['FileId'] = $file['File']['FileId'];
            } else {
                $histories[$key]['FileId'] = 0;
            }
        }
        $this->set('histories', $histories);
        $this->set('direction', $direction);
        //Get category
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
                'conditions' => array('IsDeleted' => '0'),
                'limit' => 15,
                'fields'=> array(
                    'Lesson.*','Lesson.Author'
                ),
                'contain' => array('User'),
            );
            $topLessons = $this->Paginator->paginate('Lesson');
            foreach ($topLessons as $key => $value) {
                $isStudying = false;
                $isBlocked = $this->StudentBlock->find('first', array(
                    'conditions' => array(
                        'StudentBlock.UserId' => $userId,
                        'StudentBlock.LessonId' => $value['Lesson']['LessonId'],
                    )
                        )
                );
                if ($isBlocked) {
                    $topLessons[$key]['Lesson']['isBlocked'] = 1;
                } else {
                    $topLessons[$key]['Lesson']['isBlocked'] = 0;
                }
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
                $topLessons[$key]['Lesson']['isStudying'] = $isStudying;
            }
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

    public function view_lesson($lesson_id = null, $file_id = null) {
        $this->pageTitle = '授業';
        $userId = $this->Auth->user('UserId');
        $today = new DateTime();
        //top lesson
        $allLessons = $this->Lesson->getAllLessons();
        $this->set('allLessons', $allLessons);
        if (!isset($lesson_id) || empty($lesson_id)) {
            $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
            $this->redirect(array('controller' => 'student', 'action' => 'index'));
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
                //Get test of lesson
                $test = $this->Test->find('first', array(
                    'conditions' => array(
                        'Test.LessonId' => $lesson_id,
                        'Test.IsDeleted' => '0',
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
                    $this->redirect(array('controller' => 'student', 'action' => 'index'));
                } elseif ($file_id == 0) {
                    $this->Session->setFlash(__('ファイルは存在しません。'));
                    $this->redirect(array('controller' => 'student', 'action' => 'index'));
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
                        $this->redirect(array('controller' => 'student', 'action' => 'index'));
                    }
                    if ($file['File']['LessonId'] != $lesson_id) {
                        $this->Session->setFlash(__('ページにアクセスすることはできません'));
                        $this->redirect(array('controller' => 'student', 'action' => 'index'));
                    }
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
                        $isStudying = false;
                        $study_history = $this->StudentHistory->find('first', array(
                            'conditions' => array(
                                'StudentHistory.LessonId' => $lesson_id,
                                'StudentHistory.UserId' => $userId
                            ),
                            'order' => array('StudentHistory.ExpiryDate' => 'DESC'),
                                )
                        );
                        // debug($study_history);
                        if ($study_history) {
                            $this->set(compact('study_history'));
                            $expiryDay = new DateTime($study_history['StudentHistory']['ExpiryDate']);
                            if ($today < $expiryDay) {
                                $isStudying = true;
                            }
                        }
                        if (!$isStudying) {
                            $this->Session->setFlash(__('ページにアクセスすることはできません'));
                            $this->redirect(array('controller' => 'Student', 'action' => 'index'));
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
                        $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
                        $this->redirect(array('controller' => 'teacher', 'action' => 'index'));
                    }
                }
            }
        }
    }

    public function test($lesson_id = null, $test_id = null) {
        $this->pageTitle = 'テスト';
        $userId = $this->Auth->user('UserId');
        $today = new DateTime();
        if (!isset($lesson_id)) {
            $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
            $this->redirect(array('controller' => 'student', 'action' => 'index'));
        } else {
            $isStudying = false;
            $study_history = $this->StudentHistory->find('first', array(
                'conditions' => array(
                    'StudentHistory.LessonId' => $lesson_id,
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
            if (!$isStudying) {
                $this->Session->setFlash(__('このテストを行うことはできません。'));
                $this->redirect(array('controller' => 'student', 'action' => 'view_lesson', $lesson_id));
            } else {
                if (!isset($test_id)) {
                    $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
                    $this->redirect(array('controller' => 'student', 'action' => 'index'));
                } elseif ($test_id == 0) {
                    $this->Session->setFlash(__('テストは存在しません。'));
                    $this->redirect(array('controller' => 'student', 'action' => 'view_lesson', $lesson_id));
                } else {
                    $this->set(compact('lesson_id'));
                    $test = $this->Test->find('first', array(
                        'conditions' => array(
                            'Test.TestId' => $test_id,
                            'Test.IsDeleted' => '0',
                        ),
                        'order' => array('Test.TestId' => 'Asc'),
                            )
                    );
                    if (empty($test)) {
                        $this->Session->setFlash(__('ページにアクセスすることはできません'));
                        $this->redirect(array('controller' => 'Student', 'action' => 'index'));
                    }
                    if ($test['Test']['LessonId'] != $lesson_id) {
                        $this->Session->setFlash(__('ページにアクセスすることはできません'));
                        $this->redirect(array('controller' => 'Student', 'action' => 'index'));
                    }
                    // debug($test);
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
                    if ($this->request->is('post')) {
                        $test_result = $this->request->data;
                        $n = 0;
                        foreach ($test_result as $key => $value) {
                            if ($value == 0) {
                                $n++;
                            }
                        }
                        if ($n != 0) {
                            $this->Session->setFlash(__('あなたはすべての答えを完了していない！'));
                        } else {
                            $test_result['0'] = 1;
                            $total_ans_correct = 0;
                            $point = 0;
                            $answer = '';
                            foreach ($data_test['Question'] as $key => $value) {
                                if ($value['Answer'] == $test_result[$value['QuesNum']]) {
                                    $total_ans_correct++;
                                    $point = $point + $value['Point'];
                                }
                                $answer = $answer . $value['Answer'] . ',';
                            }
                            $this->set(compact('point', 'total_ans_correct'));
                            $data['StudentTest']['UserId'] = $userId;
                            $data['StudentTest']['TestId'] = $test_id;
                            $data['StudentTest']['Answer'] = $answer;
                            $data['StudentTest']['Point'] = $point;
                        }
                        $this->set(compact('test_result'));
                    }
                }
            }
        }
    }

    public function view_result($lesson_id = null) {
        $this->pageTitle = 'View Test Result';
        $userId = $this->Auth->user('UserId');
        if (!isset($lesson_id) || empty($lesson_id)) {
            $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
        } else {
            $this->set(compact('lesson_id'));
            $test = $this->Test->find('all', array(
                'conditions' => array(
                    'Test.LessonId' => $lesson_id,
                    'Test.IsDeleted' => '0',
                ),
                'order' => array('Test.TestId' => 'Asc'),
                    )
            );
            // debug($test);
            $data_test = array();
            foreach ($test as $key => $value) {
                $data_test['Title'] = $value['Test']['Title'];
                $data_test['SubTitle'] = $value['Test']['SubTitle'];
                if (isset($value['Question']) && !empty($value['Question'])) {
                    $i = 0;
                    $j = 0;
                    foreach ($value['Question'] as $key => $value) {
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
            }
            $this->set(compact('data_test'));
        }
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
            $isBlocked = $this->StudentBlock->find('first', array(
                'conditions' => array(
                    'StudentBlock.UserId' => $userId,
                    'StudentBlock.LessonId' => $value['Lesson']['LessonId'],
                )
                    )
            );
            if ($isBlocked) {
                $lessons[$key]['Lesson']['isBlocked'] = 1;
            } else {
                $lessons[$key]['Lesson']['isBlocked'] = 0;
            }
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
            $lessons[$key]['Lesson']['isStudying'] = $isStudying;
        }
        $this->set('lessons', $lessons);
    }

    public function buy_lesson($lessonId = null) {
        if (empty($lessonId)) {
            $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
            $this->redirect(array('controller' => 'Student', 'action' => 'index'));
        } else {
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
                $this->Session->setFlash(__('このレッスンを表示するには許可されていません'));
                $this->redirect(array('controller' => 'Student', 'action' => 'index'));
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
                    $this->Session->setFlash(__('このレッスンを表示するには許可されていません'));
                    $this->redirect(array('controller' => 'Student', 'action' => 'index'));
                } else {
                    $lesson = $this->Lesson->find('first', array(
                        'conditions' => array(
                            'Lesson.LessonId' => $lessonId,
                            'Lesson.IsDeleted' => '0',
                        ),
                        'contain' => false,
                            )
                    );
                    if (empty($lesson)) {
                        $this->Session->setFlash(__('Error. Please try it again'));
                        $this->redirect(array('controller' => 'Student', 'action' => 'index'));
                    } else {
                        $file = $this->File->find('first', array(
                            'conditions' => array(
                                'File.LessonId' => $lessonId,
                                'File.IsDeleted' => '0',
                                'File.FileType' => '1',
                            ),
                            'contain' => false,
                            'order' => array('File.FileId' => 'Asc'),
                                )
                        );
                        if (!empty($file)) {
                            $file_id = $file['File']['FileId'];
                        } else {
                            $file_id = 0;
                        }
                        $updateViewNumber = $lesson['Lesson']['ViewNumber'] + 1;
                        //update view number
                        $this->StudentHistory->create();
                        $data['StudentHistory']['UserId'] = $userId;
                        $data['StudentHistory']['LessonId'] = $lessonId;
                        $data['StudentHistory']['StartDate'] = $today->format('Y-m-d H:i:s');
                        $data['StudentHistory']['ExpiryDate'] = date('Y-m-d H:i:s', strtotime("+1 week"));
                        $data['StudentHistory']['CourseFee'] = $fee;
                        if ($this->StudentHistory->save($data)) {
                            $this->Lesson->updateAll(array("ViewNumber" => $updateViewNumber), array('Lesson.LessonId' => $lessonId));
                            $this->Session->setFlash(__('このレッスンを買った'));
                            $this->redirect(array('controller' => 'Student', 'action' => 'view_lesson', $lessonId, $file_id));
                        } else {
                            $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
                            $this->redirect(array('controller' => 'Student', 'action' => 'index'));
                        }
                    }
                }
            } else {
                $this->Session->setFlash(__('すでにこのレッスンを購入した'));
                $this->redirect(array('controller' => 'Student', 'action' => 'index'));
            }
        }
    }

    public function like_lesson($lesson_id = null) {
        if ($this->RequestHandler->isAjax() && $lesson_id != null) {
            $this->autoRender = false;
            $params = array(
                'conditions' => array(
                    'Lesson.LessonId' => $lesson_id,
                    'IsDeleted' => '0'
                ),
            );
            $lesson = $this->Lesson->find('first', $params);
            $userId = $this->Auth->user('UserId');
            $isStudying = false;
            $study_history = $this->StudentHistory->find('first', array(
                'conditions' => array(
                    'StudentHistory.LessonId' => $lesson_id,
                    'StudentHistory.UserId' => $userId
                ),
                'order' => array('StudentHistory.StartDate' => 'DESC'),));
            if ($study_history != null) {
                $today = new DateTime();
                $expiryDay = new DateTime($study_history['StudentHistory']['ExpiryDate']);
                if ($today < $expiryDay) {
                    $isStudying = true;
                }
            }
            if ($isStudying) {
                if ($study_history['StudentHistory']['IsLike'] == 0) {
                    if ($this->StudentHistory->updateAll(array("IsLike" => 1), array("StudentHistory.LessonId" => $lesson_id, "StudentHistory.UserId" => $userId))) {
                        if ($lesson != null) {
                            $likenumber = $lesson['Lesson']['LikeNumber'];
                            $likenumber += 1;
                            if ($likenumber > 0) {
                                $this->Lesson->updateAll(array('LikeNumber' => $likenumber), array('LessonId' => $lesson_id));
                            }
                        }
                        echo "嫌い";
                    } else {
                        $this->Session->setFlash("エラーが発生した、もう一度お願いします");
                    }
                } else {
                    if ($this->StudentHistory->updateAll(array("IsLike" => 0), array("StudentHistory.LessonId" => $lesson_id, "StudentHistory.UserId" => $userId))) {
                        $likenumber = $lesson['Lesson']['LikeNumber'];
                        $likenumber -= 1;
                        if ($likenumber > 0) {
                            $this->Lesson->updateAll(array('LikeNumber' => $likenumber), array('LessonId' => $lesson_id));
                        }
                        echo "いいね";
                    } else {
                        $this->Session->setFlash("エラーが発生した、もう一度お願いします");
                    }
                }
                $lesson = $this->Lesson->find('first', $params);
            } else {
                $this->Session->setFlash("あなたはこの授業を勉強していません。授業評価してはいけない");
            }
        }
    }
    public function  report($lessonId = null)
    {

        $userId = $this->_usersUsername()['UserId'];

        if ($lessonId == null || $userId == null) {
            $this->Session->setFlash(__('あなたがその授業にアクセスできません'));
            $this->redirect(array('controller' => 'Student', 'action' => 'index'));
        } else {

            $today = new DateTime();
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
            if ($isStudying) {
                $this->set("userId", $userId);
                $this->set("lessonId", $lessonId);
                if ($this->request->is('post')) {
                    $data = $this->request->data;
                    $this->Report->create();
                    if($this->Report->save($data)){
                        $this->Session->setFlash(__('ご協力ありがとうございます'));
                        $this->redirect(array('controller' => 'Student', 'action' => 'index'));
                    }
                    else{
                        $this->Session->setFlash(__('エラーが発生しました。ちょっと待ってください'));
                    }
                    debug($data);
                }
            }
            else{
                $this->Session->setFlash(__('あなたがその授業にアクセスできません'));
                $this->redirect(array('controller' => 'Student', 'action' => 'index'));
            }

        }
    }

}

?>