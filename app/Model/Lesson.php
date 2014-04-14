<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lesson
 *
 * @author anh
 */
class Lesson extends AppModel{
    //put your code here
    public $primaryKey = 'LessonId';
    public $actsAs = array('Containable');
	public $hasMany = array(
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'LessonId',
            'conditions' => array('Comment.IsDeleted' => '0'),
            'order' => 'Comment.created DESC',
            'dependent' => true
        ),
        'Test' => array(
            'className' => 'Test',
            'foreignKey' => 'LessonId',
            'conditions' => array('Test.IsDeleted' => '0'),
            'order' => 'Test.created DESC',
            'dependent' => true
        ),
        'File' => array(
            'className' => 'File',
            'foreignKey' => 'LessonId',
            'conditions' => array('File.IsDeleted' => '0'),
            'order' => 'File.created DESC',
            'dependent' => true
        ),
        'Tag' => array(
            'className' => 'Tag',
            'foreignKey' => 'LessonId',
            'order' => 'Tag.created DESC',
            'dependent' => true
        )
    );
    
    public $belongsTo = array(
        'Author' => array(
            'className' => 'User',
            'foreignKey' => 'UserId',
            'fields' => array(
                'Author.UserId',
                'Author.Username',
                'Author.Status',
                )
            ),
        'User' => array('className' => 'users',
            // 'conditions' => array('User.UserType' => 2,"`Lesson`.`UserId` = `User`.`UserId`"),
            // 'foreignKey' => false
            'className' => 'User',
            'foreignKey' => 'UserId',
        )
    );
    public function getLessonsByTeacher($userId) {
        $this->contain('Comment');
        $lessons = $this->find('all', array(
           'conditions' => array('Lesson.UserId' => $userId,'Lesson.IsDeleted' => '0'), 
           'contain' => array(
                'Comment' => array(
                    'fields' => array( 'COUNT(DISTINCT CommentId) as count'),
                    'conditions' => array(
                        'Comment.IsDeleted' => '0',
                    ),
                ),
            ),

        ));
        return $lessons;
    }
    public function getLessonById($lessonId) {
        $lessons = $this->find('all', array(
           'conditions' => array('Lesson.LessonId' => $lessonId), 
        ));

        return $lessons[0];
    }
    public function getAllLessons() {
        $lessons = $this->find('all',array(
            'limit' => 10,
            )
        );

        return $lessons;
    }
    function getTopLessons() {
        $lessons = $this->find('all',array(
            'limit' => 10,
            'contain'=> false,
            )
        );

        return $lessons;
    }
    public $validate = array(
        'Title' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Title is required'
            ),
        ),
        'Category' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Category is required'
            ),
        ),
        'File.name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'This file is required'
            ),
        ),
        'TestFile.name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'This file is required'
            ),
        )
    );
	public function getLessonInfo($lessonId) {
        $buff = $this->find('first', array(
            'conditions' => array(
                'Lesson.LessonId' => $lessonId,
            ),
        ));
        return $buff['Lesson'];
    }    
}
