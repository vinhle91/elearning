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
class Test extends AppModel{
    public $primaryKey = 'TestId';
    // put your code here
    public $hasMany = array(
        'Question' => array(
            'className' => 'Question',
            'foreignKey' => 'TestId',
            'order' => 'Question.QuesNumber Asc',
            'dependent' => true
        ),
    );     
    
    function getLessonsByTeacher($userId) {
        return $lessons = $this->find('all', array(
           'conditions' => array('Lesson.UserId' => $userId), 
        ));
    }
    
}
