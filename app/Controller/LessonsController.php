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
        $userId = $this->Auth->user('UserId');
        $today = new DateTime();
        $UserType = $this->Auth->user()['UserType'];
        $this->set(compact('UserType'));
        $this->set(compact('userId'));
        // debug($this->request->data);
        if (empty($this->request->data['Lesson']['keyWords'])) {
            $this->Session->setFlash("何かキーワードを入力してください");
        }else{
            if (!isset($keyWord) || empty($keyWord)) {
                $keyWord = $this->request->data['Lesson']['keyWords'];
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
                        array('Lesson.Abstract LIKE' => "%$keyWord%")
                    )
                )
            ));
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