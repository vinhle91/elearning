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
class Comment extends AppModel{
	public $primaryKey = 'CommentId';
    public $belongsTo = array(
        'User' => array('className' => 'User',
            'conditions' => array('User.Status'=>'1',"`User`.`UserId` = `Comment`.`UserId`"),
            'foreignKey' => false,
        )
    );
        
}
