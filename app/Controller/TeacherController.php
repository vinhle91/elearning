<?php

/**
 * @copyright Copyright (c) 2013 mrhieusd
 */
class TeacherController extends AppController
{

    /**
     * index
     */
    public $components = array('Paginator', 'RequestHandler');
    public $helpers = array('Js');
    public $uses = array(
        'Config',
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
        'StudentBlock',
        'StudentTest',
        'Msg'
    );

    public function beforeFilter()
    {
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

    public function index()
    {
        $this->pageTitle = 'ホームページ';
        $userId = $this->Auth->user('UserId');
        $this->set(compact('userId'));
         if (isset($this->request->query['sortBy']) && isset($this->request->query['direction'])) {
            $sortBy = $this->request->query['sortBy'];
            $direction = $this->request->query['direction'];
        } else {
            $sortBy = 'time';
            $direction = 'DESC';
        }
        switch ($sortBy) {
            case 'like':
                $order = 'Lesson.LikeNumber ' . $direction;
                break;
            case 'view':
                $order = 'Lesson.ViewNumber ' . $direction;
                break;
            case 'title':
                $order = 'Lesson.Title ' . $direction;
                break;
            case 'time':
                $order = 'Lesson.modified ' . $direction;
                break;
        }
        if ($direction == 'DESC') {
            $direction = 'ASC';
        } else {
            $direction = 'DESC';
        }
        $this->set('direction', $direction);
        $lessons = $this->Lesson->find('all', array(
            'conditions' => array(
                'Lesson.UserId' => $userId,
                'IsDeleted' => 0, 'IsBlocked'=>0,
            ),
            'order' => $order,
        ));
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
        if (!isset($this->request->query['top']) || $this->request->query['top'] == 'lesson') {
            $this->Lesson->virtualFields = array(
                'Author' => 'User.Username'
            );
            $this->Paginator->settings = array(
                'conditions' => array('Lesson.IsDeleted' => '0', 'User.Status' => '1'),
                'limit' => 15,
                'fields' => array(
                    'Lesson.*', 'Lesson.Author'
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

    public function view_lesson($lesson_id = null, $file_id = null)
    {
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
                            // debug($lesson);
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
            $isStudying = true;
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
                        // debug($test_result);
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
                                $answer = $answer.$test_result[$value['QuesNum']].',';
                            }
                            $this->set(compact('point', 'total_ans_correct'));
                            $data['StudentTest']['UserId'] = $userId;
                            $data['StudentTest']['TestId'] = $test_id;
                            $data['StudentTest']['Answer'] = $answer;
                            $data['StudentTest']['Point'] = $point;
                            $tmp = $this->StudentTest->find('first',array(
                               'conditions' => array('StudentTest.TestId' =>  $test_id,'StudentTest.UserId' =>$userId,'StudentTest.IsDeleted' =>'0'),
                                ));
                            if(empty($tmp)){
                                $this->StudentTest->save($data);
                            }else{
                                // $now = new DateTime();
                                $this->StudentTest->updateAll(array('Answer' => "'$answer'", 'Point' => "'$point'"), array('StudentTest.TestId' =>  $test_id,'StudentTest.UserId' =>$userId));
                            }
                        }
                        $this->set(compact('test_result'));
                    }
                }
            }
        }
    }
     public function make_lesson($userId = null)
    {
        $this->pageTitle = 'Make Lesson';
        // Check UserId
        if ($userId != $this->Auth->user('UserId')) {
            $userId = $this->Auth->user('UserId');
            $this->redirect(array('controller' => 'teacher', 'action' => 'make_lesson', $userId));
        }
        // Get list tag
        $params = array(
            'fields' => array('TagId', 'TagContent'),
            'order' => array('Category.tagId' => 'Asc'),
        );
        $list_tag = $this->Tag->find('all');
        $tmp ='';
        foreach ($list_tag as $key => $value) {
            $tmp = $tmp.'"'.$value['Tag']['TagContent'].'"'.',';
        }
        $this->set(compact('tmp'));
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
                    $num_file = 0;
                    foreach ($data['File'] as $key => $value) {
                        if (!empty($value['path']['name'])) {
                            $data['File'][$key]['path']['old_name'] = $value['path']['name'];
                            $num_file++;
                            $type = explode(".", $value['path']['name']);
                            $type = $type['1'];
                            //formatName LessonId_FileNum_Size.Type
                            $name = 'File' . '_' . $lesson_id . '_' . $num_file . '_' . $value['path']['size'] . '.' . $type;
                            $data['File'][$key]['path']['name'] = $name;
                        }
                    }
                    // debug($data);
                    if ($num_file != 0) {
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
                                if (!empty($File)) {
                                    $file_id = $File['File']['FileId'];
                                }
                            } else {
                                $error_msg = $this->File->validationErrors['File'];
                                $this->set(compact('error_msg'));
                                $this->Lesson->delete($lesson_id);
                                $this->Tag->deleteAll(array('Tag.LessonId' => $lesson_id), false);
                                $this->Session->setFlash(__('ファイルは保存できませんでした。 、もう一度お試しください。'));
                                return;
                                // $this->redirect(array('controller' => 'teacher', 'action' => 'make_lesson', $userId));
                            }
                        }
                    }else{
                        $this->Lesson->delete($lesson_id);
                        $this->Tag->deleteAll(array('Tag.LessonId' => $lesson_id), false);
                        $this->Session->setFlash(__('あなたはまだアップロードするファイルを選択していない'));
                        return;
                    }
                    // // Save test of lesson
                    $num_test = 0;
                    foreach ($data['TestFile'] as $key => $value) {
                        if (!empty($value['path']['name'])) {
                            $data['TestFile'][$key]['path']['old_name'] = $value['path']['name'];
                            $num_test++;
                            $type = explode(".", $value['path']['name']);
                            $type = $type['1'];
                            //formatName LessonId_FileNum_Size_Type
                            $name = 'Test' . '_' . $lesson_id . '_' . $num_test . '_' . $value['path']['size'] . '.' . $type;
                            $data['TestFile'][$key]['path']['name'] = $name;
                        }
                    }
                    // debug($data);
                    if ($num_test != 0) {
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
                                // debug($test_tmp);
                                $link = $test_tmp['File']['FileLink'];
                                $link = substr($link, 1);
                                $excel = $this->Readtsv->loadFile($link);
                                $test = array();
                                $quest = array();
                                $answer = array();
                                $Answer = array();
                                $i = 1;
                                $this->Test->create();
                                while (strcmp(substr($this->Readtsv->getCell($i, 1),0,1), '#') == 0) {
                                    $i++;
                                }
                                $test['Test']['Title'] = $this->Readtsv->getCell($i, 2);
                                $i++;
                                while (strcmp(substr($this->Readtsv->getCell($i, 1),0,1), '#') == 0) {
                                    $i++;
                                }
                                $test['Test']['SubTitle'] = $this->Readtsv->getCell($i, 2);
                                $i++;
                                while (strcmp($this->Readtsv->getCell($i, 1), '#') == 0||strcmp($this->Readtsv->getCell($i, 1), '') == 0) {
                                    $i++;
                                }
                                $test['Test']['LessonId'] = $lesson_id;
                                $test['Test']['FileId'] = $test_tmp['File']['FileId'] ;
                                // Check format file TSV
                                $check = $this->Readtsv->getColumn(1);
                                $k=0;
                                foreach ($check as $key => $value) {
                                   if(strcmp($value, 'End') == 0){
                                        $k++;
                                   }
                                }
                                if($k==0){
                                    $this->Lesson->delete($lesson_id);
                                    $this->Tag->deleteAll(array('Tag.LessonId' => $lesson_id), false);
                                    $this->File->deleteAll(array('File.LessonId' => $lesson_id), false);
                                    $this->Session->setFlash(__('ファイルの構造が正しくありません。'));
                                    return;
                                }
                                $g = 0;
                                $num = 1;
                                $Answer[$num]['Num'] = 0;
                                while (strcmp($this->Readtsv->getCell($i, 1), 'End') != 0) {
                                    if (strcmp(substr($this->Readtsv->getCell($i, 1),0,1), '#') == 0) {
                                        $i++;
                                        continue;
                                    }
                                    if (strcmp($this->Readtsv->getCell($i, 1), 'Q(' . $num . ')') == 0 && $Answer[$num]['Num'] == 0 && strcmp($this->Readtsv->getCell($i + 1, 1), 'Q(' . $num . ')') == 0) {
                                        if(strcmp($this->Readtsv->getCell($i, 2), 'QS')!=0){
                                            $g++;
                                            break;
                                        }
                                        $Answer[$num]['Start'] = $i;
                                        $Answer[$num]['Num'] = $Answer[$num]['Num'] + 1;
                                        $i++;
                                        continue;
                                    } else if (strcmp($this->Readtsv->getCell($i, 1), 'Q(' . $num . ')') == 0 && $Answer[$num]['Num'] != 0 && strcmp($this->Readtsv->getCell($i + 1, 1), 'Q(' . $num . ')') == 0) {
                                        $Answer[$num]['Num'] = $Answer[$num]['Num'] + 1;
                                        $i++;
                                        continue;
                                    } else if (strcmp($this->Readtsv->getCell($i, 1), 'Q(' . $num . ')') == 0 && $Answer[$num]['Num'] != 0 && strcmp($this->Readtsv->getCell($i + 1, 1), 'Q(' . $num . ')') != 0) {
                                        if(strcmp($this->Readtsv->getCell($i, 2), 'KS')!=0){
                                            $g++;
                                            break;
                                        }
                                        $Answer[$num]['Num'] = $Answer[$num]['Num'] + 1;
                                        $num = $num + 1;
                                        $Answer[$num]['Num'] = 0;
                                        $i++;
                                        continue;
                                    }else{
                                        if (strcmp($this->Readtsv->getCell($i, 1), 'Q(' . $num . ')') != 0&&strcmp($this->Readtsv->getCell($i, 1), '') != 0 ) {
                                            $g++;
                                            break;
                                        }
                                        $i++;
                                        continue;
                                    }
                                }
                                // debug($h);
                                if($g!=0){
                                    $this->Lesson->delete($lesson_id);
                                    $this->Tag->deleteAll(array('Tag.LessonId' => $lesson_id), false);
                                    $this->File->deleteAll(array('File.LessonId' => $lesson_id), false);
                                    $this->Session->setFlash(__('ファイルの構造が正しくありません。'));
                                    return;
                                }
                                // debug($test);
                                // die;
                                if ($this->Test->save($test)) {
                                    $Test = $this->Test->find('first', array(
                                        'conditions' => array('Test.LessonId' => $lesson_id),
                                        'fields' => array('Test.TestId'),
                                        'order' => array('Test.TestId' => 'desc'),
                                        'contain' => False,
                                    ));
                                    // debug($Test);
                                    $test_id = $Test['Test']['TestId'];
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
                                $error_msg = $this->File->validationErrors['File'];
                                $this->set(compact('error_msg'));
                                $this->Lesson->delete($lesson_id);
                                $this->Tag->deleteAll(array('Tag.LessonId' => $lesson_id), false);
                                $this->File->deleteAll(array('File.LessonId' => $lesson_id), false);
                                $this->Session->setFlash(__('ファイルは保存できませんでした。 、もう一度お試しください。'));
                                return;
                            }
                        }
                    }

                    $this->redirect(array('controller' => 'teacher', 'action' => 'view_lesson', $lesson_id, $file_id));
                } else {
                    $this->Session->setFlash(__('レッスンを作ることができなかった。もう一度やり直してください。'));
                    // $this->redirect(array('controller' => 'teacher', 'action' => 'make_lesson', $userId));
                }

            } else {
                $this->Session->setFlash(__('利用規約をご確認ください'));
            }
        }
    }


    public function view_test($lesson_id = null, $test_id = null)
    {
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
                        $this->redirect(array('controller' => 'teacher', 'action' => 'view_lesson', $lesson_id, $file['File']['FileId']));
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
                                $tmp = (int)$tmp;
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
    public function view_kekka($lesson_id = null, $test_id = null) {
        $this->pageTitle = 'View Test Result';
        $userId = $this->Auth->user('UserId');
        if (!isset($lesson_id) || empty($lesson_id)) {
            $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
            $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
        } else {
            if (!isset($test_id)) {
                $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
                $this->redirect(array('controller' => 'student', 'action' => 'index'));
            } elseif ($test_id == 0) {
                $this->Session->setFlash(__('テストの結果は存在しません。'));
                $this->redirect(array('controller' => 'student', 'action' => 'view_lesson', $lesson_id));
            } else {
                $this->set(compact('lesson_id'));
                 $this->set(compact('test_id'));
                $file = $this->File->find('first', array(
                    'conditions' => array(
                        'File.LessonId' => $lesson_id,
                        'File.IsDeleted' => '0',
                        'File.FileType' => '1',
                    ),
                    'contain' => false,
                    'order' => array('File.FileId' => 'Asc'),
                        )
                );
                $this->set(compact('file'));
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
                // debug($data_test);
                $test_result = $this->StudentTest->find('first',array(
                       'conditions' => array('StudentTest.TestId' =>  $test_id,'StudentTest.UserId' =>$userId,'StudentTest.IsDeleted' =>'0'),
                        ));
                // debug($test_result);
                if(!empty($test_result)){
                    $an = $test_result['StudentTest']['Answer'];
                    $an = strtolower($an);
                    $an = explode(",", $an);
                    // debug($an);
                    $this->set(compact('test_result','an'));
                }
            }
        }
    }

    public function edit_lesson($lesson_id)
    {
        $this->pageTitle = 'Edit Lesson';
        $userId = $this->Auth->user('UserId');
         // Get list tag
        $params = array(
            'fields' => array('TagId', 'TagContent'),
            'order' => array('Category.tagId' => 'Asc'),
        );
        $tag = $this->Tag->find('all');
        $tmp ='';
        foreach ($tag as $key => $value) {
            $tmp = $tmp.'"'.$value['Tag']['TagContent'].'"'.',';
        }
        $this->set(compact('tmp'));
          // Get list category 
        $params = array(
            'conditions' => array('Category.IsDeleted' => '0'),
            'fields' => array('CatId', 'CatName'),
            'order' => array('Category.CatId' => 'Asc'),
        );
        $cat = $this->Category->find('all', $params);
        
        $this->set(compact('cat'));
        if (!isset($lesson_id) || empty($lesson_id)) {
            $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
            $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
        }else{
        	$lessons = $this->Lesson->find('first', array(
                'conditions' => array('Lesson.LessonId' => $lesson_id,'Lesson.IsDeleted'=>'0'),
                'order' => array('Lesson.created' => 'desc'),
                'contain' => False,
            ));
            // debug($lessons);
            if (empty($lessons)) {
            	$this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
	            $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
	        }else{
	        	$this->set(compact('lessons'));
	        	$tag = $this->Tag->find('all', array(
	                'conditions' => array('Tag.LessonId' => $lesson_id),
	                'order' => array('Tag.created' => 'desc'),
	                'contain' => False,
	            ));
	            $list_tag = '';
	            foreach ($tag as $key => $value) {
                    if(!empty($list_tag)){
                        $list_tag = $list_tag.','.$value['Tag']['TagContent'];
                    }else{
	            	    $list_tag = $list_tag.$value['Tag']['TagContent'];
                    }
	            }
	            $this->set(compact('list_tag'));
                $file = $this->File->find('all', array(
                    'conditions' => array('File.LessonId' => $lesson_id,'FIle.FileType'=>1),
                    'fields' => array('File.*'),
                    'order' => array('File.created' => 'desc'),
                    'contain' => False,
                ));
                $this->set(compact('file'));
                $file_test = $this->File->find('all', array(
                    'conditions' => array('File.LessonId' => $lesson_id,'FIle.FileType'=>2),
                    'fields' => array('File.*'),
                    'order' => array('File.created' => 'desc'),
                    'contain' => False,
                ));
                $this->set(compact('file_test'));
	            // debug($file);
	        }
        	if ($this->request->is('post')) {
	            $data = $this->request->data;
	            // debug($data);
	            // die;
	            if ($data['Lesson']['TermsOfService'] == 1) {
	                //update lesson
	                 $updateData = array(
	                    'Title' => "'" . $data['Lesson']['Title'] . "'",
                        'Category' => "'" . $data['Lesson']['Category'] . "'",
	                    'Abstract' => "'" . $data['Lesson']['Abstract'] . "'",
	                );
	              	if($this->Lesson->updateAll($updateData, array('Lesson.LessonId' =>  $lesson_id)))
	                {
	                	 // Save file of lesson
	                    $num_file = 0;
	                    foreach ($data['File'] as $key => $value) {
	                        if (!empty($value['path']['name'])) {
	                            $data['File'][$key]['path']['old_name'] = $value['path']['name'];
	                            $num_file++;
	                            $type = explode(".", $value['path']['name']);
	                            $type = $type['1'];
	                            //formatName LessonId_FileNum_Size.Type
	                            $name = 'File' . '_' . $lesson_id . '_' . $num_file . '_' . $value['path']['size'] . '.' . $type;
	                            $data['File'][$key]['path']['name'] = $name;
	                        }
	                    }
	                    // debug($data);
	                    if ($num_file != 0) {
	                        foreach ($data['File'] as $key => $value) {
	                            $this->File->create();
	                            $param1['File']['File'] = $value['path'];
	                            $param1['File']['LessonId'] = $lesson_id;
	                            $param1['File']['FileType'] = '1';
	                            $param1['File']['FileName'] = $value['path']['old_name'];
	                            // debug($param1);
	                            if ($this->File->save($param1)) {
	                                $options['conditions'] = array(
                                        'File.FileName' => $value['path']['old_name'],
                                        'File.LessonId' =>$lesson_id,
                                        'File.IsDeleted' => '0',
                                        'File.FileType' => '1',
                                        'Lesson.IsDeleted' => '0',
                                    );
                                    $options['order'] = array(
                                        'File.FileId' => 'Asc',
                                    );
                                    $options['fields'] = array('Lesson.UserId', 'File.*');
                                    $file_n = $this->File->find('all', $options);
                                    // debug($file_n);
                                    $l =0;
                                    foreach ($file_n as $key1 => $value1) {
                                        $l++;
                                    }
                                    if ($l>1) {
                                        $this->File->deleteAll(array('File.FileId' =>$file_n['0']['File']['FileId']));
                                    }
	                            } else {
	                            	$error_msg = $this->File->validationErrors['File'];
	                            	$this->set(compact('error_msg'));
	                                $this->Session->setFlash(__('ファイルは保存できませんでした。 、もう一度お試しください。'));
	                                $this->redirect(array('controller' => 'teacher', 'action' => 'edit_lesson', $lesson_id));
	                            }
	                        }
	                    }else{
                            if(empty($file)){
                                $this->Session->setFlash(__('あなたはまだアップロードするファイルを選択していない'));
                                return;
                            }
                        }
	                	$this->Tag->deleteAll(array('Tag.LessonId' => $lesson_id), false);
	                    // Save Tag of lesson

	                    $tag = $data['Lesson']['Tag'];
	                    $tag = strtolower($tag);
	                    $tag = explode(",", $tag);
                       
	                    if (isset($tag) && !empty($tag)) {
	                        foreach ($tag as $value) {
	                            $value = trim($value);
                                debug($value);
	                            $this->Tag->create();
	                            $data1['Tag']['LessonId'] = $lesson_id;
	                            $data1['Tag']['TagContent'] = $value;
	                            if ($this->Tag->save($data1)) {

	                            } else {
	                                $this->Lesson->delete($lesson_id);
	                                $this->Session->setFlash(__('タグは作成できませんでした。 、もう一度お試しください。'));
	                                $this->redirect(array('controller' => 'teacher', 'action' => 'edit_lesson', $lesson_id));
	                            }
	                        }
	                    }
                         // Save test of lesson
                        $num_test = 0;
                        foreach ($data['TestFile'] as $key => $value) {
                            if (!empty($value['path']['name'])) {
                                $data['TestFile'][$key]['path']['old_name'] = $value['path']['name'];
                                $num_test++;
                                $type = explode(".", $value['path']['name']);
                                $type = $type['1'];
                                //formatName LessonId_FileNum_Size_Type
                                $name = 'Test' . '_' . $lesson_id . '_' . $num_test . '_' . $value['path']['size'] . '.' . $type;
                                $data['TestFile'][$key]['path']['name'] = $name;
                            }
                        }
                        if ($num_test != 0) {
                            foreach ($data['TestFile'] as $key => $value12) {
                                $this->File->create();
                                $param2['File']['TestFile'] = $value12['path'];
                                $param2['File']['LessonId'] = $lesson_id;
                                $param2['File']['FileType'] = '2';
                                $param2['File']['FileName'] = $value12['path']['old_name'];
                                if ($this->File->save($param2)) {
                                    $test_tmp = $this->File->find('first', array(
                                        'conditions' => array('File.LessonId' => $lesson_id, 'File.FileType' => '2'),
                                        'fields' => array('File.FileId', 'FileLink'),
                                        'order' => array('File.FileId' => 'desc'),
                                        'contain' => False,
                                    ));
                                    $File_id = $test_tmp['File']['FileId'];
                                    $link = $test_tmp['File']['FileLink'];
                                    $link = substr($link, 1);
                                    $excel = $this->Readtsv->loadFile($link);
                                    $test = array();
                                    $quest = array();
                                    $answer = array();
                                    $Answer = array();
                                    $i = 1;
                                    $this->Test->create();
                                    while (strcmp(substr($this->Readtsv->getCell($i, 1),0,1), '#') == 0) {
                                        $i++;
                                    }
                                    $test['Test']['Title'] = $this->Readtsv->getCell($i, 2);
                                    $i++;
                                    while (strcmp(substr($this->Readtsv->getCell($i, 1),0,1), '#') == 0) {
                                        $i++;
                                    }
                                    $test['Test']['SubTitle'] = $this->Readtsv->getCell($i, 2);
                                    $i++;
                                    while (strcmp($this->Readtsv->getCell($i, 1), '#') == 0||strcmp($this->Readtsv->getCell($i, 1), '') == 0) {
                                        $i++;
                                    }
                                    $test['Test']['LessonId'] = $lesson_id;
                                    $test['Test']['FileId'] = $test_tmp['File']['FileId'] ;
                                    // Check format file TSV
                                    $check = $this->Readtsv->getColumn(1);
                                    $k=0;
                                    foreach ($check as $key => $value) {
                                       if(strcmp($value, 'End') == 0){
                                            $k++;
                                       }
                                    }
                                    if($k==0){
                                        $this->File->deleteAll(array('File.FileId' => $File_id), false);
                                        $this->Session->setFlash(__('ファイルの構造が正しくありません。'));
                                        return;
                                    }
                                    $g = 0;
                                    $num = 1;
                                    $Answer[$num]['Num'] = 0;
                                    while (strcmp($this->Readtsv->getCell($i, 1), 'End') != 0) {
                                        if (strcmp(substr($this->Readtsv->getCell($i, 1),0,1), '#') == 0) {
                                            $i++;
                                            continue;
                                        }
                                        if (strcmp($this->Readtsv->getCell($i, 1), 'Q(' . $num . ')') == 0 && $Answer[$num]['Num'] == 0 && strcmp($this->Readtsv->getCell($i + 1, 1), 'Q(' . $num . ')') == 0) {
                                            if(strcmp($this->Readtsv->getCell($i, 2), 'QS')!=0){
                                                $g++;
                                                break;
                                            }
                                            $Answer[$num]['Start'] = $i;
                                            $Answer[$num]['Num'] = $Answer[$num]['Num'] + 1;
                                            $i++;
                                            continue;
                                        } else if (strcmp($this->Readtsv->getCell($i, 1), 'Q(' . $num . ')') == 0 && $Answer[$num]['Num'] != 0 && strcmp($this->Readtsv->getCell($i + 1, 1), 'Q(' . $num . ')') == 0) {
                                            $Answer[$num]['Num'] = $Answer[$num]['Num'] + 1;
                                            $i++;
                                            continue;
                                        } else if (strcmp($this->Readtsv->getCell($i, 1), 'Q(' . $num . ')') == 0 && $Answer[$num]['Num'] != 0 && strcmp($this->Readtsv->getCell($i + 1, 1), 'Q(' . $num . ')') != 0) {
                                            if(strcmp($this->Readtsv->getCell($i, 2), 'KS')!=0){
                                                $g++;
                                                break;
                                            }
                                            $Answer[$num]['Num'] = $Answer[$num]['Num'] + 1;
                                            $num = $num + 1;
                                            $Answer[$num]['Num'] = 0;
                                            $i++;
                                            continue;
                                        }else{
                                            if (strcmp($this->Readtsv->getCell($i, 1), 'Q(' . $num . ')') != 0&&strcmp($this->Readtsv->getCell($i, 1), '') != 0 ) {
                                                $g++;
                                                break;
                                            }
                                            $i++;
                                            continue;
                                        }
                                    }
                                    // debug($h);
                                    if($g!=0){
                                        $this->File->deleteAll(array('File.FileId' => $File_id), false);
                                        $this->Session->setFlash(__('ファイルの構造が正しくありません。'));
                                        return;
                                    }
                                    // debug($data['TestFile']);
                                    //overwrite file
                                    $options['conditions'] = array(
                                        'File.FileName' => $value12['path']['old_name'],
                                        'File.LessonId' =>$lesson_id,
                                        'File.IsDeleted' => '0',
                                        'File.FileType' => '2',
                                        'Lesson.IsDeleted' => '0',
                                        'Lesson.UserId' => $userId,
                                    );
                                    $options['order'] = array(
                                        'File.FileId' => 'Asc',
                                    );
                                    $options['fields'] = array('Lesson.UserId', 'File.*');
                                    $file_name = $this->File->find('all', $options);
                                    $j =0;
                                    foreach ($file_name as $key => $value) {
                                        $j++;
                                    }

                                    if ($j>1) {
                                        $Test = $this->Test->find('first', array(
                                            'conditions' => array('Test.FileId' => $file_name['0']['File']['FileId']),
                                            'fields' => array('Test.*'),
                                            'order' => array('Test.created' => 'Asc'),
                                            'contain' => False,
                                        ));
                                        // debug($Test);
                                        $Question = $this->Question->find('all', array(
                                            'conditions' => array('Question.TestId' => $Test['Test']['TestId']),
                                            'fields' => array('Question.*'),
                                            'contain' => False,
                                        ));
                                        foreach ($Question as $key => $value) {
                                             $this->Answer->deleteAll(array('Answer.QuesId' => $value['Question']['QuesId']));
                                        }
                                        $this->Question->deleteAll(array('Question.TestId' => $Test['Test']['TestId']));
                                        $this->File->deleteAll(array('File.FileId' =>$file_name['0']['File']['FileId']));
                                        $this->Test->deleteAll(array('Test.TestId' => $Test['Test']['TestId']));
                                    }
                                    // debug($test);
                                    // die;
                                    if ($this->Test->save($test)) {
                                        $Test = $this->Test->find('first', array(
                                            'conditions' => array('Test.LessonId' => $lesson_id),
                                            'fields' => array('Test.TestId'),
                                            'order' => array('Test.created' => 'desc'),
                                            'contain' => False,
                                        ));
                                        $test_id = $Test['Test']['TestId'];
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
                                                            $this->redirect(array('controller' => 'teacher', 'action' => 'edit_lesson', $userId));
                                                        }
                                                        $h++;
                                                    }
                                                } else {
                                                    $this->Lesson->delete($lesson_id);
                                                    $this->Tag->deleteAll(array('Tag.LessonId' => $lesson_id), false);
                                                    $this->File->deleteAll(array('File.LessonId' => $lesson_id), false);
                                                    $this->Test->deleteAll(array('Test.LessonId' => $lesson_id), false);
                                                    $this->Session->setFlash(__('クエストは作成できませんでした。 、もう一度お試しください。'));
                                                    $this->redirect(array('controller' => 'teacher', 'action' => 'edit_lesson', $userId));

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
                                    $error_msg = $this->File->validationErrors['File'];
                                    $this->set(compact('error_msg'));
                                    $this->Lesson->delete($lesson_id);
                                    $this->Tag->deleteAll(array('Tag.LessonId' => $lesson_id), false);
                                    $this->File->deleteAll(array('File.LessonId' => $lesson_id), false);
                                    $this->Session->setFlash(__('ファイルは保存できませんでした。 、もう一度お試しください。'));
                                    return;
                                }
                            }
                        }

                        $File = $this->File->find('first', array(
                            'conditions' => array('File.LessonId' => $lesson_id,'File.FileType'=>1),
                            'fields' => array('File.FileId'),
                            'order' => array('File.created' => 'Asc'),
                            'contain' => False,
                        ));
                        if (!empty($File)) {
                            $file_id = $File['File']['FileId'];
                        }
	                    $this->redirect(array('controller' => 'teacher', 'action' => 'view_lesson', $lesson_id, $file_id));
	                } else {
	                    $this->Session->setFlash(__('レッスンを変更することができなかった。もう一度やり直してください。'));
	                    // $this->redirect(array('controller' => 'teacher', 'action' => 'make_lesson', $userId));
	                }

	            } else {
	                $this->Session->setFlash(__(' コピーライト規約をご確認ください'));
	            }
	        }
        }
        
    }

    public function transaction_history()
    {
        $this->pageTitle = 'Transaction History';
        $userId = $this->Auth->user('UserId');
        if (isset($this->request->data['User'])) {
            $month = $this->request->data['User']['months'] + 1;
            $year = $this->request->data['User']['year'];

        } else {
            $today = getdate();
            $month = $today['mon'];
            $year = $today['year'];
        }
        $this->set('selectMonth', $month - 1);
        $this->set('selectYear', $year);
        $rate = $this->Config->getSharingRateConfig();
        if ($rate == null) {
            $this->Session->setFlash('システム設定の定数が見つかれない');
            $rate = 0;
        }
        $transactions = $this->StudentHistory->getTeacherTransactionHistory($userId, $month, $year);
        $this->set('transactions', $transactions);
        $total = 0;
        foreach ($transactions as $t) {
            $total = $total + $t['StudentHistory']['fee'];
        }
        $this->set(compact('rate'));
        $this->set('total', $total);
    }

    public function delete_lesson($lesson_id = null)
    {
        $this->pageTitle = '授業';
        $userId = $this->Auth->user('UserId');
        if ($this->request->is('post')) {
            if (isset($this->request->data['submit']) && isset($this->request->data['Teacher']['lesson_id'])) {
                $lesson_id = $this->request->data['Teacher']['lesson_id'];
                if ($this->request->data['submit'] == 'はい') {
                    $lesson = $this->Lesson->find('first', array(
                        'conditions' => array('LessonId' => $lesson_id),
                    ));
                    if ($lesson != null) {
                        if ($lesson['Lesson']['UserId'] == $userId) {
                            if ($lesson['Author']['Status'] == 1) {
                                if($this->Lesson->delete($lesson_id, true)){
                                    // $this->StudentHistory->deleteAll(array('StudentHistory.LessonId'=>$lesson_id));
                                    //$this->StudentBlock->deleteAll(array('StudentBlock.LessonId'=>$lesson_id));
                                    // $test = $this->Test->find('all',array(
                                    //     'conditions' => array('Test.LessonId' => $lesson_id),
                                    //     'contain' => false,
                                    //     )
                                    // );
                                    // if(!empty($test)){
                                    //     foreach ($test as $key => $value) {
                                    //         $this->StudentTest->deleteAll(array('StudentTest.TestId'=>$value['Test']['TestId']));
                                    //     }
                                    // }
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

    public function view_category($catId)
    {
        $userId = $this->Auth->user('UserId');
        $this->set(compact('userId'));
        $category = $this->Category->getCategory($catId);
        $this->set('cat', $category);

        $options = $this->Category->getPaginationOptions($catId);

        $this->paginate = $options;
        $lessons = $this->paginate('Category');
        // debug($lessons);
        $this->set('lessons', $lessons);
    }

    public function list_student()
    {
        $this->pageTitle = 'List Student';

        if ($this->request->is('get')) {

            $lessonId = $this->request->params['pass']['0'];
            $lesson = $this->Lesson->getLessonById($lessonId);

            $studentHistories = $this->StudentHistory->getStudentHistoryOfLesson($lessonId);
            $test= $this->Test->find('all', array(
                'conditions' => array('Test.LessonId' => $lessonId),
                'fields' => array('Test.TestId'),
                'order' => array('Test.created' => 'Asc'),
                'contain' => False,
            ));
            if(!empty($test)){
                foreach ($studentHistories as $key1 => $value1) {
                    foreach ($test as $key => $value) {
                        $test_history = $this->StudentTest->find('first', array(
                            'conditions' => array('StudentTest.UserId' => $value1['StudentHistory']['UserId'],'StudentTest.TestId'=>$value['Test']['TestId']),
                            'contain' => False,
                        ));
                        if(!empty($test_history)){
                            $studentHistories[$key1]['Test'][$key] = $value['Test']['TestId'];
                        }
                    }
                   
                }
              
            }
            // debug($studentHistories);
            $this->set('studentHistories', $studentHistories);
            $this->set('lessonTitle', $lesson['Lesson']['Title']);

            //	debug($studentHistories);
        }
    }
    public function view_result($lesson_id = null, $test_id = null,$userId = null) {
        $this->pageTitle = 'View Test Result';
        if (!isset($lesson_id) || empty($lesson_id)) {
            $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
            $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
        } else {
            if (!isset($test_id)) {
                $this->Session->setFlash(__('エラーが発生しました。もう一度やり直してください'));
                $this->redirect(array('controller' => 'student', 'action' => 'index'));
            } elseif ($test_id == 0) {
                $this->Session->setFlash(__('テストの結果は存在しません。'));
                $this->redirect(array('controller' => 'student', 'action' => 'view_lesson', $lesson_id));
            } else {
                $this->set(compact('lesson_id'));
                 $this->set(compact('test_id'));
                $file = $this->File->find('first', array(
                    'conditions' => array(
                        'File.LessonId' => $lesson_id,
                        'File.IsDeleted' => '0',
                        'File.FileType' => '1',
                    ),
                    'contain' => false,
                    'order' => array('File.FileId' => 'Asc'),
                        )
                );
                $this->set(compact('file'));
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
                // debug($data_test);
                $test_result = $this->StudentTest->find('first',array(
                       'conditions' => array('StudentTest.TestId' =>  $test_id,'StudentTest.UserId' =>$userId,'StudentTest.IsDeleted' =>'0'),
                        ));
                // debug($test_result);
                if(!empty($test_result)){
                    $an = $test_result['StudentTest']['Answer'];
                    $an = strtolower($an);
                    $an = explode(",", $an);
                    // debug($an);
                    $this->set(compact('test_result','an'));
                }
            }
        }
    }
    public function block_student()
    {

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

    public function report($lessonId = null)
    {
        $userId = $this->_usersUsername()['UserId'];

        if ($lessonId == null || $userId == null) {
            $this->Session->setFlash(__('あなたがその授業にアクセスできません'));
            $this->redirect(array('controller' => 'Student', 'action' => 'index'));
        } else {
            $this->set("userId", $userId);
            $this->set("lessonId", $lessonId);

            if ($this->request->is('post')) {
                $data = $this->request->data;
                $this->log($data);
                $this->Msg->create();
                $lesson = $this->Lesson->find("first", array(
                    'Lesson.LessonId' => $lessonId,
                    ));
                $data['Msg']['Content'] = "「" . $lesson['Lesson']['Title'] . "」(" . $lessonId . ") " . $data['Msg']['Content'];

                if ($this->Msg->save($data)) {
                    $this->Session->setFlash(__('ご協力ありがとうございます'));
                    $this->redirect(array('controller' => 'Teacher', 'action' => 'index'));
                } else {
                    $this->Session->setFlash(__('エラーが発生しました。ちょっと待ってください'));
                }
                //debug($data);
            }
        }
    }

    public function view_message()
    {
        if ($this->request->is('post')) {
//            debug($this->request->data);
            $data = $this->request->data;
            if (isset($data['Message']['Delete']) && $data['Message']['Delete'] == 1) {
                $msgId = $data['Message']['MsgId'];
                $this->msg->updateAll(array("IsReaded" => 1), array('msg.MsgId' => $msgId));
            }
        }
        $id = $this->_usersUsername()['UserId'];
        $messages = $this->msg->find('all', array(
            'conditions' => array('msg.UserId' => $id, 'msg.IsReaded' => 0)
        ));
//        echo $id;
//        debug($messages);
        if ($messages != null)
            $this->set("messages", $messages);
    }
    public function delete_file($file_id)
    {
         $File = $this->File->find('first', array(
            'conditions' => array('File.FileId' => $file_id),
            'fields' => array('File.*'),
            'order' => array('File.created' => 'Asc'),
            'contain' => False,
        ));

        $this->File->deleteAll(array('File.FileId' => $file_id));
        $this->Session->setFlash(__('このファイルには、正常な削除してしまった。'));
        $this->redirect(array('controller' => 'teacher', 'action' => 'edit_lesson', $File['File']['LessonId']));
   
    }
    public function delete_filetest($file_id)
    {
        $File = $this->File->find('first', array(
            'conditions' => array('File.FileId' => $file_id),
            'fields' => array('File.*'),
            'order' => array('File.created' => 'Asc'),
            'contain' => False,
        ));
        // debug($file_id);
        $Test = $this->Test->find('first', array(
            'conditions' => array('Test.FileId' => $file_id),
            'fields' => array('Test.*'),
            'order' => array('Test.created' => 'Asc'),
            'contain' => False,
        ));
        // debug($Test);
        $Question = $this->Question->find('all', array(
            'conditions' => array('Question.TestId' => $Test['Test']['TestId']),
            'fields' => array('Question.*'),
            'contain' => False,
        ));
        foreach ($Question as $key => $value) {
             $this->Answer->deleteAll(array('Answer.QuesId' => $value['Question']['QuesId']));
        }
        $this->Question->deleteAll(array('Question.TestId' => $Test['Test']['TestId']));
        $this->File->deleteAll(array('File.FileId' => $file_id));
        $this->Test->deleteAll(array('Test.TestId' => $Test['Test']['TestId']));
       
        $this->Session->setFlash(__('このファイルには、正常な削除してしまった。'));
        $this->redirect(array('controller' => 'teacher', 'action' => 'edit_lesson', $File['File']['LessonId']));
   
    }

}

?>