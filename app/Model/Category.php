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
class Category extends AppModel{
    //put your code here
    public $primaryKey = 'CatId';
    public $actsAs = array('Containable');
    public $hasMany = array(
        'Lesson' => array(
            'className' => 'Lesson',
            'foreignKey' => 'Category',
            'conditions' => array('Lesson.IsDeleted' => '0'),
            'dependent' => true
        ),
    );
  	public function getCategories() {
    return $this->find('all',array(
    	'conditions'=>array('IsDeleted'=>'0')
    	));
    }

    function getCategory($catId) {
        return $this->find('first', array(
                    'conditions' => array(
                        'Category.CatId' => $catId,
                    ),
        ));
    }

    function getLessonsByCategory($catId) {
        $lessons = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array('Category.CatId' => $catId, 'Category.IsDeleted' => '0'),
            'joins' => array(
                array('table' => 'lessons',
                    'alias' => 'Lesson',
                    'type' => 'inner',
                    'conditions' => array(
                        'Lesson.Category = Category.CatId',
                        'Lesson.IsDeleted' => '0',
                    )
                ),
                array('table' => 'users',
                    'alias' => 'User',
                    'type' => 'inner',
                    'conditions' => array(
                        'Lesson.UserId = User.UserId',
                        'User.Status' => '1',
                    )
                ),
            ),
            'fields' => array('Lesson.*', 'User.*', 'Category.*'),
        ));

        return $lessons;
    }

    function getPaginationOptions($catId) {
        $options = array();
        $options['fields'] = array('Lesson.*', 'Category.*', 'User.*');
        $options['joins'] = array(
            array('table' => 'lessons',
                'alias' => 'Lesson',
                'type' => 'inner',
                'conditions' => array(
                    'Lesson.Category = Category.CatId',
                    'Lesson.IsDeleted' => '0',
                )
            ),
            array('table' => 'users',
                'alias' => 'User',
                'type' => 'inner',
                'conditions' => array(
                    'Lesson.UserId = User.UserId',
                    'User.Status' => '1',
                )
            ),
        );
        $options['conditions'] = array(
            'Category.CatId' => $catId, 'Category.IsDeleted' => '0',
        );
        $options['limit'] = 12;
        return $options;
    }


}

