<?php
/**
 * Created by PhpStorm.
 * User: TanVN
 * Date: 3/9/14
 * Time: 1:48 PM
 */
class LessonsController extends AppController
{
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
        'Report'
    );

    function beforeFilter()
    {
        $this->pageTitle = 'Home';
        $this->layout = 'template';
//        $this->Auth->allow(array('index', 'sign_up'));
        return parent::beforeFilter();
    }

    public function search($keyWord = null)
    {
//        debug($this->request->data);
        if (isset($this->request->data['Lesson']['種類'])) {
            $searchType = $this->request->data['Lesson']['種類'];
        } else {
            $searchType = 1;
        }

//        debug($searchType);
        $conditions = array();
        $userId = $this->Auth->user('UserId');
        $today = new DateTime();
        $UserType = $this->Auth->user()['UserType'];
        $this->set(compact('UserType'));
        $this->set(compact('userId'));
        // debug($this->request->data);
        if (empty($this->request->data['Lesson']['keyWords'])) {
            $this->Session->setFlash("何かキーワードを入力してください");
        } else {
            if (!isset($keyWord) || empty($keyWord)) {
                $keyWord = $this->request->data['Lesson']['keyWords'];
            }
            if (strpos($keyWord, '+') !== false) {
                $andConditions = explode("+", $keyWord);
                for ($i = 0; $i < sizeof($andConditions); $i++) {
                    $andConditions[$i] = trim($andConditions[$i]);
                }
//                debug($andConditions);
            } else if (strpos($keyWord, "-") !== false) {
                $orConditions = explode("-", $keyWord);
                for ($i = 0; $i < sizeof($orConditions); $i++) {
                    $orConditions[$i] = trim($orConditions[$i]);
                }
//                debug($orConditions);
            }

            if ($searchType == 1) {
                $results = $this->Lesson->find("all", array(
                    "joins" => array(
                        array(
                            "table" => "tags",
                            "alias" => "Tag",
                            "type" => "LEFT",
                            "conditions" => array(
                                "Tag.LessonId= Lesson.LessonId"
                            )
                        )
                    ),
                    'fields' => array('User.FullName',
                        'User.UserId',
                        'Lesson.LessonId',
                        'Lesson.Title',
                        'Lesson.LikeNumber',
                        'Lesson.Category',
                        'Lesson.ViewNumber',
                        'Lesson.Abstract',
                        'Lesson.modified',
                        'Tag.TagContent',
                    ),
                    'conditions' => array(
                        'User.Status' => 1,
                        'OR' => array(
                            array('Lesson.Title LIKE' => "%$keyWord%"),
                            array('Tag.TagContent LIKE' => "%$keyWord%"),
                            array('User.Username LIKE' => "%$keyWord%"),
                            array('Lesson.Abstract LIKE' => "%$keyWord%"),
                            array('User.FullName LIKE'=> "%$keyWord%")
                        )
                    )
                ));


            } //search by teacher name
            else if ($searchType == 2) {
//                echo "Teacher";
                if (isset($andConditions)) {
                    for ($i = 0; $i < sizeof($andConditions); $i++) {
                        $conditions[$i] = array('User.Username LIKE' => "%$andConditions[$i]%");

                    }
                    $results = $this->Lesson->find("all", array(
                        "joins" => array(
                            array(
                                "table" => "tags",
                                "alias" => "Tag",
                                "type" => "LEFT",
                                "conditions" => array(
                                    "Tag.LessonId= Lesson.LessonId"
                                )
                            )
                        ),
                        'fields' => array('User.FullName',
                            'User.UserId',
                            'Lesson.LessonId',
                            'Lesson.Title',
                            'Lesson.LikeNumber',
                            'Lesson.Category',
                            'Lesson.ViewNumber',
                            'Lesson.Abstract',
                            'Lesson.modified',
                            'Tag.TagContent',
                        ),
                        'conditions' => array(
                            'User.Status' => 1,
                            'AND' => $conditions
                        )
                    ));

                } else if (isset($orConditions)) {
                    for ($i = 0; $i < sizeof($orConditions); $i++) {

                        $conditions[$i] = array('User.Username LIKE' => "%$orConditions[$i]%");
                    }

//                    debug($conditions);
                    $results = $this->Lesson->find("all", array(
                        "joins" => array(
                            array(
                                "table" => "tags",
                                "alias" => "Tag",
                                "type" => "LEFT",
                                "conditions" => array(
                                    "Tag.LessonId= Lesson.LessonId"
                                )
                            )
                        ),
                        'fields' => array('User.FullName',
                            'User.UserId',
                            'Lesson.LessonId',
                            'Lesson.Title',
                            'Lesson.LikeNumber',
                            'Lesson.Category',
                            'Lesson.ViewNumber',
                            'Lesson.Abstract',
                            'Lesson.modified',
                            'Tag.TagContent',
                        ),
                        'conditions' => array(
                            'User.Status' => 1,
                            'OR' => $conditions
                        )
                    ));
                } else {
                    $results = $this->Lesson->find("all", array(
                        "joins" => array(
                            array(
                                "table" => "tags",
                                "alias" => "Tag",
                                "type" => "LEFT",
                                "conditions" => array(
                                    "Tag.LessonId= Lesson.LessonId"
                                )
                            )
                        ),
                        'fields' => array('User.FullName',
                            'User.UserId',
                            'Lesson.LessonId',
                            'Lesson.Title',
                            'Lesson.LikeNumber',
                            'Lesson.Category',
                            'Lesson.ViewNumber',
                            'Lesson.Abstract',
                            'Lesson.modified',
                            'Tag.TagContent',
                        ),
                        'conditions' => array(
                            'User.Status' => 1,
                            'OR' => array(
                                array('User.Username LIKE' => "%$keyWord%"),
                                array('User.FullName LIKE' => "%$keyWord%")
                            )
                        )
                    ));

                }


            } //search by lesson
            else if ($searchType == 3) {
                if (isset($andConditions)) {
                    for ($i = 0; $i < sizeof($andConditions); $i++) {
                        $conditions[$i] = array('Lesson.Title LIKE' => "%$andConditions[$i]%");
                    }
                    $results = $this->Lesson->find("all", array(
                        "joins" => array(
                            array(
                                "table" => "tags",
                                "alias" => "Tag",
                                "type" => "LEFT",
                                "conditions" => array(
                                    "Tag.LessonId= Lesson.LessonId"
                                )
                            )
                        ),
                        'fields' => array('User.FullName',
                            'User.UserId',
                            'Lesson.LessonId',
                            'Lesson.Title',
                            'Lesson.LikeNumber',
                            'Lesson.Category',
                            'Lesson.ViewNumber',
                            'Lesson.Abstract',
                            'Lesson.modified',
                            'Tag.TagContent',
                        ),
                        'conditions' => array(
                            'User.Status' => 1,
                            'AND' => $conditions
                        )
                    ));


                } else if (isset($orConditions)) {
                    for ($i = 0; $i < sizeof($orConditions); $i++) {
                        $conditions[$i] = array('Lesson.Title LIKE' => "%$orConditions[$i]%");
                    }
                    $results = $this->Lesson->find("all", array(
                        "joins" => array(
                            array(
                                "table" => "tags",
                                "alias" => "Tag",
                                "type" => "LEFT",
                                "conditions" => array(
                                    "Tag.LessonId= Lesson.LessonId"
                                )
                            )
                        ),
                        'fields' => array('User.FullName',
                            'User.UserId',
                            'Lesson.LessonId',
                            'Lesson.Title',
                            'Lesson.LikeNumber',
                            'Lesson.Category',
                            'Lesson.ViewNumber',
                            'Lesson.Abstract',
                            'Lesson.modified',
                            'Tag.TagContent',
                        ),
                        'conditions' => array(
                            'User.Status' => 1,
                            'OR' => $conditions
                        )
                    ));
                } else {
                    $results = $this->Lesson->find("all", array(
                        "joins" => array(
                            array(
                                "table" => "tags",
                                "alias" => "Tag",
                                "type" => "LEFT",
                                "conditions" => array(
                                    "Tag.LessonId= Lesson.LessonId"
                                )
                            )
                        ),
                        'fields' => array('User.FullName',
                            'User.UserId',
                            'Lesson.LessonId',
                            'Lesson.Title',
                            'Lesson.LikeNumber',
                            'Lesson.Category',
                            'Lesson.ViewNumber',
                            'Lesson.Abstract',
                            'Lesson.modified',
                            'Tag.TagContent',
                        ),
                        'conditions' => array(
                            'User.Status' => 1,
                            'OR' => array(
                                array('Lesson.Title LIKE' => "%$keyWord%"),
                            )
                        )
                    ));

                }
            } //this time it's tag
            else if ($searchType == 4) {
                if (isset($andConditions)) {
                    for ($i = 0; $i < sizeof($andConditions); $i++) {
                        $conditions[$i] = array('Tag.TagContent LIKE' => "%$andConditions[$i]%");
                    }
                    $results = $this->Lesson->find("all", array(
                        "joins" => array(
                            array(
                                "table" => "tags",
                                "alias" => "Tag",
                                "type" => "LEFT",
                                "conditions" => array(
                                    "Tag.LessonId= Lesson.LessonId"
                                )
                            )
                        ),
                        'fields' => array('User.FullName',
                            'User.UserId',
                            'Lesson.LessonId',
                            'Lesson.Title',
                            'Lesson.LikeNumber',
                            'Lesson.Category',
                            'Lesson.ViewNumber',
                            'Lesson.Abstract',
                            'Lesson.modified',
                            'Tag.TagContent',
                        ),
                        'conditions' => array(
                            'User.Status' => 1,
                            'AND' => $conditions
                        )
                    ));
                } else if (isset($orConditions)) {
                    for ($i = 0; $i < sizeof($orConditions); $i++) {
                        $conditions[$i] = array('Tag.TagContent LIKE' => "%$orConditions[$i]%");
                    }
                    $results = $this->Lesson->find("all", array(
                        "joins" => array(
                            array(
                                "table" => "tags",
                                "alias" => "Tag",
                                "type" => "LEFT",
                                "conditions" => array(
                                    "Tag.LessonId= Lesson.LessonId"
                                )
                            )
                        ),
                        'fields' => array('User.FullName',
                            'User.UserId',
                            'Lesson.LessonId',
                            'Lesson.Title',
                            'Lesson.LikeNumber',
                            'Lesson.Category',
                            'Lesson.ViewNumber',
                            'Lesson.Abstract',
                            'Lesson.modified',
                            'Tag.TagContent',
                        ),
                        'conditions' => array(
                            'User.Status' => 1,
                            'OR' => $conditions
                        )
                    ));


                } else {

                    $results = $this->Lesson->find("all", array(
                        "joins" => array(
                            array(
                                "table" => "tags",
                                "alias" => "Tag",
                                "type" => "LEFT",
                                "conditions" => array(
                                    "Tag.LessonId= Lesson.LessonId"
                                )
                            )
                        ),
                        'fields' => array('User.FullName',
                            'User.UserId',
                            'Lesson.LessonId',
                            'Lesson.Title',
                            'Lesson.LikeNumber',
                            'Lesson.Category',
                            'Lesson.ViewNumber',
                            'Lesson.Abstract',
                            'Lesson.modified',
                            'Tag.TagContent',
                        ),
                        'conditions' => array(
                            'User.Status' => 1,
                            'OR' => array(
                                array('Tag.TagContent LIKE' => "%$keyWord%"),
                            )
                        )
                    ));


                }

            }

            $this->set(compact('keyWord'));
            //Get category
            $cat = $this->Category->getCategories();
            $Category = array();
            foreach ($cat as $key => $value) {
                $Category[$key + 1] = $value['Category']['CatName'];
            }
            $this->set('Category', $Category);
            // debug($Category);
//            $results = $this->Lesson->find("all", array(
//                "joins" => array(
//                    array(
//                        "table" => "tags",
//                        "alias" => "Tag",
//                        "type" => "LEFT",
//                        "conditions" => array(
//                            "Tag.LessonId= Lesson.LessonId"
//                        )
//                    )
//                ),
//                'fields' => array('User.FullName',
//                    'User.UserId',
//                    'Lesson.LessonId',
//                    'Lesson.Title',
//                    'Lesson.LikeNumber',
//                    'Lesson.Category',
//                    'Lesson.ViewNumber',
//                    'Lesson.Abstract',
//                    'Lesson.modified',
//                    'Tag.TagContent',
//                ),
//                'conditions' => array(
//                    'User.Status' => 1,
//                    'OR' => array(
//                        array('Lesson.Title LIKE' => "%$keyWord%"),
//                        array('Tag.TagContent LIKE' => "%$keyWord%"),
//                        array('User.Username LIKE' => "%$keyWord%"),
//                        array('Lesson.Abstract LIKE' => "%$keyWord%")
//                    )
//                )
//            ));
            foreach ($results as $key => $value) {
                $isStudying = false;
                $isBlocked = $this->StudentBlock->find('first', array(
                        'conditions' => array(
                            'StudentBlock.UserId' => $userId,
                            'StudentBlock.LessonId' => $value['Lesson']['LessonId'],
                        ))
                );
                if ($isBlocked) {
                    $results[$key]['Lesson']['isBlocked'] = 1;
                } else {
                    $results[$key]['Lesson']['isBlocked'] = 0;
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
                $results[$key]['Lesson']['isStudying'] = $isStudying;
            }
            $this->set('results', $results);
        }
    }
}

?>