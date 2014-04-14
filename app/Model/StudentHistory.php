<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StudentHistory
 *
 * @author anh
 */
class StudentHistory extends AppModel {
//put your code here
    public $name = 'StudentHistory';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => false,
            'conditions' => array(
                'StudentHistory.UserId = User.UserId',
            )
        ),
        'Lesson' => array(
            'className' => 'Lesson',
            'foreignKey' => false,
            'conditions' => array(
                'StudentHistory.LessonId = Lesson.LessonId',
            )
        )
    );
    function getStudentTransactionHistory($userId, $month, $year) {
        $this->recursive = -1;
        if ($month != 0 && $year != 0) {
            $options['conditions'] = array(
                'StudentHistory.UserId' => $userId,
                'MONTH(ExpiryDate)' => $month,
                'YEAR(ExpiryDate)' => $year,
            );
        } else {
            $options['conditions'] = array(
                'StudentHistory.UserId' => $userId,
            );
        }

        $options['fields'] = array('Lesson.Title', 'StudentHistory.*');
        $options['joins'] = array(
            array('table' => 'lessons',
                'alias' => 'Lesson',
                'type' => 'inner',
                'conditions' => array(
                    'Lesson.LessonId = StudentHistory.LessonId'
                )
            )
        );

        $transactions = $this->find('all', $options);
        return $transactions;
    }

    function getTeacherTransactionHistory($userId, $month, $year) {
        $this->recursive = -1;

        $this->virtualFields = array(
            'buys' => 'COUNT(*)',
            'fee' => 'SUM(CourseFee)',
        );
        $options['fields'] = array('Lesson.Title', 'StudentHistory.*', 'buys');
        $options['joins'] = array(
            array('table' => 'lessons',
                'alias' => 'Lesson',
                'type' => 'inner',
                'conditions' => array(
                    'Lesson.LessonId = StudentHistory.LessonId'
                )
            )
        );
        $options['group'] = array('StudentHistory.LessonId');
        if ($month != 0 && $year != 0) {
            $options['conditions'] = array(
                'Lesson.UserId' => $userId,
                'MONTH(ExpiryDate)' => $month,
                'YEAR(ExpiryDate)' => $year,
            );
        } else {
            $options['conditions'] = array(
                'Lesson.UserId' => $userId,
            );
        }

        return $transactions = $this->find('all', $options);
    }
    function getPaginationOptions($userId, $sortBy) {
        $options = array();
        $options['fields'] = array(
            'StudentHistory.*',
            'Lesson.*',
            'User.*', );
        $options['conditions'] = array(
            'StudentHistory.UserId' => $userId,
            'CURDATE() BETWEEN DATE(StudentHistory.StartDate) AND DATE(StudentHistory.ExpiryDate)',
        );
        $options['limit'] = 5;
        switch ($sortBy) {
            case 'like':
                $options['order'] = array('StudentHistory.LikeNumber' => 'DESC');
                break;
            case 'view':
                $options['order'] = array('StudentHistory.ViewNumber' => 'DESC');
                break;
            default:
                $options['order'] = array('StudentHistory.ExpiryDate' => 'DESC');
                break;
        }
        
        return $options;
    }
    function getStudentHistoryOfLesson($lessonId)
    {
        $options['fields'] = array('User.FullName', 'StudentHistory.*');
        $options['conditions'] = array(
                'StudentHistory.LessonId' => $lessonId,
            );
        return $studentHistories = $studentHistories = $this->find('all', $options);
    }

    function getStudentHistoryByUserIdAndLessonId($userId, $lessonId)
    {
        $options['conditions'] = array(
                'StudentHistory.LessonId' => $lessonId,
                'StudentHistory.UserId' => $userId
            );
   
        return $studentHistories = $studentHistories = $this->find('all', $options);
    }

}
