<?php
/**
 * Created by PhpStorm.
 * User: TanVN
 * Date: 3/9/14
 * Time: 1:48 PM
 */
class LessonsController extends AppController
{
    function beforeFilter()
    {
        $this->pageTitle = 'Home';
        $this->layout = 'template';
//        $this->Auth->allow(array('index', 'sign_up'));
        return parent::beforeFilter();
    }

    public function search($keyWord = null)
    {
//        $keyWord = $keyWord!=null? $keyWord:$this->request->data['Lesson']['keyWords'];
//        $this->request->data['Lesson'];
//        debug($this->request->data);
        if (!isset($keyWord) || empty($keyWord)) {
            if (!isset($this->request->data['Lesson'])) {

                $this->Session->setFlash("何かキーワードを入力してください");
//                $this->set('results', $this->Lesson->find('all'));
//                throw new NotFoundException(__("INVALID INPUT"));
            } else {
                $keyWord = $this->request->data['Lesson']['keyWords'];
            }
        }
        if (!isset($keyWord) || empty($keyWord)) {
            $this->Session->setFlash("何かキーワードを入力してください");
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
                    'fields' => array('User.Username',
                        'User.UserId',
                        'Lesson.Title',
                        'Lesson.LikeNumber',
                        'Lesson.Abstract',
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
                )
            );
            $this->set('results', $results);

        }
    }
}

?>